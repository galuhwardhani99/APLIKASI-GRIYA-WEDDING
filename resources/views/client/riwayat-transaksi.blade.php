@extends('layouts.app')
@section('title', 'Riwayat Transaksi')
@section('content')
<section class="section section-sand"><div class="container">
    <div class="section-head"><h2>Riwayat Transaksi</h2><p>Ringkasan nilai booking dan status reservasi Anda.</p></div>
    <div class="history-actions"><a class="btn btn-gold" href="{{ route('reservasi.create') }}">Buat Reservasi</a><a class="btn btn-outline" href="{{ route('client.riwayat.reservasi') }}">Riwayat Reservasi</a><a class="btn btn-outline" href="{{ route('client.dashboard') }}">Dashboard</a></div>
    <div class="history-table-wrap"><table class="history-table"><thead><tr><th>Kode Transaksi</th><th>Paket</th><th>Tanggal Booking</th><th>Jumlah</th><th>Total</th><th>Status Pembayaran</th></tr></thead><tbody>
        @forelse($transaksi as $item)
            <tr><td><strong>{{ $item->kode_reservasi }}</strong></td><td>{{ $item->nama_paket ?: $item->nama_layanan ?: $item->paket?->nama_paket ?: $item->layanan?->nama_layanan ?: $item->detail_acara ?: '—' }}</td><td>{{ $item->tgl_reservasi?->translatedFormat('d F Y') }}</td><td>{{ $item->jumlah_pesanan }}</td><td>Rp {{ number_format($item->biaya_sewa ?: (($item->harga_paket ?? $item->harga_layanan ?? 0) * $item->jumlah_pesanan), 0, ',', '.') }}</td><td><span class="history-status {{ $item->bukti_transfer ? 'has-proof' : '' }}">{{ $item->bukti_transfer ? 'Bukti pembayaran diterima' : 'Belum ada pembayaran' }}</span><small class="history-note">Reservasi: {{ $item->status_reservasi }}</small></td></tr>
        @empty<tr><td colspan="6" class="history-empty">Belum ada transaksi booking. Setelah mengajukan reservasi, ringkasannya akan muncul di sini.</td></tr>@endforelse
    </tbody></table></div><div class="history-pagination">{{ $transaksi->links() }}</div>
</div></section>
<style>.history-actions{display:flex;justify-content:center;gap:10px;flex-wrap:wrap;margin:-24px 0 24px}.history-table-wrap{overflow:auto;background:#fff;border:1px solid #eee7e0;border-radius:16px;box-shadow:0 8px 26px #33221108}.history-table{width:100%;min-width:750px;border-collapse:collapse}.history-table th{text-align:left;padding:14px 16px;background:#fcfaf8;color:#8c7967;font-size:11px;letter-spacing:.08em;text-transform:uppercase}.history-table td{padding:16px;border-top:1px solid #f0ebe6;vertical-align:middle}.history-status{display:inline-block;padding:6px 10px;border-radius:20px;background:#fbf2e4;color:#8a6026;font-size:12px;font-weight:700}.history-status.has-proof{background:#eaf6ee;color:#267145}.history-note{display:block;color:#887e75;margin-top:5px;font-size:12px}.history-empty{text-align:center;color:#80766e;padding:40px!important}.history-pagination{display:flex;justify-content:center;margin-top:20px}</style>
@endsection
