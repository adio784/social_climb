<?php

namespace App\Http\Controllers;

use App\Services\CableServices;
use App\Services\CabletvServices;
use Illuminate\Support\Facades\Log;
use App\Services\User\AuthService;
use App\Services\HistoryServices;
use App\Traits\ResponseTrait;
use App\Services\VtuServices;
use Illuminate\Http\Request;

class CableController extends Controller
{
    //
    use ResponseTrait;
    public function __construct(protected VtuServices $vtuService,
                                protected AuthService $authService, protected HistoryServices $historyServices,
                                protected CableServices $cableServices, protected CabletvServices $cabletvServices)
    {}

    public function getCables()
    {
        return $this->cabletvServices->allCabletv();
    }

    public function getplan($id)
    {
        return $this->cableServices->getCable($id);
    }

    public function createVtpassCable(Request $request)
    {
        try {
            date_default_timezone_set("Africa/Lagos");

            $request->validate([
                'cableName'             => 'required|string',
                'cablePlan'             => 'required|string',
                'cableNumber'           => 'required|numeric',
                'customerName'          => 'required|string',
                'customerPhoneNumber'   => 'required|numeric'
            ]);

            $requestID  = date('YmdHi').rand(99, 9999999);
            $planId     = $request->cablePlan;
            $phone      = $request->phone;
            $iucNumber  = $request->meterNumber;
            $cableName  = $request->billerName;
            $cableTv    = $this->cabletvServices->getCabletvByName($cableName);
            $amount     = $this->cableServices->getCable($cableTv->id)->plan_amount;
            $variationCode = $request->variation_code;
            $meterType  = $request->meterType;
            $userId     = $this->authService->profile()->id;
            $req_bal_process = $this->authService->wallet();
            $bal_after  = $req_bal_process - $amount;
            $Details = [
                'request_id'        => $requestID,
                'serviceID'         => $cableName,//'eko-electric',
                'billersCode'       => $iucNumber,
                'variation_code'    => $variationCode,//'prepaid',
                'amount'            => $amount,
                'phone'             => $phone,
                'subscription_type' => 'change'
            ];

            if($req_bal_process < $amount){

                return $this->inputErrorResponse("Insufficient balance");

            }else{

                $response = json_decode($this->vtuService->makePayment($Details));
                if ( !is_null($response)) {
                    $HDetails = [
                        'reference'     => $response->content->transactions->transactionId,
                        'user_id'       => $userId,
                        'cable_id'      => $cableTv->id,
                        'plan_id'       => $planId,
                        'paid_amount'   => $amount,
                        'balance_before'   => $req_bal_process,
                        'balance_after'   => $bal_after,
                        'customer_name' => $response->content->transactions->status,
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
}
