<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

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
        Route::post('leads', [LeadController::class, 'store']);  // Create a lead (admin only)
        Route::get('leads/{lead}', [LeadController::class, 'show']);  
        Route::put('leads/{lead}', [LeadController::class, 'update']);
        Route::delete('leads/{lead}', [LeadController::class, 'destroy']);
        Route::get('counselor-list', [UserController::class, 'counselorList']);  // View all counselor (admin only)
        Route::put('applications/{application}', [ApplicationController::class, 'update']);  // Update an application (admin only)
        Route::get('applications', [ApplicationController::class, 'index']);  // View all applications (admin only)
        Route::get('applications/{application}', [ApplicationController::class, 'show']); 
        Route::get('/dashboard-stats', [DashboardController::class, 'getStats']);
    });

    // Counselor Routes
    Route::middleware('role:counselor')->group(function () {
        Route::get('/counselor-dashboard', function () {
            return response()->json(['message' => 'Welcome, Counselor!']);
        });
       // Route::put('leads/{lead}', [LeadController::class, 'update']);
        Route::get('counselor-leads', [LeadController::class, 'counselorLeads']);  
        Route::put('/leads/{id}/status', [LeadController::class, 'updateStatus']);
        Route::post('applications', [ApplicationController::class, 'store']);  // Move application (counselor only)
        Route::get('my-applications', [ApplicationController::class, 'myApplication']);
        Route::get('/dashboard-stats-me', [DashboardController::class, 'getStatsMe']);
    });

});

