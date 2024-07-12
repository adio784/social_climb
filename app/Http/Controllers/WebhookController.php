<?php

namespace App\Http\Controllers;

use App\Services\VtpassWebhookServices;
use App\Services\VtuServices;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    //
    public function __construct(protected VtpassWebhookServices $vtpassWebhookServices, protected VtuServices $vtuServices)
    {

    }

    public function requery(Request $request)
    {
        $id = $request->route('id');
        $data = [
            'request_id' => $id
        ];
        return $this->vtuServices->requery($data);
    }
    public function handleWebhook(Request $request)
    {
        return $request->all();
        return $this->vtpassWebhookServices->verifyWebhook($request->all());
    }
}
