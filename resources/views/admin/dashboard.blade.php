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
        .nav-menu::-webkit-scrollbar-thumb { background:#EFE8DE; border-radius:4px; }
        
        .admin-nav-label { font-size:.65rem; letter-spacing:.15em; font-weight:800; color:#A59A8E; padding:10px 12px 4px; }
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
        }
        .stat-card:hover {
            border-color: var(--gold-primary);
            transform: translateY(-2px);
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
                <li><a href="{{ route('admin.jadwal.index') }}" class="nav-item"><i class="fa-regular fa-calendar"></i> Jadwal Acara</a></li>
                <li><a href="#" class="nav-item"><i class="fa-solid fa-chart-column"></i> Laporan Transaksi</a></li>
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
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-wallet"></i></div>
                <div>
                    <div class="stat-title">Total Pendapatan Bulan Ini</div>
                    <div class="stat-value">Rp 48.500.000</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fa-regular fa-calendar-check"></i></div>
                <div>
                    <div class="stat-title">Total Reservasi</div>
                    <div class="stat-value">18 Acara</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                <div>
                    <div class="stat-title">Client Aktif</div>
                    <div class="stat-value">124 User</div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-section">
            <h2 class="table-header">Daftar Transaksi Terbaru</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Layanan</th>
                        <th>Tgl Acara</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="color: var(--text-muted); font-weight: 700;">#GR-0892</td>
                        <td><strong>Siti Rahmawati</strong></td>
                        <td>Rias Akad &amp; Resepsi Gold</td>
                        <td>06 Oct 2026</td>
                        <td><span class="status-badge status-dp">DP Verified</span></td>
                    </tr>
                    <tr>
                        <td style="color: var(--text-muted); font-weight: 700;">#GR-0891</td>
                        <td><strong>Anisa Putri</strong></td>
                        <td>WO Package Intimate</td>
                        <td>12 Oct 2026</td>
                        <td><span class="status-badge status-lunas">Lunas 100%</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
</script>
</body>
</html>