<?php

namespace App\Services;

use App\Models\AirtimeHistory;
use App\Models\BillHistory;
use App\Models\CableHistory;
use App\Models\DataHistory;
use Illuminate\Support\Facades\Http;

class HistoryServices
{

    public function createDataHistory(array $Details)
    {
        return DataHistory::create($Details);
    }

    public function createAirtimeHistory(array $Details)
    {
        return AirtimeHistory::create($Details);
    }

    public function createBillHistory(array $Details)
    {
        return BillHistory::create($Details);
    }

    public function createCableHistory(array $Details)
    {
        return CableHistory::create($Details);
    }





}
