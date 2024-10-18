<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShareController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
Route::resource('products', ProductController::class);

Route::post('/save_shares', [ShareController::class, 'saveShares']);
Route::get('/getShares', [ShareController::class, 'getShares']);
Route::get('/show', [ProductCOntroller::class, 'show']);
Route::match(['get', 'post'], 'login', [AuthController::class, 'login']);

Route::delete('/delete_shares', [ShareController::class, 'deleteShares']);

