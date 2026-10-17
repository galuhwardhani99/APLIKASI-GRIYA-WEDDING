<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\ReservasiController;
Route::put('/reservasi/{id}', [ReservasiController::class, 'updateStatus']);
Route::put('/reservasi/{id}/status', [ReservasiController::class, 'updateStatus']);
// Reservasi
Route::get('/reservasi', [ReservasiController::class, 'index']);
Route::post('/reservasi', [ReservasiController::class, 'store']);

// Route API Katalog
Route::get('/pakets', [PaketController::class, 'index']);
Route::post('/pakets', [PaketController::class, 'store']);
Route::put('/pakets/{id}', [PaketController::class, 'update']);
Route::delete('/pakets/{id}', [PaketController::class, 'destroy']);

// Route API Reservasi
Route::get('/reservasis', [ReservasiController::class, 'index']);
Route::post('/reservasis', [ReservasiController::class, 'store']);
