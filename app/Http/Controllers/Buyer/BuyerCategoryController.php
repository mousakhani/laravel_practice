<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Buyer $buyer)
    {
        $categories = $buyer->transactions()->with('product.categories')
            ->get()
            ->pluck('product.categories')
            ->collapse()
            // برای اینکه مقادیر تکراری وجود نداشته باشد
            ->unique('id')
            //برای اینکه مقادیر خالی را حذف کنیم
            ->values();

        return $this->showAll($categories);
    }
}
