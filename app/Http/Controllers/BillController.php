<?php

namespace App\Http\Controllers;

use App\Services\BillServices;
use App\Services\DiscoServices;
use Illuminate\Support\Facades\Log;
use App\Services\User\AuthService;
use App\Services\HistoryServices;
use App\Traits\ResponseTrait;
use App\Services\VtuServices;
use Illuminate\Http\Request;

class BillController extends Controller
{
    //
    use ResponseTrait;
    public function __construct(protected VtuServices $vtuService,
                                protected AuthService $authService, protected HistoryServices $historyServices,
                                protected BillServices $billServices, protected DiscoServices $discoServices)
    {}

    public function getBills()
    {
        return $this->discoServices->allDisco();
    }

    public function getplan($id)
    {
        return $this->billServices->getBill($id);
    }

    public function createVtpassBill(Request $request)
    {
        try {
            date_default_timezone_set("Africa/Lagos");
            $request->validate([
                'billerName'            => 'required|string',
                'meterType'             => 'required|string',
                'meterNumber'           => 'required|numeric',
                'amount'                => 'required|numeric',
                'customerName'          => 'required',
                'customerPhoneNumber'   => 'required|numeric'
            ]);

            $requestID  = date('YmdHi').rand(99, 9999999);
            $phone      = $request->phone;
            $meterNo    = $request->meterNumber;
            $billerName = $request->billerName;
            $meterType  = $request->meterType;
            $disco      = $this->discoServices->getDiscoByName($billerName);
            $amount     = $this->billServices->getBill($disco->id)->plan_amount;
            $userId     = $this->authService->profile()->id;
            $req_bal_process = $this->authService->wallet();
            $bal_after  = $req_bal_process - $amount;
            $Details = [
                'request_id'        => $requestID,
                'serviceID'         => $billerName,//'eko-electric',
                'variation_code'    => $meterType,//'prepaid',
                'billersCode'       => $meterNo,
                'amount'            => $amount,
                'phone'             => $phone
            ];

            if($req_bal_process < $amount){

                return $this->inputErrorResponse("Insufficient balance");

            }else{

                $response = json_decode($this->vtuService->makePayment($Details));
                if ( !is_null($response)) {
                    $HDetails = [
                        'reference'     => $response->content->transactions->transactionId,
                        'user_id'       => $userId,
                        'disco_id'      => $disco->id,
                        'bill_amount'   => $amount,
                        'paid_amount'   => $amount,
                        'balance_bfo'   => $req_bal_process,
                        'balance_aft'   => $bal_after,
                        'meter_number'  => $meterNo,
                        'meter_type'    => $meterType,
                        'customer_name' => $response->content->transactions->status,
                        'customer_address'=> $response->content->transactions->status,
                        'customer_phone'=> $response->content->transactions->status,
                        'token'         => $response->requestId,
                        'refund'        => 0,
                        'status'        => $response->content->transactions->status,
                    ];
                    $this->historyServices->createAirtimeHistory($HDetails);
                    $this->authService->updateProfile($userId, ['wallet_balance' => $bal_after]);
                    return $this->successResponse("Successful");
                }
                return $this->inputErrorResponse("Error, failed to complete request !!!");
            }
        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
            return $this->errorResponse($ex->getMessage(), "Something went wrong", 401);
        }
    }

    public function validateId(Request $request)
    {
        try {
            $request->validate([
                'ctr' => 'required',
                'billerName' => 'required',
                'meterType' => 'required'
            ]);

            $Details = [
                'billersCode'   => $request->ctr,//1111111111111,
                'serviceID'     => $request->billerName,//'eko-electric',
                'type'          => $request->meterType//'prepaid'
            ];
            $response = json_decode($this->vtuService->validate($Details));
            return $this->successResponse("Successful", $response->content);
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), "Something went wrong", 401);
        }
    }
}
