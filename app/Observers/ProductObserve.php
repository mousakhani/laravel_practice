<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserve
{
    public function updated(Product $product)
    {
        if ($product->quantity == 0 && $product->isAvailable()) {
            $product->status = Product::UNAVAILABLE_PRODUCT;
            $product->save();
        }
    }
}
