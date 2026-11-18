<?php

use App\Http\Controllers\Admin\JadwalController as AdminJadwalController;
use App\Http\Controllers\Admin\KategoriPaketController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Admin\PortofolioController as AdminPortofolioController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\JadwalController as ClientJadwalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\Client\PaymentController;
use App\Models\Transaksi;
use App\Http\Controllers\UserProfileController;
use App\Models\Portofolio;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhatsAppController;
use App\Models\Reservasi;
use App\Models\User;
use Carbon\Carbon;

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
    // Pastikan mengimpor model di bagian atas web.php:

// Di dalam Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () { ...
Route::get('/dashboard', function () {
    $now = Carbon::now();

    // 1. Total Pendapatan Bulan Ini (Gunakan kolom tanggal_acara)
    $pendapatanBulanIni = Reservasi::whereMonth('tanggal_acara', $now->month)
        ->whereYear('tanggal_acara', $now->year)
        ->whereIn('payment_status', ['paid', 'settlement', 'lunas', 'capture'])
        ->get()
        ->sum(function ($item) {
            return $item->biaya_sewa ?? $item->harga_paket ?? $item->harga_layanan ?? 0;
        });

    // 2. Total Reservasi (Semua reservasi yang sudah tervalidasi/disetujui)
    $totalReservasi = Reservasi::whereIn('status_reservasi', ['tervalidasi', 'disetujui', 'selesai', 'confirmed'])
        ->count();

    // 3. Client Aktif (User dengan role 'client')
    $clientAktif = User::where('role', 'client')->count();

    // 4. Daftar Transaksi Terbaru
    $transaksiTerbaru = Reservasi::with(['user', 'paket', 'layanans'])
        ->orderByDesc('id_reservasi')
        ->take(7)
        ->get();

    // 5. Badge Notifikasi Jadwal Acara Pending untuk Sidebar
    $pendingReservationsCount = Reservasi::whereIn('status_reservasi', ['pending', 'menunggu', 'menunggu_konfirmasi'])
        ->count();

    return view('admin.dashboard', compact(
        'pendapatanBulanIni',
        'totalReservasi',
        'clientAktif',
        'transaksiTerbaru',
        'pendingReservationsCount'
    ));
})->name('dashboard');

    // Tambahkan baris ini di dalam group middleware admin
    Route::post('/jadwal/kirim-wa/{id}', [AdminJadwalController::class, 'kirimNotifWaAdmin'])->name('jadwal.kirimWa');
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
    // Laporan Transaksi Admin
    Route::get('/laporan-transaksi', [LaporanController::class, 'index'])->name('laporan.transaksi');
    Route::get('/laporan-transaksi/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.transaksi.pdf');
    // Laporan Transaksi Admin
    Route::get('/laporan-transaksi', [LaporanController::class, 'index'])->name('laporan.transaksi');
    Route::get('/laporan-transaksi/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.transaksi.pdf');
    Route::get('/laporan-transaksi/excel', [LaporanController::class, 'exportExcel'])->name('laporan.transaksi.excel'); // <-- TAMBAHKAN INI
    // baris penutup grup admin
    });

// ---------- Client ----------
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard');
    Route::get('/halaman-client', [HomeController::class, 'clientPage'])->name('client.home');
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
    Route::delete('/profil', [UserProfileController::class, 'destroy'])->name('user.profile.destroy');

    // Endpoint API untuk mengecek tanggal yang sudah tervalidasi di form reservasi
    Route::get('/api/jadwal-tervalidasi', [ClientDashboardController::class, 'getJadwalTervalidasi'])->name('api.jadwal.tervalidasi');

    Route::get('/reservasi', [ReservasiController::class, 'create'])->name('reservasi.create');
    Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
    Route::post('/reservasi/{reservasi}/payment', [PaymentController::class, 'create'])->name('reservasi.payment.create');
    Route::post('/reservasi/{reservasi}/payment/sync', [PaymentController::class, 'syncStatus'])->name('reservasi.payment.sync');
    Route::get('/transaksi/{reservasi}/pembayaran', [PaymentController::class, 'show'])->name('client.payment.show');
});

Route::post('/payment/midtrans/notification', [PaymentController::class, 'notification'])->name('payment.midtrans.notification');
Route::get('/kirim-notif-wa', [WhatsAppController::class, 'kirimPengingatOtomatis']);
