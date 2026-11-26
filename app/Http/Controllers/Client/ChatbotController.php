<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\Paket;
use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    private const OUT_OF_SCOPE_REPLY = 'Maaf saya tidak dilatih untuk itu, coba keyword lain';

    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $rawMessage = trim($request->input('message'));
        $message = mb_strtolower($rawMessage);

        // 1. Sapaan dasar
        if (preg_match('/^(halo|hai|hi|hello|assalamualaikum|selamat\s+(pagi|siang|sore|malam)|permisi|p)\b/i', $message) && str_word_count($message) <= 4) {
            return response()->json([
                'reply' => "Halo! Selamat datang di Asisten Virtual Griya Rias Elly Jr. ✨\nAda yang bisa saya bantu seputar paket rias pengantin, layanan Wedding Organizer (WO), Event Organizer (EO), cek harga, atau cara reservasi?",
            ]);
        }

        // 2. Rule-Based Domain Filter (Hanya topik WO / EO / Rias / Reservasi)
        $allowedKeywords = [
            'wo', 'wedding', 'nikah', 'pernikahan', 'pengantin', 'akad', 'resepsi', 'lamaran', 'tunangan',
            'eo', 'event', 'acara', 'wisuda', 'karnaval', 'ulang tahun', 'gathering',
            'rias', 'makeup', 'make up', 'mua', 'busana', 'gaun', 'kebaya', 'baju', 'adat', 'modern', 'hijab', 'paes',
            'paket', 'layanan', 'katalog', 'harga', 'biaya', 'tarif', 'promo', 'diskon', 'rincian',
            'jadwal', 'tanggal', 'kalender', 'slot', 'jam', 'kosong', 'tersedia', 'bentrok', 'durasi', 'aturan', 'sop',
            'reservasi', 'booking', 'pesan', 'order', 'cara', 'syarat',
            'bayar', 'pembayaran', 'dp', 'uang muka', 'lunas', 'midtrans', 'transfer', 'nota', 'invoice',
            'griya', 'elly', 'alamat', 'lokasi', 'kediri', 'ngasem', 'doko', 'kontak', 'wa', 'whatsapp', 'admin',
        ];

        $isRelevant = false;
        foreach ($allowedKeywords as $keyword) {
            if (str_contains($message, $keyword)) {
                $isRelevant = true;
                break;
            }
        }

        if (!$isRelevant) {
            return response()->json([
                'reply' => self::OUT_OF_SCOPE_REPLY,
            ]);
        }

        // 3. Ambil data real-time dari MySQL
        $daftarPaket = Paket::all()->map(function ($p) {
            $nama = $p->nama_paket ?? 'Paket';
            $harga = number_format((float) ($p->harga_paket ?? $p->harga ?? 0), 0, ',', '.');
            return "- {$nama}: Rp {$harga}";
        })->implode("\n");

        $daftarLayanan = Layanan::all()->map(function ($l) {
            $nama = $l->nama_layanan ?? 'Layanan';
            $harga = number_format((float) ($l->harga_layanan ?? $l->harga ?? 0), 0, ',', '.');
            return "- {$nama}: Rp {$harga}";
        })->implode("\n");

        $jadwalTerisi = Reservasi::whereIn('status_reservasi', ['Disetujui', 'Tervalidasi', 'Menunggu Konfirmasi'])
            ->whereDate('tanggal_acara', '>=', now()->toDateString())
            ->orderBy('tanggal_acara')
            ->take(10)
            ->get()
            ->map(function ($r) {
                $tgl = Carbon::parse($r->tanggal_acara)->locale('id')->translatedFormat('d M Y');
                $mulai = $r->waktu_mulai ? substr($r->waktu_mulai, 0, 5) : '09:00';
                $selesai = $r->waktu_selesai ? substr($r->waktu_selesai, 0, 5) : '21:00';
                return "- {$tgl} ({$mulai} - {$selesai} WIB)";
            })->implode("\n");

        // 4. Panggil Gemini API (dengan bypass SSL lokal & fallback model)
        $apiKey = trim((string) config('services.gemini.api_key'));
        if (!empty($apiKey)) {
            $systemInstruction = <<<PROMPT
Anda adalah Asisten Virtual resmi untuk "Griya Rias Elly Jr." (Wedding Organizer / WO, Event Organizer / EO, dan Jasa Rias Pengantin di Jl. Rengganis No. 333A, Desa Doko, Kec. Ngasem, Kab. Kediri).

ATURAN:
1. Hanya jawab pertanyaan seputar Griya Rias Elly Jr., WO, EO, paket rias, harga, jadwal acara, dan cara reservasi/pembayaran.
2. Jika di luar topik tersebut, balas PERSIS:
Maaf saya tidak dilatih untuk itu, coba keyword lain
3. Jawab ramah, singkat, dan jelas dalam Bahasa Indonesia berdasarkan data berikut:

ATURAN JADWAL & RIAS:
- Jam acara berlangsung antara pukul 09.00 s.d. 21.00 WIB.
- Durasi rias 1 orang maksimal 3 jam (dimulai 3 jam sebelum acara, slot 3 jam terkunci otomatis).
- Opsi A (Rias + Acara Wedding): Rias 3 jam lalu dilanjutkan acara utama.
- Opsi B (Rias Saja / Wisuda / Personal): Blok 3 jam terkunci, setelah 3 jam selesai slot berikutnya di hari yang sama tetap terbuka untuk client lain.
- Layanan katering dan tenda dikelola mitra/tenant lain; sistem ini fokus pada Jadwal Acara dan Riasan.
- Pembayaran online via Midtrans dan e-Nota PDF tersedia setelah lunas.

DAFTAR PAKET:
{$daftarPaket}

DAFTAR LAYANAN SATUAN:
{$daftarLayanan}

JADWAL TERISI TERDEKAT:
{$jadwalTerisi}
PROMPT;

            $modelsToTry = array_unique([
                config('services.gemini.model', 'gemini-2.5-flash'),
                'gemini-2.5-flash',
                'gemini-2.0-flash',
            ]);

            foreach ($modelsToTry as $model) {
                try {
                    $http = Http::timeout(15);
                    if (app()->environment('local')) {
                        $http = $http->withoutVerifying();
                    }

                    $response = $http->post(
                        "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}",
                        [
                            'systemInstruction' => [
                                'parts' => [['text' => $systemInstruction]],
                            ],
                            'contents' => [
                                [
                                    'role' => 'user',
                                    'parts' => [['text' => $rawMessage]],
                                ],
                            ],
                            'generationConfig' => [
                                'temperature' => 0.3,
                                'maxOutputTokens' => 450,
                            ],
                        ]
                    );

                    if ($response->successful()) {
                        $replyText = data_get($response->json(), 'candidates.0.content.parts.0.text');
                        if (!empty($replyText)) {
                            return response()->json([
                                'reply' => trim($replyText),
                            ]);
                        }
                    } else {
                        Log::warning("Gemini API ({$model}) gagal: " . $response->body());
                    }
                } catch (\Throwable $e) {
                    Log::warning("Gemini API ({$model}) exception: " . $e->getMessage());
                }
            }
        }

        // 5. Fallback Rule-Based Lokal yang Lengkap
        return response()->json([
            'reply' => $this->localRuleBasedReply($message, $daftarPaket, $daftarLayanan, $jadwalTerisi),
        ]);
    }

    private function localRuleBasedReply(string $message, string $daftarPaket, string $daftarLayanan, string $jadwalTerisi): string
    {
        if (str_contains($message, 'durasi') || str_contains($message, 'wisuda') || str_contains($message, 'aturan') || str_contains($message, 'sop') || str_contains($message, 'jam')) {
            return "Aturan Durasi Rias & Jadwal Griya Rias Elly Jr.:\n"
                . "• Durasi rias untuk 1 orang dialokasikan maksimal 3 jam (dimulai 3 jam sebelum acara).\n"
                . "• Khusus Rias Saja (seperti Rias Wisuda/Personal), slot 3 jam akan terkunci dan jam setelahnya tetap terbuka untuk client lain di hari yang sama.\n"
                . "• Jam operasional acara berlangsung pukul 09.00 – 21.00 WIB.";
        }

        if (str_contains($message, 'paket') || str_contains($message, 'harga') || str_contains($message, 'biaya') || str_contains($message, 'katalog') || str_contains($message, 'layanan')) {
            return "Berikut daftar Paket & Layanan Griya Rias Elly Jr.:\n\n"
                . "Paket Tersedia:\n" . ($daftarPaket ?: '- Silakan cek menu Katalog Paket') . "\n\n"
                . "Layanan Satuan:\n" . ($daftarLayanan ?: '- Silakan cek menu Katalog Layanan');
        }

        if (str_contains($message, 'jadwal') || str_contains($message, 'tanggal') || str_contains($message, 'slot') || str_contains($message, 'kosong') || str_contains($message, 'tersedia')) {
            return "Jadwal yang sudah terisi terdekat:\n"
                . ($jadwalTerisi ?: '- Belum ada jadwal terisi terdekat (semua tanggal masih tersedia)')
                . "\n\nAnda dapat melihat kalender lengkapnya di menu Jadwal Acara.";
        }

        if (str_contains($message, 'alamat') || str_contains($message, 'lokasi') || str_contains($message, 'kediri')) {
            return "Griya Rias Elly Jr. beralamat di Jl. Rengganis Nomor 333A, Desa Doko, Kecamatan Ngasem, Kabupaten Kediri, Jawa Timur.";
        }

        if (str_contains($message, 'reservasi') || str_contains($message, 'booking') || str_contains($message, 'cara') || str_contains($message, 'bayar') || str_contains($message, 'midtrans') || str_contains($message, 'nota')) {
            return "Cara melakukan reservasi & pembayaran:\n"
                . "1. Cek tanggal tersedia pada menu Jadwal Acara.\n"
                . "2. Isi Form Reservasi (pilih paket/layanan, tanggal, jam, dan lokasi).\n"
                . "3. Setelah divalidasi Admin, lakukan pembayaran online via Midtrans pada menu Riwayat Transaksi.\n"
                . "4. Setelah lunas, e-Nota PDF dapat langsung diunduh.";
        }

        return "Saya dapat membantu informasi seputar Paket Rias, Layanan WO/EO, Cek Harga, Aturan Jadwal (durasi 3 jam), dan Cara Reservasi di Griya Rias Elly Jr. Silakan ketik topik yang ingin ditanyakan.";
    }
}