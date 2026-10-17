@extends('layouts.app')
@section('title', 'Riwayat Reservasi')
@section('content')
<section class="section section-sand"><div class="container">
    <div class="section-head"><h2>Riwayat Reservasi</h2><p>Daftar pengajuan booking dan perkembangan jadwal acara Anda.</p></div>
    <div class="history-actions"><a class="btn btn-gold" href="{{ route('reservasi.create') }}">Buat Reservasi</a><a class="btn btn-outline" href="{{ route('client.riwayat.transaksi') }}">Riwayat Transaksi</a><a class="btn btn-outline" href="{{ route('client.dashboard') }}">Dashboard</a></div>
    <div class="history-table-wrap"><table class="history-table"><thead><tr><th>Kode</th><th>Paket</th><th>Tanggal Acara</th><th>Waktu</th><th>Jumlah</th><th>Status</th></tr></thead><tbody>
        @forelse($reservasis as $reservasi)
            <tr><td><strong>{{ $reservasi->kode_reservasi }}</strong><small>Diajukan {{ $reservasi->tgl_reservasi?->format('d/m/Y') }}</small></td><td>{{ $reservasi->nama_paket ?: $reservasi->nama_layanan ?: $reservasi->paket?->nama_paket ?: $reservasi->layanan?->nama_layanan ?: $reservasi->detail_acara ?: '—' }}<small>{{ $reservasi->lokasi_acara }}</small></td><td>{{ \Carbon\Carbon::parse($reservasi->tgl_acara)->translatedFormat('d F Y') }}</td><td>{{ $reservasi->waktu_mulai ? substr($reservasi->waktu_mulai, 0, 5) : '—' }}–{{ $reservasi->waktu_selesai ? substr($reservasi->waktu_selesai, 0, 5) : '—' }}</td><td>{{ $reservasi->jumlah_pesanan }}</td><td><span class="history-status">{{ $reservasi->status_reservasi }}</span></td></tr>
        @empty<tr><td colspan="6" class="history-empty">Belum ada pengajuan reservasi. <a href="{{ route('reservasi.create') }}">Buat reservasi pertama Anda.</a></td></tr>@endforelse
    </tbody></table></div><div class="history-pagination">{{ $reservasis->links() }}</div>
</div></section>
<style>.history-actions{display:flex;justify-content:center;gap:10px;flex-wrap:wrap;margin:-24px 0 24px}.history-table-wrap{overflow:auto;background:#fff;border:1px solid #eee7e0;border-radius:16px;box-shadow:0 8px 26px #33221108}.history-table{width:100%;min-width:750px;border-collapse:collapse}.history-table th{text-align:left;padding:14px 16px;background:#fcfaf8;color:#8c7967;font-size:11px;letter-spacing:.08em;text-transform:uppercase}.history-table td{padding:16px;border-top:1px solid #f0ebe6;vertical-align:middle}.history-table td small{display:block;color:#887e75;margin-top:4px}.history-status{display:inline-block;padding:6px 10px;border-radius:20px;background:#fbf2e4;color:#8a6026;font-size:12px;font-weight:700}.history-empty{text-align:center;color:#80766e;padding:40px!important}.history-empty a{color:#a9753b;font-weight:700}.history-pagination{display:flex;justify-content:center;margin-top:20px}</style>
@endsection
