<?php

use App\Http\Controllers\EmployeesController;
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

Route::get("employees",[EmployeesController::class,'index']);
Route::get("employees/search",[EmployeesController::class,'search']);
Route::get("employees/{emp_cd}",[EmployeesController::class,'show']);
Route::post("employees/create",[EmployeesController::class,'create']);
Route::post("employees/update/{emp_cd}",[EmployeesController::class,'update']);
Route::post("employees/delete/{emp_cd}",[EmployeesController::class,'delete']);

