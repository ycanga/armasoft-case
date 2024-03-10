<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\front\ProductsController;
use App\Models\Products;
use App\Http\Controllers\front\DashboardController;

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
});
