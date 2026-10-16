<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    /**
     * Menampilkan daftar katalog paket (Web View & API JSON)
     */
    public function index(Request $request)
    {
        try {
            $query = Paket::query();

            // Fitur pencarian berdasarkan nama paket atau kategori
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where('nama_paket', 'like', "%{$search}%")
                      ->orWhere('kategori', 'like', "%{$search}%");
            }

            $pakets = $query->latest()->get();

            // Jika dipanggil dari Aplikasi Android Mobile / Request API JSON
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'data'    => $pakets
                ], 200);
            }

            // Jika dibuka dari Web Browser Admin -> Render File Blade View
            return view('admin.katalog.index', compact('pakets'));

        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'data'    => []
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal memuat data: ' . $e->getMessage());
        }
    }

    /**
     * Menyimpan paket baru ke database
     */
    public function store(Request $request)
    {
        // Bersihkan format titik pada input harga (misal: "7.500.000" -> "7500000")
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

        $paket = Paket::create($validated);

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Katalog layanan berhasil ditambahkan',
                'data'    => $paket
            ], 201);
        }

        return redirect()->route('admin.katalog.index')->with('success', 'Paket layanan berhasil ditambahkan!');
    }

    /**
     * Memperbarui data paket di database
     */
    public function update(Request $request, string $id)
    {
        // Bersihkan format titik pada input harga (misal: "7.500.000" -> "7500000")
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

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Katalog layanan berhasil diperbarui',
                'data'    => $paket
            ], 200);
        }

        return redirect()->route('admin.katalog.index')->with('success', 'Paket layanan berhasil diperbarui!');
    }

    /**
     * Menghapus paket dari database
     */
    public function destroy(Request $request, string $id)
    {
        $paket = Paket::findOrFail($id);
        $paket->delete();

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Katalog layanan berhasil dihapus'
            ], 200);
        }

        return redirect()->route('admin.katalog.index')->with('success', 'Paket layanan berhasil dihapus!');
    }
}