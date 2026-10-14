<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
{
    try {
        $query = Paket::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('nama_paket', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
        }

        $pakets = $query->latest()->get();

        return response()->json([
            'success' => true,
            'data'    => $pakets
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'data'    => []
        ], 500);
    }
}

    public function store(Request $request)
    {
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

        return response()->json([
            'success' => true,
            'message' => 'Katalog layanan berhasil ditambahkan',
            'data'    => $paket
        ], 201);
    }

    public function update(Request $request, string $id)
    {
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

        return response()->json([
            'success' => true,
            'message' => 'Katalog layanan berhasil diperbarui',
            'data'    => $paket
        ], 200);
    }

    public function destroy(string $id)
    {
        $paket = Paket::findOrFail($id);
        $paket->delete();

        return response()->json([
            'success' => true,
            'message' => 'Katalog layanan berhasil dihapus'
        ], 200);
    }
}