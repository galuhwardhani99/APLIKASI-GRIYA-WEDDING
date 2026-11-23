<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
        $status = $request->input('status', 'Semua');

        $query = Reservasi::with(['user', 'paket', 'layanans']);

        if ($tanggalMulai) {
            $query->whereDate('tanggal_acara', '>=', $tanggalMulai);
        }
        if ($tanggalSelesai) {
            $query->whereDate('tanggal_acara', '<=', $tanggalSelesai);
        }
        if ($status && $status !== 'Semua') {
            $query->where('status_reservasi', $status);
        }

        $allFiltered = (clone $query)->get();
        $totalPendapatan = $allFiltered->sum(function ($item) {
            return ($item->biaya_sewa ?? 0) > 0
                ? $item->biaya_sewa
                : (($item->harga_paket ?? $item->harga_layanan ?? 0) * ($item->jumlah_pesanan ?? 1));
        });
        $totalTransaksi = $allFiltered->count();

        // Urutkan transaksi yang baru lunas (paid_at) di paling atas
        $transaksi = $query
            ->orderByRaw('CASE WHEN paid_at IS NOT NULL THEN 0 ELSE 1 END')
            ->orderByDesc('paid_at')
            ->orderByDesc('id_reservasi')
            ->paginate(10)
            ->withQueryString();

        // 3 Pelunasan Midtrans Terbaru untuk kotak highlight di atas
        $pelunasanTerbaru = Reservasi::with(['user', 'paket', 'layanans'])
            ->whereIn('payment_status', ['paid', 'settlement', 'lunas', 'capture', 'proof_verified'])
            ->orderByDesc('paid_at')
            ->orderByDesc('updated_at')
            ->take(3)
            ->get();

        // Simpan waktu terakhir admin mengecek laporan agar badge sidebar otomatis ter-reset
        $lastCheckedPaid = session('admin_last_checked_paid');
        session(['admin_last_checked_paid' => now()]);

        return view('admin.laporan.transaksi', compact(
            'transaksi',
            'tanggalMulai',
            'tanggalSelesai',
            'status',
            'totalPendapatan',
            'totalTransaksi',
            'pelunasanTerbaru',
            'lastCheckedPaid'
        ));
    }

    public function exportPdf(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
        $status = $request->input('status', 'Semua');

        $query = Reservasi::with(['user', 'paket', 'layanans']);

        if ($tanggalMulai) {
            $query->whereDate('tanggal_acara', '>=', $tanggalMulai);
        }
        if ($tanggalSelesai) {
            $query->whereDate('tanggal_acara', '<=', $tanggalSelesai);
        }
        if ($status && $status !== 'Semua') {
            $query->where('status_reservasi', $status);
        }

        $transaksi = $query
            ->orderByRaw('CASE WHEN paid_at IS NOT NULL THEN 0 ELSE 1 END')
            ->orderByDesc('paid_at')
            ->orderByDesc('id_reservasi')
            ->get();

        $totalPendapatan = $transaksi->sum(function ($item) {
            if (!empty($item->biaya_sewa) && $item->biaya_sewa > 0) {
                return $item->biaya_sewa;
            }
            $harga = $item->harga_paket ?? $item->harga_layanan ?? 0;
            $qty = $item->jumlah_pesanan ?? 1;
            return $harga * $qty;
        });

        $periodeLabel = ($tanggalMulai && $tanggalSelesai)
            ? $tanggalMulai . '-sd-' . $tanggalSelesai
            : 'Semua-Periode';

        $pdf = Pdf::loadView('admin.laporan.transaksi_pdf', compact(
            'transaksi',
            'tanggalMulai',
            'tanggalSelesai',
            'status',
            'totalPendapatan'
        ))->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan-Transaksi-' . $periodeLabel . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
        $status = $request->input('status', 'Semua');

        $query = Reservasi::with(['user', 'paket', 'layanans']);

        if ($tanggalMulai) {
            $query->whereDate('tanggal_acara', '>=', $tanggalMulai);
        }
        if ($tanggalSelesai) {
            $query->whereDate('tanggal_acara', '<=', $tanggalSelesai);
        }
        if ($status && $status !== 'Semua') {
            $query->where('status_reservasi', $status);
        }

        $transaksi = $query
            ->orderByRaw('CASE WHEN paid_at IS NOT NULL THEN 0 ELSE 1 END')
            ->orderByDesc('paid_at')
            ->orderByDesc('id_reservasi')
            ->get();

        $totalPendapatan = $transaksi->sum(function ($item) {
            if (!empty($item->biaya_sewa) && $item->biaya_sewa > 0) {
                return $item->biaya_sewa;
            }
            $harga = $item->harga_paket ?? $item->harga_layanan ?? 0;
            $qty = $item->jumlah_pesanan ?? 1;
            return $harga * $qty;
        });

        $periodeLabel = ($tanggalMulai && $tanggalSelesai)
            ? $tanggalMulai . '-sd-' . $tanggalSelesai
            : 'Semua-Periode';

        $fileName = 'Laporan-Transaksi-' . $periodeLabel . '.xls';

        return response()
            ->view('admin.laporan.transaksi_excel', compact(
                'transaksi',
                'tanggalMulai',
                'tanggalSelesai',
                'status',
                'totalPendapatan'
            ))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }
}