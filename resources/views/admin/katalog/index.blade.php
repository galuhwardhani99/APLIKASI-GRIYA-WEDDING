<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Katalog - Admin Griya Rias Elly Jr.</title>
    
    <!-- FAVICON (Logo di Tab Browser) -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}">
    
    <!-- Google Fonts & Font Awesome Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS SweetAlert2 untuk Popup Notifikasi -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            /* Tema Cerah / Light Theme Konsisten Dengan Dashboard */
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

        .sidebar-brand img {
            width: 42px;
            height: 42px;
            object-fit: cover;
            border-radius: 6px;
        }

        .brand-text h2 { 
            font-family: 'Playfair Display', serif; 
            color: var(--gold-primary); 
            font-size: 1.15rem; 
            line-height: 1.2;
            margin-bottom: 2px; 
        }

        .brand-text p { 
            font-size: 0.78rem; 
            color: var(--text-muted); 
        }

        .nav-menu { list-style: none; display: flex; flex-direction: column; gap: 8px; }
        .nav-item { 
            padding: 12px 16px; 
            border-radius: 8px; 
            color: var(--text-dark); 
            text-decoration: none; 
            font-size: 0.95rem; 
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

        /* ================= SIDEBAR BOTTOM ACTIONS (DESAIN RAPI) ================= */
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

        .header-action {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            color: var(--text-dark);
            font-size: 1.5rem;
        }

        .btn-gold {
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
            box-shadow: 0 4px 12px rgba(197, 143, 67, 0.2);
        }

        .btn-gold:hover {
            background-color: var(--gold-hover);
            transform: translateY(-1px);
        }

        /* Table Styling Tema Cerah */
        .table-section {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            text-align: left;
            padding: 12px 16px;
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

        .badge-active {
            background-color: #E8F5E9;
            color: #2E7D32;
            border: 1px solid #C8E6C9;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .action-btns {
            display: flex;
            gap: 8px;
            justify-content: flex-start;
        }

        .btn-sm {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            color: #fff;
            transition: opacity 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-edit { background-color: #3B82F6; }
        .btn-delete { background-color: #EF4444; }
        .btn-sm:hover { opacity: 0.85; }

        /* Modal Styling Tema Cerah */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            background: rgba(36, 26, 22, 0.6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            backdrop-filter: blur(4px);
            padding: 20px;
        }

        .modal-overlay.show { display: flex; }

        .modal-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            width: 100%;
            max-width: 520px;
            padding: 28px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 12px;
        }

        .modal-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            color: var(--text-dark);
            font-weight: 700;
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: var(--text-muted);
        }

        .form-group { margin-bottom: 16px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

        .modal-card label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            margin-bottom: 6px;
            color: var(--text-dark);
        }

        .modal-card input, .modal-card textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.9rem;
            background-color: #FAFAFA;
            color: var(--text-dark);
        }

        .modal-card input:focus, .modal-card textarea:focus {
            outline: none;
            border-color: var(--gold-primary);
            background-color: #FFF;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .btn-cancel {
            flex: 1;
            background-color: transparent;
            color: var(--text-muted);
            border: 1px solid #D6CEC3;
            padding: 10px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-save {
            flex: 1;
            background-color: var(--gold-primary);
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <!-- Sidebar Admin Panel -->
    <aside class="sidebar">
        <!-- Brand + Logo Sidebar -->
        <div class="sidebar-brand">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Griya Rias Elly Jr.">
            <div class="brand-text">
                <h2>Admin Panel</h2>
                <p>Griya Rias Elly Jr.</p>
            </div>
        </div>

        <nav>
            <ul class="nav-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="nav-item">
                        <i class="fa-solid fa-shapes"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.katalog.index') }}" class="nav-item active">
                        <i class="fa-solid fa-box-open"></i> Kelola Katalog
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.portofolio.index') }}" class="nav-item">
                        <i class="fa-solid fa-images"></i> Galeri Portofolio
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-item">
                        <i class="fa-regular fa-calendar"></i> Jadwal Acara
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-item">
                        <i class="fa-solid fa-chart-column"></i> Laporan Transaksi
                    </a>
                </li>
            </ul>
        </nav>        
        
        <!-- Bottom Actions (Kembali ke Halaman Utama & Logout Mandiri) -->
        <div class="sidebar-footer">
             <!-- Link Halaman Utama Mandiri -->
             <a href="{{ route('home') }}" class="btn-sidebar-home">
                 <i class="fa-solid fa-globe"></i> Halaman Utama
             </a>

             <!-- Form Logout Mandiri -->
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
        <div class="header-action">
            <h1 class="page-title">Daftar Paket Rias &amp; WO</h1>
            <button class="btn-gold" onclick="openModal()">
                <i class="fa-solid fa-plus"></i> Tambah Paket Baru
            </button>
        </div>

        <div class="table-section">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama Paket</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pakets as $paket)
                        <tr>
                            <td style="font-weight: 600;">{{ $paket->nama_paket }}</td>
                            <td style="color: var(--text-muted);">{{ $paket->kategori }}</td>
                            <td style="color: var(--gold-primary); font-weight: 600;">
                                Rp {{ number_format($paket->harga, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="badge-active">{{ $paket->status ?? 'Aktif' }}</span>
                            </td>
                            <td class="action-btns">
                                <button class="btn-sm btn-edit" onclick="openModalEdit({{ json_encode($paket) }})">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>
                                
                                <form action="{{ route('admin.katalog.destroy', $paket->id) }}" method="POST" style="display:inline;" onsubmit="confirmDelete(event, this)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sm btn-delete">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 24px;">Belum ada data paket layanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal Form Tambah / Edit Paket -->
    <div class="modal-overlay" id="packageModal">
        <div class="modal-card">
            <div class="modal-header">
                <h2 class="modal-title" id="modalTitle">Tambah Paket Layanan</h2>
                <button class="btn-close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
            </div>
            
            <form id="paketForm" action="{{ route('admin.katalog.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST">
                
                <div class="form-group">
                    <label>Nama Paket Layanan</label>
                    <input type="text" name="nama_paket" id="nama_paket" placeholder="Contoh: Paket Rias Pengantin Exclusive" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Kategori</label>
                        <input type="text" name="kategori" id="kategori" placeholder="Rias Pengantin" required>
                    </div>
                    <div class="form-group">
                        <label>Harga (Rp)</label>
                        <input type="number" name="harga" id="harga" placeholder="7500000" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Deskripsi Paket</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" placeholder="Tuliskan rincian fasilitas paket..."></textarea>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn-save">Simpan Paket</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Kontrol Modal & Notifikasi SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const modal = document.getElementById('packageModal');
        const form = document.getElementById('paketForm');
        const modalTitle = document.getElementById('modalTitle');
        const methodField = document.getElementById('methodField');

        const storeUrl = "{{ route('admin.katalog.store') }}";

        function openModal() {
            modalTitle.innerText = "Tambah Paket Layanan";
            form.action = storeUrl;
            methodField.value = "POST";
            form.reset();
            modal.classList.add('show');
        }

        function openModalEdit(paket) {
            modalTitle.innerText = "Edit Paket Layanan";
            form.action = `/admin/katalog/${paket.id}`;
            methodField.value = "PUT";
            
            document.getElementById('nama_paket').value = paket.nama_paket || '';
            document.getElementById('kategori').value = paket.kategori || '';
            document.getElementById('harga').value = paket.harga || '';
            document.getElementById('deskripsi').value = paket.deskripsi || '';
            
            modal.classList.add('show');
        }

        function confirmDelete(event, form) {
            event.preventDefault(); // Menghentikan submit bawaan form

            Swal.fire({
                title: 'Hapus Paket Layanan?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#8C8279',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#FFFFFF',
                color: '#241A16'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        function closeModal() {
            modal.classList.remove('show');
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
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