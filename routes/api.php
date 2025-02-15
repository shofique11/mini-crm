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
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

    // Admin Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin-dashboard', function () {
            return response()->json(['message' => 'Welcome, Admin!']);
        });
        Route::get('leads', [LeadController::class, 'index']);  // View all leads (admin only)
        Route::get('applications', [ApplicationController::class, 'index']);  // View all applications (admin only)
    });

    // Counselor Routes
    Route::middleware('role:counselor')->group(function () {
        Route::get('/counselor-dashboard', function () {
            return response()->json(['message' => 'Welcome, Counselor!']);
        });
        Route::post('leads', [LeadController::class, 'store']);  // Create a lead (counselor only)
        Route::put('leads/{lead}', [LeadController::class, 'update']);  // Update a lead (counselor only)
        
        Route::post('applications', [ApplicationController::class, 'store']);  // Create an application (counselor only)
        Route::put('applications/{application}', [ApplicationController::class, 'update']);  // Update an application (counselor only)
    });

});

