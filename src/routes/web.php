<?php

use App\Http\Controllers\EquipoController;
use App\Http\Controllers\JugadorController;
use App\Http\Controllers\PartidoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rutas para Equipos
Route::get('/equipos', [EquipoController::class, 'index'])->name('equipos.index');
Route::get('/equipos/create', [EquipoController::class, 'create'])->name('equipos.create');
Route::post('/equipos', [EquipoController::class, 'store'])->name('equipos.store');
Route::get('/equipos/{id}', [EquipoController::class, 'show'])->name('equipos.show');
Route::get('/equipos/{id}/edit', [EquipoController::class, 'edit'])->name('equipos.edit');
Route::put('/equipos/{id}', [EquipoController::class, 'update'])->name('equipos.update');
Route::delete('/equipos/{id}', [EquipoController::class, 'destroy'])->name('equipos.destroy');
Route::get('/equipos/{id}/confirm', [EquipoController::class, 'confirm'])->name('equipos.confirm');

// Rutas para Jugadores
Route::get('/jugadores', [JugadorController::class, 'index'])->name('jugadores.index');
Route::get('/jugadores/create', [JugadorController::class, 'create'])->name('jugadores.create');
Route::post('/jugadores', [JugadorController::class, 'store'])->name('jugadores.store');
Route::get('/jugadores/{id}', [JugadorController::class, 'show'])->name('jugadores.show');
Route::get('/jugadores/{id}/edit', [JugadorController::class, 'edit'])->name('jugadores.edit');
Route::put('/jugadores/{id}', [JugadorController::class, 'update'])->name('jugadores.update');
Route::delete('/jugadores/{id}', [JugadorController::class, 'destroy'])->name('jugadores.destroy');
Route::get('/jugadores/{id}/confirm', [JugadorController::class, 'confirm'])->name('jugadores.confirm');

// Rutas para Partidos
Route::get('/partidos', [PartidoController::class, 'index'])->name('partidos.index');
Route::get('/partidos/create', [PartidoController::class, 'create'])->name('partidos.create');
Route::post('/partidos', [PartidoController::class, 'store'])->name('partidos.store');
Route::get('/partidos/{id}', [PartidoController::class, 'show'])->name('partidos.show');
Route::get('/partidos/{id}/edit', [PartidoController::class, 'edit'])->name('partidos.edit');
Route::put('/partidos/{id}', [PartidoController::class, 'update'])->name('partidos.update');
Route::delete('/partidos/{id}', [PartidoController::class, 'destroy'])->name('partidos.destroy');
Route::get('/partidos/{id}/confirm', [PartidoController::class, 'confirm'])->name('partidos.confirm');
