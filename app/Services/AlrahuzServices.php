<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AlrahuzServices
{

    public function makePayment(array $Details)
    {
        $response = Http::post('https://api.simservers.io', $Details);
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
