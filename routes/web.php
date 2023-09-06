<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard.index');
});


Route::resource('warehouses', \App\Http\Controllers\Dashboard\WarehousesController::class);
Route::resource('products', \App\Http\Controllers\Dashboard\ProductsController::class);

Route::get('warehouses-balances', [\App\Http\Controllers\Dashboard\WarehousesController::class, 'warehousesBalance'])
    ->name('warehouse-balances');


Route::get('document-{type}', [\App\Http\Controllers\Dashboard\DocumentController::class, 'create'])
    ->name('document-create');
Route::post('document', [\App\Http\Controllers\Dashboard\DocumentController::class, 'store'])
    ->name('document-store');
