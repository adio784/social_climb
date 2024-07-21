<?php

namespace App\Services;

use App\Models\AirtimeHistory;
use App\Models\BillHistory;
use App\Models\CableHistory;
use App\Models\DataHistory;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;

class HistoryServices
{

    public function createDataHistory(array $Details)
    {
        return DataHistory::create($Details);
    }


    public function createAirtimeHistory(array $Details)
    {
        return AirtimeHistory::create($Details);
    }

    public function createBillHistory(array $Details)
    {
        return BillHistory::create($Details);
    }

    public function createCableHistory(array $Details)
    {
        return CableHistory::create($Details);
    }

    // Get Histories .......................................................
    public function getDataHistory()
    {
        return DataHistory::join('users', 'users.id', 'data_histories.user_id')
                           ->join('data', 'data.vtpass_planid', 'data_histories.plan_id')
                           ->select('users.username', 'data.plan_size', 'data.plan_measure', 'data_histories.*')
                           ->get();
    }


    public function getAirtimeHistory()
    {
        return AirtimeHistory::join('users', 'users.id', 'airtime_histories.user_id')
                              ->select('users.username', 'airtime_histories.*')
                              ->get();
    }

    public function getBillHistory()
    {
        return BillHistory::join('users', 'users.id', 'bill_histories.user_id')
                            ->join('discos', 'discos.id', 'bill_histories.disco_id')
                            ->select('users.username', 'discos.name', 'bill_histories.*')
                            ->get();
    }

    public function getCableHistory()
    {
        return CableHistory::join('users', 'users.id', 'cable_histories.user_id')
                            ->join('cable_tvs', 'cable_tvs.id', 'cable_histories.cable_id')
                            ->select('users.username', 'cable_tvs.name', 'cable_histories.*')
                            ->get();
    }

    public function getSocioHistory()
    {
        return Order::join('users', 'users.id', 'orders.user_id')
                            ->join('products', 'products.id', 'orders.product_id')
                            ->select('users.username', 'products.name', 'products.product_rate', 'orders.*')
                            ->get();
    }

    // Get User Histories .......................................................
    public function getUserDataHistory($id)
    {
        return DataHistory::where('user_id', $id)->get();
    }


    public function getUserAirtimeHistory($id)
    {
        return AirtimeHistory::where('user_id', $id)->get();
    }

    public function getUserBillHistory($id)
    {
        return BillHistory::where('user_id', $id)->get();
    }

    public function getUserCableHistory($id)
    {
        return CableHistory::where('user_id', $id)->get();
    }

    public function getUserSocialHistory($id)
    {
        return CableHistory::where('user_id', $id)->get();
    }

    public function getUserFundHistory($id)
    {
        return Payment::where('user_id', $id)->get();
    }

    // GET HISTORY BY HISTORY ID .........................................................


    public function getDataHistoryById($id)
    {
        return DataHistory::join('users', 'users.id', 'data_histories.user_id')
                           ->join('data', 'data.vtpass_planid', 'data_histories.plan_id')
                           ->select('users.username', 'data.plan_size', 'data.plan_measure', 'data_histories.*')
                           ->where('data_histories.id', $id)
                           ->first();
    }


    public function getAirtimeHistoryById($id)
    {
        return AirtimeHistory::join('users', 'users.id', 'airtime_histories.user_id')
                              ->select('users.username', 'airtime_histories.*')
                              ->where('airtime_histories.id', $id)
                              ->first();
    }

    public function getBillHistoryById($id)
    {
        return BillHistory::join('users', 'users.id', 'bill_histories.user_id')
                            ->join('discos', 'discos.id', 'bill_histories.disco_id')
                            ->select('users.username', 'discos.name', 'bill_histories.*')
                            ->where('bill_histories.id', $id)
                            ->first();
    }

    public function getCableHistoryById($id)
    {
        return CableHistory::join('users', 'users.id', 'cable_histories.user_id')
                            ->join('cable_tvs', 'cable_tvs.id', 'cable_histories.cable_id')
                            ->select('users.username', 'cable_tvs.name', 'cable_histories.*')
                            ->where('cable_histories.id', $id)
                            ->first();
    }



    public function getSocioHistoryById($id)
    {
        return Order::join('users', 'users.id', 'orders.user_id')
                            ->join('products', 'products.id', 'orders.product_id')
                            ->select('users.username', 'products.name', 'products.product_rate', 'products.category', 'orders.*')
                            ->where('orders.id', $id)
                            ->first();
    }








}
