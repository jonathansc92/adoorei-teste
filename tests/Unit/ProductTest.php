<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private $url = '/api/products/';

    public function test_index(): void
    {
        $response = $this->get($this->url);
        $response->assertStatus(200);
    }

    public function test_store(): void
    {
        DB::beginTransaction();

        $data = Product::factory()->make()->toArray();
        $response = $this->post($this->url, $data);
        $response->assertStatus(201);

        DB::rollBack();
    }

    public function test_show(): void
    {
        DB::beginTransaction();

        $author = Product::factory()->create();
        $response = $this->get($this->url.$author->id);
        $response->assertStatus(200);

        DB::rollBack();
    }

    public function test_update(): void
    {
        DB::beginTransaction();

        $product = Product::factory()->create();
        $response = $this->put($this->url.$product->id, Product::factory()->make()->toArray());
        $response->assertStatus(200);

        DB::rollBack();
    }

    public function test_destroy(): void
    {
        DB::beginTransaction();

        $product = Product::factory()->create();
        $response = $this->delete($this->url.$product->id);
        $response->assertStatus(200);

        DB::rollBack();
    }
}
