<?php

namespace App\Http\Services;

use App\Http\Filters\ProductFilter;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class ProductService
{
    public function get(ProductFilter $filter): JsonResponse
    {
        $products = Product::filter($filter)->product()->paginate();

        return success_response(
            data: new ResourceCollection($products),
            message: __('messages.retrieved', ['model' => __('models/product.plural')]),
        );
    }

    public function create(StoreProductRequest $request): JsonResponse
    {
        $product = Product::create($request->validated());

        return success_response(
            data: new ProductResource($product),
            message: __('messages.saved', ['model' => __('models/product.singular')]),
            httpStatus: Response::HTTP_CREATED,
        );
    }

    public function find(Product $product): JsonResponse
    {
        return success_response(
            data: new ProductResource($product),
            message: __('messages.retrieved', ['model' => __('models/product.singular')]),
        );
    }

    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $product->update($request->validated());

        return success_response(
            data: new ProductResource($product),
            message: __('messages.updated', ['model' => __('models/product.singular')]),
        );
    }

    public static function delete(Product $product): JsonResponse
    {
        Product::destroy($product->id);

        return success_response(
            message: __('messages.deleted', ['model' => __('models/product.singular')]),
        );
    }
}
