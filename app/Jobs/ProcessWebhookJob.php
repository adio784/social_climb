<?php

namespace App\Jobs;

use App\Services\User\AuthService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $payload;

    public function __construct(array $payload)
    {
        //
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $body       = $this->payload;
        $data       = json_decode(json_encode($body));
        Log::info([$data]);

        switch ($data->event) {
            case "customeridentification.success":
                Log::error("Customer identification successful but not handled.");
                break;
            case "customeridentification.failed":
                Log::error("Customer identification failed.");
                break;
            case "dedicatedaccount.assign.success":
                $this->handleDedicatedAccountAssignSuccess($data);
                Log::info("Dedicated account assignment successful.");
                break;
            case "dedicatedaccount.assign.failed":
                Log::info("Dedicated account assignment failed.");
                break;
            default:
                Log::error(["Unhandled event: " => $data->event]);
                break;
        }
    }


    protected function handleDedicatedAccountAssignSuccess($data, AuthService $authservice)
    {
        try {
            $userData = [
                'account_name'      => $data->data->dedicated_account->account_name,
                'account_number'    => $data->data->dedicated_account->account_number,
                'bank_name'         => $data->data->dedicated_account->bank->name,
            ];
            $authservice->update($data->data->customer->email, $userData);
            Log::info("User account updated successfully with virtual account details.");
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            Log::error("User account could not be updated");
        }
    }

}
