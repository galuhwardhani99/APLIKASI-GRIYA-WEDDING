<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        // Sementara hardcode; nanti diganti data dari tabel katalog/paket
        $layanan = [
            [
                'judul'     => 'Rias Pengantin Royal',
                'deskripsi' => 'Make up flawless tahan 12 jam + busana pengantin 2 pasang.',
                'harga'     => 7500000,
                'label'     => '[ Foto Rias Pengantin ]',
                'gambar'    => null, // contoh: 'images/rias-pengantin.jpg'
                'tone'      => 'rose',
            ],
            [
                'judul'     => 'Full Package WO Intimate',
                'deskripsi' => 'Konsep acara, tim koordinasi lapangan 6 orang, dekorasi dasar.',
                'harga'     => 15000000,
                'label'     => '[ Foto Wedding Organizer ]',
                'gambar'    => null,
                'tone'      => 'sand',
            ],
            [
                'judul'     => 'Rias Wisuda / Prewedding',
                'deskripsi' => 'Make up halus, hairdo/hijab styling, free bulu mata tiran.',
                'harga'     => 450000,
                'label'     => '[ Foto Rias Wisuda ]',
                'gambar'    => null,
                'tone'      => 'rose',
            ],
        ];

        $whatsapp = '6281234567890'; // ganti dengan nomor WA asli (format 62...)

        return view('home', compact('layanan', 'whatsapp'));
    }
}