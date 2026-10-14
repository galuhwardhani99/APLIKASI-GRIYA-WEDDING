<?php

namespace App\Providers;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        // 2. Paksa semua URL generated (asset/route) menggunakan HTTPS
        if (config('app.env') !== 'local' || request()->hasHeader('x-forwarded-proto')) {
            URL::forceScheme('https');
        }
    }
}
