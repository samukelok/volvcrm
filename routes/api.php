<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FunnelsController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\LeadsStatusChangeController;
use App\Http\Controllers\SysEmailTemplatesController;
use App\Http\Controllers\EmailTemplatesController;
use App\Http\Controllers\FunnelStepController;
use App\Http\Controllers\EmailTrackingController;


Route::get('/', function () {
    return view('VolvCRM API');
});

//Auth:
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']);

//Funnels:
Route::apiResource('funnels', FunnelsController::class);

// Funnel Steps:
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/funnels/{funnel}/steps', [FunnelStepController::class, 'index']);
    Route::post('/funnels/{funnel}/steps', [FunnelStepController::class, 'store']);
    Route::get('/steps/{step}', [FunnelStepController::class, 'show']);
    Route::delete('/steps/{step}', [FunnelStepController::class, 'destroy']);
    Route::post('/steps/{step}/send', [FunnelStepController::class, 'sendEmails']);
});

Route::get('/track/open/{lead}/{emailLog}', [EmailTrackingController::class, 'open']);
Route::get('/track/click/{lead}/{emailLog}', [EmailTrackingController::class, 'click']);

// Leads (Only Store: Public)
Route::post('/leads', [LeadsController::class, 'store']);

// Lead Status Changes
Route::apiResource('lead-status-changes', LeadsStatusChangeController::class);

// Email Templates (Admin Only)
Route::get('/sys-email-templates', [SysEmailTemplatesController::class, 'index']);
Route::get('/sys-email-templates/{sysEmailTemplate}', [SysEmailTemplatesController::class, 'show']);
Route::post('/sys-email-templates', [SysEmailTemplatesController::class, 'store']);
Route::put('/sys-email-templates/{sysEmailTemplate}', [SysEmailTemplatesController::class, 'update']);
Route::delete('/sys-email-templates/{sysEmailTemplate}', [SysEmailTemplatesController::class, 'destroy']);

 Route::post('/email-templates', [EmailTemplatesController::class, 'store']);   