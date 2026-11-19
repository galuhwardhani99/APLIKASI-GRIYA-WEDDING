<?php

namespace App\Console\Commands;

use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KirimReminderH1 extends Command
{
    protected $signature = 'reminder:h1';
    protected $description = 'Kirim pengingat WhatsApp H-1 acara wedding via Fonnte';

    private function kirimFonnte(string $tujuan, string $pesan): bool
    {
        $response = Http::withHeaders([
            'Authorization' => config('services.fonnte.token'),
        ])->post('https://api.fonnte.com/send', [
            'target'  => $tujuan,
            'message' => $pesan,
        ]);

        return $response->successful() && ($response->json('status') === true);
    }

    public function handle(): int
    {
        $besok = Carbon::tomorrow()->toDateString();

        $reservasis = Reservasi::with(['akun', 'layanans'])
            ->whereDate('tanggal_acara', $besok)
            ->whereNull('reminder_h1_sent_at')
            // ->where('status_reservasi', 'Disetujui')  // SESUAIKAN dengan status yang kamu pakai
            ->get();

        if ($reservasis->isEmpty()) {
            $this->info("Tidak ada acara untuk besok ($besok).");
            return self::SUCCESS;
        }

        foreach ($reservasis as $item) {
            $noHp = $item->akun->no_hp ?? $item->akun->phone ?? null;
            if (!$noHp) {
                Log::warning("Reminder H-1: reservasi {$item->kode_reservasi} tanpa nomor HP");
                continue;
            }

            $namaPemesan = $item->akun->name ?? 'Pelanggan';
            $namaAcara = $item->nama_paket
                ?: ($item->layanans->pluck('nama_layanan')->filter()->implode(', ')
                    ?: ($item->nama_layanan ?: ($item->jenis_acara ?: 'acara Anda')));

            $tanggal = Carbon::parse($item->tanggal_acara)->format('d/m/Y');
            $total   = 'Rp ' . number_format($item->total_harga ?? 0, 0, ',', '.'); // Sesuaikan nama kolom total

            $pesan = "GRIYA RIAS ELLY JR.\n"
                . "Jl. Rengganis Nomor 333A Doko, Kab. Kediri\n"
                . "Tgl : {$tanggal}\n"
                . "Kode : {$item->kode_reservasi}\n"
                . "Plgn : {$namaPemesan}\n"
                . "Acara : " . ($item->jenis_acara ?: '-') . "\n"
                . "Paket : {$namaAcara}\n"
                . "TOTAL : {$total}\n\n"
                . "Halo Admin, reservasi saya telah berhasil divalidasi. "
                . "Saya ingin berdiskusi mengenai pembayaran. "
                . "Kapan saya bisa bertemu untuk diskusi pembayaran?";

            if ($this->kirimFonnte($noHp, $pesan)) {
                $item->update(['reminder_h1_sent_at' => now()]);
                $this->info("Terkirim: {$namaPemesan}");
            } else {
                Log::error("Reminder H-1 gagal untuk reservasi {$item->kode_reservasi}");
                $this->error("Gagal: {$namaPemesan}");
            }

            // Pesan pelunasan (opsional, kalau kolom status_pembayaran ada)
            if (isset($item->status_pembayaran) && $item->status_pembayaran != 'lunas') {
                $linkBayar = route('client.pembayaran', $item->id_reservasi);
                $this->kirimFonnte($noHp, "Halo *{$namaPemesan}*,\n\nPembayaran reservasi wedding Anda belum lunas. Mohon segera lakukan pelunasan melalui link berikut:\n{$linkBayar}");
            }

            sleep(2); // jeda antar pesan supaya nomor WA tidak dianggap spam
        }

        return self::SUCCESS;
    }
}