<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/customers', [ CustomerController::class, 'index'])->name('customers.index');
Route::get('/customers/{id}', [ CustomerController::class, 'show'])->name('customers.show');
Route::post('/customers', [ CustomerController::class, 'store'])->name('customers.store');
Route::put('/customers/{id}', [ CustomerController::class, 'update'])->name('customers.update');
Route::delete('/customers/{id}', [ CustomerController::class, 'destroy'])->name('customers.destroy');
