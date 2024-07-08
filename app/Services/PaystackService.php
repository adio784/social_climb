<?php

namespace App\Services;

use App\Jobs\ProcessWebhookJob;
use App\Models\User;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaystackService
{
    use ResponseTrait;

    protected $secretKey;
    protected $publictKey;

    public function __construct(protected User $user)
    {
        $this->secretKey = "sk_test_360cf1a56394942c77852f2c2d0a967fd7515f7f";
        $this->publictKey = "pk_test_28120c5d86a5e06a8fdd2096891f8f164acb95c6";
    }

    public function createVirtualAccount(array $data)
    {
        try {

            // $url = 'https://api.paystack.co/dedicated_account';
            $url = 'https://api.paystack.co/dedicated_account/assign';
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json'
            ])->post($url, $data);
            return json_decode($response->body());
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return $this->errorResponse($ex->getMessage());
        }
    }

    public function verifyAccount(array $data): JsonResponse
    {
        try {
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return $this->errorResponse($ex->getMessage());
        }
    }

    public function initiatePayment(array $data): JsonResponse
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json'
            ])->post('https://api.paystack.co/transaction/initialize', $data);
            return $response;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return $this->errorResponse($ex->getMessage());
        }
    }

    public function verifyPayment(array $ref): JsonResponse
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json'
            ])->get('https://api.paystack.co/transaction/verify/' . $ref);
            return $response;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return $this->errorResponse($ex->getMessage());
        }
    }

    public function verifyWebhook(array $data): JsonResponse
    {
        try {
            ProcessWebhookJob::dispatch($data);
            return $this->successResponse("Webhook verified successfully.", $data);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return $this->errorResponse($ex->getMessage());
        }
    }
}
