<?php

namespace App\Http\Controllers;

use App\Models\Network;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;


class DasboardController extends Controller
{
    //
    use ResponseTrait;
    public function index()
    {
        $data = [
            'totalUser' => User::count(),
            'network'   => Network::count(),
            'product'   => Product::count(),
            'order'     => Order::count(),
            'Permissions' => Auth::user()->getAllPermissions(),
            'orders'    => Order::join('users', 'users.id', 'orders.user_id')
                ->join('products', 'products.id', 'orders.product_id')
                ->select('users.username', 'products.name', 'products.product_rate', 'orders.*')
                ->orderBy('orders.id', 'desc')
                ->limit(2)
                ->get(),
        ];
        return view('dashboard', $data);
    }

    public function getProfileVisits()
    {
        $profileVisits = Visit::selectRaw('MONTH(visited_at) as month, COUNT(*) as visits')
            ->groupBy('month')
            ->get()
            ->pluck('visits', 'month');

        return response()->json($profileVisits);
    }

    public function profilevisits(Request $request)
    {
        try {
            $user_id =  Auth::user()->id;
            $ip_address = $this->getRealIpAddr();
            $data = [ 'user_id'=>$user_id, 'ip_address'=>$ip_address];
            Visit::create([
                'user_id' => $user_id,
                'ip_address' => $ip_address,
            ]);
            return $this->successResponse('Request successful', $data);
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), "Something went wrong", 401);
        }
    }

    private function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            // Check IP from shared internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // Check IP passed from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            // Default fallback
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }


    public function getPermissions(Request $request)
    {
        $permissions = auth()->user()->getAllPermissions();
        return response()->json($permissions);
    }
}
