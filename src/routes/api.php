<?php

use App\Http\Controllers\Api\EquipoController;
use App\Http\Controllers\Api\JugadorController;
use App\Http\Controllers\Api\PartidoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::apiResource('equipos', EquipoController::class)
    ->only(['index', 'show', 'store', 'update', 'destroy']);

Route::apiResource('jugadores', JugadorController::class)
    ->only(['index', 'show', 'store', 'update', 'destroy']);

Route::apiResource('partidos', PartidoController::class)
    ->only(['index', 'show', 'store', 'update', 'destroy']);
