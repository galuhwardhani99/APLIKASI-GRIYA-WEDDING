<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Griya Rias Elly Jr.</title>
    
    <!-- FAVICON (Logo di Tab Browser) -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}">

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS SweetAlert2 untuk Popup -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            /* Tema Cerah / Light Theme sesuai Figma Client */
            --bg-light: #FDFBF7; 
            --bg-card: #FFFFFF; 
            --gold-primary: #C58F43;
            --gold-hover: #A87632;
            --text-dark: #241A16; 
            --text-muted: #8C8279; 
            --border-color: #EFE8DE;
            --success-color: #2e7d32;
            --warning-color: #b9770e;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            background-color: var(--bg-light); 
            color: var(--text-dark); 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            display: flex; 
            min-height: 100vh; 
        }
        
        /* Sidebar Styles Tema Cerah */
        .sidebar { 
            width: 260px; 
            background-color: var(--bg-card); 
            border-right: 1px solid var(--border-color); 
            padding: 24px 16px; 
            display: flex; 
            flex-direction: column; 
            gap: 20px; 
            box-shadow: 2px 0 10px rgba(0,0,0,0.02);
        }

        /* Header Brand dengan Logo + Teks Flex */
        .sidebar-brand { 
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 20px; 
            border-bottom: 1px solid var(--border-color); 
        }

        .sidebar-brand img { display:none; }
        .sidebar-brand { align-items:flex-start; padding-left:12px; }

        .sidebar-brand img {
            width: 42px;
            height: 42px;
            object-fit: cover;
            border-radius: 6px;
        }

        .brand-text h2 { 
            font-family: 'Playfair Display', serif; 
            color: var(--gold-primary); 
            font-size: 0.67rem; 
            letter-spacing: .2em;
            line-height: 1.2;
            margin-bottom: 2px;
        }

        .brand-text p { 
            font-size: 0.78rem; 
            color: var(--text-muted); 
        }

        .admin-sidebar-user { display:flex; align-items:center; gap:11px; padding:16px 8px; border-bottom:1px solid var(--border-color); }
        .admin-sidebar-avatar { width:40px; height:40px; border-radius:50%; display:grid; place-items:center; background:#f4e6d2; color:#93622d; font-weight:800; }
        .admin-sidebar-user strong,.admin-sidebar-user small { display:block; }
        .admin-sidebar-user strong { font-size:.86rem; }
        .admin-sidebar-user small { color:var(--text-muted); font-size:.72rem; margin-top:3px; }
        .admin-nav-label { list-style:none; font-size:.65rem; letter-spacing:.12em; font-weight:800; color:#a59a8e; padding:2px 12px 4px; }

        .nav-menu { list-style: none; display: flex; flex-direction: column; gap: 5px; }
        .nav-item { 
            padding: 11px 12px; 
            border-radius: 8px; 
            color: var(--text-dark); 
            text-decoration: none; 
            font-size: 0.88rem; 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            transition: all 0.2s; 
            font-weight: 500;
        }
        .nav-item i { width: 20px; text-align: center; font-size: 1.1rem; color: var(--text-muted); }
        .nav-item:hover { background-color: rgba(197, 143, 67, 0.08); color: var(--gold-primary); }
        .nav-item.active { background-color: var(--gold-primary); color: #fff; font-weight: 600; }
        .nav-item.active i { color: #fff; }

        /* ================= SIDEBAR BOTTOM ACTIONS ================= */
        .sidebar-footer {
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .btn-sidebar-home {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 8px;
            color: var(--text-dark);
            background-color: var(--bg-light);
            border: 1px solid var(--border-color);
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-sidebar-home:hover {
            background-color: rgba(197, 143, 67, 0.12);
            color: var(--gold-primary);
            border-color: var(--gold-primary);
        }

        .btn-sidebar-logout {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 8px;
            color: #DC2626;
            background-color: #FEF2F2;
            border: 1px solid #FCA5A5;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .btn-sidebar-logout:hover {
            background-color: #FEE2E2;
            color: #991B1B;
            border-color: #F87171;
        }
        
        /* Main Content */
        .main-content { flex: 1; padding: 40px; }
        
        /* Header Dashboard */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        /* Stats Grid Tema Cerah */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }
        .stat-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        }
        .stat-title {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .stat-value {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            color: var(--text-dark);
            font-weight: 700;
        }

        /* Table Section Tema Cerah */
        .table-section {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        }
        .table-header {
            font-family: 'Playfair Display', serif;
            color: var(--text-dark);
            font-size: 1.25rem;
            margin-bottom: 20px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table th {
            text-align: left;
            padding: 12px;
            font-size: 0.75rem;
            color: var(--gold-primary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid var(--border-color);
            background-color: #FAFAFA;
        }
        .data-table td {
            padding: 16px 12px;
            font-size: 0.9rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-dark);
        }
        .data-table tr:last-child td { border-bottom: none; }
        
        /* Status Badges */
        .status-badge {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-dp { background-color: #FFF3E0; color: #E65100; border: 1px solid #FFE0B2; }
        .status-lunas { background-color: #E8F5E9; color: #2E7D32; border: 1px solid #C8E6C9; }
    </style>
</head>
<body>

    <!-- Sidebar Admin -->
    <aside class="sidebar">
        <!-- Brand + Logo Sidebar -->
        <div class="sidebar-brand">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Griya Rias Elly Jr.">
            <div class="brand-text">
                <h2>GRIYA RIAS</h2>
                <p style="font-family:'Playfair Display',serif;font-size:1.25rem;color:#241a16;font-weight:700;">Elly Jr.</p>
                <p>Area Admin</p>
            </div>
        </div>
        <div class="admin-sidebar-user">
            <span class="admin-sidebar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            <div><strong>{{ auth()->user()->name }}</strong><small>Administrator</small></div>
        </div>
        
        <nav>
            <ul class="nav-menu">
                <li class="admin-nav-label">MENU UTAMA</li>
                <li><a href="{{ route('admin.dashboard') }}" class="nav-item active"><i class="fa-solid fa-shapes"></i> Dashboard</a></li>
                <li><a href="{{ route('admin.layanan.index') }}" class="nav-item"><i class="fa-solid fa-scissors"></i> Kelola Layanan</a></li>
                <li><a href="{{ route('admin.paket.index') }}" class="nav-item"><i class="fa-solid fa-box-open"></i> Kelola Paket</a></li>
                <li><a href="{{ route('admin.kategori-paket.index') }}" class="nav-item"><i class="fa-solid fa-tags"></i> Kategori Paket</a></li>
                <li><a href="{{ route('admin.portofolio.index') }}" class="nav-item"><i class="fa-solid fa-images"></i> Galeri Portofolio</a></li>
                
                <li class="admin-nav-label" style="padding-top:14px;">AKTIVITAS</li>
                <li><a href="{{ route('admin.jadwal.index') }}" class="nav-item"><i class="fa-regular fa-calendar"></i> Jadwal Acara</a></li>
                <li><a href="#" class="nav-item"><i class="fa-solid fa-chart-column"></i> Laporan Transaksi</a></li>
            </ul>
        </nav>
        
        <!-- Bottom Actions -->
        <div class="sidebar-footer">
             <a href="{{ route('home') }}" class="btn-sidebar-home">
                 <i class="fa-solid fa-globe"></i> Halaman Utama
             </a>
             
             <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                 @csrf
                 <button type="submit" class="btn-sidebar-logout">
                     <i class="fa-solid fa-right-from-bracket"></i> Keluar Akun
                 </button>
             </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">

        <!-- Dashboard Header Bar -->
        <div class="dashboard-header">
            <h1 style="font-family: 'Playfair Display', serif; color: var(--text-dark); font-size: 1.5rem;">Dashboard Overview</h1>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-title">Total Pendapatan Bulan Ini</div>
                <div class="stat-value">Rp 48.500.000</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Total Reservasi</div>
                <div class="stat-value">18 Acara</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Pelanggan Aktif</div>
                <div class="stat-value">124 User</div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-section">
            <h2 class="table-header">Daftar Transaksi Terbaru</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Tgl Acara</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="color: var(--text-muted);">#GR-0892</td>
                        <td>Siti Rahmawati</td>
                        <td>Rias Akad & Resepsi Gold</td>
                        <td>06 Oct 2026</td>
                        <td><span class="status-badge status-dp">DP Verified</span></td>
                    </tr>
                    <tr>
                        <td style="color: var(--text-muted);">#GR-0891</td>
                        <td>Anisa Putri</td>
                        <td>WO Package Intimate</td>
                        <td>12 Oct 2026</td>
                        <td><span class="status-badge status-lunas">Lunas 100%</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Script SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Login',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#C58F43',
                    background: '#FFFFFF',
                    color: '#241A16'
                });
            @endif
        });
    </script>
</body>
</html>