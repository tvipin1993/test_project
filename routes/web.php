<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/login', [App\Http\Controllers\UserAuthController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\UserAuthController::class, 'loginPost'])->name('user-login');
Route::get('/customer-register', [App\Http\Controllers\UserAuthController::class, 'registerForm'])->name('customer-register-form');
Route::post('/customer-register', [App\Http\Controllers\UserAuthController::class, 'register'])->name('do-customer-register');
Route::get('/admin-register', [App\Http\Controllers\UserAuthController::class, 'registerForm'])->name('admin-register-form');

// Auth Routes
Route::get('/dashboard', function () {
    return view('page_layout.dashboard');
})->middleware('jwt');
Route::get('/logout', [App\Http\Controllers\UserAuthController::class, 'logout'])->name('logout')->middleware('jwt');
Route::post('/refresh', [App\Http\Controllers\UserAuthController::class, 'refreshToken'])->middleware('jwt');
