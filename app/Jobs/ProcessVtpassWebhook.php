<?php

namespace App\Jobs;

use App\Services\HistoryServices;
use App\Services\User\AuthService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessVtpassWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $data;
    protected $payload;
    protected $userServices;
    protected $historyServices;

    public function __construct(array $payload)
    {
        //
        $this->payload          = $payload;
        $this->userServices     = app(AuthService::class);
        $this->historyServices  = app(HistoryServices::class);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $data           = json_decode(json_encode($this->payload));
        Log::info([$data]);

        Switch ($data->data->content->transactions->status) {
            case 'delivered':
                Log::debug(['Data Received' => $data]);
                $this->handleSuccessfulRequest($data);
                break;
            default:
                Log::error(["Unhandled event: " => $data->eventType]);
                $this->handleFailedRequest($data);
                break;
        }
        http_response_code(200);
    }

    public function checkTransactionId($id, $status, $refund = 0)
    {
        try {
            $Details = ['status' => $status, 'refund' => $refund];
            $historyServices= app(HistoryServices::class);
            $chkData = $historyServices->getDataHistory($id);
            $chkAirt = $historyServices->getAirtimeHistory($id);
            $chkBill = $historyServices->getBillHistory($id);
            $chkCable = $historyServices->getCableHistory($id);

            if ( !is_null($chkData) ) {
                return $this->historyServices->updateDataHistory($id, $Details);
            } else if ( !is_null($chkAirt) ) {;
                return $this->historyServices->updateAirtimeHistory($id, $Details);
            } else if ( !is_null($chkBill) ) {
                return $this->historyServices->updateBillHistory($id, $Details);
            } else if ( !is_null($chkCable) ) {
                return $this->historyServices->updateCableHistory($id, $Details);
            } else {
                return false;
            }
            return false;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }
    }

    public function handleSuccessfulRequest($data)
    {
        try {
            $Reference  = $data->data->content->transactions->id;
            $Status     = $data->data->content->transactions->status;
            return $this->checkTransactionId($Reference, $Status);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }
    }

    public function handleFailedRequest($data)
    {
        try {

            $reference  = $data->data->content->transactions->id;
            $status     = $data->data->content->transactions->status;

            $history = $this->getTransactionDetails($reference);
            // Get transaction details to process refund
            // $history = $this->historyServices->getAirtimeHistory($reference) ??
            //            $this->historyServices->getDataHistory($reference) ??
            //            $this->historyServices->getBillHistory($reference) ??
            //            $this->historyServices->getCableHistory($reference);

            if ( $history ) {
                $userId = $history->user_id;
                $amountPaid = $this->getAmountPaid($history);;

                $user = $this->userServices->profile($userId);
                $newBalance = $user->wallet_balance + $amountPaid;
                $this->userServices->updateProfile($userId, ['wallet_balance' => $newBalance]);

                return $this->checkTransactionId($reference, $status, 1);
            }

        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }
    }

    public function getTransactionDetails($reference)
    {
        $historyServices = $this->historyServices;
        $chkData = $historyServices->getDataHistory($reference);
        if ($chkData) {
            $chkData->amount_paid_field = 'plan_amount';
            return $chkData;
        }

        $chkAirt = $historyServices->getAirtimeHistory($reference);
        if ($chkAirt) {
            $chkAirt->amount_paid_field = 'amount_paid';
            return $chkAirt;
        }

        $chkBill = $historyServices->getBillHistory($reference);
        if ($chkBill) {
            $chkBill->amount_paid_field = 'paid_amount';
            return $chkBill;
        }

        $chkCable = $historyServices->getCableHistory($reference);
        if ($chkCable) {
            $chkCable->amount_paid_field = 'plan_amount';
            return $chkCable;
        }

        return null;
    }

    public function getAmountPaid($history)
    {
        $amountPaidField = $history->amount_paid_field ?? 'amount_paid';
        return $history->$amountPaidField;
    }


}
