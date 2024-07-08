<?php

namespace App\Http\Controllers;

use App\Services\ProductServices;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    use ResponseTrait;

    protected $productService;
    public function __construct(ProductServices $productService)
    {
        $this->productService = $productService;
    }
    public function products()
    {
        $data = $this->productService->getActiveService();
        return $this->successResponse("Successful", $data);
    }

    public function getProductById($id)
    {
        $data = $this->productService->getProductById($id);
        return $this->successResponse("Successful", $data);
    }

    public function updateProduct(Request $request)
    {
        $request->validate([
            'service' => 'required',
            'name' => 'required',
            'rate' => 'required',
            'category' => 'required',
            'min' => 'required',
            'max' => 'required',
            'type' => 'required',
            'desc' => 'required',
            'dripfeed' => 'required',
            'refill' => 'required',
            'is_active' => 'required',
        ]);
        $id = $request->route('id');
        $data = [
            'product_id'    => $request->service,
            'name'          => $request->name,
            'product_rate'  => $request->rate,
            'category'      => $request->category,
            'min'           => $request->min,
            'max'           => $request->max,
            'product_type'  => $request->type,
            'description'   => $request->desc,
            'dripfeed'      => $request->dripfeed,
            'refill'        => $request->refill,
            'is_active'     => $request->is_active,
        ];
        $response = $this->productService->updateProduct($id, $data);
        return $this->successResponse("Updated Successful", $response);
    }


    public function deleteProduct($id)
    {
        $data = $this->productService->deleteProduct($id);
        return $this->successResponse("Deleted Successful", $data);
    }

    public function activateProduct($id)
    {
        $data = ['is_active' => 1];
        $response = $this->productService->updateProduct($id, $data);
        return $this->successResponse("Successful", $response);
    }

    public function deactivateProduct($id)
    {
        $data = ['is_active' => 0];
        $response = $this->productService->updateProduct($id, $data);
        return $this->successResponse("Successful", $response);
    }


}
