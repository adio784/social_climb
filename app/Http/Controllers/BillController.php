<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Services\BillServices;
use App\Services\DiscoServices;
use Illuminate\Support\Facades\Log;
use App\Services\User\AuthService;
use App\Services\HistoryServices;
use App\Traits\ResponseTrait;
use App\Services\VtuServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
                'billerName'    => 'required|string',
                'meterType'     => 'required|string',
                'meterNumber'   => 'required|numeric',
                'amount'        => 'required|numeric',
                'phone'         => 'required|numeric'
            ]);

            $requestID  = date('YmdHi').rand(99, 9999999);
            $phone      = $request->phone;
            $meterNo    = $request->meterNumber;
            $billerName = $request->billerName;
            $meterType  = $request->meterType;
            // $disco      = $this->discoServices->getDiscoByName($billerName);
            $amount     = $request->amount;//$this->billServices->getBill($disco->id)->plan_amount;
            $userId     = $this->authService->profile()->id;
            $req_bal_process = $this->authService->wallet();
            $bal_after  = $req_bal_process - $amount;
            $Details = [
                'request_id'        => $requestID,
                'serviceID'         => $billerName,//'eko-electric',
                'billersCode'       => $meterNo,
                'variation_code'    => $meterType,//'prepaid',
                'amount'            => $amount,
                'phone'             => $phone
            ];

            if($req_bal_process < $amount){

                return $this->inputErrorResponse("Insufficient balance");

            }else{

                $response = json_decode($this->vtuService->makePayment($Details));
                // return $response;
                if ( !is_null($response)) {
                    $HDetails = [
                        'reference'     => $response->content->transactions->transactionId,
                        'user_id'       => $userId,
                        'disco_id'      => $billerName,//$disco->id,
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
                    $this->historyServices->createBillHistory($HDetails);
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
                'serviceNumber' => 'required',
                'serviceName'   => 'required',
                'serviceType'   => 'sometimes|nullable|string',
            ]);

            $Details = [
                'billersCode'   => $request->serviceNumber,
                'serviceID'     => $request->serviceName,
                'type'          => $request->serviceType
            ];
            $response = json_decode($this->vtuService->validate($Details));
            return $this->successResponse("Successful", $response->content);
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), "Something went wrong", 401);
        }
    }

    public function getVtPlans()
    {
        $get = Http::get('https://sandbox.vtpass.com/api/service-variations?serviceID=showmax');
        $response = json_decode($get);
        foreach ($response->content->varations as $content) {
            Bill::create([
                'disco_id' => 4,
                'plan_name' => $content->name,
                'plan_code' => $content->variation_code,
                'plan_amount' => $content->variation_amount,
                'is_active' => 1
            ]);
        }
        return $response;
    }
}
