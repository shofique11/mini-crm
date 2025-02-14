<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ApplicationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin-dashboard', function () {
            return response()->json(['message' => 'Welcome, Admin!']);
        });
    });

    Route::middleware('role:counselor')->group(function () {
        Route::get('/counselor-dashboard', function () {
            return response()->json(['message' => 'Welcome, Counselor!']);
        });
    });

    // Admin routes
    Route::middleware('role:admin')->get('/leads', [LeadController::class, 'index']);

    // Counselor routes
    Route::middleware('role:counselor')->post('/leads', [LeadController::class, 'store']);
    Route::middleware('role:counselor')->put('/leads/{lead}', [LeadController::class, 'update']);
    Route::middleware('role:counselor')->post('/applications', [ApplicationController::class, 'store']);
    Route::middleware('role:counselor')->put('/applications/{application}', [ApplicationController::class, 'update']);
});

