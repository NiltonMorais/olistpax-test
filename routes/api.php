<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('products', ProductController::class);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
