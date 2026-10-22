<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Paket;
use App\Models\Portofolio;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role === 'client') {
            return redirect()->route('client.dashboard');
        }

        return $this->homePage();
    }

    public function clientPage()
    {
        return $this->homePage(true);
    }

    private function homePage(bool $clientPage = false)
    {
        $layanans = Layanan::where('status', 'Aktif')
            ->where('unggulan', true)
            ->latest('id_layanan')
            ->get();

        $pakets = Paket::with('kategoriPaket')
            ->where('status', 'Aktif')
            ->where('unggulan', true)
            ->latest()
            ->get();

        $portofolios = Portofolio::latest()->take(6)->get();
        $whatsapp = config('services.griya.whatsapp');

        return view('home', compact('layanans', 'pakets', 'portofolios', 'whatsapp', 'clientPage'));
    }
}
