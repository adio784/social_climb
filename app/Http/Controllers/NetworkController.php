<?php

namespace App\Http\Controllers;

use App\Services\NetworkServices;
use Illuminate\Http\Request;

class NetworkController extends Controller
{
    //
    public function __construct(protected NetworkServices $networkService)
    {

    }

    public function getNetwork()
    {
        return $this->networkService->all();
    }
}
