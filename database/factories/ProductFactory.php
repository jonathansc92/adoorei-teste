<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $uniqueNames = collect(['Iphone 15', 'Samsung Galaxy S23', 'Motorola Edge 40', 'Iphone 14', 'Sansung Galaxy S24'])->shuffle();

        return [
            'name' => $uniqueNames->pop(),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 1800, 10000),
        ];
    }
}
