<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class VtuServices
{

    public function makePayment(array $Details)
    {
        $response = Http::withBasicAuth(
            'moyofolatimothy@gmail.com',
            'Damola24..'
            )->post(
                'https://api-service.vtpass.com/api/pay',
                $Details
            );
        return $response;
    }


    public function validate(array $Details)
    {
        $response = Http::withBasicAuth(
            'moyofolatimothy@gmail.com',
            'Damola24..'
            )->post(
                'https://sandbox.vtpass.com/api/merchant-verify',
                $Details
            );
        return $response;
    }


    public function handleWebhook(array $Details)
    {
        $response = Http::withBasicAuth(
            'moyofolatimothy@gmail.com',
            'Damola24..'
            )->post(
                'https://api-service.vtpass.com/api/pay',
                $Details
            );
        return $response;
    }


}
