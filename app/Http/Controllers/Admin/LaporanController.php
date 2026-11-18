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
        $tanggalMulai = $request->input('tanggal_mulai', now()->startOfMonth()->toDateString());
        $tanggalSelesai = $request->input('tanggal_selesai', now()->endOfMonth()->toDateString());
        $status = $request->input('status', 'Disetujui');

        $query = Reservasi::with(['user', 'paket', 'layanans'])
            ->whereBetween('tanggal_acara', [$tanggalMulai, $tanggalSelesai]);

        if ($status && $status !== 'Semua') {
            $query->where('status_reservasi', $status);
        }

        $transaksi = $query->orderBy('tanggal_acara', 'asc')->get();

        $totalPendapatan = $transaksi->sum(function ($item) {
            if (!empty($item->biaya_sewa) && $item->biaya_sewa > 0) {
                return $item->biaya_sewa;
            }
            $harga = $item->harga_paket ?? $item->harga_layanan ?? 0;
            $qty = $item->jumlah_pesanan ?? 1;
            return $harga * $qty;
        });

        $totalTransaksi = $transaksi->count();

        return view('admin.laporan.transaksi', compact(
            'transaksi',
            'tanggalMulai',
            'tanggalSelesai',
            'status',
            'totalPendapatan',
            'totalTransaksi'
        ));
    }

    public function exportPdf(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai', now()->startOfMonth()->toDateString());
        $tanggalSelesai = $request->input('tanggal_selesai', now()->endOfMonth()->toDateString());
        $status = $request->input('status', 'Disetujui');

        $query = Reservasi::with(['user', 'paket', 'layanans'])
            ->whereBetween('tanggal_acara', [$tanggalMulai, $tanggalSelesai]);

        if ($status && $status !== 'Semua') {
            $query->where('status_reservasi', $status);
        }

        $transaksi = $query->orderBy('tanggal_acara', 'asc')->get();

        $totalPendapatan = $transaksi->sum(function ($item) {
            if (!empty($item->biaya_sewa) && $item->biaya_sewa > 0) {
                return $item->biaya_sewa;
            }
            $harga = $item->harga_paket ?? $item->harga_layanan ?? 0;
            $qty = $item->jumlah_pesanan ?? 1;
            return $harga * $qty;
        });

        $pdf = Pdf::loadView('admin.laporan.transaksi_pdf', compact(
            'transaksi',
            'tanggalMulai',
            'tanggalSelesai',
            'status',
            'totalPendapatan'
        ))->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan-Transaksi-' . $tanggalMulai . '-sd-' . $tanggalSelesai . '.pdf');
    }
        public function exportExcel(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai', now()->startOfMonth()->toDateString());
        $tanggalSelesai = $request->input('tanggal_selesai', now()->endOfMonth()->toDateString());
        $status = $request->input('status', 'Disetujui');

        $query = Reservasi::with(['user', 'paket', 'layanans'])
            ->whereBetween('tanggal_acara', [$tanggalMulai, $tanggalSelesai]);

        if ($status && $status !== 'Semua') {
            $query->where('status_reservasi', $status);
        }

        $transaksi = $query->orderBy('tanggal_acara', 'asc')->get();

        $totalPendapatan = $transaksi->sum(function ($item) {
            if (!empty($item->biaya_sewa) && $item->biaya_sewa > 0) {
                return $item->biaya_sewa;
            }
            $harga = $item->harga_paket ?? $item->harga_layanan ?? 0;
            $qty = $item->jumlah_pesanan ?? 1;
            return $harga * $qty;
        });

        $fileName = 'Laporan-Transaksi-' . $tanggalMulai . '-sd-' . $tanggalSelesai . '.xls';

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