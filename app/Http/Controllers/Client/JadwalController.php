<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Support\BookingAvailability;
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
        $reservasis = BookingAvailability::activeBookings()
            ->filter(fn (Reservasi $reservasi) => $reservasi->tanggal_acara);

        $events = [];

        foreach ($reservasis as $item) {
            [$start, $end] = BookingAvailability::interval($item);
            $isFullDay = BookingAvailability::isFullDay($start, $end);
            $date = $item->tanggal_acara->toDateString();

            $events[] = [
                'title'           => $isFullDay
                    ? 'Sudah Dibooking · Full day'
                    : 'Sudah Dibooking · ' . substr($start, 0, 5) . '–' . substr($end, 0, 5),
                'start'           => $isFullDay ? $date : $date . 'T' . substr($start, 0, 8),
                'end'             => $isFullDay ? null : $date . 'T' . substr($end, 0, 8),
                'backgroundColor' => '#DC2626', // Warna merah
                'borderColor'     => '#DC2626',
                'textColor'       => '#FFFFFF',
                'allDay'          => $isFullDay,
                'extendedProps'   => ['fullDay' => $isFullDay],
            ];
        }

        return response()->json($events);
    }
}
