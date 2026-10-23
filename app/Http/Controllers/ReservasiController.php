<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Paket;
use App\Models\JadwalAcara;
use App\Models\Layanan;
use App\Support\BookingAvailability;
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
                'id_item' => ['nullable', 'required_if:jenis_pesanan,paket', 'regex:/^paket:[0-9]+$/'],
                'id_items' => ['nullable', 'required_if:jenis_pesanan,layanan', 'array', 'min:1'],
                'id_items.*' => ['required', 'integer', 'distinct', 'exists:layanans,id_layanan'],
                'tgl_acara' => ['required', 'date', 'after_or_equal:today'],
                'full_day' => ['nullable', 'boolean'],
                'waktu_mulai' => ['required_unless:full_day,1', 'nullable', 'date_format:H:i'],
                'waktu_selesai' => ['required_unless:full_day,1', 'nullable', 'date_format:H:i', 'after:waktu_mulai'],
                'lokasi_acara' => ['required', 'string', 'max:255'],
                'catatan' => ['nullable', 'string', 'max:2000'],
            ]);

            if ($request->boolean('full_day')) {
                $validated['waktu_mulai'] = '00:00';
                $validated['waktu_selesai'] = '23:59';
            }

            $bookingsForDate = BookingAvailability::forDate($validated['tgl_acara']);
            $hasConflict = $bookingsForDate->contains(fn (Reservasi $booking) => BookingAvailability::overlaps(
                $validated['waktu_mulai'],
                $validated['waktu_selesai'],
                $booking
            ));

            if ($hasConflict) {
                $freeSlots = BookingAvailability::freeSlots($bookingsForDate);

                return back()->withInput()->with('booking_conflict', [
                    'date' => $validated['tgl_acara'],
                    'free_slots' => $freeSlots,
                ]);
            }

            $isPaket = $validated['jenis_pesanan'] === 'paket';
            $item = null;
            $selectedLayanans = collect();

            if ($isPaket) {
                $itemId = (int) substr($validated['id_item'], strlen('paket:'));
                $item = Paket::where('status', 'Aktif')->findOrFail($itemId);
            } else {
                $selectedLayanans = Layanan::where('status', 'Aktif')
                    ->whereIn('id_layanan', $validated['id_items'])
                    ->get();

                if ($selectedLayanans->count() !== count($validated['id_items'])) {
                    return back()->withInput()->withErrors([
                        'id_items' => 'Satu atau beberapa layanan sudah tidak tersedia. Silakan pilih kembali.',
                    ]);
                }
            }

            $reservasi = DB::transaction(function () use ($validated, $item, $selectedLayanans, $isPaket) {
                $layananPertama = $selectedLayanans->first();
                $hargaLayanan = $selectedLayanans->sum('harga');

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
                    'id_layanan'        => $isPaket ? null : $layananPertama->id_layanan,
                    'nama_layanan'      => $isPaket ? null : $layananPertama->nama_layanan,
                    'harga_layanan'     => $isPaket ? null : $hargaLayanan,
                    'jumlah_pesanan'    => 1,
                    'waktu_mulai'       => $validated['waktu_mulai'],
                    'waktu_selesai'     => $validated['waktu_selesai'],
                    'detail_acara'      => $validated['catatan'] ?? null, // Sesuai kolom detail_acara
                ]);

                if (! $isPaket) {
                    $reservasiBaru->layanans()->attach($selectedLayanans->mapWithKeys(fn (Layanan $layanan) => [
                        $layanan->id_layanan => [
                            'nama_layanan' => $layanan->nama_layanan,
                            'harga_layanan' => $layanan->harga,
                        ],
                    ])->all());
                }

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
