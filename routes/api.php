<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\MedicalRecordController;



Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',[AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('appointments',AppointmentController::class);
    Route::apiResource('medical-records', MedicalRecordController::class);
});

});


