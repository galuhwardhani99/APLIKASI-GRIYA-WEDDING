<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Transaksi - Griya Rias Elly Jr.</title>
    
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-light: #FDFBF7; 
            --bg-card: #FFFFFF; 
            --gold-primary: #C58F43;
            --gold-hover: #A87632;
            --text-dark: #241A16; 
            --text-muted: #8C8279; 
            --border-color: #EFE8DE;
            --success-bg: #EAF6EE;
            --success-text: #267145;
            --warning-bg: #FBF2E4;
            --warning-text: #8A6026;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: var(--bg-light); color: var(--text-dark); font-family: 'Plus Jakarta Sans', sans-serif; display: flex; min-height: 100vh; }

        /* Sidebar Styling (Konsisten) */
        .client-sidebar {
            width: 260px;
            flex: 0 0 260px;
            background: #FFF;
            border-right: 1px solid var(--border-color);
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: sticky;
            top: 0;
            z-index: 20;
            box-shadow: 2px 0 14px rgba(36, 26, 22, 0.03);
        }
        .client-sidebar-brand {
            padding: 4px 12px 20px;
            border-bottom: 1px solid var(--border-color);
            text-decoration: none;
            display: flex;
            flex-direction: column;
        }
        .client-sidebar-brand span { font-size: .67rem; letter-spacing: .2em; color: var(--gold-primary); font-weight: 700; text-transform: uppercase; }
        .client-sidebar-brand strong { font-family: 'Playfair Display', serif; color: var(--text-dark); font-size: 1.55rem; line-height: 1.2; }
        .client-sidebar-brand small { color: var(--text-muted); margin-top: 4px; }

        /* User Profile di Sidebar */
        .client-sidebar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 10px;
            margin: 16px 0;
            background: #FAFAFA;
            border: 1px solid var(--border-color);
            border-radius: 10px;
        }
        .client-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #F4E6D2;
            color: var(--gold-hover);
            display: grid;
            place-items: center;
            font-weight: 800;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .client-sidebar-user strong { font-size: .88rem; color: var(--text-dark); display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .client-sidebar-user small { font-size: .75rem; color: var(--text-muted); display: block; }

        /* Navigasi Sidebar */
        .client-sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex: 1;
            overflow-y: auto;
            padding-right: 4px;
        }
        .client-nav-label { font-size: .65rem; letter-spacing: .12em; font-weight: 800; color: #A59A8E; padding: 10px 12px 4px; display: block; }

        .client-sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #55483F;
            font-size: .86rem;
            font-weight: 600;
            padding: 11px 12px;
            border-radius: 8px;
            transition: .2s;
        }
        .client-sidebar-nav a i { width: 18px; text-align: center; color: var(--text-muted); }
        .client-sidebar-nav a:hover { background: #FBF5EC; color: var(--gold-hover); }
        .client-sidebar-nav a.active { background: var(--gold-primary); color: #FFF; }
        .client-sidebar-nav a.active i { color: #FFF; }

        /* Footer Sidebar */
        .client-sidebar-footer {
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
            display: grid;
            gap: 7px;
        }
        .client-sidebar-footer > a {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #55483F;
            font-size: .86rem;
            font-weight: 600;
            padding: 11px 12px;
            border-radius: 8px;
        }
        .client-sidebar-footer button {
            width: 100%;
            border: 1px solid #F1D0D0;
            background: #FFF5F5;
            color: #B33B3B;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 8px;
            font: 600 .85rem 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
        }

        /* Main Content Styling */
        .main-content { flex: 1; padding: 40px; min-width: 0; }
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
            overflow: hidden;
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
        .payment-modal { position:fixed; inset:0; z-index:100; display:grid; place-items:center; padding:20px; background:rgba(36,26,22,.42); backdrop-filter:blur(6px); }
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
</head>
<body>

    <!-- Sidebar Client -->
    <aside class="client-sidebar">
        <a class="client-sidebar-brand" href="{{ route('client.dashboard') }}">
            <span>GRIYA RIAS</span><strong>Elly Jr.</strong><small>Area Client</small>
        </a>
        
        <div class="client-sidebar-user">
            <span class="client-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            <div style="min-width: 0;">
                <strong>{{ auth()->user()->name }}</strong>
                <small>Client</small>
            </div>
        </div>

        <nav class="client-sidebar-nav">
            <span class="client-nav-label">MENU UTAMA</span>
            <a href="{{ route('client.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a>
            <a href="{{ route('client.katalog.layanan') }}"><i class="fa-solid fa-scissors"></i> Katalog Layanan</a>
            <a href="{{ route('client.katalog.paket') }}"><i class="fa-solid fa-box-open"></i> Katalog Paket</a>
            <a href="{{ route('client.jadwal.index') }}"><i class="fa-regular fa-calendar-days"></i> Jadwal Acara</a>
            <a href="{{ route('reservasi.create') }}"><i class="fa-regular fa-calendar-check"></i> Form Reservasi</a>
            
            <span class="client-nav-label" style="margin-top: 12px;">AKTIVITAS & AKUN</span>
            <a href="{{ route('client.riwayat.reservasi') }}"><i class="fa-regular fa-calendar"></i> Riwayat Reservasi</a>
            <a href="{{ route('client.riwayat.transaksi') }}" class="active">
                <i class="fa-solid fa-receipt"></i> Riwayat Transaksi
            </a>
            <a href="{{ route('user.profile.edit') }}">
                <i class="fa-solid fa-user-gear"></i> Pengaturan Akun
            </a>
        </nav>

        <div class="client-sidebar-footer">
    <a href="{{ route('client.home') }}"><i class="fa-solid fa-globe"></i> Halaman Client</a>
    <form id="logout-form-client" action="{{ route('logout') }}" method="POST" style="margin: 0;">
        @csrf
        <button type="button" onclick="confirmLogoutClient()"><i class="fa-solid fa-right-from-bracket"></i> Keluar Akun</button>
    </form>
</div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
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
                            <td>{{ $item->nama_paket ?: ($namaLayananTerpilih ?: $item->nama_layanan ?: $item->paket?->nama_paket ?: $item->layanan?->nama_layanan ?: $item->detail_acara ?: '—') }}</td>
                            <td>{{ $item->tgl_reservasi ? \Carbon\Carbon::parse($item->tgl_reservasi)->translatedFormat('d F Y') : '—' }}</td>
                            <td>{{ $item->jumlah_pesanan }}</td>
                            <td><strong>Rp {{ number_format($item->biaya_sewa ?: (($item->harga_paket ?? $item->harga_layanan ?? 0) * $item->jumlah_pesanan), 0, ',', '.') }}</strong></td>
                            <td>
                                <span class="history-status {{ $item->bukti_transfer ? 'has-proof' : '' }}">
                                    @if($item->bukti_transfer)
                                        <i class="fa-solid fa-circle-check"></i> Bukti Pembayaran Diterima
                                    @else
                                        <i class="fa-solid fa-clock"></i> Belum Ada Pembayaran
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
        </div>

        <div class="history-pagination">
            {{ $transaksi->links() }}
        </div>
    </main>

    @foreach($transaksi as $item)
        @if($item->status_reservasi === 'Disetujui' && !in_array($item->payment_status ?? 'unpaid', ['paid', 'proof_verified'], true))
            @php($totalModal = (int) (($item->biaya_sewa ?: ($item->harga_paket ?? $item->harga_layanan ?? 0)) * ($item->jumlah_pesanan ?: 1)))
            <div class="payment-modal" id="payment-modal-{{ $item->id_reservasi }}" hidden>
                <div class="payment-modal-card" role="dialog" aria-modal="true" aria-labelledby="payment-title-{{ $item->id_reservasi }}">
                    <div class="payment-modal-head">
                        <div><h2 id="payment-title-{{ $item->id_reservasi }}">Lanjutkan Pembayaran</h2><small style="color:var(--text-muted);">{{ $item->kode_reservasi }} · Reservasi disetujui admin</small></div>
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
                            <button type="button" class="payment-modal-pay js-midtrans-pay" data-url="{{ route('reservasi.payment.create', $item) }}" data-modal="payment-modal-{{ $item->id_reservasi }}"><i class="fa-solid fa-lock"></i> Bayar Sekarang</button>
                        </section>
                        <section class="payment-modal-section">
                            <h3>Ringkasan Transaksi</h3>
                            <div style="display:flex;justify-content:space-between;gap:12px;font-size:.82rem;padding:10px 0;border-bottom:1px solid var(--border-color);"><span style="color:var(--text-muted)">Paket / layanan</span><strong>{{ $item->nama_paket ?: ($item->nama_layanan ?: $item->detail_acara) }}</strong></div>
                            <div style="display:flex;justify-content:space-between;font-size:.82rem;padding:14px 0 0;"><span style="color:var(--text-muted)">Total</span><strong style="color:var(--gold-primary);font-size:1.15rem;">Rp {{ number_format($totalModal, 0, ',', '.') }}</strong></div>
                            <form action="{{ route('reservasi.payment.proof', $item) }}" method="POST" enctype="multipart/form-data" style="margin-top:18px;padding-top:16px;border-top:1px solid var(--border-color);">
                                @csrf
                                <label style="font-size:.78rem;font-weight:700;display:block;margin-bottom:7px;">Upload bukti pembayaran</label>
                                <input type="file" name="bukti_transfer" accept=".jpg,.jpeg,.png,.pdf" required style="width:100%;font-size:.75rem;">
                                <button type="submit" style="margin-top:10px;border:1px solid var(--gold-primary);background:#fff;color:var(--gold-hover);border-radius:8px;padding:9px 11px;cursor:pointer;font-weight:600;font-size:.75rem;"><i class="fa-solid fa-upload"></i> Upload Bukti</button>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</body>
<!-- SweetAlert2 CDN & Script Konfirmasi -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
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
    document.querySelectorAll('.js-midtrans-pay').forEach(button => button.addEventListener('click', async () => {
        const modal = document.getElementById(button.dataset.modal);
        const method = modal.querySelector('input[type="radio"]:checked')?.value;
        if (!method) { Swal.fire('Pilih metode pembayaran', 'Silakan pilih metode pembayaran terlebih dahulu.', 'info'); return; }
        button.disabled = true;
        try {
            const response = await fetch(button.dataset.url, { method:'POST', headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content,'Accept':'application/json','Content-Type':'application/json'}, body:JSON.stringify({payment_method:method}) });
            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'Pembayaran gagal dibuat.');
            window.snap.pay(data.token, { onSuccess:() => location.reload(), onPending:() => location.reload(), onError:() => Swal.fire('Pembayaran gagal','Silakan coba lagi.','error'), onClose:() => button.disabled = false });
        } catch (error) { Swal.fire('Gagal', error.message, 'error'); button.disabled = false; }
    }));

    function confirmLogoutClient() {
        Swal.fire({
            title: 'Keluar dari Akun?',
            text: 'Anda harus masuk kembali untuk membuat atau melihat reservasi.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#C58F43',
            cancelButtonColor: '#8C8279',
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form-client').submit();
            }
        });
    }
</script>
</html>
