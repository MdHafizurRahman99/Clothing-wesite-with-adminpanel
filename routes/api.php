<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\MockupController;
use App\Http\Controllers\ProductSideController;
use App\Http\Controllers\SleeveConfigController;
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

Route::apiResource('sleeve-configs', SleeveConfigController::class);

Route::get('/products/{productId}/sides', [ProductSideController::class, 'getSides']);
Route::post('/save-coordinate', [ProductSideController::class, 'saveCoordinate']);
Route::post('/mockups/generate', [MockupController::class, 'generate']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
