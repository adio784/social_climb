<?php
namespace App\Services;

use App\Models\Order;

class OrderServices
{
    public function getallOrders()
    {
        return Order::all();
    }

    public function createOrder(array $data)
    {
        return Order::create($data);
    }

    public function getSuccessfulOrder()
    {
        return Order::where('is_active', 1)->orderBy('id', 'desc')->get();
    }

    public function getFailedOrder()
    {
        return Order::where('is_active', 0)->orderBy('id', 'desc')->get();
    }

    public function getOrderById($id)
    {
        return Order::find($id);
    }

    public function getOrderByUser($id)
    {
        return Order::where('user_id', $id)->get();
    }

    public function updateOrder($id, $data)
    {
        return Order::where('id', $id)->update($data);
    }

    public function deleteOrder($id)
    {
        return Order::where('id', $id)->delete();
    }
}
