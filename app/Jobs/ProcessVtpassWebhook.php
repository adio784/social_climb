<?php

namespace App\Jobs;

use App\Services\HistoryServices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessVtpassWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $payload;
    protected $paymentService;

    /**
     * Create a new job instance.
     */
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
        $body           = $this->payload;
        $data           = json_decode(json_encode($body));
        $histortService = app(HistoryServices::class);
        Log::info([$data]);
        Switch ($data->data->content->transactions->status) {
            case 'delivered':
                Log::debug(['Data Received' => $data]);
                $this->processSuccessTransferEnvt($data, $histortService);
                break;
            default:
                Log::error(["Unhandled event: " => $data->eventType]);
                break;
        }
        http_response_code(200);
    }

    public function processSuccessTransferEnvt($data, HistoryServices $histortService)
    {
        try {
            $PaymentRef = $data->eventData->product->reference;
            $Payment_id = $data->eventData->paymentReference;
            $Status     = $data->eventData->paymentStatus;
            $Email      = $data->eventData->customer->email;
            $User       = User::where('email', $Email)->first();
            $Userwallet = $User->wallet_balance;
            $histortService->createPayment([
                'user_id' => $User->id,
                'reference' => $PaymentRef,
                'payment_id' => $Payment_id,
                'status' => $Status,
                'amount' => $data->eventData->amountPaid,
                'email' => $Email
            ]);
            $Amount = $data->eventData->amountPaid;
            $Amt    = $Amount - 50;
            if ($Amt > 50) {
                if (!is_null($User)) {
                    //Deposit Payment amount to Deposit
                    $PaymentDetails = [
                        'user_id' => $User->id,
                        'amount' => $Amt,
                        'type' => 'deposit',
                        'payment_id' => $Payment_id,
                        'payment_mode' => 'Vtpass',
                        'status' => $Status
                    ];
                    $paymentService->createPayment($PaymentDetails);
                    $newBal = $Userwallet + $Amt;
                    $User->update(['wallet_balance' => $newBal]);
                }
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }
    }

    public function updateWalletBalance()
    {
        $user = User::where('wallet_balance', '>', 0)->get();
        foreach ($user as $key => $value) {
            $value->update(['wallet_balance' => $value->wallet_balance - 50]);
        }
    }
}
