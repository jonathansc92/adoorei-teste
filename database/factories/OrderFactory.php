<?php

namespace Database\Factories;

use App\Enums\StatusEnum;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement([StatusEnum::Pending->value]),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            $product = Product::inRandomOrder()->first();

            $orderProducts = OrderProduct::factory(1)->create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'amount' => fake()->numberBetween(1, 10),
            ]);

            $totalAmount = $orderProducts->sum(function ($orderProduct) use ($product) {
                return $orderProduct->amount * $product->price;
            });

            $order->update(['amount' => $totalAmount]);
        });
    }
}
