<?php

namespace App\Http\Controllers;

use App\Services\DataServices;
use Illuminate\Support\Facades\Log;
use App\Services\User\AuthService;
use App\Services\HistoryServices;
use App\Traits\ResponseTrait;
use App\Services\VtuServices;
use Illuminate\Http\Request;

class DataController extends Controller
{
    //
    use ResponseTrait;
    public function __construct(protected VtuServices $vtuService,
                                protected AuthService $authService, protected HistoryServices $historyServices,
                                protected DataServices $dataServices)
    {}

    public function getplan($id)
    {
        return $this->dataServices->allData($id);
    }

    public function createVtpassData(Request $request)
    {
        try {
            date_default_timezone_set("Africa/Lagos");

            $request->validate([
                'plan_id' => 'required|string',
                'amount'  => 'required|numeric',
                'network' => 'required|string',
                'phone'   => 'required|numeric'
            ]);

            $requestID  = date('YmdHi').rand(99, 9999999);
            $planId     = $request->plan_id;
            $dataType   = $request->type;
            $phone      = $request->phone;
            $network    = $request->network;
            // $data       = $this->dataServices->getData($network);
            $amount     = $request->amount;//$data->plan_price;
            $userId     = $this->authService->profile()->id;
            $req_bal_process = $this->authService->wallet();
            $bal_after  = $req_bal_process - $amount;
            $Details = [
                'request_id'        => $requestID,
                'serviceID'         => $network,
                'variation_code'    => $planId,
                "billersCode"       => $phone,
                'amount'            => $amount,
                'phone'             => $this->authService->profile()->phone,
            ];

            if($req_bal_process < $amount){

                return $this->inputErrorResponse("Insufficient balance");

            }else{

                $response = json_decode($this->vtuService->makePayment($Details));
                // return $response;
                if ( !is_null($response)) {
                    $HDetails = [
                        'network_id'    => $network,
                        'plan_id'       => $planId,
                        'user_id'       => $userId,
                        'data_type'     => $dataType,
                        'mobile_number' => $phone,
                        'Status'        => 'processing',
                        'medium'        => 'API',
                        'balance_before'=> $req_bal_process,
                        'balance_after' => $bal_after,
                        'plan_amount'   => $amount,
                        'Ported_number' => 0,
                        'ident'         => $requestID,
                        'refund'        => 0,
                        'api_response'  => $response->response_description,
                    ];
                    $this->historyServices->createDataHistory($HDetails);
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
