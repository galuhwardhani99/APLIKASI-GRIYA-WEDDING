<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Portofolio;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil data paket/layanan dari database
        $layananDb = Paket::latest()->get();

        // Pemetaan data layanan agar sesuai dengan struktur tampilan di view home.blade.php
        $layanan = $layananDb->map(function ($item, $index) {
            return [
                'judul'     => $item->nama_paket,
                'deskripsi' => $item->deskripsi ?? 'Layanan unggulan terbaik dari Griya Rias Elly Jr.',
                'harga'     => $item->harga,
                'label'     => '[ Foto ' . $item->kategori . ' ]',
                'gambar'    => $item->gambar ? 'storage/' . $item->gambar : null,
                'tone'      => $index % 2 == 0 ? 'rose' : 'sand', // Variasi warna kartu secara bergantian
            ];
        });

        // Jika database paket masih kosong, gunakan data fallback agar tampilan tidak kosong
        if ($layanan->isEmpty()) {
            $layanan = collect([
                [
                    'judul'     => 'Rias Pengantin Royal',
                    'deskripsi' => 'Make up flawless tahan 12 jam + busana pengantin 2 pasang.',
                    'harga'     => 7500000,
                    'label'     => '[ Foto Rias Pengantin ]',
                    'gambar'    => null,
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
            ]);
        }

        // Ambil data galeri portofolio terbaru dari database
        $portofolios = Portofolio::latest()->get();

        // Nomor WhatsApp resmi Griya Rias Elly Jr.
        $whatsapp = '6287850875676';

        return view('home', compact('layanan', 'portofolios', 'whatsapp'));
    }
}