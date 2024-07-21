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

    // Administrative operations ...............................
    public function index()
    {
        $data = [
            'Pricing' => $this->cableServices->allCable()
        ];
        return view('control.cable-plans', $data);
    }

    public function createCable()
    {
        $data = [
            'Cables' => $this->getCables()
        ];
        return view('control.create-cable', $data);
    }


    public function read($id)
    {
        $data = [
            'Plan'  => $this->cableServices->getPlan($id),
            'Cables' => $this->getCables()
        ];
        return view('control.cableplan', $data);
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'cable'         => 'required|numeric',
                'plan_name'     => 'required|string',
                'plan_code'     => 'required|string',
                'cost_price'    => 'required|numeric',
                'selling_price' => 'required|numeric',
            ]);
            $Data = [
                'cable_id'      =>  $request->cable,
                'plan_name'     =>  $request->plan_name,
                'plan_code'     =>  $request->plan_code,
                'cost_price'    =>  $request->cost_price,
                'plan_amount'   =>  $request->selling_price,
            ];
            $this->cableServices->createCable($Data);
            return back()->with('success', 'Record Successfully Created');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return back()->with('fail', 'Error Occured, Reason: ' . $e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        try {
            $planId = $request->plan_id;
            $request->validate([
                'cable'         => 'required|numeric',
                'plan_name'     => 'required|string',
                'plan_code'     => 'required|string',
                'cost_price'    => 'required|numeric',
                'selling_price' => 'required|numeric',
            ]);
            $Data = [
                'cable_id'      =>  $request->cable,
                'plan_name'     =>  $request->plan_name,
                'plan_code'     =>  $request->plan_code,
                'cost_price'    =>  $request->cost_price,
                'plan_amount'   =>  $request->selling_price,
            ];
            $this->cableServices->updateCable($Data, $planId);
            return back()->with('success', 'Record Successfully Updated');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return back()->with('fail', 'Error Occured, Reason: ' . $e->getMessage());
        }
    }



    public function delete($id)
    {
        try {
            $this->cableServices->deleteCable($id);
            return back()->with('success', 'Record Successfully Deleted !!!');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return back()->with('fail', 'Error Deleting Record !!!');
        }
    }

    public function histories()
    {
        $data = [
            'Histories' => $this->historyServices->getCableHistory()
        ];
        return view('control.cable-histories', $data);
    }

    public function cableDetails($id)
    {
        $data = [
            'History' => $this->historyServices->getCableHistoryById($id)
        ];
        return view('control.view-cable-details', $data);
    }

}
