<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

// Admin dashboard (protected by admin middleware)
Route::middleware(['auth:sanctum', 'admin'])->get('/admin', function (Request $request) {
    return view('dashboard.admin', [
        'user' => $request->user(),
        'dashboard' => $request->user()->dashboardData() 
    ]);
});

// Client dashboard
Route::middleware(['auth:sanctum'])->get('/dashboard', function (Request $request) {
    return view('dashboard.client', [
        'user' => $request->user()
    ]);
});