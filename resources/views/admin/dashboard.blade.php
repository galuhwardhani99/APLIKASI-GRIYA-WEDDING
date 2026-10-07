<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Griya Rias Elly Jr.</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-dark: #241A16; 
            --bg-sidebar: #33231D; 
            --gold-primary: #C58F43;
            --text-light: #FDFBF8; 
            --text-muted: #A0948D; 
            --border-color: #4A362D;
            --success-color: #2e7d32;
            --warning-color: #b9770e;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: var(--bg-dark); color: var(--text-light); font-family: 'Plus Jakarta Sans', sans-serif; display: flex; min-height: 100vh; }
        
        /* Sidebar Styles */
        .sidebar { width: 260px; background-color: var(--bg-sidebar); border-right: 1px solid var(--border-color); padding: 24px 16px; display: flex; flex-direction: column; gap: 24px; }
        .sidebar-brand { text-align: center; padding-bottom: 24px; border-bottom: 1px solid var(--border-color); }
        .sidebar-brand h2 { font-family: 'Playfair Display', serif; color: var(--gold-primary); font-size: 1.2rem; margin-bottom: 4px; }
        .sidebar-brand p { font-size: 0.8rem; color: var(--text-muted); }
        .nav-menu { list-style: none; display: flex; flex-direction: column; gap: 8px; }
        .nav-item { padding: 12px 16px; border-radius: 8px; color: var(--text-light); text-decoration: none; font-size: 0.95rem; display: flex; align-items: center; gap: 12px; transition: all 0.2s; }
        .nav-item i { width: 20px; text-align: center; font-size: 1.1rem; color: var(--text-muted); }
        .nav-item:hover { background-color: rgba(197, 143, 67, 0.1); }
        .nav-item.active { background-color: var(--gold-primary); color: #fff; font-weight: 600; }
        .nav-item.active i { color: #fff; }
        
        /* Main Content */
        .main-content { flex: 1; padding: 40px; }
        
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }
        .stat-card {
            background-color: var(--bg-sidebar);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
        }
        .stat-title {
            font-size: 0.75rem;
            color: var(--gold-primary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .stat-value {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            color: var(--text-light);
            font-weight: 700;
        }

        /* Table Section */
        .table-section {
            background-color: var(--bg-sidebar);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
        }
        .table-header {
            font-family: 'Playfair Display', serif;
            color: var(--gold-primary);
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
            border-bottom: 1px solid var(--border-color);
            background-color: rgba(36, 26, 22, 0.5); /* slightly darker than sidebar */
        }
        .data-table td {
            padding: 16px 12px;
            font-size: 0.9rem;
            border-bottom: 1px solid rgba(74, 54, 45, 0.5);
            color: var(--text-light);
        }
        .data-table tr:last-child td { border-bottom: none; }
        
        /* Status Badges */
        .status-badge {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-dp { background-color: rgba(185, 119, 14, 0.2); color: var(--warning-color); border: 1px solid var(--warning-color); }
        .status-lunas { background-color: rgba(46, 125, 50, 0.2); color: #81c784; border: 1px solid var(--success-color); }
    </style>
</head>
<body>

    <!-- Sidebar Admin -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h2>Admin Panel</h2>
            <p>Griya Rias Elly Jr.</p>
        </div>
        <nav>
            <ul class="nav-menu">
                <li><a href="{{ route('admin.dashboard') }}" class="nav-item active"><i class="fa-solid fa-shapes"></i> Dashboard</a></li>
                <li><a href="{{ route('admin.katalog.index') }}" class="nav-item"><i class="fa-solid fa-box-open"></i> Kelola Katalog</a></li>
                <li><a href="#" class="nav-item"><i class="fa-regular fa-calendar"></i> Jadwal Acara</a></li>
                <li><a href="#" class="nav-item"><i class="fa-solid fa-chart-column"></i> Laporan Transaksi</a></li>
            </ul>
        </nav>
        
        <!-- Back to Home Link placed at bottom of sidebar for layout consistency -->
        <div style="margin-top: auto;">
             <a href="{{ route('home') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.85rem; display: flex; align-items: center; gap: 8px;"><i class="fa-solid fa-arrow-left"></i> Halaman Utama</a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
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

</body>
</html>