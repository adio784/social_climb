<?php

namespace App\Services;

use App\Models\Data;

class DataServices
{
    public function allData()
    {
        return Data::all();
    }

    public function getData($id, $planId)
    {
        return Data::where('network', $id)->where('id', $planId)->first();
    }

    public function getDataPlans($id)
    {
        return Data::where('network', $id)->get();
    }

    public function createData(array $Details)
    {
        return Data::create($Details);
    }

    public function updateData(array $Details, $id)
    {
        return Data::whereId($id)->update($Details);
    }

    public function deleteData($id)
    {
        return Data::whereId($id)->delete();
    }
}
