<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReservasiController extends Controller
{
    public function index()
    {
        try {
            $reservasis = Reservasi::latest('id_reservasi')->get();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil data reservasi',
                'data'    => $reservasis
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data'    => []
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validasi input dari Android
            $request->validate([
                'tanggal_acara' => 'required',
                'lokasi'        => 'required|string',
            ]);

            // Ambil nama & hp dari request atau buat gabungan detail_acara
            $namaClient = $request->input('nama_client', 'Client');
            $nomorHp = $request->input('nomor_hp', '-');
            $catatan = $request->input('catatan', '-');

            $detailAcaraFormatted = "Nama: {$namaClient} | HP: {$nomorHp} | {$catatan}";

            // Buat record reservasi baru yang sesuai dengan struktur tabel MySQL
            $reservasi = Reservasi::create([
                'kode_reservasi'    => 'RSV-' . strtoupper(Str::random(6)),
                'jenis_acara'       => 'Rias Wedding / Event',
                'detail_acara'      => $detailAcaraFormatted,
                'lokasi'            => $request->lokasi,
                'tanggal_acara'     => $request->tanggal_acara,
                'tanggal_pengajuan' => now()->toDateString(),
                'status_reservasi'  => 'Pending',
                'id_akun'           => $request->input('id_akun', 1), // Default id_akun
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pengajuan reservasi berhasil dibuat.',
                'data'    => $reservasi
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $reservasi = Reservasi::findOrFail($id);

            $updateData = [];
            if ($request->has('status_reservasi')) {
                $updateData['status_reservasi'] = $request->status_reservasi;
            }
            if ($request->has('bukti_transfer')) {
                $updateData['bukti_transfer'] = $request->bukti_transfer;
            }

            $reservasi->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Status reservasi berhasil diperbarui',
                'data'    => $reservasi
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status: ' . $e->getMessage()
            ], 500);
        }
    }
}