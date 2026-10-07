<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\Admin\KatalogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// ---------- Guest ----------
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

    Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.store');
});

// ---------- Auth ----------
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// ---------- Admin ----------
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    
    // CRUD Katalog (Hanya menggunakan index, store, update, destroy karena form menggunakan Modal pop-up)
    Route::resource('katalog', KatalogController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);
});

// ---------- Client ----------
Route::middleware(['auth'])->group(function () {
    // Rute untuk menampilkan form reservasi
    Route::get('/reservasi', [ReservasiController::class, 'create'])->name('reservasi.create');
    
    // Rute untuk memproses/submit data reservasi
    Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
});