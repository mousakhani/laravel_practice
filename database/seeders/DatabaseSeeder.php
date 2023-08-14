<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // فارن کی ها را چک نکن
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // Truncate === delete all rows from a table
        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();

        // Disable event listeners
        User::flushEventListeners();
        Category::flushEventListeners();
        Product::flushEventListeners();
        Transaction::flushEventListeners();

        $usersQuantity = 200;
        $categoriesQuantity = 10;
        $productsQuantity = 500;
        $transactionsQuantity = 200;

        User::factory($usersQuantity)->create();
        Category::factory($categoriesQuantity)->create();
        Product::factory($productsQuantity)->create()->each(
            function ($product) {
                $categories = Category::all('id')->random(random_int(1, 5));
                $product->categories()->attach($categories);
            }
        );
        Transaction::factory($transactionsQuantity)->create();
    }
}
