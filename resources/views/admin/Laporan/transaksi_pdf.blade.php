<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi - Griya Rias Elly Jr.</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #241A16; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #C58F43; padding-bottom: 12px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 20px; color: #241A16; letter-spacing: 1px; }
        .header p { margin: 4px 0 0; font-size: 11px; color: #666; }
        .meta { margin-bottom: 16px; font-size: 11px; }
        .meta table { width: 100%; }
        table.data { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data th, table.data td { border: 1px solid #D8CEC0; padding: 8px 10px; text-align: left; }
        table.data th { background-color: #FBF5EC; font-size: 11px; text-transform: uppercase; }
        .text-right { text-align: right !important; }
        .text-center { text-align: center !important; }
        .total-row { background-color: #FCFAF8; font-weight: bold; }
        .footer-ttd { width: 100%; margin-top: 40px; }
        .footer-ttd td { width: 65%; }
        .ttd-box { text-align: center; font-size: 11px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>GRIYA RIAS ELLY JR.</h1>
        <p>Jl. Rengganis Nomor 333A, Doko, Kec. Ngasem, Kab. Kediri, Jawa Timur</p>
        <p><strong>LAPORAN REKAPITULASI TRANSAKSI</strong></p>
    </div>

    <div class="meta">
        <table>
            <tr>
                <td><strong>Periode Acara:</strong> {{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('d M Y') }} s/d {{ \Carbon\Carbon::parse($tanggalSelesai)->translatedFormat('d M Y') }}</td>
                <td class="text-right"><strong>Filter Status:</strong> {{ $status }}</td>
            </tr>
            <tr>
                <td><strong>Dicetak pada:</strong> {{ now()->translatedFormat('d M Y, H:i') }} WIB</td>
                <td class="text-right"><strong>Total Data:</strong> {{ $transaksi->count() }} Reservasi</td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th class="text-center" style="width: 30px;">No</th>
                <th>Kode</th>
                <th>Tanggal Acara</th>
                <th>Nama Client</th>
                <th>Acara & Paket</th>
                <th>Status</th>
                <th class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $index => $item)
                @php
                    $namaLayanan = $item->layanans->map(fn($l) => $l->pivot->nama_layanan)->filter()->implode(', ');
                    $paket = $item->nama_paket ?: ($namaLayanan ?: ($item->paket?->nama_paket ?: ($item->nama_layanan ?: '—')));
                    $nominal = ($item->biaya_sewa ?? 0) > 0 
                        ? $item->biaya_sewa 
                        : (($item->harga_paket ?? $item->harga_layanan ?? 0) * ($item->jumlah_pesanan ?? 1));
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $item->kode_reservasi }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_acara)->translatedFormat('d M Y') }}</td>
                    <td>{{ $item->user->name ?? 'Client' }}</td>
                    <td>
                        <strong>{{ $item->jenis_acara ?: 'Acara' }}</strong><br>
                        <span style="color: #666; font-size: 10px;">{{ $paket }}</span>
                    </td>
                    <td>{{ ucfirst($item->status_reservasi) }}</td>
                    <td class="text-right">Rp {{ number_format($nominal, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data transaksi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        @if($transaksi->count() > 0)
            <tfoot>
                <tr class="total-row">
                    <td colspan="6" class="text-right">TOTAL PENDAPATAN</td>
                    <td class="text-right" style="color: #A87632;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        @endif
    </table>

    <table class="footer-ttd">
        <tr>
            <td></td>
            <td class="ttd-box">
                Kediri, {{ now()->translatedFormat('d F Y') }}<br>
                Pemilik / Admin Griya Rias Elly Jr.
                <br><br><br><br>
                <strong>( Elly Jr. )</strong>
            </td>
        </tr>
    </table>
</body>
</html>