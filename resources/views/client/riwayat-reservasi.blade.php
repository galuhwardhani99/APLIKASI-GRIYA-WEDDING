@extends('layouts.client')

@section('title', 'Riwayat Reservasi - Griya Rias Elly Jr.')

@push('styles')
<style>
    :root {
        --status-bg: #FBF2E4;
        --status-text: #8A6026;
    }

    .page-header { margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; }
    .page-title { font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--text-dark); margin-bottom: 6px; }
    .page-sub { color: var(--text-muted); font-size: 0.9rem; }

    .btn-gold {
        background-color: var(--gold-primary);
        color: #FFF;
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.88rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background-color 0.2s;
    }
    .btn-gold:hover { background-color: var(--gold-hover); }

    /* Table Card Container */
    .history-table-wrap {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        overflow-x: auto;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }
    .history-table { width: 100%; min-width: 750px; border-collapse: collapse; }
    .history-table th {
        text-align: left;
        padding: 16px;
        background: #FCFAF8;
        color: var(--text-muted);
        font-size: 11px;
        letter-spacing: .08em;
        text-transform: uppercase;
        font-weight: 700;
        border-bottom: 1px solid var(--border-color);
    }
    .history-table td { padding: 18px 16px; border-top: 1px solid #F0EBE6; vertical-align: middle; font-size: 0.9rem; }
    .history-table td small { display: block; color: var(--text-muted); margin-top: 4px; font-size: 0.8rem; }

    .history-status {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        background: var(--status-bg);
        color: var(--status-text);
        font-size: 12px;
        font-weight: 700;
        text-transform: capitalize;
    }
    
    .history-empty { text-align: center; color: var(--text-muted); padding: 48px !important; }
    .history-empty a { color: var(--gold-primary); font-weight: 700; text-decoration: none; }
    .history-empty a:hover { text-decoration: underline; }

    .history-pagination { display: flex; justify-content: center; margin-top: 24px; }
    
    /* Layout Pembayaran Rapih */
    .payment-box {
        background: #FAFAFA;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 12px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .payment-amount { font-size: 1rem; font-weight: 800; color: var(--gold-primary); }
    .payment-status-info { font-size: 0.78rem; display: flex; align-items: center; gap: 5px; }
</style>
@endpush

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Riwayat Reservasi</h1>
            <p class="page-sub">Daftar pengajuan booking dan perkembangan jadwal acara Anda.</p>
        </div>
        <div>
            <a class="btn-gold" href="{{ route('reservasi.create') }}">
                <i class="fa-solid fa-plus"></i> Buat Reservasi
            </a>
        </div>
    </div>

    <div class="history-table-wrap">
        <table class="history-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Paket / Layanan</th>
                    <th>Tanggal Acara</th>
                    <th>Waktu</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Pembayaran &amp; Bukti</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservasis as $reservasi)
                    <tr>
                        @php($namaLayananTerpilih = $reservasi->layanans->map(fn ($layanan) => $layanan->pivot->nama_layanan)->filter()->implode(', '))
                        <td>
                            <strong>{{ $reservasi->kode_reservasi }}</strong>
                            <small>Diajukan {{ ($reservasi->tanggal_pengajuan ?? $reservasi->tgl_reservasi)?->format('d/m/Y') }}</small>
                        </td>
                        <td>
                            {{ $reservasi->nama_paket ?: ($namaLayananTerpilih ?: $reservasi->nama_layanan ?: $reservasi->paket?->nama_paket ?: $reservasi->layanan?->nama_layanan ?: $reservasi->detail_acara ?: '—') }}
                            <small>{{ $reservasi->lokasi_acara ?: $reservasi->lokasi }}</small>
                            @foreach($reservasi->layanans as $layananTerpilih)
                                @if($layananTerpilih->pivot->catatan_layanan)
                                    <small style="white-space:pre-line;"><strong>Catatan {{ $layananTerpilih->pivot->nama_layanan }}:</strong> {{ $layananTerpilih->pivot->catatan_layanan }}</small>
                                @endif
                            @endforeach
                        </td>
                        <td>{{ ($reservasi->tanggal_acara ?? $reservasi->tgl_acara)?->translatedFormat('d F Y') ?? '—' }}</td>
                        <td style="white-space: nowrap;">
                            {{ $reservasi->waktu_mulai ? substr($reservasi->waktu_mulai, 0, 5) : '-' }} &ndash; {{ $reservasi->waktu_selesai ? substr($reservasi->waktu_selesai, 0, 5) : '-' }}
                        </td>
                        <td>{{ $reservasi->jumlah_pesanan }}</td>
                        <td>
                            <span class="history-status">{{ $reservasi->status_reservasi }}</span>
                        </td>
                        <td style="min-width:240px;">
                            <div class="payment-box">
                                @php($totalPembayaran = (int) (($reservasi->harga_paket ?: $reservasi->harga_layanan ?: 0) * ($reservasi->jumlah_pesanan ?: 1)))
                                <div class="payment-amount">Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</div>
                                
                                @if(in_array($reservasi->payment_status ?? 'unpaid', ['paid', 'proof_verified'], true))
                                    <div class="payment-status-info" style="color:#15803D;"><i class="fa-solid fa-circle-check"></i> Pembayaran lunas</div>
                                @else
                                    @if($reservasi->status_reservasi === 'Disetujui' && config('services.midtrans.client_key') && $totalPembayaran > 0)
                                        <a class="btn-gold" href="{{ route('client.riwayat.transaksi', ['reservasi' => $reservasi->id_reservasi]) }}" style="text-decoration:none;padding:6px 10px;font-size:.75rem;justify-content:center;">
                                            <i class="fa-solid fa-credit-card"></i> Lanjut ke Pembayaran
                                        </a>
                                    @elseif($reservasi->status_reservasi !== 'Disetujui')
                                        <div class="payment-status-info" style="color:#8C8279;"><i class="fa-solid fa-clock"></i> Menunggu validasi admin</div>
                                    @else
                                        <div class="payment-status-info" style="color:#B45309;">Gateway belum dikonfigurasi</div>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="history-empty">
                            <i class="fa-regular fa-calendar-xmark" style="font-size: 2rem; color: #D1C7BD; margin-bottom: 12px; display: block;"></i>
                            Belum ada pengajuan reservasi. <a href="{{ route('reservasi.create') }}">Buat reservasi pertama Anda.</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
            {{ $reservasis->links('vendor.pagination.client-custom') }}
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const newlyValidated = @json($newlyValidatedList ?? []);
        if (newlyValidated.length === 0) return;

        const alertSignature = newlyValidated.map(i => `${i.kode_reservasi}:${i.status_reservasi}`).join('|');
        if (sessionStorage.getItem('last_shown_validation_alert') === alertSignature) {
            return;
        }
        sessionStorage.setItem('last_shown_validation_alert', alertSignature);

        const approved = newlyValidated.filter(item => item.status_reservasi === 'Disetujui');
        const rejected = newlyValidated.filter(item => item.status_reservasi === 'Ditolak');

        playValidationSound();

        if (approved.length > 0) {
            const kodeList = approved.map(i => `<strong>${i.kode_reservasi}</strong>`).join(', ');
            Swal.fire({
                icon: 'success',
                title: 'Reservasi berhasil silahkan tunggu validasi dari admin',
                html: `Kode reservasi ${kodeList} berhasil dibuat.`,
                showCancelButton: false,
                allowOutsideClick: false,
                confirmButtonColor: '#C58F43',
                confirmButtonText: 'Oke',
                background: '#FFFFFF',
                color: '#241A16'
            });
        } else if (rejected.length > 0) {
            const kodeList = rejected.map(i => `<strong>${i.kode_reservasi}</strong>`).join(', ');
            Swal.fire({
                icon: 'info',
                title: 'Status Reservasi Diperbarui',
                html: `Pengajuan reservasi ${kodeList} berstatus <strong>Ditolak</strong>. Silakan cek detail atau hubungi admin untuk jadwal alternatif.`,
                allowOutsideClick: false,
                confirmButtonColor: '#C58F43',
                background: '#FFFFFF',
                color: '#241A16'
            });
        }
    });

    function playValidationSound() {
        try {
            const AudioCtx = window.AudioContext || window.webkitAudioContext;
            const ctx = new AudioCtx();
            const now = ctx.currentTime;
            [587.33, 880.00].forEach((freq, i) => {
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'sine';
                osc.frequency.setValueAtTime(freq, now + i * 0.12);
                gain.gain.setValueAtTime(0.001, now + i * 0.12);
                gain.gain.exponentialRampToValueAtTime(0.22, now + i * 0.12 + 0.02);
                gain.gain.exponentialRampToValueAtTime(0.0001, now + i * 0.12 + 0.4);
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start(now + i * 0.12);
                osc.stop(now + i * 0.12 + 0.42);
            });
        } catch (e) {}
    }
</script>
@endpush