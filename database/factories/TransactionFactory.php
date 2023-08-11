<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // انتخاب تصادفی فروشندگانی که حداقل یک محصول برای فروش دارند
        // has
        // به معنی حداقل یک ارتباط داشتن است
        $seller = Seller::all()->first();

        // همه ی یوزرها غیر از یوزر سلر.
        $buyer = User::all()->except($seller->id)->random();
        return [
            'quantity' => rand(1, 5),
            'buyer_id' => $buyer->id,
            'product_id' => $seller->products->random()->id,
        ];
    }
}
