<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

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


Route::get('customers',[CustomerController::class,"index"]);
Route::get('customers/search',[CustomerController::class,"search"]);
Route::get('customers/{customer_cd}',[CustomerController::class,"show"]);
Route::post('customers/create',[CustomerController::class,"create"]);
Route::put('customers/update/{customer_cd}',[CustomerController::class,"update"]);
Route::delete('customers/delete/{customer_cd}',[CustomerController::class,"delete"]);