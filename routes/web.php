<?php

use App\Http\Controllers\Dashboard\Dashborad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Auth::routes();

Route::get('/', function() {
    return redirect()->route('dashboard.index');
});

require __DIR__.'/dashboard.php';
