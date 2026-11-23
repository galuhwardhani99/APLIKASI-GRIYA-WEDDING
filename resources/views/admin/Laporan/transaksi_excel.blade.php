<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <table>
        <tr>
            <td colspan="7" style="font-size: 16px; font-weight: bold; text-align: center;">
                LAPORAN REKAPITULASI TRANSAKSI - GRIYA RIAS ELLY JR.
            </td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: center;">
                Periode:
                @if($tanggalMulai && $tanggalSelesai)
                    {{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('d M Y') }} s/d {{ \Carbon\Carbon::parse($tanggalSelesai)->translatedFormat('d M Y') }}
                @elseif($tanggalMulai)
                    Mulai {{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('d M Y') }}
                @elseif($tanggalSelesai)
                    Sampai {{ \Carbon\Carbon::parse($tanggalSelesai)->translatedFormat('d M Y') }}
                @else
                    Semua Periode
                @endif
                | Status: {{ $status }}
            </td>
        </tr>
        <tr></tr>
        <thead>
            <tr>
                <th style="border: 1px solid #000; background-color: #FBF5EC; font-weight: bold;">No</th>
                <th style="border: 1px solid #000; background-color: #FBF5EC; font-weight: bold;">Kode Reservasi</th>
                <th style="border: 1px solid #000; background-color: #FBF5EC; font-weight: bold;">Tanggal Acara</th>
                <th style="border: 1px solid #000; background-color: #FBF5EC; font-weight: bold;">Nama Client</th>
                <th style="border: 1px solid #000; background-color: #FBF5EC; font-weight: bold;">Jenis Acara & Paket</th>
                <th style="border: 1px solid #000; background-color: #FBF5EC; font-weight: bold;">Status</th>
                <th style="border: 1px solid #000; background-color: #FBF5EC; font-weight: bold;">Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $index => $item)
                @php
                    $namaLayanan = $item->layanans->map(fn($l) => $l->pivot->nama_layanan)->filter()->implode(', ');
                    $paket = $item->nama_paket ?: ($namaLayanan ?: ($item->paket?->nama_paket ?: ($item->nama_layanan ?: '—')));
                    $nominal = ($item->biaya_sewa ?? 0) > 0 
                        ? $item->biaya_sewa 
                        : (($item->harga_paket ?? $item->harga_layanan ?? 0) * ($item->jumlah_pesanan ?? 1));
                @endphp
                <tr>
                    <td style="border: 1px solid #000; text-align: center;">{{ $index + 1 }}</td>
                    <td style="border: 1px solid #000;">{{ $item->kode_reservasi }}</td>
                    <td style="border: 1px solid #000;">{{ \Carbon\Carbon::parse($item->tanggal_acara)->translatedFormat('d M Y') }}</td>
                    <td style="border: 1px solid #000;">{{ $item->user->name ?? 'Client' }}</td>
                    <td style="border: 1px solid #000;">{{ ($item->jenis_acara ?: 'Acara') . ' - ' . $paket }}</td>
                    <td style="border: 1px solid #000;">{{ ucfirst($item->status_reservasi) }}</td>
                    <td style="border: 1px solid #000; text-align: right;">{{ $nominal }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" style="border: 1px solid #000; font-weight: bold; text-align: right;">TOTAL PENDAPATAN</td>
                <td style="border: 1px solid #000; font-weight: bold; text-align: right;">{{ $totalPendapatan }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>