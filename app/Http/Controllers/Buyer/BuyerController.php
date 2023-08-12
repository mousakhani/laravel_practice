<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buyer = Buyer::has('transactions')->get();
        return response()->json(['data' => $buyer, 'code' => 200], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $buyer = Buyer::has('transactions')->findOrFail($id);
        return response()->json(['data' => $buyer, 'code' => 200], 200);
    }
}
