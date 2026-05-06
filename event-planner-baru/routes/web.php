<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

// Halaman Utama (Home)
Route::get('/', function () {
    return view('home');
})->name('home');

// Halaman Katalog Paket
Route::get('/packages', function () {
    return view('packages');
})->name('packages');

// Halaman About Us
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/booking', function () {
    return view('booking');
});

Route::get('/consultation', function () {
    return view('consultation');
})->name('consultation');

Route::get('/check-models', function () {
    $apiKey = env('GEMINI_API_KEY');
    $response = Http::get("https://generativelanguage.googleapis.com/v1beta/models?key={$apiKey}");
    return $response->json();
});