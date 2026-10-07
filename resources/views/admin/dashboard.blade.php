<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Griya Rias Elly Jr.</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS SweetAlert2 untuk Popup -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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
        
        /* Header Dashboard + Tombol Unduh */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }
        .btn-pdf {
            background-color: var(--gold-primary);
            color: #fff;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .btn-pdf:hover {
            background-color: #a87632;
            transform: translateY(-1px);
        }

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
            background-color: rgba(36, 26, 22, 0.5);
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

        /* ================= MODAL PREVIEW STYLING (SUDAH PRESISI & BISA DI-SCROLL) ================= */
        .modal-overlay {
            position: fixed;
            top: 0; 
            left: 0; 
            width: 100vw; 
            height: 100vh;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            backdrop-filter: blur(5px);
            padding: 20px;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-container {
            background-color: #2a1d18;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            width: 100%;
            max-width: 800px;
            height: 85vh; /* Mengunci tinggi modal agar konsisten */
            display: flex;
            flex-direction: column;
            box-shadow: 0 20px 40px rgba(0,0,0,0.6);
            overflow: hidden;
        }

        .modal-header-bar {
            padding: 16px 24px;
            background-color: var(--bg-sidebar);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0; /* Header tetap diam di atas */
        }

        .modal-title {
            font-family: 'Playfair Display', serif;
            color: var(--gold-primary);
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Area Bodi tempat Kertas A4 yang Bisa Di-scroll */
        .modal-body-preview {
            padding: 24px;
            overflow-y: auto; /* Mengaktifkan scrollbar internal */
            background-color: #1a120e;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            flex: 1; /* Mengisi seluruh sisa ruang tengah */
        }

        /* Scrollbar Kustom Tema Emas/Cokelat */
        .modal-body-preview::-webkit-scrollbar {
            width: 8px;
        }
        .modal-body-preview::-webkit-scrollbar-track {
            background: #1a120e;
        }
        .modal-body-preview::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
        }
        .modal-body-preview::-webkit-scrollbar-thumb:hover {
            background: var(--gold-primary);
        }

        /* Lembar Kertas Preview A4 */
        .paper-preview {
            background-color: #ffffff;
            color: #241A16;
            width: 100%;
            max-width: 680px;
            padding: 32px;
            border-radius: 6px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.4);
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0 auto 20px auto;
        }

        .paper-header {
            text-align: center;
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 2px solid #241A16;
        }

        .paper-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            color: #241A16;
            margin-bottom: 4px;
        }

        .paper-header p {
            font-size: 0.8rem;
            color: #666;
        }

        .paper-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        .paper-stat {
            border: 1px solid #e0e0e0;
            padding: 12px;
            border-radius: 6px;
            background-color: #fafafa;
        }

        .paper-stat-title {
            font-size: 0.65rem;
            color: #B9833B;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .paper-stat-val {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: #241A16;
        }

        .paper-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        .paper-table th {
            background-color: #f4f4f4;
            color: #241A16;
            text-align: left;
            padding: 10px 8px;
            border-bottom: 2px solid #ccc;
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .paper-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #eee;
            color: #333;
        }

        .modal-footer-bar {
            padding: 16px 24px;
            background-color: var(--bg-sidebar);
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            flex-shrink: 0; /* Footer tetap dikunci di bawah modal */
        }
        
        .btn-cancel {
            background-color: transparent;
            color: var(--text-muted);
            border: 1px solid var(--border-color);
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }
        .btn-cancel:hover { background-color: rgba(255,255,255,0.05); color: #fff; }

        /* ================= MEDIA PRINT ================= */
        @media print {
            body * {
                visibility: hidden !important;
            }
            #paper-preview, #paper-preview * {
                visibility: visible !important;
            }
            #paper-preview {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                box-shadow: none !important;
                padding: 0 !important;
            }
            .modal-overlay {
                background: none !important;
            }
        }
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
        
        <div style="margin-top: auto;">
             <a href="{{ route('home') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.85rem; display: flex; align-items: center; gap: 8px;"><i class="fa-solid fa-arrow-left"></i> Halaman Utama</a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">

        <!-- Dashboard Header Bar -->
        <div class="dashboard-header">
            <h1 style="font-family: 'Playfair Display', serif; color: var(--gold-primary); font-size: 1.5rem;">Dashboard Overview</h1>
            <button onclick="openPreviewModal()" class="btn-pdf">
                <i class="fa-solid fa-file-pdf"></i> Unduh Laporan PDF
            </button>
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

    <!-- ================= MODAL PREVIEW PRATINJAU PDF ================= -->
    <div class="modal-overlay" id="previewModal">
        <div class="modal-container">
            <div class="modal-header-bar">
                <div class="modal-title"><i class="fa-solid fa-eye"></i> Pratinjau Laporan PDF</div>
                <button onclick="closePreviewModal()" style="background:none; border:none; color:var(--text-muted); cursor:pointer; font-size:1.2rem;"><i class="fa-solid fa-xmark"></i></button>
            </div>
            
            <div class="modal-body-preview">
                <!-- Lembaran Kertas A4 yang Akan Dicetak -->
                <div class="paper-preview" id="paper-preview">
                    <div class="paper-header">
                        <h2>LAPORAN DASHBOARD ADMIN</h2>
                        <p>Griya Rias Elly Jr. - Dicetak pada: {{ date('d F Y') }}</p>
                    </div>

                    <div class="paper-grid">
                        <div class="paper-stat">
                            <div class="paper-stat-title">Total Pendapatan</div>
                            <div class="paper-stat-val">Rp 48.500.000</div>
                        </div>
                        <div class="paper-stat">
                            <div class="paper-stat-title">Total Reservasi</div>
                            <div class="paper-stat-val">18 Acara</div>
                        </div>
                        <div class="paper-stat">
                            <div class="paper-stat-title">Pelanggan Aktif</div>
                            <div class="paper-stat-val">124 User</div>
                        </div>
                    </div>

                    <h4 style="font-size: 0.95rem; margin-bottom: 12px; font-family: 'Playfair Display', serif;">Daftar Transaksi Terbaru</h4>
                    <table class="paper-table">
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
                                <td>#GR-0892</td>
                                <td>Siti Rahmawati</td>
                                <td>Rias Akad & Resepsi Gold</td>
                                <td>06 Oct 2026</td>
                                <td>DP Verified</td>
                            </tr>
                            <tr>
                                <td>#GR-0891</td>
                                <td>Anisa Putri</td>
                                <td>WO Package Intimate</td>
                                <td>12 Oct 2026</td>
                                <td>Lunas 100%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer-bar">
                <button onclick="closePreviewModal()" class="btn-cancel">Batal</button>
                <button onclick="window.print()" class="btn-pdf">
                    <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
                </button>
            </div>
        </div>
    </div>

    <!-- Script SweetAlert2 & Modal JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openPreviewModal() {
            document.getElementById('previewModal').classList.add('show');
        }

        function closePreviewModal() {
            document.getElementById('previewModal').classList.remove('show');
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Login',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#C58F43',
                    background: '#33231D',
                    color: '#FDFBF8'
                });
            @endif
        });
    </script>
</body>
</html>