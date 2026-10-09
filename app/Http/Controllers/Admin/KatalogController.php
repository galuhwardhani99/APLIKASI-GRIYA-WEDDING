<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index()
    {
        $pakets = Paket::latest()->get();
        
        return view('admin.katalog.index', compact('pakets'));
    }

    public function store(Request $request)
    {
        // Bersihkan tanda titik dari input harga sebelum validasi
        if ($request->has('harga')) {
            $request->merge([
                'harga' => str_replace('.', '', $request->harga)
            ]);
        }

        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'kategori'   => 'required|string|max:100',
            'harga'      => 'required|numeric|min:0',
            'deskripsi'  => 'nullable|string',
        ]);

        Paket::create($validated);

        return redirect()->route('admin.katalog.index')
            ->with('success', 'Katalog layanan berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        // Bersihkan tanda titik dari input harga sebelum validasi
        if ($request->has('harga')) {
            $request->merge([
                'harga' => str_replace('.', '', $request->harga)
            ]);
        }

        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'kategori'   => 'required|string|max:100',
            'harga'      => 'required|numeric|min:0',
            'deskripsi'  => 'nullable|string',
        ]);

        $paket = Paket::findOrFail($id);
        $paket->update($validated);

        return redirect()->route('admin.katalog.index')
            ->with('success', 'Katalog layanan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $paket = Paket::findOrFail($id);
        $paket->delete();

        return redirect()->route('admin.katalog.index')
            ->with('success', 'Katalog layanan berhasil dihapus.');
    }
}