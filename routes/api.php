<?php

use App\Http\Controllers\Api\ClearAllData;
use App\Http\Controllers\Api\FetchProductsController;
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

Route::get('/fetch-data', [FetchProductsController::class, 'index'])->name('fetch-data');
Route::get('/clear-data', [ClearAllData::class, 'clearAllData'])->name('clear-data');
