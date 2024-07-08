<?php
namespace App\Services;

use App\Models\Product;

class ProductServices
{
    public function getallServices()
    {
        return Product::all();
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

    public function updateProduct($id, $data)
    {
        return Product::where('id', $id)->update($data);
    }

    public function deleteProduct($id)
    {
        return Product::where('id', $id)->delete();
    }
}
