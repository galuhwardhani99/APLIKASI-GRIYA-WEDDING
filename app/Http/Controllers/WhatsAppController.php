<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Reservasi;
use Carbon\Carbon;

class WhatsAppController extends Controller
{
    // Fungsi untuk mengirim pesan WA via Fonnte
    private function kirimFonnte($tujuan, $pesan)
    {
        $response = Http::withHeaders([
            'Authorization' => env('FONNTE_TOKEN'),
        ])->post('https://api.fonnte.com/send', [
            'target' => $tujuan,
            'message' => $pesan,
        ]);

        return $response->json();
    }

    // Fungsi utama untuk demo pengingat H-1 & Pelunasan
    public function kirimPengingatOtomatis()
    {
        $besok = Carbon::tomorrow()->toDateString();
        
        // Ambil data reservasi yang tanggal acaranya besok, sekaligus ambil data user (pemesan)
        $reservasis = Reservasi::with(['akun', 'layanans'])->whereDate('tanggal_acara', $besok)->get();

        if ($reservasis->isEmpty()) {
            return "Tidak ada jadwal wedding untuk besok (" . $besok . ").";
        }

        foreach ($reservasis as $item) {
            // Pastikan relasi akun dan nomor HP/teleponnya ada
            $noHp = $item->akun->no_hp ?? $item->akun->phone ?? null; // Sesuaikan nama kolom no_hp di tabel users kamu
            $namaPemesan = $item->akun->name ?? 'Pelanggan';
            $namaAcara = $item->nama_paket
                ?: ($item->layanans->pluck('nama_layanan')->filter()->implode(', ')
                    ?: ($item->nama_layanan ?: ($item->jenis_acara ?: 'acara Anda')));

            if (!$noHp) {
                continue; // Lewati jika nomor HP tidak ditemukan
            }

            // 1. Pesan Pengingat H-1 Acara Wedding
            $tanggal = Carbon::parse($item->tanggal_acara)->format('d/m/Y');
            $totalHarga = (int) ($item->biaya_sewa ?: (($item->harga_paket ?: $item->harga_layanan ?: 0) * ($item->jumlah_pesanan ?: 1)));
            $total = 'Rp ' . number_format($totalHarga, 0, ',', '.');

            $pesanAcara = "GRIYA RIAS ELLY JR.\n"
                . "Jl. Rengganis Nomor 333A Doko, Kab. Kediri\n"
                . "Tgl : {$tanggal}\n"
                . "Kode : {$item->kode_reservasi}\n"
                . "Plgn : {$namaPemesan}\n"
                . "Paket : {$namaAcara}\n"
                . "TOTAL : {$total}\n\n"
                . "Halo Admin, reservasi saya telah berhasil divalidasi. "
                . "Saya ingin berdiskusi mengenai pembayaran. "
                . "Kapan saya bisa bertemu untuk diskusi pembayaran?";
            
            $this->kirimFonnte($noHp, $pesanAcara);

            // 2. Pesan Pengingat Pelunasan (Opsional/Jika ada kolom status pembayaran di reservasi)
            // Kalau di tabel reservasi belum ada kolom status pembayaran, bagian ini bisa dilewati dulu.
            if (isset($item->status_pembayaran) && $item->status_pembayaran != 'lunas') {
                $linkBayar = route('client.pembayaran', $item->id_reservasi); 
                $pesanBayar = "Halo *{$namaPemesan}*,\n\n" .
                              "Pembayaran reservasi wedding Anda belum lunas. " .
                              "Mohon segera lakukan pelunasan melalui link berikut:\n{$linkBayar}";
                
                $this->kirimFonnte($noHp, $pesanBayar);
            }
        }

        return "Berhasil! Notifikasi pengingat H-1 telah dikirim ke nomor klien.";
    }
}
