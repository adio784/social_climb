<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class VtpassWebhookServices
{

    public function verifyWebhook(array $Details)
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
