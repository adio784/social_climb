<?php

namespace App\Http\Controllers;

use App\Services\HistoryServices;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
    public function  __construct(protected PaymentService $paymentService)
    {

    }


    public function histories()
    {
        $data = [
            'Histories' => $this->paymentService->getAllPayments()
        ];
        return view('control.fund-histories', $data);
    }
}
