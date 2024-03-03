<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    private $url = '/api/orders/';

    public function test_index(): void
    {
        $response = $this->get($this->url);
        $response->assertStatus(200);
    }

    public function test_store(): void
    {
        DB::beginTransaction();

        Product::factory()->create();

        $jsonData = '{
            "products": [
                {
                    "product_id": 1,
                    "amount": 1
                }
            ]
        }';

        $data = json_decode($jsonData, true);
        $response = $this->post($this->url, $data);
        $response->assertStatus(201);

        DB::rollBack();
    }

    public function test_show(): void
    {
        DB::beginTransaction();

        Product::factory()->create();
        $order = Order::factory()->create();
        $response = $this->get($this->url.$order->id);
        $response->assertStatus(200);

        DB::rollback();
    }

    public function test_cancel(): void
    {
        DB::beginTransaction();

        Product::factory()->create();
        $order = Order::factory()->create();
        $response = $this->post($this->url.'cancel/'.$order->id);
        $response->assertStatus(200);

        DB::rollback();
    }

    public function test_add_product(): void
    {
        DB::beginTransaction();

        Product::factory()->create();
        Order::factory()->create();
        $data = OrderProduct::factory()->make()->toArray();
        $response = $this->post($this->url.'add/product/', $data);
        $response->assertStatus(201);

        DB::rollback();
    }
}
