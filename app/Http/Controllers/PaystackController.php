<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessWebhookJob;
use App\Services\MonnifyService;
use App\Services\PaystackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaystackController extends Controller
{
    //
    public function __construct(protected PaystackService $paystackService)
    {
    }

    public function createdAccount(Request $request)
    {
        $ran = $request->phone . random_int(1000000000, 9999999999);
        $name = $request->first_name .' '. $request->last_name;
        $details = [
            "accountReference"=> $ran,
            "accountName"=> $name,
            "currencyCode"=> "NGN",
            "contractCode"=> "5787668243",
            "customerEmail"=> $request->email,
            "bvn"=> "22318673488",
            "customerName"=> $name,
            "getAllAvailableBanks"=> false,
            "preferredBanks"=> ["035"]

        ];
        return $this->monnifyService->createVirtualAccount($details);
    }

    public function handle(Request $request)//: JsonResponse
    {
        Log::info(['success in controller' => true, 'data' => $request->all()]);
        $this->paystackService->verifyWebhook($request->all());
        return response()->json(['success' => true]);
    }
}


