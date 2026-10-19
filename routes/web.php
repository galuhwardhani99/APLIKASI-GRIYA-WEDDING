<?php

use App\Http\Controllers\Admin\JadwalController as AdminJadwalController;
use App\Http\Controllers\Admin\KategoriPaketController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Admin\PortofolioController as AdminPortofolioController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\JadwalController as ClientJadwalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\UserProfileController;
use App\Models\Portofolio;
use Illuminate\Support\Facades\Route;

// ---------- Halaman Publik ----------
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/galeri', function () {
    $portofolios = Portofolio::latest()->get();

    return view('galeri', compact('portofolios'));
})->name('galeri');

// Halaman katalog publik
Route::view('/katalog', 'katalog')->name('katalog');

// ---------- Guest ----------
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

    Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.store');
});

// ---------- Auth (Logout) ----------
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ---------- Admin ----------
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

    Route::resource('layanan', LayananController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('paket', PaketController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('kategori-paket', KategoriPaketController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::resource('portofolio', AdminPortofolioController::class);

    // Kelola Akun Pengguna oleh Admin
    Route::resource('users', UserController::class);

    // Jadwal Acara Admin & Endpoint JSON Kalender
    Route::get('/jadwal', [AdminJadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/json', [ClientJadwalController::class, 'getJadwalJson'])->name('jadwal.json');
    Route::post('/jadwal/validasi/{id}', [AdminJadwalController::class, 'validasi'])->name('jadwal.validasi');
    Route::put('/jadwal/update-tanggal/{id}', [AdminJadwalController::class, 'updateTanggal'])->name('admin.jadwal.updateTanggal');
});

// ---------- Client ----------
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard');
    Route::get('/riwayat-reservasi', [ClientDashboardController::class, 'riwayatReservasi'])->name('client.riwayat.reservasi');
    Route::get('/riwayat-transaksi', [ClientDashboardController::class, 'riwayatTransaksi'])->name('client.riwayat.transaksi');
    Route::get('/katalog/layanan', [ClientDashboardController::class, 'katalogLayanan'])->name('client.katalog.layanan');
    Route::get('/katalog/paket', [ClientDashboardController::class, 'katalogPaket'])->name('client.katalog.paket');

    // Jadwal Acara & JSON API untuk Client (Read-Only)
    Route::get('/jadwal-acara', [ClientJadwalController::class, 'index'])->name('client.jadwal.index');
    Route::get('/jadwal-acara/json', [ClientJadwalController::class, 'getJadwalJson'])->name('client.jadwal.json');
    
});

// ---------- Profil User ----------
Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [UserProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/profil', [UserProfileController::class, 'update'])->name('user.profile.update');

    // Endpoint API untuk mengecek tanggal yang sudah tervalidasi di form reservasi
    Route::get('/api/jadwal-tervalidasi', [ClientDashboardController::class, 'getJadwalTervalidasi'])->name('api.jadwal.tervalidasi');

    Route::get('/reservasi', [ReservasiController::class, 'create'])->name('reservasi.create');
    Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
});