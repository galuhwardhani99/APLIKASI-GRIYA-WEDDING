@extends('layouts.client')

@section('title', 'Riwayat Transaksi - Griya Rias Elly Jr.')

@push('styles')
<style>
    :root {
        --success-bg: #EAF6EE;
        --success-text: #267145;
        --warning-bg: #FBF2E4;
        --warning-text: #8A6026;
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
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        background: var(--warning-bg);
        color: var(--warning-text);
        font-size: 12px;
        font-weight: 700;
    }
    .history-status.has-proof { background: var(--success-bg); color: var(--success-text); }
    .history-note { display: block; color: var(--text-muted); margin-top: 4px; font-size: 12px; }
    .history-empty { text-align: center; color: var(--text-muted); padding: 48px !important; }

    .history-pagination { display: flex; justify-content: center; margin-top: 24px; }
    .payment-modal[hidden] { display:none; }
    .payment-modal { position:fixed; inset:0; z-index:1000; display:grid; place-items:center; padding:20px; background:rgba(36,26,22,.42); backdrop-filter:blur(6px); }
    .payment-modal-card { width:min(720px,100%); max-height:calc(100vh - 40px); overflow:auto; background:#fff; border-radius:24px; padding:28px; box-shadow:0 24px 80px rgba(36,26,22,.28); animation:paymentModalIn .2s ease-out; }
    @keyframes paymentModalIn { from { opacity:0; transform:translateY(12px) scale(.98); } to { opacity:1; transform:none; } }
    .payment-modal-head { display:flex; justify-content:space-between; align-items:flex-start; gap:16px; padding-bottom:16px; border-bottom:1px solid var(--border-color); }
    .payment-modal-head h2 { font-family:'Playfair Display',serif; font-size:1.5rem; }
    .payment-modal-close { width:36px; height:36px; border:1px solid var(--border-color); background:#fff; border-radius:50%; cursor:pointer; color:var(--text-muted); }
    .payment-modal-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-top:20px; }
    .payment-modal-section { border:1px solid var(--border-color); border-radius:16px; padding:20px; }
    .payment-modal-section h3 { font-size:.95rem; margin-bottom:14px; }
    .payment-methods-modal { display:grid; grid-template-columns:1fr 1fr; gap:8px; }
    .payment-method-modal { border:1px solid var(--border-color); border-radius:10px; padding:11px; font-size:.75rem; cursor:pointer; }
    .payment-method-modal:has(input:checked) { border-color:var(--gold-primary); background:#FDF8EF; box-shadow:0 0 0 1px var(--gold-primary); }
    .payment-method-modal input { accent-color:var(--gold-primary); margin-right:5px; }
    .payment-modal-pay { width:100%; margin-top:16px; padding:13px; border:0; border-radius:10px; color:#fff; background:var(--gold-primary); font-weight:700; cursor:pointer; }
    @media(max-width:680px) { .payment-modal-card { padding:20px; border-radius:18px; } .payment-modal-grid { grid-template-columns:1fr; } }
</style>
@endpush

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Riwayat Transaksi</h1>
            <p class="page-sub">Ringkasan nilai booking dan status reservasi Anda.</p>
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
                    <th>Kode Transaksi</th>
                    <th>Paket / Layanan</th>
                    <th>Tanggal Booking</th>
                    <th>Jumlah</th>
                    <th>Total Biaya</th>
                    <th>Status Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksi as $item)
                    <tr>
                        @php($namaLayananTerpilih = $item->layanans->map(fn ($layanan) => $layanan->pivot->nama_layanan)->filter()->implode(', '))
                        <td><strong>{{ $item->kode_reservasi }}</strong></td>
                        <td>
                            {{ $item->nama_paket ?: ($namaLayananTerpilih ?: $item->nama_layanan ?: $item->paket?->nama_paket ?: $item->layanan?->nama_layanan ?: $item->detail_acara ?: '—') }}
                            @foreach($item->layanans as $layananTerpilih)
                                @if($layananTerpilih->pivot->catatan_layanan)
                                    <small style="display:block;white-space:pre-line;color:var(--text-muted);"><strong>Catatan {{ $layananTerpilih->pivot->nama_layanan }}:</strong> {{ $layananTerpilih->pivot->catatan_layanan }}</small>
                                @endif
                            @endforeach
                        </td>
                        <td>{{ ($item->tanggal_acara ?? $item->tgl_acara ?? $item->tanggal_pengajuan ?? $item->tgl_reservasi)?->translatedFormat('d F Y') ?? '&mdash;' }}</td>
                        <td>{{ $item->jumlah_pesanan }}</td>
                        <td><strong>Rp {{ number_format($item->biaya_sewa ?: (($item->harga_paket ?? $item->harga_layanan ?? 0) * $item->jumlah_pesanan), 0, ',', '.') }}</strong></td>
                        <td>
                            @php($paymentStatus = $item->payment_status ?? 'unpaid')
                            <span id="payment-status-{{ $item->id_reservasi }}" class="history-status {{ in_array($paymentStatus, ['paid', 'proof_verified'], true) ? 'has-proof' : '' }}" @if($item->payment_order_id && !in_array($paymentStatus, ['paid', 'proof_verified'], true)) data-payment-sync-url="{{ route('reservasi.payment.sync', $item) }}" @endif>
                                @if($paymentStatus === 'paid')
                                    <i class="fa-solid fa-circle-check"></i> Pembayaran Lunas
                                @elseif($paymentStatus === 'proof_verified')
                                    <i class="fa-solid fa-circle-check"></i> Pembayaran Lunas
                                @elseif(in_array($paymentStatus, ['pending', 'authorize', 'capture'], true))
                                    <i class="fa-solid fa-clock"></i> Menunggu Pembayaran
                                @else
                                    <i class="fa-solid fa-clock"></i> {{ $paymentStatus === 'expired' ? 'Pembayaran Kedaluwarsa' : 'Belum Ada Pembayaran' }}
                                @endif
                            </span>
                            <small class="history-note">Status Reservasi: {{ ucfirst($item->status_reservasi) }}</small>
                            @if($item->status_reservasi === 'Disetujui' && !in_array($item->payment_status ?? 'unpaid', ['paid', 'proof_verified'], true))
                                <button type="button" class="btn-gold js-open-payment-modal" data-modal="payment-modal-{{ $item->id_reservasi }}" style="border:0;margin-top:8px;padding:7px 10px;font-size:.72rem;cursor:pointer;">
                                    <i class="fa-solid fa-arrow-right"></i> Lanjutkan Pembayaran
                                </button>
                            @elseif($item->status_reservasi !== 'Disetujui')
                                <small class="history-note"><i class="fa-solid fa-clock"></i> Menunggu validasi admin</small>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="history-empty">
                            <i class="fa-solid fa-receipt" style="font-size: 2rem; color: #D1C7BD; margin-bottom: 12px; display: block;"></i>
                            Belum ada transaksi booking. Setelah mengajukan reservasi, ringkasannya akan muncul di sini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $transaksi->links('vendor.pagination.client-custom') }}
    </div>

    <div class="history-pagination">
        {{ $transaksi->links() }}
    </div>

    @foreach($transaksi as $item)
        @if($item->status_reservasi === 'Disetujui' && !in_array($item->payment_status ?? 'unpaid', ['paid', 'proof_verified'], true))
            @php($totalModal = (int) (($item->biaya_sewa ?: ($item->harga_paket ?? $item->harga_layanan ?? 0)) * ($item->jumlah_pesanan ?: 1)))
            <div class="payment-modal" id="payment-modal-{{ $item->id_reservasi }}" hidden>
                <div class="payment-modal-card" role="dialog" aria-modal="true" aria-labelledby="payment-title-{{ $item->id_reservasi }}">
                    <div class="payment-modal-head">
                        <div><h2 id="payment-title-{{ $item->id_reservasi }}">Lanjutkan Pembayaran</h2><small style="color:var(--text-muted);">{{ $item->kode_reservasi }} &middot; Reservasi disetujui admin</small></div>
                        <button type="button" class="payment-modal-close js-close-payment-modal" data-modal="payment-modal-{{ $item->id_reservasi }}" aria-label="Tutup"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                    <div class="payment-modal-grid">
                        <section class="payment-modal-section">
                            <h3><i class="fa-solid fa-wallet" style="color:var(--gold-primary)"></i> Pilih metode pembayaran</h3>
                            <div class="payment-methods-modal">
                                <label class="payment-method-modal"><input type="radio" name="payment_method_{{ $item->id_reservasi }}" value="bank_transfer"> Bank / VA</label>
                                <label class="payment-method-modal"><input type="radio" name="payment_method_{{ $item->id_reservasi }}" value="qris"> QRIS</label>
                                <label class="payment-method-modal"><input type="radio" name="payment_method_{{ $item->id_reservasi }}" value="gopay"> GoPay</label>
                                <label class="payment-method-modal"><input type="radio" name="payment_method_{{ $item->id_reservasi }}" value="shopeepay"> ShopeePay</label>
                                <label class="payment-method-modal"><input type="radio" name="payment_method_{{ $item->id_reservasi }}" value="credit_card"> Kartu Kredit</label>
                            </div>
                            <button type="button" class="payment-modal-pay js-midtrans-pay" data-url="{{ route('reservasi.payment.create', $item) }}" data-sync-url="{{ route('reservasi.payment.sync', $item) }}" data-status-id="payment-status-{{ $item->id_reservasi }}" data-modal="payment-modal-{{ $item->id_reservasi }}" data-simulator-enabled="{{ config('services.midtrans.is_production') ? 'false' : 'true' }}"><i class="fa-solid fa-lock"></i> Bayar Sekarang</button>
                            @unless(config('services.midtrans.is_production'))
                                <p style="margin:9px 0 0;color:var(--text-muted);font-size:.72rem;line-height:1.5;">Untuk Sandbox, salin nomor VA atau kode pembayaran dari Snap, tutup popup, lalu klik tombol lagi untuk membuka Simulator Midtrans.</p>
                            @endunless
                        </section>
                        <section class="payment-modal-section">
                            <h3>Ringkasan Transaksi</h3>
                            <div style="display:flex;justify-content:space-between;gap:12px;font-size:.82rem;padding:10px 0;border-bottom:1px solid var(--border-color);"><span style="color:var(--text-muted)">Paket / layanan</span><strong>{{ $item->nama_paket ?: ($item->nama_layanan ?: $item->detail_acara) }}</strong></div>
                            <div style="display:flex;justify-content:space-between;font-size:.82rem;padding:14px 0 0;"><span style="color:var(--text-muted)">Total</span><strong style="color:var(--gold-primary);font-size:1.15rem;">Rp {{ number_format($totalModal, 0, ',', '.') }}</strong></div>
                        </section>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection

