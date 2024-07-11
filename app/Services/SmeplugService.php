<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmeplugService
{

    public function makePayment(array $Details)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer 90c5b5fa939ca9e9df10d517bd3915b651aa6810f1fddb8a3977e8c5a1e2b74a',
            'Content-Type' => 'application/json'
        ])->post('https://smeplug.ng/api/v1/data/purchase', $Details);
        return $response;
    }


    public function getTransaction(array $Details)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer 90c5b5fa939ca9e9df10d517bd3915b651aa6810f1fddb8a3977e8c5a1e2b74a',
            'Content-Type' => 'application/json'
        ])->post('https://smeplug.ng/api/v1/data/purchase', $Details);
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
