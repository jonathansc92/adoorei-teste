<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderProductRequest;
use App\Http\Services\OrderProductService;
use Illuminate\Http\JsonResponse;

class OrderProductController extends Controller
{
    protected $service;

    public function __construct(OrderProductService $service)
    {
        $this->service = $service;
    }

    public function addProductToOrder(StoreOrderProductRequest $request): JsonResponse
    {
        return $this->service->create($request);
    }
}
