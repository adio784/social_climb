<?php

namespace App\Http\Controllers;

use App\Models\Cable;
use App\Services\CableServices;
use App\Services\CabletvServices;
use Illuminate\Support\Facades\Log;
use App\Services\User\AuthService;
use App\Services\HistoryServices;
use App\Traits\ResponseTrait;
use App\Services\VtuServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
                'cableName'     => 'required|string',
                'cablePlan'     => 'required|string',
                'cableNumber'   => 'required|numeric',
                'phone'         => 'required|numeric'
            ]);

            $requestID  = date('YmdHi').rand(99, 9999999);
            $planId     = $request->cablePlan;
            $phone      = $request->phone;
            $iucNumber  = $request->cableNumber;
            $cableName  = $request->cableName;
            $cableTv    = $this->cabletvServices->getCabletvByName($cableName);
            $amount     = $this->cableServices->getACable($cableTv->id, $planId)->plan_amount;
            $userId     = $this->authService->profile()->id;
            $req_bal_process = $this->authService->wallet();
            $bal_after  = $req_bal_process - $amount;
            $Details = [
                'request_id'        => $requestID,
                'serviceID'         => $cableName,//'gotv',
                'billersCode'       => $iucNumber,
                'variation_code'    => $planId, //goto-lite,
                'amount'            => $amount,
                'phone'             => $phone,
                'subscription_type' => 'change'
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
                        'cable_id'      => $cableName,
                        'plan_id'       => 1,//$planId,
                        'plan_amount'   => $amount,
                        'smart_card_number' => $iucNumber,
                        'balance_before' => $req_bal_process,
                        'balance_after' => $bal_after,
                        'refund'        => 0,
                        'status'        => $response->content->transactions->status,
                    ];
                    $this->historyServices->createCableHistory($HDetails);
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

    public function getVtPlans()
    {
        $get = Http::get('https://sandbox.vtpass.com/api/service-variations?serviceID=showmax');
        $response = json_decode($get);
        foreach ($response->content->varations as $content) {
            Cable::create([
                'cable_id' => 4,
                'plan_name' => $content->name,
                'plan_code' => $content->variation_code,
                'plan_amount' => $content->variation_amount,
                'is_active' => 1
            ]);
        }
        return $response;
    }
}
