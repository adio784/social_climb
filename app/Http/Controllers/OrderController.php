<?php

namespace App\Http\Controllers;

use App\Services\GetfollowerService;
use App\Services\OrderServices;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    use ResponseTrait;

    protected $orderService;
    protected $getFollowerService;

    public function __construct(OrderServices $orderService, GetfollowerService $getFollowerService)
    {
        $this->orderService = $orderService;
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
        return $this->orderService->getOrderByUser($id);
    }

    public function make()
    {
        $data = $this->getFollowerService->addOrder(array('service' => 18210, 'link' => 'http://example.com/test', 'quantity' => 100));
        // if ($data->success == true) {
        //     $createOrder = [
        //         'order_id'      => $data->data->order_id,
        //         'product_id'    => $data->data->product_id,
        //         'service'       => $data->data->service,
        //         'link'          => $data->data->link,
        //         'quantity'      => $data->data->quantity,
        //         'product_price' => $data->data->total,
        //         'status'        => $data->data->status,
        //     ];

        //     $this->orderService->createOrder($createOrder);
        //     return $this->successResponse("Successful", $data);
        // }
        return $this->successResponse("Successful", $data);
    }
}
