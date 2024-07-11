<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmeifyServices
{

    public function makePayment(array $Details)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Token getCredentials->access_token',
            'Content-Type' => 'application/json'
        ])->post('https://tentendata.com.ng/api/data/', $Details);
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
