<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FunnelsController;

Route::get('/', function () {
    return view('VolvCRM API');
});

//Auth:
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']);

//Funnels:
Route::middleware('auth:sanctum')->apiResource('funnels', FunnelsController::class);