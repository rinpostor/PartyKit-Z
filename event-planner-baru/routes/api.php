<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PackageController; 
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\RecommendationController;

Route::get('/packages', [PackageController::class, 'index']);
Route::post('/bookings', [BookingController::class, 'store']);
Route::get('/categories', [PackageController::class, 'categories']);
Route::post('/recommendation', [RecommendationController::class, 'calculate']);