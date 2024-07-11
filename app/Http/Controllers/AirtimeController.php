<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Services\User\AuthService;
use App\Services\HistoryServices;
use App\Traits\ResponseTrait;
use App\Services\VtuServices;
use Illuminate\Http\Request;


class AirtimeController extends Controller
{
    //
    use ResponseTrait;

    public function __construct(protected VtuServices $vtuService,
                                protected AuthService $authService, protected HistoryServices $historyServices)
    {}

    public function createVtpassAirtime(Request $request)
    {
        try {
            date_default_timezone_set("Africa/Lagos");
            $request->validate([
                'phone'   =>  ['required', 'numeric'],
                'amount'  =>  ['required', 'numeric'],
                'network' =>  ['required', 'string'],
            ]);
            $requestID  = date('YmdHi').rand(99, 9999999);
            $phone      = $request->phone;
            $amount     = $request->amount;
            $network    = $request->network;
            $perc       = (2/100) * $amount;
            $amountPay  = $amount - $perc;
            $userId     = $this->authService->profile()->id;
            $req_bal_process = $this->authService->wallet();
            $bal_after  = $req_bal_process - $amountPay;
            $Details = [
                'request_id'        => $requestID,
                'serviceID'         => $network,
                'amount'            => $amount,
                'phone'             => $phone,
            ];

            if($req_bal_process < $amount){

                return $this->inputErrorResponse("Insufficient balance");

            }else{

                $response = json_decode($this->vtuService->makePayment($Details));
                if ( !is_null($response)) {
                    $HDetails = [
                        'user_id'           => $userId,
                        'network_id'        => $network,
                        'mobile_number'     => $phone,
                        'cost_price'        => $amount,
                        'amount_paid'       => $amountPay,
                        'airtime_type'      => 'VTU',
                        'reference'         => $response->content->transactions->transactionId,
                        'status'            => $response->content->transactions->status,
                        'medium'            => 'API',
                        'balance_before'    => $req_bal_process,
                        'balance_after'     => $bal_after,
                        'ported_number'     => 0,
                        'refunded'          => 0,
                        'api_response'      => $response->response_description,
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
