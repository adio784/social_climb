<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Services\GetfollowerService;
use App\Services\HistoryServices;
use App\Services\OrderServices;
use App\Services\ProductServices;
use App\Services\User\AuthService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //
    use ResponseTrait;

    protected $authService;
    protected $orderService;
    protected $historyServices;
    protected $productServices;
    protected $getFollowerService;

    public function __construct(
        AuthService $authService,
        OrderServices $orderService,
        GetfollowerService $getFollowerService,
        HistoryServices $historyServices,
        ProductServices $productServices
    ) {
        $this->authService = $authService;
        $this->orderService = $orderService;
        $this->historyServices = $historyServices;
        $this->productServices = $productServices;
        $this->getFollowerService = $getFollowerService;
    }

    public function getOrderById($id)
    {
        $data = $this->orderService->getOrderById($id);
        return $this->successResponse("Successful", $data);
    }

    public function status(Request $request)
    {
        $id = $request->route('id');
        return $this->getFollowerService->status($id);
    }

    public function read()
    {
        $id = auth()->user()->id;
        $data = $this->orderService->getOrderByUser($id);
        return $this->successResponse("Successful", $data);
    }

    public function makeOrder(Request $request)
    {
        try {
            $request->validate([
                'service'   => 'required|numeric',
                'link'      => 'required|string',
                'quantity'  => 'required|numeric',
            ]);
            $service    = $request->service;
            $link       = $request->link;
            $quantity   = $request->quantity;

            $getProductDetails  = $this->productServices->getProductByProductId($service);
            $amount             = $getProductDetails->product_rate * $quantity;
            $productId          = $getProductDetails->id;
            $req_bal_process    = $this->authService->wallet();
            $bal_after          = $req_bal_process - $amount;

            // $data = $this->getFollowerService->addOrder(array('service' => 18210, 'link' => 'http://example.com/test', 'quantity' => 100));
            if ($req_bal_process < $amount) {
                return $this->inputErrorResponse("Insufficient balance");
            } else {
                $request = $this->getFollowerService->addOrder(array('service' => $service, 'link' => $link, 'quantity' => $quantity));
                $data = $request;
                // return $data;
                $resStatus = $data['status'];
                $resOrder = $data['order'];

                if ($resStatus == true) {
                    $createOrder = [
                        'user_id'       => Auth::user()->id,
                        'order_id'      => $resOrder,
                        'product_id'    => $productId,
                        'service'       => $getProductDetails->name,
                        'link'          => $link,
                        'quantity'      => $quantity,
                        'product_price' => $amount,
                        'status'        => $resStatus,
                        'balance_before'=> $req_bal_process,
                        'balance_after' => $bal_after,
                    ];
                    $this->authService->updateProfile(Auth::user()->id, ['wallet_balance' => $bal_after]);
                    $this->orderService->createOrder($createOrder);
                    return $this->successResponse("Successful", $data);
                }
                $this->authService->updateProfile(Auth::user()->id, ['wallet_balance' => $req_bal_process]);
                return $this->inputErrorResponse("Error Occured, try later", $data);
            }
        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), "Something went wrong", 401);
        }
    }


    public function histories()
    {
        $data = [
            'Histories' => $this->historyServices->getSocioHistory()
        ];
        return view('control.order-histories', $data);
    }

    public function orderDetails($id)
    {
        $data = [
            'History' => $this->historyServices->getSocioHistoryById($id)
        ];
        return view('control.view-order-details', $data);
    }
}
