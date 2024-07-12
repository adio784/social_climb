<?php

namespace App\Services;

use App\Models\Cable;

class CableServices
{
    public function allCable()
    {
        return Cable::all();
    }

    public function getCable($id)
    {
        return Cable::where('cable_id', $id)->get();
    }

    public function getACable($id, $planId)
    {
        return Cable::where('cable_id', $id)->where('plan_code', $planId)->first();
    }

    public function createCable(array $Details)
    {
        return Cable::create($Details);
    }

    public function updateCable(array $Details, $id)
    {
        return Cable::whereId($id)->update($Details);
    }

    public function deleteCable($id)
    {
        return Cable::whereId($id)->delete();
    }
}
