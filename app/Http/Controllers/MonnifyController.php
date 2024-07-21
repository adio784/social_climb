<?php

namespace App\Http\Controllers;

use App\Services\MonnifyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MonnifyController extends Controller
{
    //
    public function __construct(protected MonnifyService $monnifyService)
    {

    }

    public function handle(Request $request)
    {
        Log::info(['success in controller' => true, 'data' => $request->all()]);
        $this->monnifyService->verifyWebhook($request->all());
        return response()->json(['success' => true]);
    }
}
