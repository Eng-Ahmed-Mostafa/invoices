<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;




Auth::routes();

Route::get('/', function() {
    return redirect()->route('dashboard.index');
});


require __DIR__.'/dashboard.php';
