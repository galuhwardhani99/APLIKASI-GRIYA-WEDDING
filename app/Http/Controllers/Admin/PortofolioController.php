<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portofolio;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortofolioController extends Controller
{
    public function index()
    {
        $portofolios = Portofolio::latest()->get();
        
        // Ambil kategori unik yang tersimpan di tabel pakets
        $kategoriList = Paket::select('kategori')->distinct()->pluck('kategori');

        return view('admin.portofolio.index', compact('portofolios', 'kategoriList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|string|max:100',
            'gambar'    => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('portofolio', 'public');
        }

        Portofolio::create($validated);

        return redirect()->route('admin.portofolio.index')
            ->with('success', 'Foto galeri portofolio berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $portofolio = Portofolio::findOrFail($id);

        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|string|max:100',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        if ($request->hasFile('gambar')) {
            if ($portofolio->gambar) {
                Storage::disk('public')->delete($portofolio->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('portofolio', 'public');
        }

        $portofolio->update($validated);

        return redirect()->route('admin.portofolio.index')
            ->with('success', 'Galeri portofolio berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $portofolio = Portofolio::findOrFail($id);
        
        if ($portofolio->gambar) {
            Storage::disk('public')->delete($portofolio->gambar);
        }
        
        $portofolio->delete();

        return redirect()->route('admin.portofolio.index')
            ->with('success', 'Foto portofolio berhasil dihapus.');
    }
}