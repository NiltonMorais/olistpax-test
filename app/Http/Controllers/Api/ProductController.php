<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    /**
     * @var ProductService
     */
    private $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data = $this->service->getAll();
        return ProductResource::collection($data);
    }

    public function store(ProductRequest $request)
    {
        $data = $this->service->create($request);
        return new ProductResource($data);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(ProductRequest $request, Product $product)
    {
        if($this->service->update($product, $request)){
            return response()->json(['message' => 'Updated successfully!']);
        }

        return response()->json(['message' => 'Error updating record!'], 500);
    }

    public function destroy(Product $product)
    {
        if($this->service->delete($product)){
            return response()->json([], 204);
        }

        return response()->json(['message' => 'Error deleting record!'], 500);
    }
}
