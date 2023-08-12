<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seller = Seller::has('products')->get();
        return $this->showAll($seller);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $seller = Seller::has('products')->findOrFail($id);
        return $this->showOne($seller);
    }
}
