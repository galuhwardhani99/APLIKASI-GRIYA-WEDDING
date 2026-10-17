<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class LayananController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $layanans = Layanan::query()->when($search, fn ($query) => $query->where(fn ($q) => $q
            ->where('nama_layanan', 'like', "%{$search}%")
            ->orWhere('variasi', 'like', "%{$search}%")))
            ->latest('id_layanan')->get();

        return view('admin.layanan.index', compact('layanans', 'search'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['foto'] = $request->file('foto')?->store('layanan', 'public');
        $data['unggulan'] = $request->boolean('unggulan');
        Layanan::create($data);

        return to_route('admin.layanan.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function update(Request $request, string $id_layanan)
    {
        $layanan = Layanan::findOrFail($id_layanan);
        $data = $this->validated($request);
        if ($request->exists('unggulan')) {
            $data['unggulan'] = $request->boolean('unggulan');
        }

        if ($request->hasFile('foto')) {
            $fotoLama = $layanan->foto;
            $data['foto'] = $request->file('foto')->store('layanan', 'public');
            $layanan->update($data);
            if ($fotoLama) Storage::disk('public')->delete($fotoLama);
        } else {
            $layanan->update($data);
        }

        return to_route('admin.layanan.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(string $id_layanan)
    {
        $layanan = Layanan::findOrFail($id_layanan);
        if ($layanan->foto) Storage::disk('public')->delete($layanan->foto);
        $layanan->delete();

        return to_route('admin.layanan.index')->with('success', 'Layanan berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        if ($request->filled('harga')) {
            $request->merge(['harga' => preg_replace('/\D+/', '', (string) $request->input('harga'))]);
        }

        return $request->validate([
            'nama_layanan' => ['required', 'string', 'max:255'],
            'variasi' => ['nullable', 'string', 'max:255'],
            'harga' => ['required', 'integer', 'min:0'],
            'deskripsi' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'unggulan' => ['sometimes', 'boolean'],
            'status' => ['required', Rule::in(['Aktif', 'Nonaktif'])],
        ]);
    }
}
