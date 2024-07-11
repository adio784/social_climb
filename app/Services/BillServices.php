<?php

namespace App\Services;

use App\Models\Bill;

class BillServices
{
    public function allBill()
    {
        return Bill::all();
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
