<?php

use App\Http\Controllers\api\v1\CustomerController;
use App\Http\Controllers\api\v1\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//api v1
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\api\v1', 'middleware' => 'auth:sanctum'], function () {
    Route::get('customers', [CustomerController::class, 'index']);
    Route::post('customers', [CustomerController::class, 'store']);
    Route::get('customers/{customer}', [CustomerController::class, 'show']);
    Route::put('customers/{customer}', [CustomerController::class, 'update']);
    Route::delete('customers/{customer}', [CustomerController::class, 'destroy']);

    Route::get('invoices', [InvoiceController::class, 'index']);
    Route::post('invoices/bulk', ['uses' => 'InvoiceController@bulkStore']);
    Route::get('invoices/{invoice}', [InvoiceController::class, 'show']);
    Route::delete('invoices/{invoice}', [InvoiceController::class, 'destroy']);
});
