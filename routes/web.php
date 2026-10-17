<?php

use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\KategoriPaketController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Admin\PortofolioController as AdminPortofolioController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservasiController;
use App\Models\Portofolio;
use Illuminate\Support\Facades\Route;

// ---------- Halaman Publik ----------
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/galeri', function () {
    $portofolios = Portofolio::latest()->get();

    return view('galeri', compact('portofolios'));
})->name('galeri');

// Halaman katalog publik (hapus baris ini kalau resources/views/katalog.blade.php tidak ada)
Route::view('/katalog', 'katalog')->name('katalog');

// ---------- Guest ----------
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

    Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.store');
});

// ---------- Auth ----------
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

    Route::resource('layanan', LayananController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('paket', PaketController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('kategori-paket', KategoriPaketController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::resource('portofolio', AdminPortofolioController::class);

    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::post('/jadwal/validasi/{id}', [JadwalController::class, 'validasi'])->name('jadwal.validasi');
    Route::put('/jadwal/update-tanggal/{id}', [JadwalController::class, 'updateTanggal'])->name('jadwal.updateTanggal');
});

// ---------- Client ----------
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard');
    Route::get('/katalog/layanan', [ClientDashboardController::class, 'katalogLayanan'])->name('client.katalog.layanan');
    Route::get('/katalog/paket', [ClientDashboardController::class, 'katalogPaket'])->name('client.katalog.paket');

    Route::get('/reservasi', [ReservasiController::class, 'create'])->name('reservasi.create');
    Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
});
