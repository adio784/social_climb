<?php

namespace App\Services;

use App\Models\AirtimeNetwork;
use App\Models\BillNetwork;
use App\Models\CableNetwork;
use App\Models\DataNetwork;
use App\Models\Network;
use Illuminate\Support\Facades\Http;

class NetworkServices
{

    public function createNetwork(array $Details)
    {
        return Network::create($Details);
    }
    public function all()
    {
        return Network::all();
    }


    public function getNetwork($id)
    {
        return Network::whereId($id)->first();
    }

    public function updateNetwork($id, array $Details)
    {
        return Network::whereId($id, )->update($Details);
    }

    public function deleteNetwork($id)
    {
        return Network::whereId($id)->delete();
    }





}
