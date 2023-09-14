<?php

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('companies', [\App\Http\Controllers\CompanyController::class, 'index']);
    Route::post('companies', [\App\Http\Controllers\CompanyController::class, 'store']);
    Route::post('companies/{company}', [\App\Http\Controllers\CompanyController::class, 'update']);
    Route::delete('companies/{company}', [\App\Http\Controllers\CompanyController::class, 'destroy']);

    Route::get('employees', [\App\Http\Controllers\EmployeeController::class, 'index']);
    Route::post('employees', [\App\Http\Controllers\EmployeeController::class, 'store']);
    Route::put('employees/{company}', [\App\Http\Controllers\EmployeeController::class, 'update']);
    Route::delete('employees/{company}', [\App\Http\Controllers\EmployeeController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
