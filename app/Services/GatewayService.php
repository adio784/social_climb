<?php

namespace App\Services;

use App\Models\PaymentGateway;
use App\Models\User;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GatewayService
{
    use ResponseTrait;

    public function getAllGateways()
    {
        return PaymentGateway::all();
    }

    public function getActiveGateway()
    {
        return PaymentGateway::where('is_active', 1)->first();
    }


}
