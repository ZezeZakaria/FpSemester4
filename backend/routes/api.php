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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json(['data' => ['user' => $request->user()]]);
});

Route::middleware('auth:sanctum')->put('/user', [App\Http\Controllers\Api\AuthController::class, 'updateProfile']);

Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get("/products", [App\Http\Controllers\Api\ProductController::class, 'index']);
Route::get("/products/{id}", [App\Http\Controllers\Api\ProductController::class, 'show']);

Route::middleware('auth:sanctum')->get('/user/cart', [App\Http\Controllers\Api\CartController::class, 'getUserCart']);
Route::middleware('auth:sanctum')->post('/user/cart/{productId}/increase', [App\Http\Controllers\Api\CartController::class, 'increaseCartQty']);
Route::middleware('auth:sanctum')->post('/user/cart/{productId}/decrease', [App\Http\Controllers\Api\CartController::class, 'decreaseCartQty']);
Route::middleware('auth:sanctum')->delete('/user/cart/{productId}/remove', [App\Http\Controllers\Api\CartController::class, 'removeCart']);

Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::get("/invoice", [App\Http\Controllers\Api\InvoiceController::class, 'index']);
        Route::post("/invoice", [App\Http\Controllers\Api\InvoiceController::class, 'store']);
        Route::get("/invoice/{id}", [App\Http\Controllers\Api\InvoiceController::class, 'show']);
        Route::post("/invoice/{id}/payment", [App\Http\Controllers\Api\InvoiceController::class, 'uploadPayment']);
    });
