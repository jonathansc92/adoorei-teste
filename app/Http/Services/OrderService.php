<?php

namespace App\Http\Services;

use App\Enums\StatusEnum;
use App\Http\Filters\OrderFilter;
use App\Http\Requests\StoreOrderProductRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function get(OrderFilter $filter): JsonResponse
    {
        $orders = Order::filter($filter)->withProducts()->paginate();

        return success_response(
            data: new ResourceCollection($orders),
            message: __('messages.retrieved', ['model' => __('models/order.plural')]),
        );
    }

    public function create(StoreOrderRequest $request): JsonResponse
    {
        $request->validated();

        $order = Order::create(['status' => StatusEnum::Pending]);

        $order->products()->attach($request->products);

        $totalAmount = $order->products()->sum(DB::raw('amount * price'));

        $order->update(['amount' => $totalAmount]);

        return success_response(
            data: new OrderResource($order->load('products')),
            message: __('messages.saved', ['model' => __('models/order.singular')]),
            httpStatus: Response::HTTP_CREATED,
        );
    }

    public function find(Order $order): JsonResponse
    {
        return success_response(
            data: new OrderResource($order->load('products')),
            message: __('messages.retrieved', ['model' => __('models/order.singular')]),
        );
    }

    public function cancel(int $id): JsonResponse
    {
        $order = Order::find($id);

        if ($order->status === StatusEnum::Cancelled->value) {
            return $this->cancelledReturn();
        }

        $order->update(['status' => StatusEnum::Cancelled]);

        return success_response(
            data: new OrderResource($order->load('products')),
            message: __('Pedido cancelado com sucesso.', ['model' => __('models/order.singular')]),
        );
    }

    public function addProduct(StoreOrderProductRequest $request): JsonResponse
    {
        $request->validated();

        $order = Order::find($request->order_id);

        if ($order->status === StatusEnum::Cancelled->value) {
            return $this->cancelledReturn();
        }

        $where = [
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
        ];

        $product = OrderProduct::updateOrCreate($where);

        $totalAmount = $product->amount + $request->amount;

        $product->where($where)->update(['amount' => $totalAmount]);

        $totalPrice = $order->amount + $request->amount * $product->product->price;

        $order->update(['amount' => $totalPrice]);

        return success_response(
            data: new OrderResource($order->load('products')),
            message: __('messages.saved', ['model' => __('models/product.singular')]),
            httpStatus: Response::HTTP_CREATED,
        );
    }

    private function cancelledReturn()
    {
        return error_response(
            message: __('Pedido já foi cancelado.', ['model' => __('models/product.singular')]),
            httpStatus: Response::HTTP_FORBIDDEN,
        );
    }
}