@push('scripts')
@if(config('services.midtrans.client_key'))
    <script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
@endif
<script>
    function playSuccessSound() {
        try {
            const AudioCtx = window.AudioContext || window.webkitAudioContext;
            const ctx = new AudioCtx();
            const now = ctx.currentTime;
            const notes = [523.25, 659.25, 783.99, 1046.50];
            
            notes.forEach((freq, i) => {
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                const startTime = now + (i * 0.085);

                osc.type = 'sine';
                osc.frequency.setValueAtTime(freq, startTime);

                gain.gain.setValueAtTime(0.001, startTime);
                gain.gain.exponentialRampToValueAtTime(0.28, startTime + 0.02);
                gain.gain.exponentialRampToValueAtTime(0.0001, startTime + 0.35);

                osc.connect(gain);
                gain.connect(ctx.destination);

                osc.start(startTime);
                osc.stop(startTime + 0.36);
            });
        } catch (e) {}
    }
    
    document.querySelectorAll('.js-open-payment-modal').forEach(button => button.addEventListener('click', () => {
        document.getElementById(button.dataset.modal).hidden = false;
    }));
    document.querySelectorAll('.js-close-payment-modal').forEach(button => button.addEventListener('click', () => {
        document.getElementById(button.dataset.modal).hidden = true;
    }));
    document.querySelectorAll('.payment-modal').forEach(modal => modal.addEventListener('click', event => {
        if (event.target === modal) modal.hidden = true;
    }));
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') document.querySelectorAll('.payment-modal:not([hidden])').forEach(modal => modal.hidden = true);
    });
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    document.querySelectorAll('.js-midtrans-pay').forEach(button => button.addEventListener('click', async () => {
        const modal = document.getElementById(button.dataset.modal);
        if (button.dataset.simulatorReady === 'true') {
            window.open('https://simulator.sandbox.midtrans.com/', '_blank', 'noopener');
            return;
        }
        const method = modal.querySelector('input[type="radio"]:checked')?.value;
        if (!method) { Swal.fire('Pilih metode pembayaran', 'Silakan pilih metode pembayaran terlebih dahulu.', 'info'); return; }
        button.disabled = true;
        try {
            const response = await fetch(button.dataset.url, { method:'POST', headers:{'X-CSRF-TOKEN':csrfToken,'Accept':'application/json','Content-Type':'application/json'}, body:JSON.stringify({payment_method:method}) });
            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'Pembayaran gagal dibuat.');
            if (!data.token || !window.snap) throw new Error('Snap Midtrans belum siap. Muat ulang halaman lalu coba lagi.');
            button.dataset.simulatorReady = 'false';
            button.dataset.orderId = data.order_id;
            const statusElement = document.getElementById(button.dataset.statusId);
            if (statusElement) statusElement.dataset.paymentSyncUrl = button.dataset.syncUrl;
            window.snap.pay(data.token, {
                onSuccess: () => { button.innerHTML = '<i class="fa-solid fa-check"></i> Pembayaran berhasil'; syncPaymentStatuses(); },
                onPending: () => enableSandboxSimulator(button),
                onError: () => { button.disabled = false; button.innerHTML = '<i class="fa-solid fa-lock"></i> Bayar Sekarang'; Swal.fire('Pembayaran gagal','Silakan coba lagi.','error'); },
                onClose: () => enableSandboxSimulator(button),
            });
        } catch (error) { Swal.fire('Gagal', error.message, 'error'); button.disabled = false; }
    }));

    function enableSandboxSimulator(button) {
        if (button.dataset.simulatorEnabled === 'true') {
            button.dataset.simulatorReady = 'true';
            button.innerHTML = '<i class="fa-solid fa-arrow-up-right-from-square"></i> Lanjut ke Simulator Sandbox';
        } else {
            button.innerHTML = '<i class="fa-solid fa-lock"></i> Bayar Sekarang';
        }
        button.disabled = false;
    }

    let isPaymentAlertShown = false;

    async function syncPaymentStatuses() {
        for (const statusElement of document.querySelectorAll('[data-payment-sync-url]')) {
            try {
                const response = await fetch(statusElement.dataset.paymentSyncUrl, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                });
                if (!response.ok) continue;
                const data = await response.json();
                if (['pending', 'authorize', 'capture'].includes(data.payment_status)) {
                    statusElement.innerHTML = '<i class="fa-solid fa-clock"></i> Menunggu Pembayaran';
                } else if (data.payment_status === 'expired') {
                    statusElement.innerHTML = '<i class="fa-solid fa-clock"></i> Pembayaran Kedaluwarsa';
                }
                if (data.payment_status === 'paid') {
                    statusElement.classList.add('has-proof');
                    statusElement.innerHTML = '<i class="fa-solid fa-circle-check"></i> Pembayaran Lunas';
                    statusElement.removeAttribute('data-payment-sync-url');
                    const row = statusElement.closest('tr');
                    const kodeTransaksi = row?.querySelector('td:first-child strong')?.textContent?.trim() || '';
                    const modalTrigger = row?.querySelector('.js-open-payment-modal');
                    if (modalTrigger) {
                        const modal = document.getElementById(modalTrigger.dataset.modal);
                        if (modal) modal.hidden = true;
                        modalTrigger.remove();
                    }

                    if (!isPaymentAlertShown) {
                        isPaymentAlertShown = true;
                        playSuccessSound();
                        Swal.fire({
                            icon: 'success',
                            title: 'Pembayaran Berhasil (Lunas 100%)!',
                            html: `Transaksi <strong>${kodeTransaksi}</strong> telah terverifikasi lunas secara otomatis.`,
                            confirmButtonColor: '#C58F43',
                            confirmButtonText: 'Selesai',
                            background: '#FFFFFF',
                            color: '#241A16'
                        }).then(() => {
                            isPaymentAlertShown = false;
                        });
                    }
                } else if (data.payment_status === 'proof_verified') {
                    statusElement.classList.add('has-proof');
                    statusElement.innerHTML = '<i class="fa-solid fa-circle-check"></i> Pembayaran Lunas';
                    statusElement.removeAttribute('data-payment-sync-url');
                }
            } catch (error) {}
        }
    }
    const requestedReservation = new URLSearchParams(window.location.search).get('reservasi');
    if (requestedReservation) {
        const paymentModal = document.getElementById(`payment-modal-${requestedReservation}`);
        if (paymentModal) paymentModal.hidden = false;
    }
    syncPaymentStatuses();
    window.setInterval(syncPaymentStatuses, 15000);
    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'visible') syncPaymentStatuses();
    });
</script>
@endpush