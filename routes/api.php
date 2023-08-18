<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Buyers
 */
Route::resource('buyers', BuyerController::class, ['only' => ['index', 'show']]);
Route::resource('buyers.transactions', BuyerTransactionController::class, ['only' => ['index',]]);
Route::resource('buyers.products', BuyerProductController::class, ['only' => ['index',]]);
Route::resource('buyers.sellers', BuyerSellerController::class, ['only' => ['index',]]);
Route::resource('buyers.categories', BuyerCategoryController::class, ['only' => ['index',]]);

/**
 * Sellers
 */
Route::resource('sellers', SellerController::class, ['only' => ['index', 'show']]);
Route::resource('sellers.transactions', SellerTransactionController::class, ['only' => ['index',]]);
Route::resource('sellers.categories', SellerCategoryController::class, ['only' => ['index',]]);
Route::resource('sellers.buyers', SellerBuyerController::class, ['only' => ['index',]]);
Route::resource('sellers.products', SellerProductController::class, ['only' => ['index', 'store', 'update', 'destroy']]);

/**
 * Categories
 */
Route::resource('categories', CategoryController::class, ['except' => ['create', 'edit']]);
Route::resource('categories.products', CategoryProductController::class, ['only' => 'index']);
Route::resource('categories.transactions', CategoryTransactionController::class, ['only' => 'index']);
Route::resource('categories.buyers', CategoryBuyerController::class, ['only' => 'index']);

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
Route::resource('products.categories', ProductCategoryController::class, ['only' => ['index', 'show', 'update', 'destroy']]);
Route::resource('products.transactions', ProductTransactionController::class, ['only' => ['index', 'show', 'destroy']]);
Route::resource('products.buyers', ProductBuyerController::class, ['only' => ['index', 'show', 'destroy']]);
Route::resource('products.buyers.transactions', ProductBuyerTransactionController::class, ['only' => ['store',]]);

/**
 * Users
 */
Route::resource('users', UserController::class, ['except' => ['create', 'edit']]);
Route::get('users/verify/{token}', [UserController::class, 'verify'])->name('verify');
Route::get('users/{user}/resend', [UserController::class, 'resend'])->name('resend');
