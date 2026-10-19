<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Paket;
use App\Models\JadwalAcara;
use App\Models\Layanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReservasiController extends Controller
{
    public function create(Request $request)
    {
        $pakets = Paket::with('kategoriPaket')->where('status', 'Aktif')->orderBy('nama_paket')->get();
        $layanans = Layanan::where('status', 'Aktif')->orderBy('nama_layanan')->get();
        $selectedPackageId = $request->query('id_paket');
        $selectedItemValue = $selectedPackageId ? 'paket:' . $selectedPackageId : null;
        $user = $request->user();

        return view('client.reservasi', compact('pakets', 'layanans', 'selectedPackageId', 'selectedItemValue', 'user'));
    }

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
        if (! $request->expectsJson()) {
            $validated = $request->validate([
                'jenis_pesanan' => ['required', 'in:paket,layanan'],
                'id_item' => ['required', 'regex:/^(paket|layanan):[0-9]+$/'],
                'tgl_acara' => ['required', 'date', 'after_or_equal:today'],
                'jumlah_pesanan' => ['required', 'integer', 'min:1', 'max:20'],
                'waktu_mulai' => ['required', 'date_format:H:i'],
                'waktu_selesai' => ['required', 'date_format:H:i', 'after:waktu_mulai'],
                'lokasi_acara' => ['required', 'string', 'max:255'],
                'catatan' => ['nullable', 'string', 'max:2000'],
            ]);

            abort_unless(str_starts_with($validated['id_item'], $validated['jenis_pesanan'] . ':'), 422, 'Pilihan tidak sesuai dengan jenis item.');
            $itemId = (int) substr($validated['id_item'], strpos($validated['id_item'], ':') + 1);
            $item = $validated['jenis_pesanan'] === 'paket'
                ? Paket::where('status', 'Aktif')->findOrFail($itemId)
                : Layanan::where('status', 'Aktif')->findOrFail($itemId);
            
            $isPaket = $validated['jenis_pesanan'] === 'paket';

            $reservasi = DB::transaction(function () use ($validated, $item, $isPaket) {
                // 1. Simpan Reservasi sesuai nama kolom di phpMyAdmin
                $reservasiBaru = Reservasi::create([
                    'kode_reservasi'    => 'RSV-' . strtoupper(Str::random(8)),
                    'tanggal_pengajuan' => now()->toDateString(),
                    'tanggal_acara'     => $validated['tgl_acara'], // Sesuai kolom database
                    'lokasi'            => $validated['lokasi_acara'], // Sesuai kolom database
                    'status_reservasi'  => 'Menunggu Konfirmasi',
                    'id_akun'           => Auth::id(), // Sesuai kolom id_akun di database
                    'jenis_pesanan'     => $validated['jenis_pesanan'],
                    'id_paket'          => $isPaket ? $item->id : null,
                    'nama_paket'        => $isPaket ? $item->nama_paket : null,
                    'harga_paket'       => $isPaket ? $item->harga : null,
                    'id_layanan'        => $isPaket ? null : $item->id_layanan,
                    'nama_layanan'      => $isPaket ? null : $item->nama_layanan,
                    'harga_layanan'     => $isPaket ? null : $item->harga,
                    'jumlah_pesanan'    => $validated['jumlah_pesanan'],
                    'waktu_mulai'       => $validated['waktu_mulai'],
                    'waktu_selesai'     => $validated['waktu_selesai'],
                    'detail_acara'      => $validated['catatan'] ?? null, // Sesuai kolom detail_acara
                ]);

                // 2. Buat Jadwal Acara di tabel jadwal_acaras
                JadwalAcara::create([
                    'id_reservasi'    => $reservasiBaru->id_reservasi,
                    'divalidasi_oleh' => null,
                    'waktu_mulai'     => $validated['waktu_mulai'],
                    'waktu_selesai'   => $validated['waktu_selesai'],
                    'status_validasi' => 'Menunggu Validasi',
                ]);

                return $reservasiBaru;
            });

            return to_route('client.riwayat.reservasi')->with('success', 'Pengajuan booking berhasil dikirim. Kode reservasi: ' . $reservasi->kode_reservasi);
        }

        try {
            $request->validate([
                'tanggal_acara' => 'required',
                'lokasi'        => 'required|string',
            ]);

            $namaClient = $request->input('nama_client', 'Client');
            $nomorHp = $request->input('nomor_hp', '-');
            $catatan = $request->input('catatan', '-');

            $detailAcaraFormatted = "Nama: {$namaClient} | HP: {$nomorHp} | {$catatan}";

            $reservasi = Reservasi::create([
                'kode_reservasi'    => 'RSV-' . strtoupper(Str::random(6)),
                'jenis_acara'       => 'Rias Wedding / Event',
                'detail_acara'      => $detailAcaraFormatted,
                'lokasi'            => $request->lokasi,
                'tanggal_acara'     => $request->tanggal_acara,
                'tanggal_pengajuan' => now()->toDateString(),
                'status_reservasi'  => 'Pending',
                'id_akun'           => $request->input('id_akun', 1),
            ]);

            JadwalAcara::create([
                'id_reservasi' => $reservasi->id_reservasi,
                'status_validasi' => 'Menunggu Validasi',
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