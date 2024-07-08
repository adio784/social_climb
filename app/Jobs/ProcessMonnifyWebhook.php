<?php

namespace App\Jobs;

use App\Models\Payment;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessMonnifyWebhook implements ShouldQueue
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
        $paymentService = app(PaymentService::class);
        Log::info([$data]);
        Switch ($data->eventType) {
            case 'SUCCESSFUL_TRANSACTION':
                Log::debug(['Data Received' => $data]);
                $this->handleSuccessTransferEnvt($data, $paymentService);
                break;
            default:
                Log::error(["Unhandled event: " => $data->eventType]);
                break;
        }
        http_response_code(200);
    }

    public function handleSuccessTransferEnvt($data, PaymentService $paymentService)
    {
        try {
            $PaymentRef = $data->eventData->product->reference;
            $Payment_id = $data->eventData->paymentReference;
            $Status     = $data->eventData->paymentStatus;
            $Email      = $data->eventData->customer->email;
            $User       = User::where('email', $Email)->first();
            $Userwallet = $User->wallet_balance;
            $Amt        = ($data->eventData->amountPaid);
            $Amount     = $Amt - 50;

            if ($Amt > 50) {
                if (!is_null($User)) {
                    //Deposit Payment amount to Deposit
                    $PaymentDetails = [
                        'user_id'       =>  $User->id,
                        'reference'     =>  $PaymentRef,
                        'amount'        =>  $Amount,
                        'payment_id'    =>  $Payment_id,
                        'payment_mode'  =>  'Monnify',
                        'status'        =>  $Status
                    ];
                    $paymentService->createPayment($PaymentDetails);
                    $newBal     = $Userwallet + $Amount;
                    $User->update(['wallet_balance' => $newBal]);
                    Log::info(["Info" => "Payment Successful"]);
                } else {
                    Log::debug(['Data Error' => 'User not found !!!']);
                }
            } else {
                Log::debug(['Data Error' => 'User not found !!!']);
            }
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            Log::error("User account could not be updated");
        }
    }
}
