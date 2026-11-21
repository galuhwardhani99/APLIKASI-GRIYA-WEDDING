<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Griya Rias Elly Jr.</title>
    
    <!-- FAVICON -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}">

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        /* Badge Notifikasi Titik Merah Angka */
        .badge-notification {
            background-color: #EF4444;
            color: #FFFFFF;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 9999px;
            margin-left: auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 20px;
            height: 20px;
            box-shadow: 0 2px 5px rgba(239, 68, 68, 0.3);
        }
        :root {
            --bg-light: #FDFBF7; 
            --bg-card: #FFFFFF; 
            --gold-primary: #C58F43;
            --gold-hover: #A87632;
            --text-dark: #241A16; 
            --text-muted: #8C8279; 
            --border-color: #EFE8DE;
            --border-dark: #D8CEC0;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            background-color: var(--bg-light); 
            color: var(--text-dark); 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            display: flex; 
            min-height: 100vh; 
            -webkit-font-smoothing: antialiased;
        }
        .badge-paid {
    background-color: #16A34A;
    color: #FFFFFF;
    font-size: 0.7rem;
    font-weight: 800;
    padding: 2px 6px;
    border-radius: 9999px;
    margin-left: auto;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 20px;
    height: 20px;
    box-shadow: 0 2px 5px rgba(22, 163, 74, 0.3);
}
.nav-item.active .badge-paid {
    background-color: #FFFFFF;
    color: #16A34A;
    box-shadow: none;
}
        
        /* Sidebar Freeze & Sharpened Borders */
        .sidebar { 
            width: 260px; 
            min-width: 260px;
            flex: 0 0 260px;
            height: 100vh;
            position: sticky;
            top: 0;
            background-color: var(--bg-card); 
            border-right: 1px solid var(--border-dark); 
            padding: 24px 16px; 
            display: flex; 
            flex-direction: column; 
            gap: 0;
            box-shadow: 2px 0 12px rgba(36, 26, 22, 0.04);
            overflow: hidden;
        }

        .sidebar-brand { 
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding-bottom: 20px; 
            border-bottom: 1px solid var(--border-color); 
            padding-left: 8px;
            text-decoration: none;
            border-left: 3px solid var(--gold-primary);
        }

        .brand-text h2 { 
            font-family: 'Playfair Display', serif; 
            color: var(--gold-primary); 
            font-size: 0.67rem; 
            letter-spacing: .25em;
            line-height: 1.2;
            margin-bottom: 2px;
            font-weight: 800;
        }

        .brand-title { font-family:'Playfair Display',serif; color:var(--text-dark); font-size:1.55rem; line-height:1.2; margin:0; font-weight:700; }
        .brand-sub { margin-top:2px; font-size: 0.75rem; color: var(--text-muted); font-weight: 600; }

        .admin-sidebar-user { 
            display:flex; 
            align-items:center; 
            gap:12px; 
            padding:14px 12px; 
            margin:16px 0; 
            background:#FAFAFA; 
            border:1px solid var(--border-color); 
            border-radius:10px; 
        }
        .admin-sidebar-avatar { 
            width:40px; 
            height:40px; 
            border-radius:50%; 
            display:grid; 
            place-items:center; 
            background:#F4E6D2; 
            color:#93622D; 
            font-weight:800; 
            border: 1px solid #EAD8BF;
        }
        .admin-sidebar-user strong { font-size:.86rem; color: var(--text-dark); }
        .admin-sidebar-user small { color:var(--text-muted); font-size:.72rem; margin-top:2px; font-weight:600; }

        .sidebar > nav { display:flex; flex:1; min-height:0; }
        .nav-menu { list-style:none; display:flex; flex:1; min-height:0; flex-direction:column; gap:4px; overflow-y:auto; padding-right:4px; }
        .nav-menu::-webkit-scrollbar { width:4px; }
        .nav-menu::-webkit-scrollbar-track { background:transparent; }
        .nav-menu::-webkit-scrollbar-thumb { background:#EFE8DE; border-radius:4px; }
        .nav-menu { scrollbar-width:thin; scrollbar-color:#EFE8DE transparent; overscroll-behavior:contain; }
        /* Ubah baris 122 di dashboard.blade.php menjadi: */
.admin-nav-label { 
    padding: 10px 12px 4px; 
    font-size: 0.65rem; 
    letter-spacing: 0.12em; 
    font-weight: 800; 
    color: #A59A8E; 
    text-transform: uppercase;
}
        .admin-nav-spaced { margin-top:12px; }
        
        .nav-item { 
            padding: 10px 12px; 
            border-radius: 8px; 
            color: #55483F;
            text-decoration: none; 
            font-size: 0.86rem; 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            transition: all 0.2s ease; 
            font-weight: 600;
        }
        .nav-item i { width: 18px; text-align: center; font-size: 1rem; color: #9B8877; }
        .nav-item:hover { background-color: #FBF5EC; color: var(--gold-hover); }
        .nav-item.active { background-color: var(--gold-primary); color: #FFF; font-weight: 700; box-shadow: 0 4px 10px rgba(197, 143, 67, 0.25); }
        .nav-item.active i { color: #FFF; }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
            display: grid;
            gap: 8px;
        }

        .btn-sidebar-home {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 8px;
            color: #55483F;
            text-decoration: none;
            font-size: 0.86rem;
            font-weight: 600;
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .btn-sidebar-home:hover {
            background-color: #FBF5EC;
            color: var(--gold-hover);
            border-color: var(--gold-primary);
        }

        .btn-sidebar-logout {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 8px;
            color: #B33B3B;
            background-color: #FFF5F5;
            border: 1px solid #F1D0D0;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-sidebar-logout:hover { background-color:#FDE8E8; border-color: #E6B2B2; }
        
        /* Main Content Container */
        .main-content { flex: 1; min-width:0; padding: 40px; }
        
        /* Dashboard Header Bar */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }
        .dashboard-title {
            font-family: 'Playfair Display', serif;
            color: var(--text-dark);
            font-size: 1.75rem;
            font-weight: 700;
        }

        /* Stats Grid (Visual Crisp Improvement) */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }
        .stat-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-dark);
            border-radius: 12px;
            padding: 22px 24px;
            box-shadow: 0 4px 14px rgba(36, 26, 22, 0.03);
            display: flex;
            align-items: center;
            gap: 18px;
            transition: transform 0.2s ease, border-color 0.2s ease;
            color: inherit;
            text-decoration: none;
        }
        a.stat-card:hover, a.stat-card:focus-visible {
            border-color: var(--gold-primary);
            transform: translateY(-2px);
            outline: none;
            box-shadow: 0 6px 18px rgba(197, 143, 67, 0.12);
        }
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            background: rgba(197, 143, 67, 0.12);
            color: var(--gold-primary);
            display: grid;
            place-items: center;
            font-size: 1.25rem;
            flex-shrink: 0;
            border: 1px solid rgba(197, 143, 67, 0.25);
        }
        .stat-title {
            font-size: 0.72rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            font-weight: 800;
            margin-bottom: 4px;
        }
        .stat-value {
            font-family: 'Playfair Display', serif;
            font-size: 1.65rem;
            color: var(--text-dark);
            font-weight: 700;
            line-height: 1.1;
        }

        /* Table Section Tajam & Jelas */
        .table-section {
            background-color: var(--bg-card);
            border: 1px solid var(--border-dark);
            border-radius: 12px;
            padding: 26px;
            box-shadow: 0 4px 14px rgba(36, 26, 22, 0.03);
        }
        .table-header {
            font-family: 'Playfair Display', serif;
            color: var(--text-dark);
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 20px;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 12px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table th {
            text-align: left;
            padding: 12px 14px;
            font-size: 0.75rem;
            color: var(--gold-primary);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            font-weight: 800;
            border-bottom: 2px solid var(--border-color);
            background-color: #FAFAFA;
        }
        .data-table td {
            padding: 16px 14px;
            font-size: 0.9rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-dark);
            vertical-align: middle;
        }
        .data-table tbody tr:hover {
            background-color: #FDFBF7;
        }
        .data-table tr:last-child td { border-bottom: none; }
        
        /* Status Badges Berkontras Tinggi */
        .status-badge {
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-block;
        }
        .status-dp { background-color: #FFF3E0; color: #D97706; border: 1px solid #FDE68A; }
        .status-lunas { background-color: #ECFDF5; color: #059669; border: 1px solid #A7F3D0; }
        .analysis-section, .quick-links-section {
            background: var(--bg-card);
            border: 1px solid var(--border-dark);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 14px rgba(36, 26, 22, 0.03);
        }
        .section-heading { font-family: 'Playfair Display', serif; font-size: 1.25rem; margin-bottom: 4px; }
        .section-caption { color: var(--text-muted); font-size: .82rem; margin-bottom: 18px; }
        .chart-wrap { height: 280px; position: relative; }
        .quick-links-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: 12px; }
        .quick-link {
            display: flex; align-items: center; gap: 12px; padding: 14px;
            border: 1px solid var(--border-color); border-radius: 10px;
            color: var(--text-dark); text-decoration: none; font-weight: 700; font-size: .86rem;
            transition: border-color .2s, background .2s, transform .2s;
        }
        .quick-link:hover { border-color: var(--gold-primary); background: #FBF5EC; transform: translateY(-1px); }
        .quick-link i { color: var(--gold-primary); width: 20px; text-align: center; }
        .insight-grid { display: grid; grid-template-columns: minmax(0, 1.5fr) minmax(280px, 1fr); gap: 20px; margin-bottom: 24px; }
        .insight-grid .analysis-section { margin-bottom: 0; }
        .agenda-list { display: grid; gap: 10px; }
        .agenda-item { display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 9px; }
        .agenda-client { font-weight: 700; font-size: .88rem; }
        .agenda-event { color: var(--text-muted); font-size: .78rem; margin-top: 3px; }
        .agenda-date { flex-shrink: 0; color: var(--gold-hover); font-weight: 800; font-size: .8rem; text-align: right; }
        .agenda-empty { color: var(--text-muted); padding: 12px 0; font-size: .88rem; }
        @media (max-width: 900px) { .insight-grid { grid-template-columns: 1fr; } }
        @media (max-width: 600px) { .analysis-section, .quick-links-section { padding: 18px; } .chart-wrap { height: 230px; } }
    </style>
</head>
<body>

    <!-- Sidebar Admin -->
    <aside class="sidebar">
        <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
            <div class="brand-text">
                <h2>GRIYA RIAS</h2>
                <h1 class="brand-title">Elly Jr.</h1>
                <p class="brand-sub">Area Admin</p>
            </div>
        </a>
        <div class="admin-sidebar-user">
            <span class="admin-sidebar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            <div style="min-width:0;">
                <strong>{{ auth()->user()->name }}</strong>
                <small>Administrator</small>
            </div>
        </div>
        
        <nav>
            <ul class="nav-menu">
                <li class="admin-nav-label">MENU UTAMA</li>
                <li><a href="{{ route('admin.dashboard') }}" class="nav-item active"><i class="fa-solid fa-shapes"></i> Dashboard</a></li>
                <li><a href="{{ route('admin.layanan.index') }}" class="nav-item"><i class="fa-solid fa-scissors"></i> Katalog Layanan</a></li>
                <li><a href="{{ route('admin.paket.index') }}" class="nav-item"><i class="fa-solid fa-box-open"></i> Katalog Paket</a></li>
                <li><a href="{{ route('admin.kategori-paket.index') }}" class="nav-item"><i class="fa-solid fa-tags"></i> Kategori Paket</a></li>
                <li><a href="{{ route('admin.portofolio.index') }}" class="nav-item"><i class="fa-solid fa-images"></i> Galeri Portofolio</a></li>
                
                <li class="admin-nav-label admin-nav-spaced">AKTIVITAS &amp; AKUN</li>
                
                <!-- MENU JADWAL ACARA DENGAN BADGE NOTIFIKASI -->
                <li>
                    <a href="{{ route('admin.jadwal.index') }}" class="nav-item {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}">
                        <i class="fa-regular fa-calendar"></i> Jadwal Acara
                        @if(isset($pendingReservationsCount) && $pendingReservationsCount > 0)
                            <span class="badge-notification">{{ $pendingReservationsCount }}</span>
                        @endif
                    </a>
                </li>

                <li>
            <a href="{{ route('admin.laporan.transaksi') }}" class="nav-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-column"></i> Laporan Transaksi
                @if(isset($newPaidPaymentsCount) && $newPaidPaymentsCount > 0)
                    <span class="badge-paid" title="Pembayaran Lunas Baru">{{ $newPaidPaymentsCount }}</span>
                @endif
            </a>
        </li>
                <li><a href="{{ route('admin.users.index') }}" class="nav-item"><i class="fa-solid fa-users-gear"></i> Kelola Akun</a></li>
                <li><a href="{{ route('user.profile.edit') }}" class="nav-item {{ request()->routeIs('user.profile.*') ? 'active' : '' }}"><i class="fa-solid fa-user-gear"></i> Pengaturan Akun</a></li>
            </ul>
        </nav>
        
        <div class="sidebar-footer">
             <a href="{{ route('home') }}" class="btn-sidebar-home">
                 <i class="fa-solid fa-globe"></i> Halaman Utama
             </a>
             
             <form id="logout-form-admin" action="{{ route('logout') }}" method="POST" style="margin: 0;">
                 @csrf
                 <button type="button" class="btn-sidebar-logout" onclick="confirmLogout('logout-form-admin')">
                     <i class="fa-solid fa-right-from-bracket"></i> Keluar Akun
                 </button>
             </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Dashboard Overview</h1>
        </div>

        <!-- Stats Grid Berbingkai Ikon -->
        <!-- Stats Grid Berbingkai Ikon -->
        <div class="stats-grid">
            <a class="stat-card" href="{{ route('admin.laporan.transaksi') }}" aria-label="Buka laporan transaksi">
                <div class="stat-icon"><i class="fa-solid fa-wallet"></i></div>
                <div>
                    <div class="stat-title">Total Pendapatan Bulan Ini</div>
                    <div class="stat-value">Rp {{ number_format($pendapatanBulanIni ?? 0, 0, ',', '.') }}</div>
                </div>
            </a>
            <a class="stat-card" href="{{ route('admin.jadwal.index') }}" aria-label="Buka jadwal acara">
                <div class="stat-icon"><i class="fa-regular fa-calendar-check"></i></div>
                <div>
                    <div class="stat-title">Total Reservasi</div>
                    <div class="stat-value">{{ $totalReservasi ?? 0 }} Acara</div>
                </div>
            </a>
            <a class="stat-card" href="{{ route('admin.users.index') }}" aria-label="Buka kelola akun client">
                <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                <div>
                    <div class="stat-title">Client Aktif</div>
                    <div class="stat-value">{{ $clientAktif ?? 0 }} User</div>
                </div>
            </a>
        </div>

        <section class="analysis-section" aria-labelledby="analysis-title">
            <h2 class="section-heading" id="analysis-title">Analisis Reservasi</h2>
            <p class="section-caption">Jumlah reservasi berdasarkan tanggal acara selama enam bulan terakhir.</p>
            <div class="chart-wrap">
                <canvas id="reservationChart" aria-label="Grafik jumlah reservasi enam bulan terakhir" role="img"></canvas>
            </div>
        </section>

        <div class="insight-grid" style="margin-top: 24px;">
            <section class="analysis-section" aria-labelledby="revenue-trend-title">
                <h2 class="section-heading" id="revenue-trend-title">Tren Pendapatan Bulanan</h2>
                <p class="section-caption">Pembayaran terkonfirmasi yang diterima per bulan selama enam bulan terakhir.</p>
                <div class="chart-wrap">
                    <canvas id="revenueTrendChart" aria-label="Grafik tren pendapatan bulanan" role="img"></canvas>
                </div>
            </section>

            <section class="analysis-section" aria-labelledby="product-chart-title">
                <h2 class="section-heading" id="product-chart-title">Paket &amp; Layanan Terlaris</h2>
                <p class="section-caption">Proporsi jumlah pesanan berdasarkan nama paket dan layanan.</p>
                <div class="chart-wrap">
                    <canvas id="productMixChart" aria-label="Diagram paket dan layanan terlaris" role="img"></canvas>
                </div>
            </section>
        </div>

        <section class="analysis-section" aria-labelledby="upcoming-events-title">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:12px; margin-bottom:16px;">
                <div>
                    <h2 class="section-heading" id="upcoming-events-title">Jadwal Acara Terdekat</h2>
                    <p class="section-caption" style="margin-bottom:0;">Agenda tervalidasi dalam tujuh hari ke depan.</p>
                </div>
                <a href="{{ route('admin.jadwal.index') }}" style="color:var(--gold-hover); text-decoration:none; font-size:.82rem; font-weight:800; white-space:nowrap;">Semua jadwal <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="agenda-list">
                @forelse($agendaMendatang as $agenda)
                    <div class="agenda-item">
                        <div>
                            <div class="agenda-client">{{ $agenda->user->name ?? 'Client' }}</div>
                            <div class="agenda-event">{{ $agenda->nama_paket ?: ($agenda->jenis_acara ?: 'Acara') }}</div>
                        </div>
                        <time class="agenda-date" datetime="{{ \Carbon\Carbon::parse($agenda->tanggal_acara)->toDateString() }}">{{ \Carbon\Carbon::parse($agenda->tanggal_acara)->translatedFormat('d M Y') }}</time>
                    </div>
                @empty
                    <p class="agenda-empty">Belum ada acara tervalidasi untuk tujuh hari ke depan.</p>
                @endforelse
            </div>
        </section>

        <!-- Table Section -->
        <div class="table-section">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid var(--border-color); padding-bottom: 12px;">
                <h2 class="table-header" style="margin-bottom: 0; border-bottom: none; padding-bottom: 0;">Daftar Transaksi Terbaru</h2>
                <a href="{{ route('admin.jadwal.index') }}" style="font-size: 0.82rem; font-weight: 700; color: var(--gold-primary); text-decoration: none;">
                    Kelola Jadwal Acara <i class="fa-solid fa-arrow-right" style="margin-left: 4px;"></i>
                </a>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">No</th>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Layanan / Paket</th>
                        <th>Tgl Acara</th>
                        <th>Nominal</th>
                        <th>Status Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksiTerbaru as $item)
                        <tr>
                            <td style="text-align: center; color: var(--text-muted); font-weight: 700;">
                                {{ $loop->iteration }}
                            </td>
                            <td style="color: var(--text-muted); font-weight: 700;">
                                {{ $item->kode_reservasi ?? '#GR-' . str_pad($item->id_reservasi, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td>
                                <strong>{{ $item->user->name ?? 'Client' }}</strong>
                            </td>
                            <td>
                                @if($item->jenis_pesanan === 'paket')
                                    {{ $item->nama_paket ?? $item->paket?->nama_paket ?? 'Paket Rias' }}
                                @elseif($item->layanans && $item->layanans->isNotEmpty())
                                    {{ $item->layanans->pluck('nama_layanan')->join(', ') }}
                                @else
                                    {{ $item->nama_layanan ?? $item->layanan?->nama_layanan ?? 'Layanan Rias' }}
                                @endif
                            </td>
                            <td>
                                @php
                                    $tgl = $item->tanggal_acara ?? $item->tgl_acara;
                                @endphp
                                {{ $tgl ? \Carbon\Carbon::parse($tgl)->format('d M Y') : '-' }}
                            </td>
                            <td style="font-weight: 700;">
                                @php
                                    $nominal = $item->biaya_sewa ?? $item->harga_paket ?? $item->harga_layanan ?? 0;
                                @endphp
                                Rp {{ number_format($nominal, 0, ',', '.') }}
                            </td>
                            <td>
                                @php
                                    $payStatus = strtolower($item->payment_status ?? 'unpaid');
                                @endphp

                                @if(in_array($payStatus, ['paid', 'settlement', 'lunas', 'capture']))
                                    <span class="status-badge status-lunas">Lunas 100%</span>
                                @elseif(in_array($payStatus, ['dp', 'dp_verified', 'partial']))
                                    <span class="status-badge status-dp">DP Verified</span>
                                @elseif(in_array($payStatus, ['expire', 'cancel', 'deny', 'failed']))
                                    <span class="status-badge" style="background-color: #FEF2F2; color: #DC2626; border: 1px solid #FCA5A5;">Gagal / Batal</span>
                                @else
                                    <span class="status-badge" style="background-color: #FFFBEB; color: #B45309; border: 1px solid #FDE68A;">Unpaid / Pending</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 24px;">
                                Belum ada data transaksi reservasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
    const reservationAnalysis = @json($analisisReservasi ?? []);
    const revenueTrend = @json($trenPendapatan ?? []);
    const productMix = @json($ringkasanProduk ?? []);
    const reservationCanvas = document.getElementById('reservationChart');
    if (reservationCanvas && window.Chart) {
        new Chart(reservationCanvas, {
            type: 'bar',
            data: {
                labels: reservationAnalysis.map(item => item.label),
                datasets: [{
                    label: 'Jumlah reservasi',
                    data: reservationAnalysis.map(item => item.total),
                    backgroundColor: 'rgba(197, 143, 67, 0.72)',
                    borderColor: '#C58F43',
                    borderWidth: 1,
                    borderRadius: 7,
                    maxBarThickness: 48
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#EFE8DE' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    const revenueCanvas = document.getElementById('revenueTrendChart');
    if (revenueCanvas && window.Chart) {
        new Chart(revenueCanvas, {
            type: 'line',
            data: {
                labels: revenueTrend.map(item => item.label),
                datasets: [{
                    label: 'Pendapatan',
                    data: revenueTrend.map(item => item.total),
                    borderColor: '#A87632',
                    backgroundColor: 'rgba(197, 143, 67, 0.16)',
                    pointBackgroundColor: '#C58F43',
                    pointBorderColor: '#FFFFFF',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    fill: true,
                    tension: 0.35
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { callbacks: { label: context => 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y) } } },
                scales: {
                    y: { beginAtZero: true, ticks: { callback: value => 'Rp ' + new Intl.NumberFormat('id-ID', { notation: 'compact' }).format(value) }, grid: { color: '#EFE8DE' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    const productCanvas = document.getElementById('productMixChart');
    if (productCanvas && window.Chart) {
        new Chart(productCanvas, {
            type: 'doughnut',
            data: {
                labels: Object.keys(productMix),
                datasets: [{
                    data: Object.values(productMix),
                    backgroundColor: ['#C58F43', '#8F6234', '#E6C99F', '#6B8F71', '#C96C5B', '#7187A3', '#B68AA0', '#A59A8E'],
                    borderColor: '#FFFFFF', borderWidth: 3
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 10, padding: 12, font: { size: 11 } } },
                    tooltip: { callbacks: { label: context => {
                        const total = context.dataset.data.reduce((sum, value) => sum + value, 0);
                        const percentage = total ? ((context.parsed / total) * 100).toFixed(1) : 0;
                        return `${context.label}: ${context.parsed} pesanan (${percentage}%)`;
                    } } }
                }
            }
        });
    }

    function confirmLogout(formId) {
        Swal.fire({
            title: 'Konfirmasi Keluar',
            text: 'Apakah Anda yakin ingin keluar dari akun ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#C58F43',
            cancelButtonColor: '#8C8279',
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            background: '#FFFFFF',
            color: '#241A16'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#C58F43',
                background: '#FFFFFF',
                color: '#241A16'
            });
        @endif
    });
    document.addEventListener('DOMContentLoaded', function() {
        const paidCount = {{ $newPaidPaymentsCount ?? 0 }};
        const prevPaidCount = Number(sessionStorage.getItem('admin_prev_paid_count') || 0);

        if (paidCount > prevPaidCount) {
            playAdminNotifSound();
        }
        sessionStorage.setItem('admin_prev_paid_count', paidCount);
    });

    function playAdminNotifSound() {
        try {
            const AudioCtx = window.AudioContext || window.webkitAudioContext;
            const ctx = new AudioCtx();
            const now = ctx.currentTime;

            // Nada kasir / coin masuk (B5 -> E6)
            const notes = [987.77, 1318.51];

            notes.forEach((freq, i) => {
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                const startTime = now + (i * 0.11);

                osc.type = 'sine';
                osc.frequency.setValueAtTime(freq, startTime);

                gain.gain.setValueAtTime(0.001, startTime);
                gain.gain.exponentialRampToValueAtTime(0.25, startTime + 0.015);
                gain.gain.exponentialRampToValueAtTime(0.0001, startTime + 0.45);

                osc.connect(gain);
                gain.connect(ctx.destination);

                osc.start(startTime);
                osc.stop(startTime + 0.46);
            });
        } catch (e) {}
    }
</script>
</body>
</html>
