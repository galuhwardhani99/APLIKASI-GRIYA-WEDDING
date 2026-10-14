<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalAcara;
use App\Models\Reservasi; // <-- Tambahkan baris ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        // Ambil reservasi yang sudah memiliki atau belum memiliki jadwal
        $reservasi = Reservasi::with(['user', 'jadwal'])->latest()->get();

        return view('admin.jadwal.index', compact('reservasi'));
    }

    public function validasi(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);
        
        // Update status di reservasi
        $reservasi->update([
            'status_reservasi' => 'Disetujui'
        ]);

        // Simpan atau update ke tabel jadwal_acara
        JadwalAcara::updateOrCreate(
            ['id_reservasi' => $reservasi->id_reservasi],
            [
                'divalidasi_oleh' => Auth::id(),
                'status_validasi' => 'Tervalidasi',
                'waktu_mulai'     => $request->waktu_mulai ?? '08:00:00',
                'waktu_selesai'   => $request->waktu_selesai ?? '16:00:00',
            ]
        );

        return redirect()->back()->with('success', 'Jadwal acara berhasil divalidasi!');
    }

    public function updateTanggal(Request $request, $id)
    {
        $request->validate([
            'tanggal_acara' => 'required|date',
        ]);

        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update([
            'tanggal_acara' => $request->tanggal_acara
        ]);

        return redirect()->back()->with('success', 'Tanggal acara berhasil diperbarui!');
    }
}