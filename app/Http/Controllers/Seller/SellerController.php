<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seller = Seller::has('products')->get();
        return response()->json(['data' => $seller], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $seller = Seller::has('products')->findOrFail($id);
        return response()->json(['data' => $seller], 200);
    }
}
