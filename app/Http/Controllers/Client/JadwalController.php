<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        return view('client.jadwal');
    }

    // Endpoint JSON untuk mengambil data tanggal yang sudah dibooking (Merah)
    public function getJadwalJson()
    {
        // Ambil data reservasi yang sudah divalidasi / disetujui
        $reservasis = Reservasi::where('status_reservasi', 'Disetujui')
            ->orWhereHas('jadwal', function ($query) {
                $query->where('status_validasi', 'Tervalidasi');
            })
            ->get();

        $events = [];

        foreach ($reservasis as $item) {
            $events[] = [
                'title'           => 'Sudah Dibooking',
                'start'           => \Carbon\Carbon::parse($item->tanggal_acara)->toDateString(),
                'backgroundColor' => '#DC2626', // Warna merah
                'borderColor'     => '#DC2626',
                'textColor'       => '#FFFFFF',
                'allDay'          => true,
            ];
        }

        return response()->json($events);
    }
}