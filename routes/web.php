<?php

use App\Http\Controllers\front\CategoriesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\front\ProductsController;
use App\Http\Controllers\front\DashboardController;
use App\Http\Controllers\front\MarketplacesController;
use App\Http\Controllers\front\StoreController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::name('front.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
    Route::get('/products/{slug}', [ProductsController::class, 'show'])->name('products.show');
    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
    Route::get('/marketplaces', [MarketplacesController::class, 'index'])->name('marketplaces.index');
    Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
});
