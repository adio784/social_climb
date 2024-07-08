<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\GetfollowerService;
use App\Services\ProductServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ServiceController extends Controller
{
    //
    protected $getFollowerService;
    protected $productService;
    public function __construct(GetfollowerService $getFollowerService, ProductServices $productService)
    {
        $this->getFollowerService = $getFollowerService;
        $this->productService = $productService;
    }


    public function list()
    {
        $data = $this->getFollowerService->services();
        foreach ($data as $serviceData) {
            Product::updateOrCreate(
                [
                    'product_id'    => $serviceData->service,
                    'name'          => $serviceData->name,
                    'product_rate'  => $serviceData->rate,
                    'category'      => $serviceData->category,
                    'min'           => $serviceData->min,
                    'max'           => $serviceData->max,
                    'product_type'  => $serviceData->type,
                    'description'   => $serviceData->desc,
                    'dripfeed'      => $serviceData->dripfeed,
                    'refill'        => $serviceData->refill,
                ]
            );
        }
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function services()
    {
        $response = $this->productService->getActiveService();
        return response()->json(['success' => true, 'data' =>  $response ]);
    }

    public function balance()
    {
        $balance = $this->getFollowerService->balance();

        return response()->json(['success' => true, 'data' =>  $balance ]);
    }

}
