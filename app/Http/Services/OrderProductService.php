<?php

namespace App\Http\Services;

use App\Enums\StatusEnum;
use App\Http\Requests\StoreOrderProductRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class OrderProductService
{
    public function create(StoreOrderProductRequest $request): JsonResponse
    {
        $request->validated();

        $order = Order::find($request->order_id);

        if ($order->status === StatusEnum::Cancelled->value) {
            return OrderService::cancelledReturn();
        }

        $where = [
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
        ];

        $product = OrderProduct::updateOrCreate($where);

        $totalAmount = $product->amount + $request->amount;

        $product->where($where)->update(['amount' => $totalAmount]);

        $order->update(['amount' => $order->amount + $totalAmount]);

        return success_response(
            data: new OrderResource($order->load('products')),
            message: __('messages.saved', ['model' => __('models/product.singular')]),
            httpStatus: Response::HTTP_CREATED,
        );
    }
}
