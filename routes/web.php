<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// ── Static pages (no auth required for now) ──
Route::get('/dashboard', fn() => view('dashboard'));
Route::get('/history',   fn() => view('history'));
Route::get('/user',      fn() => view('user'));
Route::get('/',          fn() => view('dashboard'));

// ── Auth routes ──
Route::get('/login',    [AuthController::class, 'showLogin']);
Route::post('/login',   [AuthController::class, 'login']);

Route::get('/register',  [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout',    [AuthController::class, 'logout']);
Route::post('/logout',   [AuthController::class, 'logout']);

// ── OTP routes ──
Route::get('/otp',          [AuthController::class, 'showOtp']);
Route::post('/otp/verify',  [AuthController::class, 'verifyOtp']);
Route::post('/otp/resend',  [AuthController::class, 'resendOtp']);

// ── Profile routes ──
Route::get('/profile',    [AuthController::class, 'getProfile']);
Route::post('/profile',   [AuthController::class, 'updateProfile']);
