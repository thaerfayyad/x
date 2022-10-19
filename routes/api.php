<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Api routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your Api!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("user", [UserApiController::class, 'getList']);

Route::get("user/{id}", [UserApiController::class, 'getItem']);

Route::get('category', [CategoryController::class, 'all']);

Route::get('category/{id}', [CategoryController::class, 'category']);

Route::post('category/add', [CategoryController::class, 'add']);

Route::put('category/edit/{id}', [CategoryController::class, 'edit']);

Route::get('category/search/{string}', [CategoryController::class, 'search']);

Route::delete('category/delete/{string}', [CategoryController::class, 'delete']);
