<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalAcara;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        // Load relasi jadwal
        $reservasi = Reservasi::with(['user', 'jadwal'])->latest('id_reservasi')->get();

        return view('admin.jadwal.index', compact('reservasi'));
    }

    public function validasi(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);
        
        // Update status_reservasi menjadi Disetujui
        $reservasi->update([
            'status_reservasi' => 'Disetujui'
        ]);

        // Simpan / update ke jadwal_acaras
        JadwalAcara::updateOrCreate(
            ['id_reservasi' => $reservasi->id_reservasi],
            [
                'divalidasi_oleh' => Auth::id(),
                'status_validasi' => 'Tervalidasi',
                'waktu_mulai'     => $request->waktu_mulai ?? $reservasi->waktu_mulai ?? '08:00:00',
                'waktu_selesai'   => $request->waktu_selesai ?? $reservasi->waktu_selesai ?? '16:00:00',
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