<?php

namespace App\Services;

use App\Models\Cable;

class CableServices
{
    public function allCable()
    {
        return Cable::join('cable_tvs', 'cables.cable_id', 'cable_tvs.id')
                    ->select('cables.*', 'cable_tvs.name as cable_name')
                    ->get();
    }

    public function getPlan($id)
    {
        return Cable::join('cable_tvs', 'cables.cable_id', 'cable_tvs.id')
                    ->select('cables.*', 'cable_tvs.name as cable_name')
                    ->where('cables.id', $id)
                    ->first();
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
