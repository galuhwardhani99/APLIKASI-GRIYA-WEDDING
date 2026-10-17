<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPaket;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriPaketController extends Controller
{
    public function index()
    {
        $kategoriPakets = KategoriPaket::withCount('pakets')->orderBy('nama_kategori')->get();

        return view('admin.kategori-paket.index', compact('kategoriPakets'));
    }

    public function store(Request $request)
    {
        KategoriPaket::create($this->validated($request));

        return to_route('admin.kategori-paket.index')->with('success', 'Kategori paket berhasil ditambahkan.');
    }

    public function update(Request $request, KategoriPaket $kategoriPaket)
    {
        $kategoriPaket->update($this->validated($request, $kategoriPaket));

        return to_route('admin.kategori-paket.index')->with('success', 'Kategori paket berhasil diperbarui.');
    }

    public function destroy(KategoriPaket $kategoriPaket)
    {
        if ($kategoriPaket->pakets()->exists()) {
            return to_route('admin.kategori-paket.index')->with('error', 'Kategori masih digunakan oleh paket dan tidak dapat dihapus.');
        }

        $kategoriPaket->delete();

        return to_route('admin.kategori-paket.index')->with('success', 'Kategori paket berhasil dihapus.');
    }

    private function validated(Request $request, ?KategoriPaket $kategoriPaket = null): array
    {
        return $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100', Rule::unique('kategori_pakets', 'nama_kategori')->ignore($kategoriPaket?->id)],
        ]);
    }
}
