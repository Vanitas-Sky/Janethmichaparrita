<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EquipoController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EquipmentController;
use App\Http\Controllers\Api\AuthController;
main

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
// Public Auth Routes
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'me']);

rama-database
    // Equipo routes - CRUD operations
    Route::get('/equipos', [EquipoController::class, 'index']);
    Route::post('/equipos', [EquipoController::class, 'store']);
    Route::get('/equipos/{id}', [EquipoController::class, 'show']);
    Route::put('/equipos/{id}', [EquipoController::class, 'update']);
    Route::delete('/equipos/{id}', [EquipoController::class, 'destroy']);
    
    // Equipo statistics and utilities
    Route::get('/equipos/estadisticas/dashboard', [EquipoController::class, 'estadisticas']);
    Route::get('/equipos/utilidades/laboratorios', [EquipoController::class, 'laboratorios']);
Stashed changes

    // Equipment routes - CRUD
    Route::apiResource('equipment', EquipmentController::class);
    
    // Equipment stats and utilities
    Route::get('/equipment/stats/dashboard', [EquipmentController::class, 'stats']);
    Route::get('/equipment/utilities/laboratories', [EquipmentController::class, 'laboratories']);
main
});
