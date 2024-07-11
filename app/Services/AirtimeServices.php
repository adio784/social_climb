<?php

namespace App\Services;

use App\Models\Airtime;

class AirtimeServices
{
    public function allAirtime()
    {
        return Airtime::all();
    }

    public function getAirtime($id)
    {
        return Airtime::whereId($id)->first();
    }

    public function createAirtime(array $Details)
    {
        return Airtime::create($Details);
    }

    public function updateAirtime(array $Details, $id)
    {
        return Airtime::whereId($id)->update($Details);
    }

    public function deleteAirtime($id)
    {
        return Airtime::whereId($id)->delete();
    }
}
