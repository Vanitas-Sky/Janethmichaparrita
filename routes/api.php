<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EquipoController;
use App\Http\Controllers\Api\EquipmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'me']);

        Route::get('/equipos', [EquipoController::class, 'index']);
        Route::post('/equipos', [EquipoController::class, 'store']);
        Route::get('/equipos/{id}', [EquipoController::class, 'show']);
        Route::put('/equipos/{id}', [EquipoController::class, 'update']);
        Route::delete('/equipos/{id}', [EquipoController::class, 'destroy']);
        Route::get('/equipos/estadisticas/dashboard', [EquipoController::class, 'estadisticas']);
        Route::get('/equipos/utilidades/laboratorios', [EquipoController::class, 'laboratorios']);

        Route::apiResource('equipment', EquipmentController::class);
        Route::get('/equipment/stats/dashboard', [EquipmentController::class, 'stats']);
        Route::get('/equipment/utilities/laboratories', [EquipmentController::class, 'laboratories']);
    });
});
