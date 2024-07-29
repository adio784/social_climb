<?php

namespace App\Http\Controllers;

use App\Models\Network;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DasboardController extends Controller
{
    //
    public function index()
    {
        $data = [
            'totalUser' => User::count(),
            'network'   => Network::count(),
            'product'   => Product::count(),
            'order'     => Order::count(),
            'Permissions'=> Auth::user()->getAllPermissions(),
            'orders'    => Order::join('users', 'users.id', 'orders.user_id')
                                ->join('products', 'products.id', 'orders.product_id')
                                ->select('users.username', 'products.name', 'products.product_rate', 'orders.*')
                                ->orderBy('orders.id', 'desc')
                                ->limit(2)
                                ->get()
        ];
        return view('dashboard', $data);
    }

    public function getPermissions(Request $request)
    {
        $permissions = auth()->user()->getAllPermissions();
        return response()->json($permissions);
    }
}
