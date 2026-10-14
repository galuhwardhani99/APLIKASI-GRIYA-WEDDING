<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\KatalogController;
use App\Http\Controllers\ReservasiController;
Route::put('/reservasi/{id}', [ReservasiController::class, 'updateStatus']);
Route::put('/reservasi/{id}/status', [ReservasiController::class, 'updateStatus']);
// Reservasi
Route::get('/reservasi', [ReservasiController::class, 'index']);
Route::post('/reservasi', [ReservasiController::class, 'store']);

// Route API Katalog
Route::get('/pakets', [KatalogController::class, 'index']);
Route::post('/pakets', [KatalogController::class, 'store']);
Route::put('/pakets/{id}', [KatalogController::class, 'update']);
Route::delete('/pakets/{id}', [KatalogController::class, 'destroy']);

// Route API Reservasi
Route::get('/reservasis', [ReservasiController::class, 'index']);
Route::post('/reservasis', [ReservasiController::class, 'store']);