<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Seller $seller)
    {
        $products = $seller->products;
        return $this->showAll($products);
    }

    public function store(Request $request, User $seller)
    {

        $request->validate(
            [
                'name' => 'required',
                'description' => 'required',
                'quantity' => 'required|integer|min:1',
                'image' => 'required|image',
            ]
        );
        $data = $request->all();
        $data['status'] = Product::UNAVAILABLE_PRODUCT;
        $data['image'] = '1.jpg';
        $data['seller_id'] = $seller->id;
        $product = Product::create($data);

        return $this->showOne($product);
    }

    public function update(Request $request, Seller $seller, Product $product)
    {
        $request->validate([
            'quantity' => 'integer|min:1',
            'status' => 'in:' . Product::AVAILABLE_PRODUCT . ',' . Product::UNAVAILABLE_PRODUCT,
            'image' => 'image'
        ]);

        $this->checkSeller($seller, $product);

        $product->fill($request->only([
            'name', 'description', 'quantity'
        ]));
        if ($request->has('status')) {
            $product->status = $request->status;
            if ($product->isAvailable() && $product->categories()->count() == 0) {
                return $this->errorResponse('An active product must have at least one category', 409);
            }
        }

        if (!$product->isDirty()) {
            return $this->errorResponse('you need to specify a different value to update', 422);
        }
        $product->save();
        return $this->showOne($product);
    }

    public function destroy(Seller $seller, Product $product)
    {
        $this->checkSeller($seller, $product);

        $product->delete();
        return $this->showOne($product);
    }
    protected function checkSeller(Seller $seller, Product $product)
    {
        if ($seller->id != $product->seller_id) {
            throw new HttpException(422, 'The specified seller is not actual seller of the product', null, [], 100);
        }
    }
}
