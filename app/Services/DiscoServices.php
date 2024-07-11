<?php

namespace App\Services;

use App\Models\Disco;

class DiscoServices
{
    public function allDisco()
    {
        return Disco::all();
    }

    public function getDisco($id)
    {
        return Disco::whereId($id)->first();
    }

    public function getDiscoByName($name)
    {
        return Disco::where('name', $name)->first();
    }

    public function createDisco(array $Details)
    {
        return Disco::create($Details);
    }

    public function updateDisco(array $Details, $id)
    {
        return Disco::whereId($id)->update($Details);
    }

    public function deleteDisco($id)
    {
        return Disco::whereId($id)->delete();
    }
}
