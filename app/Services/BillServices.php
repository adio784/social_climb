<?php

namespace App\Services;

use App\Models\Bill;

class BillServices
{
    public function allBill()
    {
        return Bill::join('discos', 'bills.disco_id', 'discos.id')
                    ->select('bills.*', 'discos.name as disco_name')
                    ->get();
    }

    public function getPlan($id)
    {
    return Bill::join('discos', 'bills.disco_id', 'discos.id')
            ->select('bills.*', 'discos.name as disco_name')
            ->where('bills.id', $id)
            ->first();
    }

    public function getBill($id)
    {
        return Bill::whereId($id)->first();
    }

    public function createBill(array $Details)
    {
        return Bill::create($Details);
    }

    public function updateBill(array $Details, $id)
    {
        return Bill::whereId($id)->update($Details);
    }

    public function deleteBill($id)
    {
        return Bill::whereId($id)->delete();
    }
}
