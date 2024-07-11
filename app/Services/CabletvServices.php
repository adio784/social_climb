<?php

namespace App\Services;

use App\Models\Cabletv;

class CabletvServices
{
    public function allCabletv()
    {
        return Cabletv::all();
    }

    public function getCabletv($id)
    {
        return Cabletv::whereId($id)->first();
    }

    public function getCabletvByName($name)
    {
        return Cabletv::where('name', $name)->first();
    }

    public function createCabletv(array $Details)
    {
        return Cabletv::create($Details);
    }

    public function updateCabletv(array $Details, $id)
    {
        return Cabletv::whereId($id)->update($Details);
    }

    public function deleteCabletv($id)
    {
        return Cabletv::whereId($id)->delete();
    }
}
