<?php

namespace App\Http\Controllers;

use App\Http\Filters\ProductFilter;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Services\ProductService;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index(ProductFilter $filter): JsonResponse
    {
        return $this->service->get($filter);
    }

    public function show(Product $product): JsonResponse
    {
        return $this->service->find($product);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        return $this->service->create($request);
    }

    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        return $this->service->update($request, $product);
    }

    public function destroy(Product $product): JsonResponse
    {
        return $this->service->delete($product);
    }
}
