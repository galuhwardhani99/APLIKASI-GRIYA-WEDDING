<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Models\Layanan;
use App\Models\KategoriPaket;
use App\Models\Portofolio;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('client.dashboard', [
            'layanans' => Layanan::where('status', 'Aktif')->latest('id_layanan')->take(6)->get(),
            'layanansCount' => Layanan::where('status', 'Aktif')->count(),
            'pakets' => Paket::with('kategoriPaket')->where('status', 'Aktif')->latest()->take(6)->get(),
            'paketsCount' => Paket::where('status', 'Aktif')->count(),
            'portofolios' => Portofolio::latest()->take(6)->get(),
            'whatsapp' => config('services.griya.whatsapp'),
        ]);
    }

    public function katalogLayanan(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'variasi' => ['nullable', 'string', 'max:255'],
            'harga_min' => ['nullable', 'numeric', 'min:0'],
            'harga_max' => ['nullable', 'numeric', 'min:0'],
        ]);

        $layanans = Layanan::query()->where('status', 'Aktif')
            ->when($filters['search'] ?? null, fn ($query, $search) => $query->where(fn ($q) => $q
                ->where('nama_layanan', 'like', "%{$search}%")
                ->orWhere('variasi', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%")))
            ->when($filters['variasi'] ?? null, fn ($query, $variasi) => $query->where('variasi', $variasi))
            ->when(isset($filters['harga_min']), fn ($query) => $query->where('harga', '>=', $filters['harga_min']))
            ->when(isset($filters['harga_max']), fn ($query) => $query->where('harga', '<=', $filters['harga_max']))
            ->latest('id_layanan')->paginate(12)->withQueryString();

        $variasiOptions = Layanan::where('status', 'Aktif')->whereNotNull('variasi')->where('variasi', '!=', '')
            ->distinct()->orderBy('variasi')->pluck('variasi');

        return view('client.katalog.layanan', compact('layanans', 'variasiOptions', 'filters'));
    }

    public function katalogPaket(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'kategori' => ['nullable', 'integer', 'exists:kategori_pakets,id'],
            'harga_min' => ['nullable', 'numeric', 'min:0'],
            'harga_max' => ['nullable', 'numeric', 'min:0'],
        ]);

        $pakets = Paket::with('kategoriPaket')->where('status', 'Aktif')
            ->when($filters['search'] ?? null, fn ($query, $search) => $query->where(fn ($q) => $q
                ->where('nama_paket', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%")
                ->orWhereHas('kategoriPaket', fn ($category) => $category->where('nama_kategori', 'like', "%{$search}%"))))
            ->when($filters['kategori'] ?? null, fn ($query, $kategori) => $query->where('kategori_paket_id', $kategori))
            ->when(isset($filters['harga_min']), fn ($query) => $query->where('harga', '>=', $filters['harga_min']))
            ->when(isset($filters['harga_max']), fn ($query) => $query->where('harga', '<=', $filters['harga_max']))
            ->latest()->paginate(12)->withQueryString();

        $kategoriPakets = KategoriPaket::orderBy('nama_kategori')->get();

        return view('client.katalog.paket', compact('pakets', 'kategoriPakets', 'filters'));
    }
}
