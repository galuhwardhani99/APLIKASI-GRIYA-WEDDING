<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\Admin\KatalogController;
use App\Http\Controllers\Admin\PortofolioController as AdminPortofolioController;
use App\Models\Portofolio;
use Illuminate\Support\Facades\Route;

// Halaman Utama Client
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
    
    // CRUD Katalog
    Route::resource('katalog', KatalogController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);

    // CRUD Portofolio
    Route::resource('portofolio', AdminPortofolioController::class);
});

// ---------- Client ----------
Route::get('/galeri', function () {
    $portofolios = Portofolio::latest()->get();
    return view('galeri', compact('portofolios'));
})->name('galeri');

Route::middleware(['auth'])->group(function () {
    Route::get('/reservasi', [ReservasiController::class, 'create'])->name('reservasi.create');
    Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
});

Route::get('/katalog', function () {
    return view('katalog');
});

Route::post('/katalog', [KatalogController::class, 'store'])->name('katalog.store');