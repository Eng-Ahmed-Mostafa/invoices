<?php

use App\Http\Controllers\Dashboard\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\InvoiceController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\DashboradController;




Route::prefix('dashboard')->middleware(['auth'])->name('dashboard.')->group(function() {
    // dashboard 
    Route::get('/', [DashboradController::class,'index'])->middleware(['role:admin'])->name('index'); 

    // invoices
    Route::get('invoices/search', [InvoiceController::class,'search'])->name('invoices.search'); 
    Route::resource('invoices', InvoiceController::class); 

    // clients
    Route::resource('clients', ClientController::class); 

    // products
    Route::resource('products', ProductController::class); 

    // pdf invoice details
    Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'generatePdf'])->name('invoices.pdf');
});

