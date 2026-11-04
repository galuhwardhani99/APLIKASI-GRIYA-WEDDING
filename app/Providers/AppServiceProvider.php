<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Reservasi;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Paksa semua URL generated (asset/route) menggunakan HTTPS
        if (config('app.env') !== 'local' || request()->hasHeader('x-forwarded-proto')) {
            URL::forceScheme('https');
        }

        // Mengirimkan variabel $pendingReservationsCount secara otomatis ke semua tampilan admin (admin/*)
        View::composer('admin.*', function ($view) {
            $count = Reservasi::where('status_reservasi', 'Menunggu Konfirmasi')->count();
            $view->with('pendingReservationsCount', $count);
        });
    }
}