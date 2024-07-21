<?php

namespace App\Http\Controllers;

use App\Services\ProductServices;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public function create(Request $request)
    {
        try {
            $request->validate([
                'productId'     => 'required',
                'name'          => 'required|string|max:255',
                'category'      => 'required|string|max:255',
                'cost_rate'     => 'required|numeric',
                'product_rate'  => 'required|numeric',
                'min'           => 'required|numeric',
                'max'           => 'required|numeric',
                'product_type'  => 'required|string|max:255',
                'description'   => 'nullable|string|max:255',
                'dripfeed'      => 'required|numeric',
                'refill'        => 'required|numeric',
            ]);
            $data = [
                'product_id'    => $request->productId,
                'name'          => $request->name,
                'category'      => $request->category,
                'cost_rate'     => $request->cost_rate,
                'product_rate'  => $request->product_rate,
                'min'           => $request->min,
                'max'           => $request->max,
                'product_type'  => $request->product_type,
                'description'   => $request->description,
                'dripfeed'      => $request->dripfeed,
                'refill'        => $request->refill
            ];
            $this->productService->createProduct($data);
            return back()->with('success', 'Record Successfully Created');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return back()->with('fail', 'Error Occured, Reason: ' . $e->getMessage());
        }
    }

    public function updateProduct(Request $request)
    {
        try {
            $id = $request->plan_id;
            $request->validate([
                'productId'     => 'required',
                'name'          => 'required|string|max:255',
                'category'      => 'required|string|max:255',
                'cost_rate'     => 'required|numeric',
                'product_rate'  => 'required|numeric',
                'min'           => 'required|numeric',
                'max'           => 'required|numeric',
                'product_type'  => 'required|string|max:255',
                'description'   => 'nullable|string|max:255',
                'dripfeed'      => 'required|numeric',
                'refill'        => 'required|numeric',
            ]);
            $data = [
                'product_id'    => $request->productId,
                'name'          => $request->name,
                'category'      => $request->category,
                'cost_rate'     => $request->cost_rate,
                'product_rate'  => $request->product_rate,
                'min'           => $request->min,
                'max'           => $request->max,
                'product_type'  => $request->product_type,
                'description'   => $request->description,
                'dripfeed'      => $request->dripfeed,
                'refill'        => $request->refill
            ];
            $this->productService->updateProduct($id, $data);
            return back()->with('success', 'Record Successfully Updated');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return back()->with('fail', 'Error Occured, Reason: ' . $e->getMessage());
        }
    }


    public function deleteProduct($id)
    {
        try {
            $this->productService->deleteProduct($id);
            return back()->with('success', 'Record Successfully Deleted !!!');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return back()->with('fail', 'Error Deleting Record !!!');
        }

        // return $this->successResponse("Deleted Successful", $data);
    }

    public function activateProduct($id)
    {
        try {
            $data = ['is_active' => 1];
            $this->productService->updateProduct($id, $data);
            return back()->with('success', 'Record Successfully Deleted !!!');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return back()->with('fail', 'Error Deleting Record !!!');
        }

        // return $this->successResponse("Successful", $response);
    }

    public function deactivateProduct($id)
    {

        // return $this->successResponse("Successful", $response);
        try {
            $data = ['is_active' => 0];
            $this->productService->updateProduct($id, $data);
            return back()->with('success', 'Record Successfully Deleted !!!');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return back()->with('fail', 'Error Deleting Record !!!');
        }
    }

    // Administrative functionality .....................
    public function index()
    {
        $data = [
            'Pricing' => $this->productService->getallServices()
        ];
        return view('control.products', $data);
    }

    public function createProduct()
    {
        return view('control.create-product');
    }

    public function read($id)
    {
        $data = [
            'Plan'  => $this->productService->getProductById($id)
        ];
        return view('control.product', $data);
    }


}
