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
    return $request->user();
});

Route::get('/books', [\App\Http\Controllers\Api\BookController::class, 'index']);
Route::get('/books/{id}', [\App\Http\Controllers\Api\BookController::class, 'show']);

Route::get('/genres', [\App\Http\Controllers\Api\GenreController::class, 'index']);
Route::get('/genres/{id}', [\App\Http\Controllers\Api\GenreController::class, 'show']);
