<?php

namespace App\Http\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class ProductService
{
    public function get($filter)
    {
        $products = Product::filter($filter)->paginate();

        return success_response(
            data: new ResourceCollection($products),
            message: __('messages.retrieved', ['model' => __('models/product.plural')]),
        );
    }

    public static function create($request)
    {
        $product = Product::create($request->validated());

        return success_response(
            data: new ProductResource($product),
            message: __('messages.saved', ['model' => __('models/product.singular')]),
            httpStatus: Response::HTTP_CREATED,
        );
    }

    public function find($product)
    {
        return success_response(
            data: new ProductResource($product),
            message: __('messages.retrieved', ['model' => __('models/product.singular')]),
        );
    }

    public static function update($request, $product)
    {
        $product->update($request->validated());

        return success_response(
            data: new ProductResource($product),
            message: __('messages.updated', ['model' => __('models/product.singular')]),
        );
    }

    public static function delete($product)
    {
        Product::destroy($product->id);

        return success_response(
            message: __('messages.deleted', ['model' => __('models/product.singular')]),
        );
    }
}
