<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardApiController;

Route::get('/dashboard', [DashboardApiController::class, 'getDashboardData']);
Route::get('/patient/profile', [DashboardApiController::class, 'getPatientProfile']);
Route::get('/vitals/current', [DashboardApiController::class, 'getCurrentVitals']);
Route::get('/vitals/history', [DashboardApiController::class, 'getSessionHistory']);
Route::get('/vitals/chart', [DashboardApiController::class, 'getChartData']);
Route::get('/vitals/stats', [DashboardApiController::class, 'getSessionStats']);
