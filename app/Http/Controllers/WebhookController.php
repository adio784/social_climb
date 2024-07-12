<?php

namespace App\Http\Controllers;

use App\Services\VtpassWebhookServices;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    //
    public function __construct(protected VtpassWebhookServices $vtpassWebhookServices)
    {

    }
    public function handleWebhook(Request $request)
    {
        return $this->vtpassWebhookServices->verifyWebhook($request->all());
    }
}
