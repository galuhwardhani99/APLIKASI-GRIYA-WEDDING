<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservasiController extends Controller
{
    /**
     * Menampilkan halaman form reservasi/checkout
     */
    public function create()
    {
        // Mengambil data user (Client) yang sedang login untuk mengisi otomatis Nama Pemesan
        $user = Auth::user();

        // Nanti Anda bisa memanggil data Paket/Layanan dari database berdasarkan pilihan Client di halaman katalog
        // $paket = Paket::find($request->paket_id); 

        return view('client.reservasi', compact('user'));
    }

    /**
     * Memproses data submit dari form reservasi
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari Client
        $validatedData = $request->validate([
            'whatsapp'     => 'required|string|max:20',
            'tanggal'      => 'required|date', // Sebaiknya gunakan tipe date pada input form nantinya
            'lokasi'       => 'required|string',
            'skema_bayar'  => 'required|in:dp,lunas',
            'metode_bayar' => 'required|in:qris,va',
        ]);

        // 2. Logika untuk menyimpan data pesanan/reservasi ke Database MySQL
        // Contoh:
        // Reservasi::create([
        //     'user_id' => Auth::id(),
        //     'no_whatsapp' => $request->whatsapp,
        //     'tanggal_acara' => $request->tanggal,
        //     'lokasi_acara' => $request->lokasi,
        //     'skema_pembayaran' => $request->skema_bayar,
        //     'metode_pembayaran' => $request->metode_bayar,
        //     'status' => 'pending', // Menunggu pembayaran
        // ]);

        // 3. TODO: Integrasi Payment Gateway (Fonnte/Midtrans/dll) di sini (Sprint 3)
        // 4. TODO: Panggilan API WhatsApp untuk notifikasi konfirmasi (Sprint 3)

        // 5. Redirect ke halaman riwayat pesanan atau sukses
        return redirect()->route('home')->with('success', 'Pengajuan reservasi berhasil dibuat. Silakan selesaikan pembayaran.');
    }
}