<?php

namespace App\Services;

use App\Models\Airtime;

class AirtimeServices
{
    public function allAirtime()
    {
        return Airtime::join('networks', 'airtimes.network_id', 'networks.id')
                        ->select('airtimes.*', 'networks.name as network_name')
                        ->get();
    }



    public function getPlan($id)
    {
        return Airtime::join('networks', 'airtimes.network_id', 'networks.id')
                    ->select('airtimes.*', 'networks.name as network_name')
                    ->where('airtimes.id', $id)
                    ->first();
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
