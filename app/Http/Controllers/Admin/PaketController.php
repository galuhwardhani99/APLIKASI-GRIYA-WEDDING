<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Models\KategoriPaket;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class PaketController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $pakets = Paket::query()->when($search, fn ($query) => $query->where(fn ($q) => $q
            ->where('nama_paket', 'like', "%{$search}%")
            ->orWhereHas('kategoriPaket', fn ($q) => $q->where('nama_kategori', 'like', "%{$search}%"))))
            ->latest()->get();

        $kategoriPakets = KategoriPaket::orderBy('nama_kategori')->get();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'data' => $pakets]);
        }

        return view('admin.paket.index', compact('pakets', 'search', 'kategoriPakets'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['foto'] = $request->file('foto')?->store('paket', 'public');
        $data['unggulan'] = $request->boolean('unggulan');
        $paket = Paket::create($data);

        return $this->respond($request, $paket, 'Paket berhasil ditambahkan.', 201);
    }

    public function update(Request $request, string $id)
    {
        $paket = Paket::findOrFail($id);
        $data = $this->validated($request);
        if ($request->exists('unggulan')) {
            $data['unggulan'] = $request->boolean('unggulan');
        }

        if ($request->hasFile('foto')) {
            $fotoLama = $paket->foto;
            $data['foto'] = $request->file('foto')->store('paket', 'public');
            $paket->update($data);
            if ($fotoLama) Storage::disk('public')->delete($fotoLama);
        } else {
            $paket->update($data);
        }

        return $this->respond($request, $paket, 'Paket berhasil diperbarui.');
    }

    public function destroy(Request $request, string $id)
    {
        $paket = Paket::findOrFail($id);
        if ($paket->foto) Storage::disk('public')->delete($paket->foto);
        $paket->delete();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Paket berhasil dihapus.']);
        }

        return to_route('admin.paket.index')->with('success', 'Paket berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        if ($request->filled('harga')) {
            $request->merge(['harga' => preg_replace('/\D+/', '', (string) $request->input('harga'))]);
        }

        return $request->validate([
            'nama_paket' => ['required', 'string', 'max:255'],
            'kategori_paket_id' => ['required', 'exists:kategori_pakets,id'],
            'harga' => ['required', 'integer', 'min:0'],
            'deskripsi' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'unggulan' => ['sometimes', 'boolean'],
            'status' => ['required', Rule::in(['Aktif', 'Nonaktif'])],
        ]);
    }

    private function respond(Request $request, Paket $paket, string $message, int $status = 200)
    {
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message, 'data' => $paket], $status);
        }

        return to_route('admin.paket.index')->with('success', $message);
    }
}
