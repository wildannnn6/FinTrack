<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Route;

// Redirect root ke signup
Route::get('/', function () {
    return redirect('/signup');
});

// Auth Routes
Route::get('/signup', [SignupController::class, 'index'])->name('signup.index');
Route::post('/signup/auth', [SignupController::class, 'signup'])->name('signup.auth');

Route::get('/login', [AuthController::class, 'index'])->name('login.index');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

// Home Route (protected)
Route::get('/home', [HomeController::class, 'index'])->name('home');