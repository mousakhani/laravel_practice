<?php

use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Buyer\BuyerProductController;
use App\Http\Controllers\Buyer\BuyerTransactionController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Transaction\TransactionCategoryController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\Transaction\TransactionSellerController;
use App\Http\Controllers\User\UserController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Buyers
 */
Route::resource('buyers', BuyerController::class, ['only' => ['index', 'show']]);
Route::resource('buyers.transactions', BuyerTransactionController::class, ['only' => ['index',]]);
Route::resource('buyers.products', BuyerProductController::class, ['only' => ['index',]]);

/**
 * Sellers
 */
Route::resource('sellers', SellerController::class, ['only' => ['index', 'show']]);

/**
 * Categories
 */
Route::resource('categories', CategoryController::class, ['except' => ['create', 'edit']]);

/**
 * Transactions
 */
Route::resource('transactions', TransactionController::class, ['only' => ['index', 'show']]);
Route::resource('transactions.categories', TransactionCategoryController::class, ['only' => ['index',]]);
Route::resource('transactions.sellers', TransactionSellerController::class, ['only' => ['index',]]);

/**
 * Products
 */
Route::resource('products', ProductController::class, ['only' => ['index', 'show']]);

/**
 * Users
 */
Route::resource('users', UserController::class, ['except' => ['create', 'edit']]);
