@extends('layouts.admin')

@section('title', 'Laporan Transaksi - Griya Rias Elly Jr.')

@push('styles')
<style>
    /* Pagination Custom Griya Rias */
    .pagination-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding: 16px 20px;
        border-top: 1px solid #EFE8DE;
        background: #FAF9F6;
    }
    .pagination-info {
        font-size: 0.82rem;
        color: #8C8279;
        font-weight: 600;
    }
    .pagination-links {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .page-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        min-width: 34px;
        height: 34px;
        padding: 0 12px;
        border-radius: 8px;
        border: 1px solid #D8CEC0;
        background: #FFFFFF;
        color: #241A16;
        font-size: 0.82rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .page-btn:hover:not(.disabled):not(.active) {
        background: #FBF5EC;
        border-color: #C58F43;
        color: #A87632;
    }
    .page-btn.active {
        background: #C58F43;
        border-color: #C58F43;
        color: #FFFFFF;
        box-shadow: 0 2px 6px rgba(197, 143, 67, 0.25);
    }
    .page-btn.disabled {
        opacity: 0.45;
        cursor: not-allowed;
        background: #F5F3F0;
    }
</style>
@endpush

@section('content')
<div style="padding: 32px; background-color: #FDFBF7; min-height: 100vh; font-family: 'Plus Jakarta Sans', sans-serif; color: #241A16;">
    
    {{-- Header Halaman --}}
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
        <div>
            <h1 style="font-family: 'Playfair Display', serif; font-size: 1.8rem; margin: 0;">Laporan Transaksi</h1>
            <p style="color: #8C8279; font-size: 0.9rem; margin-top: 4px;">Rekapitulasi pemasukan dan riwayat transaksi pelanggan (diurutkan dari pelunasan terbaru).</p>
        </div>

        {{-- Tombol Download Excel & Pratinjau PDF --}}
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('admin.laporan.transaksi.excel', request()->query()) }}" 
               style="background-color: #1D6F42; color: #FFF; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.88rem; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-file-excel"></i> Download Excel
            </a>

            <button type="button" 
                    onclick="openPdfPreview('{{ route('admin.laporan.transaksi.pdf', request()->query()) }}')"
                    style="background-color: #cc0404; color: #FFF; border: none; padding: 10px 18px; border-radius: 8px; font-weight: 600; font-size: 0.88rem; display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                <i class="fa-solid fa-file-pdf"></i> Cetak Laporan PDF
            </button>
        </div>
    </div>

    {{-- Form Filter Tanggal & Status --}}
    <div style="background: #FFF; border: 1px solid #EFE8DE; border-radius: 14px; padding: 20px; margin-bottom: 24px;">
        <form action="{{ route('admin.laporan.transaksi') }}" method="GET" style="display: flex; flex-wrap: wrap; gap: 16px; align-items: flex-end;">
            <div>
                <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 6px; color: #55483F;">Dari Tanggal Acara</label>
                <input type="date" name="tanggal_mulai" value="{{ $tanggalMulai ?? '' }}" 
                       style="padding: 9px 12px; border: 1px solid #EFE8DE; border-radius: 8px; font-size: 0.88rem;">
            </div>
            <div>
                <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 6px; color: #55483F;">Sampai Tanggal</label>
                <input type="date" name="tanggal_selesai" value="{{ $tanggalSelesai ?? '' }}" 
                       style="padding: 9px 12px; border: 1px solid #EFE8DE; border-radius: 8px; font-size: 0.88rem;">
            </div>
            <div>
                <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 6px; color: #55483F;">Status Reservasi</label>
                <select name="status" style="padding: 9px 12px; border: 1px solid #EFE8DE; border-radius: 8px; font-size: 0.88rem; background: #FFF;">
                    <option value="Semua" {{ ($status ?? 'Semua') == 'Semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="Disetujui" {{ ($status ?? '') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="Menunggu Konfirmasi" {{ ($status ?? '') == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                    <option value="Ditolak" {{ ($status ?? '') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="submit" style="background-color: #C58F43; color: #FFF; border: none; padding: 10px 18px; border-radius: 8px; font-weight: 600; font-size: 0.88rem; cursor: pointer;">
                    <i class="fa-solid fa-filter"></i> Filter Data
                </button>
                <a href="{{ route('admin.laporan.transaksi') }}" style="background-color: #F4EFEA; color: #55483F; padding: 10px 14px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.88rem;">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Kartu Ringkasan (Summary Cards) --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 24px;">
        <div style="background: #FFF; border: 1px solid #EFE8DE; border-radius: 14px; padding: 20px;">
            <span style="font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.08em; color: #8C8279; font-weight: 700;">Total Pendapatan (Periode Ini)</span>
            <h2 style="font-family: 'Playfair Display', serif; font-size: 1.75rem; color: #C58F43; margin-top: 8px;">
                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
            </h2>
        </div>
        <div style="background: #FFF; border: 1px solid #EFE8DE; border-radius: 14px; padding: 20px;">
            <span style="font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.08em; color: #8C8279; font-weight: 700;">Jumlah Transaksi</span>
            <h2 style="font-family: 'Playfair Display', serif; font-size: 1.75rem; color: #241A16; margin-top: 8px;">
                {{ $totalTransaksi }} <span style="font-size: 0.9rem; font-family: 'Plus Jakarta Sans', sans-serif; color: #8C8279; font-weight: 500;">Reservasi</span>
            </h2>
        </div>
    </div>

    {{-- Kotak Highlight Pelunasan Terbaru Diterima (Midtrans) --}}
    @if(isset($pelunasanTerbaru) && $pelunasanTerbaru->isNotEmpty())
        @php
            $paidSignature = $pelunasanTerbaru->pluck('id_reservasi')->implode('-');
        @endphp
        <div id="box-pelunasan-terbaru" data-signature="{{ $paidSignature }}" style="background: #F4FAF6; border: 1px solid #C8E6C9; border-radius: 14px; padding: 18px 20px; margin-bottom: 24px; position: relative;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                <div style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 700; color: #166534;">
                    <i class="fa-solid fa-bell"></i> Pelunasan Terbaru Diterima (Midtrans)
                </div>
                <button type="button" onclick="dismissPelunasanBox()" title="Sembunyikan notifikasi"
                        style="background: #DCFCE7; border: 1px solid #BBF7D0; color: #166534; width: 26px; height: 26px; border-radius: 50%; cursor: pointer; display: grid; place-items: center; font-size: 0.8rem;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 12px;">
                @foreach($pelunasanTerbaru as $baru)
                    @php
                        $nomBaru = ($baru->biaya_sewa ?? 0) > 0
                            ? $baru->biaya_sewa
                            : (($baru->harga_paket ?? $baru->harga_layanan ?? 0) * ($baru->jumlah_pesanan ?? 1));
                        $waktuLunas = $baru->paid_at ? \Carbon\Carbon::parse($baru->paid_at) : \Carbon\Carbon::parse($baru->updated_at);
                    @endphp
                    <div style="background: #FFFFFF; border: 1px solid #DCFCE7; border-radius: 10px; padding: 12px 14px; font-size: 0.84rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <strong>{{ $baru->kode_reservasi }}</strong>
                            <span style="background: #16A34A; color: #FFF; font-size: 0.68rem; font-weight: 700; padding: 2px 8px; border-radius: 999px;">LUNAS</span>
                        </div>
                        <div style="color: #241A16; margin-top: 4px; font-weight: 600;">
                            {{ $baru->user->name ?? 'Client' }} &bull; <span style="font-weight: 400; color: #55483F;">Acara {{ \Carbon\Carbon::parse($baru->tanggal_acara)->locale('id')->translatedFormat('d M Y') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 6px;">
                            <span style="color: #15803D; font-weight: 700;">Rp {{ number_format($nomBaru, 0, ',', '.') }}</span>
                            <small style="color: #8C8279; font-size: 0.75rem;">{{ $waktuLunas->locale('id')->diffForHumans() }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <script>
            (function () {
                const box = document.getElementById('box-pelunasan-terbaru');
                if (!box) return;
                const sig = box.dataset.signature;
                if (localStorage.getItem('dismissed_pelunasan_sig') === sig) {
                    box.style.display = 'none';
                }
            })();

            function dismissPelunasanBox() {
                const box = document.getElementById('box-pelunasan-terbaru');
                if (!box) return;
                localStorage.setItem('dismissed_pelunasan_sig', box.dataset.signature);
                box.style.display = 'none';
            }
        </script>
    @endif

    {{-- Tabel Data Transaksi --}}
    <div style="background: #FFF; border: 1px solid #EFE8DE; border-radius: 14px; overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; min-width: 860px;">
                <thead>
                    <tr style="background: #FCFAF8; border-bottom: 1px solid #EFE8DE; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.08em; color: #8C8279;">
                        <th style="padding: 16px;">No</th>
                        <th style="padding: 16px;">Kode &amp; Waktu Lunas</th>
                        <th style="padding: 16px;">Tanggal Acara</th>
                        <th style="padding: 16px;">Nama Client</th>
                        <th style="padding: 16px;">Acara &amp; Paket</th>
                        <th style="padding: 16px;">Status</th>
                        <th style="padding: 16px; text-align: right;">Nominal</th>
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
                            $isPaid = in_array($item->payment_status ?? '', ['paid', 'settlement', 'lunas', 'capture', 'proof_verified'], true);
                            $isBaruLunas = $isPaid && $item->paid_at && \Carbon\Carbon::parse($item->paid_at)->greaterThanOrEqualTo(now()->subDay());
                        @endphp
                        <tr style="border-top: 1px solid #F0EBE6; font-size: 0.9rem; {{ $isBaruLunas ? 'background-color: #F9FDFB;' : '' }}">
                            <td style="padding: 16px;">{{ ($transaksi->firstItem() ?? 1) + $index }}</td>
                            <td style="padding: 16px;">
                                <strong>{{ $item->kode_reservasi }}</strong>
                                @if($isBaruLunas)
                                    <span style="background: #16A34A; color: #FFF; font-size: 0.65rem; font-weight: 700; padding: 2px 6px; border-radius: 4px; margin-left: 4px;">BARU LUNAS</span>
                                @endif
                                @if($isPaid && $item->paid_at)
                                    <small style="display: block; color: #15803D; font-size: 0.75rem; margin-top: 3px;">
                                        <i class="fa-solid fa-circle-check"></i> Lunas {{ \Carbon\Carbon::parse($item->paid_at)->locale('id')->translatedFormat('d M Y, H:i') }}
                                    </small>
                                @elseif($isPaid)
                                    <small style="display: block; color: #15803D; font-size: 0.75rem; margin-top: 3px;">
                                        <i class="fa-solid fa-circle-check"></i> Pembayaran Lunas
                                    </small>
                                @else
                                    <small style="display: block; color: #8C8279; font-size: 0.75rem; margin-top: 3px;">
                                        Belum Lunas
                                    </small>
                                @endif
                            </td>
                            <td style="padding: 16px;">{{ \Carbon\Carbon::parse($item->tanggal_acara)->locale('id')->translatedFormat('d M Y') }}</td>
                            <td style="padding: 16px;">{{ $item->user->name ?? 'Client' }}</td>
                            <td style="padding: 16px;">
                                <strong>{{ $item->jenis_acara ?: 'Acara' }}</strong><br>
                                <small style="color: #8C8279;">{{ $paket }}</small>
                            </td>
                            <td style="padding: 16px;">
                                <span style="padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: 700; 
                                    background: {{ $item->status_reservasi === 'Disetujui' ? '#EAF6EE' : '#FBF2E4' }}; 
                                    color: {{ $item->status_reservasi === 'Disetujui' ? '#267145' : '#8A6026' }};">
                                    {{ ucfirst($item->status_reservasi) }}
                                </span>
                            </td>
                            <td style="padding: 16px; text-align: right;"><strong>Rp {{ number_format($nominal, 0, ',', '.') }}</strong></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px; color: #8C8279;">
                                Tidak ada data transaksi pada rentang tanggal tersebut.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($transaksi->count() > 0)
                    <tfoot>
                        <tr style="background: #FCFAF8; border-top: 2px solid #EFE8DE; font-weight: 700;">
                            <td colspan="6" style="padding: 16px; text-align: right;">TOTAL PENDAPATAN</td>
                            <td style="padding: 16px; text-align: right; color: #C58F43; font-size: 1.05rem;">
                                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>

        @include('partials.pagination', ['paginator' => $transaksi])
    </div>
</div>

{{-- MODAL POPUP PRATINJAU PDF (TEMA COKELAT-CREAM) --}}
<div id="pdfPreviewModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(36, 26, 22, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #FDFBF7; width: 100%; max-width: 960px; height: 90vh; border-radius: 14px; overflow: hidden; display: flex; flex-direction: column; border: 1px solid #D8CEC0; box-shadow: 0 24px 60px rgba(36, 26, 22, 0.35);">
        
        {{-- Header Modal Cokelat-Gold --}}
        <div style="background-color: rgb(197, 143, 67); color: #FFFFFF; padding: 16px 24px; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <i class="fa-solid fa-print" style="font-size: 1.15rem;"></i>
                <h3 style="font-family: 'Playfair Display', serif; font-size: 1.2rem; margin: 0; font-weight: 700; letter-spacing: 0.02em;">
                    Pratinjau Laporan Transaksi
                </h3>
            </div>
            <button type="button" onclick="closePdfPreview()" title="Tutup Pratinjau"
                    style="background: rgba(255,255,255,0.18); border: none; color: #FFF; width: 34px; height: 34px; border-radius: 50%; cursor: pointer; display: grid; place-items: center; font-size: 1rem; transition: 0.2s;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- Kontainer Iframe PDF --}}
        <div style="flex: 1; background: #EFE8DE; position: relative;">
            <div id="pdfLoadingIndicator" style="position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #55483F; gap: 10px;">
                <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 2rem; color: #C58F43;"></i>
                <span style="font-size: 0.9rem; font-weight: 600;">Memuat pratinjau dokumen PDF...</span>
            </div>
            <iframe id="pdfPreviewFrame" src="" style="width: 100%; height: 100%; border: none; position: relative; z-index: 2;" onload="document.getElementById('pdfLoadingIndicator').style.display='none';"></iframe>
        </div>
    </div>
</div>

<script>
    function openPdfPreview(pdfUrl) {
        const modal = document.getElementById('pdfPreviewModal');
        const iframe = document.getElementById('pdfPreviewFrame');
        const loader = document.getElementById('pdfLoadingIndicator');
        
        loader.style.display = 'flex';
        iframe.src = pdfUrl;
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closePdfPreview() {
        const modal = document.getElementById('pdfPreviewModal');
        const iframe = document.getElementById('pdfPreviewFrame');
        
        modal.style.display = 'none';
        iframe.src = '';
        document.body.style.overflow = 'auto';
    }

    document.getElementById('pdfPreviewModal').addEventListener('click', function(e) {
        if (e.target === this) closePdfPreview();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && document.getElementById('pdfPreviewModal').style.display === 'flex') {
            closePdfPreview();
        }
    });
</script>
@endsection