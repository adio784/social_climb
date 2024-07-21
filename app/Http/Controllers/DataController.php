<?php

namespace App\Http\Controllers;

use App\Http\Requests\DataRequest;
use App\Services\DataServices;
use Illuminate\Support\Facades\Log;
use App\Services\User\AuthService;
use App\Services\HistoryServices;
use App\Services\NetworkServices;
use App\Traits\ResponseTrait;
use App\Services\VtuServices;
use Illuminate\Http\Request;

class DataController extends Controller
{
    //
    use ResponseTrait;
    public function __construct(
        protected VtuServices $vtuService,
        protected AuthService $authService,
        protected DataServices $dataServices,
        protected HistoryServices $historyServices,
        protected NetworkServices $networkServices
    ) {
    }

    public function index()
    {
        $data = [
            'Pricing' => $this->dataServices->allData()
        ];
        return view('control.data-plans', $data);
    }

    public function createData()
    {
        $data = [
            'Networks' => $this->networkServices->all()
        ];
        return view('control.create-data', $data);
    }

    public function getplan($id)
    {
        return $this->dataServices->getDataPlans($id);
    }

    public function createVtpassData(Request $request)
    {
        try {
            date_default_timezone_set("Africa/Lagos");

            $request->validate([
                'plan_id' => 'required|string',
                'network' => 'required|string',
                'phone'   => 'required|numeric'
            ]);

            $requestID  = date('YmdHi') . rand(99, 9999999);
            $dataType   = $request->type;
            $phone      = $request->phone;
            $ntk        = $this->networkServices->getNetworkByName($request->network);
            $network    = $request->network;
            $data       = $this->dataServices->getData($ntk->id, $request->plan_id);
            $amount     = $data->plan_price;
            $planId     = $data->vtpass_planid;
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

            if ($req_bal_process < $amount) {

                return $this->inputErrorResponse("Insufficient balance");
            } else {

                $response = json_decode($this->vtuService->makePayment($Details));
                // return $response;
                if (!is_null($response)) {
                    $HDetails = [
                        'network_id'    => $network,
                        'plan_id'       => $planId,
                        'user_id'       => $userId,
                        'data_type'     => $dataType,
                        'mobile_number' => $phone,
                        'Status'        => 'processing',
                        'medium'        => 'API',
                        'balance_before' => $req_bal_process,
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

    public function read($id)
    {
        $data = [
            'Plan'  => $this->dataServices->getPlan($id),
            'Networks' => $this->networkServices->all()
        ];
        return view('control.dataplan', $data);
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'network'       => 'required|numeric',
                'plan_size'     => 'required|string',
                'plan_value'    => 'required|string',
                'cost_price'    => 'required|numeric',
                'selling_price' => 'required|numeric',
                'validity'      => 'required|string',
                'planID'        => 'required|string',
            ]);
            $Data = [
                'network'       =>  $request->network,
                'plan_size'     =>  $request->plan_size,
                'plan_measure'  =>  $request->plan_value,
                'cost_price'    =>  $request->cost_price,
                'plan_price'    =>  $request->selling_price,
                'plan_category' =>  $request->category,
                'plan_validity' =>  $request->validity,
                'ussd_string'   =>  $request->ussd_string,
                'sms_message'   =>  $request->message,
                'vtpass_planid' =>  $request->planID,
            ];
            $this->dataServices->createData($Data);
            return back()->with('success', 'Record Successfully Created');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return back()->with('fail', 'Error Occured, Reason: ' . $e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        try {
            $request->validate([
                'network'       => 'required|numeric',
                'plan_size'     => 'required|string',
                'plan_value'    => 'required|string',
                'cost_price'    => 'required|numeric',
                'selling_price' => 'required|numeric',
                'validity'      => 'required|string',
                'planID'        => 'required|string',
            ]);

            $planId = $request->plan_id;
            $Data = [
                'network'       =>  $request->network,
                'plan_size'     =>  $request->plan_size,
                'plan_measure'  =>  $request->plan_value,
                'cost_price'    =>  $request->cost_price,
                'plan_price'    =>  $request->selling_price,
                'plan_validity' =>  $request->validity,
                'vtpass_planid' =>  $request->planID,
            ];
            $this->dataServices->updateData($Data, $planId);
            return back()->with('success', 'Record Successfully Updated');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return back()->with('fail', 'Error Occured, Reason: ' . $e->getMessage());
        }
    }



    public function delete($id)
    {
        try {
            $this->dataServices->deleteData($id);
            return back()->with('success', 'Record Successfully Deleted !!!');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return back()->with('fail', 'Error Deleting Record !!!');
        }
    }

    public function histories()
    {
        $data = [
            'Histories' => $this->historyServices->getDataHistory()
        ];
        return view('control.data-histories', $data);
    }

    public function dataDetails($id)
    {
        $data = [
            'History' => $this->historyServices->getDataHistoryById($id)
        ];
        return view('control.view-data-details', $data);
    }


}
