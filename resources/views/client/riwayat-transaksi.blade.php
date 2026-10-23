<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

</body>
<!-- SweetAlert2 CDN & Script Konfirmasi -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
