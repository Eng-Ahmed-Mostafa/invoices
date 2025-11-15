<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;




Auth::routes();

Route::get('/', function() {
    return redirect()->route('dashboard.index');
});

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

require __DIR__.'/dashboard.php';
