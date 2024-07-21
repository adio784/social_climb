<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Http\JsonResponse;

class PaymentService
{

    public function getAllPayments()
    {

        return Payment::join('users', 'users.id', 'payments.user_id')
                        ->select('users.username', 'payments.*')
                        ->get();
    }

    public function createPayment(array $data)
    {
        return Payment::create($data);
    }

    public function getPaymentById(int $id)
    {
        return Payment::where('payment_id', $id)->first();
    }
}
