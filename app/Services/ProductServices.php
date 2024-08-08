<?php
namespace App\Services;

use App\Models\Product;
use App\Models\Service;

class ProductServices
{
    public function getallServices()
    {
        return Product::all();
    }

    public function createProduct(array $Data)
    {
        return Product::create($Data);
    }

    public function getActiveService()
    {
        return Product::where('is_active', 1)->orderBy('id', 'desc')->get();
    }

    public function getInactiveService()
    {
        return Product::where('is_active', 0)->orderBy('id', 'desc')->get();
    }

    public function getProductById($id)
    {
        return Product::find($id);
    }

    public function getProductByProductId($id)
    {
        return Product::where('product_id', $id)->first();
    }

    public function updateProduct($id, $data)
    {
        return Product::where('id', $id)->update($data);
    }

    public function deleteProduct($id)
    {
        return Product::where('id', $id)->delete();
    }

    public function getServices()
    {
        return Service::all();
    }

    public function updateService($id, $data)
    {
        return Service::where('id', $id)->update($data);
    }
}
