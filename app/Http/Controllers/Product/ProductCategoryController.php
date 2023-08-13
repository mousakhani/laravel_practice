<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ProductCategoryController extends ApiController
{

    public function index(Product $product)
    {
        return $this->showAll($product->categories);
    }

    public function show(Product $product, Category $category)
    {
        return $this->showAll($product->categories);
    }
    public function destroy(Product $product, Category $category)
    {
        $this->checkCategory($product, $category);
        $product->categories()->detach($category->id);
        return $this->showAll($product->categories);
    }

    protected function checkCategory(Product $product, Category $category)
    {
        if (!$product->categories()->find($category->id)) {
            return throw new HttpException(422, 'The specified product is not the actual product of the category');
        }
    }
}
