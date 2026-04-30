<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// ── Root: redirect ke login (atau dashboard jika sudah login) ──
Route::get('/', function () {
    return Session::get('logged_in')
        ? redirect('/dashboard')
        : redirect('/login');
});

// ── Auth routes (redirect ke dashboard jika sudah login) ──
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout',  [AuthController::class, 'logout']);
Route::post('/logout', [AuthController::class, 'logout']);

// ── OTP routes ──
Route::get('/otp',         [AuthController::class, 'showOtp']);
Route::post('/otp/verify', [AuthController::class, 'verifyOtp']);
Route::post('/otp/resend', [AuthController::class, 'resendOtp']);

// ── Forgot / Reset Password routes ──
Route::get('/forgot-password',  [AuthController::class, 'showForgotPassword']);
Route::post('/forgot-password', [AuthController::class, 'sendResetLink']);
Route::get('/reset-password',   [AuthController::class, 'showResetPassword']);
Route::post('/reset-password',  [AuthController::class, 'resetPassword']);

// ── Protected routes (harus login) ──
Route::middleware('auth.session')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'));
    Route::get('/history',   fn() => view('history'));
    Route::get('/user',      fn() => view('user'));

    // Profile API
    Route::get('/profile',  [AuthController::class, 'getProfile']);
    Route::post('/profile', [AuthController::class, 'updateProfile']);

    // ─── Live Vitals API ───────────────────────────────────────────────────────
    // 📡 SIMULASI SENSOR — Ganti isi closure ini dengan query ke tabel sensor
    //    ESP Anda saat hardware sudah siap.
    //    Contoh query nyata: \App\Models\Vital::latest()->first()
    // ─────────────────────────────────────────────────────────────────────────
    Route::get('/api/vitals/live', function () {
        $hr   = rand(65, 105);                    // simulasi BPM
        $spo2 = round(rand(950, 1000) / 10, 1);  // simulasi SpO₂ 95.0–100.0%

        $fingerDetected = true;   // 📡 ganti: $sensor->finger_detected
        $signalGood     = true;   // 📡 ganti: $sensor->signal_good
        $isNormal       = ($hr >= 60 && $hr <= 100 && $spo2 >= 95);

        return response()->json([
            'hr'              => $hr,
            'spo2'            => $spo2,
            'finger_detected' => $fingerDetected,
            'signal_good'     => $signalGood,
            'is_normal'       => $isNormal,
            'timestamp'       => now()->format('H:i:s'),
        ]);
    });
});
