<?php

use App\Http\Controllers\Admin\JadwalController as AdminJadwalController;
use App\Http\Controllers\Admin\KategoriPaketController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Admin\PortofolioController as AdminPortofolioController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\JadwalController as ClientJadwalController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\WhatsAppController;
use App\Models\Portofolio;
use App\Models\Reservasi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

// ---------- Halaman Publik ----------
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/galeri', function () {
    $portofolios = Portofolio::latest()->get();

    return view('galeri', compact('portofolios'));
})->name('galeri');

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
    Route::get('/dashboard', function () {
        $now = Carbon::now();

        $analisisReservasi = collect(range(5, 0))->map(function ($monthsAgo) use ($now) {
            $month = $now->copy()->startOfMonth()->subMonths($monthsAgo);

            return [
                'label' => $month->translatedFormat('M Y'),
                'total' => Reservasi::whereYear('tanggal_acara', $month->year)
                    ->whereMonth('tanggal_acara', $month->month)
                    ->count(),
            ];
        });

        $statusPembayaranBerhasil = ['paid', 'settlement', 'lunas', 'capture', 'proof_verified'];
        $trenPendapatan = collect(range(5, 0))->map(function ($monthsAgo) use ($now, $statusPembayaranBerhasil) {
            $month = $now->copy()->startOfMonth()->subMonths($monthsAgo);
            $total = Reservasi::whereIn('payment_status', $statusPembayaranBerhasil)
                ->whereNotNull('paid_at')
                ->whereYear('paid_at', $month->year)
                ->whereMonth('paid_at', $month->month)
                ->get()
                ->sum(fn ($item) => $item->biaya_sewa ?: (($item->harga_paket ?: $item->harga_layanan ?: 0) * ($item->jumlah_pesanan ?: 1)));

            return ['label' => $month->translatedFormat('M Y'), 'total' => (int) $total];
        });

        $ringkasanProduk = collect();
        Reservasi::with(['layanans', 'paket'])->get()->each(function ($item) use ($ringkasanProduk) {
            if ($item->jenis_pesanan === 'paket') {
                $nama = $item->nama_paket ?: $item->paket?->nama_paket ?: 'Paket lainnya';
                $ringkasanProduk->put($nama, ($ringkasanProduk->get($nama, 0)) + 1);
                return;
            }

            $namaLayanan = $item->layanans->pluck('nama_layanan')->filter();
            if ($namaLayanan->isEmpty() && $item->nama_layanan) {
                $namaLayanan = collect([$item->nama_layanan]);
            }
            foreach ($namaLayanan as $nama) {
                $ringkasanProduk->put($nama, ($ringkasanProduk->get($nama, 0)) + 1);
            }
        });
        $ringkasanProduk = $ringkasanProduk->sortDesc()->take(8);

        $agendaMendatang = Reservasi::with('user')
            ->whereBetween('tanggal_acara', [$now->toDateString(), $now->copy()->addDays(7)->toDateString()])
            ->whereIn('status_reservasi', ['tervalidasi', 'Tervalidasi', 'disetujui', 'Disetujui', 'confirmed', 'Confirmed', 'selesai', 'Selesai'])
            ->orderBy('tanggal_acara')
            ->take(5)
            ->get();

        $pendapatanBulanIni = Reservasi::whereMonth('tanggal_acara', $now->month)
            ->whereYear('tanggal_acara', $now->year)
            ->whereIn('payment_status', ['paid', 'settlement', 'lunas', 'capture'])
            ->get()
            ->sum(function ($item) {
                return $item->biaya_sewa ?? $item->harga_paket ?? $item->harga_layanan ?? 0;
            });

        $totalReservasi = Reservasi::whereIn('status_reservasi', ['tervalidasi', 'disetujui', 'selesai', 'confirmed'])
            ->count();

        $clientAktif = User::where('role', 'client')->count();

        $transaksiTerbaru = Reservasi::with(['user', 'paket', 'layanans'])
            ->orderByDesc('id_reservasi')
            ->take(7)
            ->get();

        $pendingReservationsCount = Reservasi::whereIn('status_reservasi', ['pending', 'menunggu', 'menunggu_konfirmasi'])
            ->count();

        return view('admin.dashboard', compact(
            'pendapatanBulanIni',
            'totalReservasi',
            'clientAktif',
            'transaksiTerbaru',
            'pendingReservationsCount',
            'analisisReservasi',
            'trenPendapatan',
            'ringkasanProduk',
            'agendaMendatang'
        ));
    })->name('dashboard');

    Route::resource('layanan', LayananController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('paket', PaketController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('kategori-paket', KategoriPaketController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('portofolio', AdminPortofolioController::class);
    Route::resource('users', UserController::class);

    // Jadwal Acara Admin & Endpoint JSON Kalender
    Route::get('/jadwal', [AdminJadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/json', [ClientJadwalController::class, 'getJadwalJson'])->name('jadwal.json');
    Route::post('/jadwal/validasi/{id}', [AdminJadwalController::class, 'validasi'])->name('jadwal.validasi');
    Route::put('/jadwal/update-tanggal/{id}', [AdminJadwalController::class, 'updateTanggal'])->name('jadwal.updateTanggal');
    Route::post('/jadwal/kirim-wa/{id}', [AdminJadwalController::class, 'kirimNotifWaAdmin'])->name('jadwal.kirimWa');

    // Laporan Transaksi Admin
    Route::get('/laporan-transaksi', [LaporanController::class, 'index'])->name('laporan.transaksi');
    Route::get('/laporan-transaksi/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.transaksi.pdf');
    Route::get('/laporan-transaksi/excel', [LaporanController::class, 'exportExcel'])->name('laporan.transaksi.excel');
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

    // Reservasi & Pembayaran (Khusus Client)
    Route::get('/api/jadwal-tervalidasi', [ClientDashboardController::class, 'getJadwalTervalidasi'])->name('api.jadwal.tervalidasi');
    Route::get('/reservasi', [ReservasiController::class, 'create'])->name('reservasi.create');
    Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
    Route::post('/reservasi/{reservasi}/payment', [PaymentController::class, 'create'])->name('reservasi.payment.create');
    Route::post('/reservasi/{reservasi}/payment/sync', [PaymentController::class, 'syncStatus'])->name('reservasi.payment.sync');
    Route::get('/transaksi/{reservasi}/pembayaran', [PaymentController::class, 'show'])->name('client.payment.show');
});

// ---------- Profil User (Admin & Client) ----------
Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [UserProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/profil', [UserProfileController::class, 'update'])->name('user.profile.update');
    Route::delete('/profil', [UserProfileController::class, 'destroy'])->name('user.profile.destroy');
});

// ---------- Webhook & Cron ----------
Route::post('/payment/midtrans/notification', [PaymentController::class, 'notification'])->name('payment.midtrans.notification');
Route::get('/kirim-notif-wa', [WhatsAppController::class, 'kirimPengingatOtomatis']);