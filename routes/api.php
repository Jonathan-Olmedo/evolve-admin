<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CatalogoController;
use App\Http\Controllers\Api\CategoriaController;
use Illuminate\Support\Facades\Route;

// Pública
Route::post('/auth/login', [AuthController::class, 'login']);

// Protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/catalogos',       [CatalogoController::class, 'index']);
    Route::get('/catalogos/{id}',  [CatalogoController::class, 'show']);
    Route::get('/categorias',      [CategoriaController::class, 'index']);
});
