<?php
namespace App\Services;

use App\Jobs\ProcessMonnifyWebhook;
use Exception;
use App\Traits\ResponseTrait;
use App\Jobs\ProcessWebhookJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MonnifyService
{
    use ResponseTrait;
    private $monnify_baseUrl, $monnify_apiKey, $monnify_secretKey;
    public function __construct()
    {
        $this->monnify_baseUrl = "https://sandbox.monnify.com";
        $this->monnify_apiKey = "MK_TEST_AJWJC1WL3N";
        $this->monnify_secretKey = "HXWFH2GMCXEY19XJUH8KY3Z682QM0AZN";
    }

    public function getToken(){
        $response = Http::withBasicAuth($this->monnify_apiKey, $this->monnify_secretKey)->post($this->monnify_baseUrl.'/api/v1/auth/login');
        return json_decode($response)->responseBody->accessToken;
    }

    public function createVirtualAccount(array $data)
    // :JsonResponse
    {

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '. $this->getToken(),
                'Content-Type' => 'application/json'
            ])->post($this->monnify_baseUrl.'/api/v2/bank-transfer/reserved-accounts', $data);
            $return = json_decode($response);
            return $return;
        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage());
        }
    }

    public function verifyWebhook(array $data): JsonResponse
    {
        try {
            ProcessMonnifyWebhook::dispatch($data);
            return $this->successResponse("Webhook verified successfully.", $data);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return $this->errorResponse($ex->getMessage());
        }
    }

}
