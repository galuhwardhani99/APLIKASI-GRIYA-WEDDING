<?php

namespace App\Providers;

use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        app()->setLocale('id');
        Carbon::setLocale('id');

        if (config('app.env') !== 'local' || request()->hasHeader('x-forwarded-proto')) {
            URL::forceScheme('https');
        }

        // Notifikasi Admin
        View::composer(['admin.*', 'layouts.admin', 'partials.sidebar', 'user.profile', 'profile'], function ($view) {
            $pendingCount = Reservasi::whereIn('status_reservasi', ['Menunggu Konfirmasi', 'Pending', 'pending'])->count();

            $lastCheckedPaid = session('admin_last_checked_paid');
            $paidQuery = Reservasi::whereIn('payment_status', ['paid', 'settlement', 'lunas', 'capture', 'proof_verified']);

            if ($lastCheckedPaid) {
                $paidQuery->where(function ($q) use ($lastCheckedPaid) {
                    $q->where('paid_at', '>', $lastCheckedPaid)
                      ->orWhere(function ($sub) use ($lastCheckedPaid) {
                          $sub->whereNull('paid_at')->where('updated_at', '>', $lastCheckedPaid);
                      });
                });
            } else {
                $paidQuery->where(function ($q) {
                    $q->whereDate('paid_at', today())
                      ->orWhere(function ($sub) {
                          $sub->whereNull('paid_at')->whereDate('updated_at', today());
                      });
                });
            }

            $view->with([
                'pendingReservationsCount' => $pendingCount,
                'newPaidPaymentsCount' => $paidQuery->count(),
            ]);
        });

        // Notifikasi Client
        View::composer(['client.*', 'user.profile', 'profile'], function ($view) {
            $clientValidatedCount = 0;
            $clientApprovedReadyToPayCount = 0;

            if (Auth::check() && Auth::user()->role !== 'admin') {
                $userId = Auth::id();
                $seenValidations = session('client_seen_validations', []);

                // 1. Ambil reservasi yang berstatus Disetujui / Ditolak & belum dibayar
                $validatedReservasis = Reservasi::where('id_akun', $userId)
                    ->whereIn('status_reservasi', ['Disetujui', 'Ditolak'])
                    ->whereNotIn('payment_status', ['paid', 'proof_verified'])
                    ->get(['id_reservasi', 'status_reservasi']);

                // Hitung hanya yang kombinasi "id:status"-nya belum pernah dilihat client
                $clientValidatedCount = $validatedReservasis->filter(function ($item) use ($seenValidations) {
                    $key = $item->id_reservasi . ':' . $item->status_reservasi;
                    return !in_array($key, $seenValidations, true);
                })->count();

                // 2. Hitung reservasi yang sudah Disetujui tapi belum dibayar (untuk badge di Riwayat Transaksi)
                $clientApprovedReadyToPayCount = Reservasi::where('id_akun', $userId)
                    ->where('status_reservasi', 'Disetujui')
                    ->whereNotIn('payment_status', ['paid', 'proof_verified'])
                    ->count();
            }

            $view->with([
                'clientValidatedCount' => $clientValidatedCount,
                'clientApprovedReadyToPayCount' => $clientApprovedReadyToPayCount,
            ]);
        });
    }
}