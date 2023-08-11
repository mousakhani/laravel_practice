<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
        return [
            'name' => fake()->name(),
            'description' => fake()->paragraph(1),
            'status' => fake()->randomElement([Product::UNAVAILABLE_PRODUCT, Product::AVAILABLE_PRODUCT]),
            'quantity' => rand(1, 10),
            'image' => fake()->randomElement(['1.jpg', '2.jpg', '3.jpg']),
            'seller_id' => User::all('id')->random(),
        ];
    }
}
