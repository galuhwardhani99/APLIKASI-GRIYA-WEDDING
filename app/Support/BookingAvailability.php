<?php

namespace App\Support;

use App\Models\Reservasi;
use Illuminate\Support\Collection;

class BookingAvailability
{
    public static function activeBookings(): Collection
    {
        return Reservasi::with('jadwal')
            ->whereNotIn('status_reservasi', ['Ditolak', 'Dibatalkan', 'Cancelled', 'Canceled'])
            ->get();
    }

    public static function forDate(string $date): Collection
    {
        return Reservasi::with('jadwal')
            ->whereDate('tanggal_acara', $date)
            ->whereNotIn('status_reservasi', ['Ditolak', 'Dibatalkan', 'Cancelled', 'Canceled'])
            ->get();
    }

    public static function interval(Reservasi $booking): array
    {
        $start = $booking->waktu_mulai ?: $booking->jadwal?->waktu_mulai;
        $end = $booking->waktu_selesai ?: $booking->jadwal?->waktu_selesai;

        // Reservasi lama tanpa rentang waktu lengkap dianggap memesan satu hari penuh.
        if (! $start || ! $end) {
            return ['00:00:00', '23:59:00'];
        }

        return [$start, $end];
    }

    public static function isFullDay(?string $start, ?string $end): bool
    {
        if (! $start || ! $end) {
            return true;
        }

        return substr($start, 0, 5) === '00:00' && substr($end, 0, 5) >= '23:59';
    }

    public static function overlaps(string $start, string $end, Reservasi $booking): bool
    {
        [$busyStart, $busyEnd] = self::interval($booking);

        if (self::isFullDay($start, $end) || self::isFullDay($busyStart, $busyEnd)) {
            return true;
        }

        return self::toMinutes($start) < self::toMinutes($busyEnd)
            && self::toMinutes($end) > self::toMinutes($busyStart);
    }

    public static function freeSlots(Collection $bookings): array
    {
        $busy = $bookings->map(function (Reservasi $booking) {
            [$start, $end] = self::interval($booking);

            return [
                'start' => self::isFullDay($start, $end) ? 0 : self::toMinutes($start),
                'end' => self::isFullDay($start, $end) ? 1440 : self::toMinutes($end),
            ];
        })->sortBy('start')->values();

        $slots = [];
        $cursor = 0;

        foreach ($busy as $interval) {
            if ($interval['start'] > $cursor) {
                $slots[] = [self::toTime($cursor), self::toTime($interval['start'])];
            }
            $cursor = max($cursor, $interval['end']);
        }

        if ($cursor < 1440) {
            $slots[] = [self::toTime($cursor), '23:59'];
        }

        return array_values(array_filter($slots, fn (array $slot) => self::toMinutes($slot[1]) > self::toMinutes($slot[0])));
    }

    public static function toMinutes(string $time): int
    {
        [$hours, $minutes] = array_map('intval', explode(':', substr($time, 0, 5)));

        return ($hours * 60) + $minutes;
    }

    private static function toTime(int $minutes): string
    {
        return sprintf('%02d:%02d', intdiv($minutes, 60), $minutes % 60);
    }
}
