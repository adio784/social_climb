<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SimhostServices
{

    public function makePayment(array $Details)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer yrtruytiuyi7yui797976867',
            'Content-Type' => 'application/json'
        ])->post('https://api.smeify.com/api/v2/data', $Details);
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
