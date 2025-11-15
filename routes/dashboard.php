<?php

use App\Http\Controllers\Dashboard\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\InvoiceController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\DashboradController;




Route::prefix('dashboard')->middleware(['auth'])->name('dashboard.')->group(function() {
    // dashboard 
    Route::get('/', [DashboradController::class,'index'])->name('index'); 

    // invoices
    Route::resource('invoices', InvoiceController::class); 

    // clients
    Route::resource('clients', ClientController::class); 

    // products
    Route::resource('products', ProductController::class); 

    // carts
    Route::resource('carts', CartController::class); 
});

