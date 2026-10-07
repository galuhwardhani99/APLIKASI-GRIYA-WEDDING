<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Katalog - Admin Griya Rias Elly Jr.</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #241A16;
            --bg-sidebar: #33231D;
            --gold-primary: #C58F43;
            --gold-hover: #A87632;
            --text-light: #FDFBF8;
            --text-muted: #A0948D;
            --border-color: #4A362D;
            --bg-modal: #FDFBF8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-light);
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background-color: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .sidebar-brand {
            text-align: center;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-brand h2 {
            font-family: 'Playfair Display', serif;
            color: var(--gold-primary);
            font-size: 1.2rem;
            margin-bottom: 4px;
        }

        .sidebar-brand p {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .nav-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .nav-item {
            padding: 12px 16px;
            border-radius: 8px;
            color: var(--text-light);
            text-decoration: none;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s;
        }

        .nav-item:hover {
            background-color: rgba(197, 143, 67, 0.1);
        }

        .nav-item.active {
            background-color: var(--gold-primary);
            color: #fff;
            font-weight: 600;
        }

        /* Main Content Styling */
        .main-content {
            flex: 1;
            padding: 40px;
        }

        .header-action {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            color: var(--gold-primary);
            font-size: 1.5rem;
        }

        .btn-gold {
            background-color: var(--gold-primary);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-gold:hover {
            background-color: var(--gold-hover);
        }

        /* Table Styling */
        .table-container {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background-color: rgba(0,0,0,0.2);
            color: var(--gold-primary);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
        }

        td {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.95rem;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .badge-active {
            background-color: rgba(46, 125, 50, 0.2);
            color: #81C784;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .action-btns {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            color: #fff;
        }

        .btn-edit { background-color: #3B82F6; }
        .btn-delete { background-color: #EF4444; }

        /* Modal Styling */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: none; /* Ubah ke flex via JS untuk menampilkan */
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-card {
            background-color: var(--bg-modal);
            border: 4px solid var(--gold-primary);
            border-radius: 12px;
            width: 100%;
            max-width: 500px;
            padding: 24px;
            color: #333;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #E0DCD3;
            padding-bottom: 12px;
        }

        .modal-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            color: #333;
            font-weight: 700;
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #888;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .modal-card label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: #4A4A4A;
        }

        .modal-card input, .modal-card textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #E0DCD3;
            border-radius: 6px;
            font-family: inherit;
            font-size: 0.9rem;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .btn-cancel {
            flex: 1;
            background-color: #D1D5DB;
            color: #374151;
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
        }
        
        .btn-save {
            flex: 1;
            background-color: var(--gold-primary);
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
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
            <nav>
    <ul class="nav-menu">
        <li><a href="{{ route('admin.dashboard') }}" class="nav-item"><i class="fa-solid fa-shapes"></i> Dashboard</a></li>
        <li><a href="{{ route('admin.katalog.index') }}" class="nav-item active"><i class="fa-solid fa-box-open"></i> Kelola Katalog</a></li>
        <li><a href="#" class="nav-item"><i class="fa-regular fa-calendar"></i> Jadwal Acara</a></li>
        <li><a href="#" class="nav-item"><i class="fa-solid fa-chart-column"></i> Laporan Transaksi</a></li>
    </ul>
</nav> 
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="header-action">
            <h1 class="page-title">Daftar Paket Rias &amp; WO</h1>
            <button class="btn-gold" onclick="openModal()">+ Tambah Paket Baru</button>
        </div>

        <div class="table-container">
            <table>
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
            <td>{{ $paket->nama_paket }}</td>
            <td>{{ $paket->kategori }}</td>
            <td style="color: var(--gold-primary); font-weight: 600;">Rp {{ number_format($paket->harga, 0, ',', '.') }}</td>
            <td><span class="badge-active">{{ $paket->status }}</span></td>
            <td class="action-btns">
                <!-- Tombol Edit (Tugas selanjutnya: mengoper data ke modal) -->
                <button class="btn-sm btn-edit" onclick="openModalEdit({{ $paket }})">Edit</button>
                
                <!-- Form Hapus -->
                <form action="{{ route('admin.katalog.destroy', $paket->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-sm btn-delete">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" style="text-align: center; color: var(--text-muted);">Belum ada data paket layanan.</td>
        </tr>
    @endforelse
</tbody>
            </table>
        </div>
    </main>

    <!-- Modal Form Tambah/Edit -->
    <!-- Modal Form Tambah/Edit -->
    <div class="modal-overlay" id="packageModal">
        <div class="modal-card">
            <div class="modal-header">
                <h2 class="modal-title" id="modalTitle">Tambah Paket Layanan</h2>
                <button class="btn-close" onclick="closeModal()">&times;</button>
            </div>
            
            <!-- Beri ID pada form agar mudah dimanipulasi JS -->
            <form id="paketForm" action="{{ route('admin.katalog.store') }}" method="POST">
                @csrf
                
                <!-- Input ini akan diaktifkan lewat JS jika sedang mode Edit -->
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

    <!-- Script Kontrol Modal -->
    <!-- Script Kontrol Modal -->
    <script>
        const modal = document.getElementById('packageModal');
        const form = document.getElementById('paketForm');
        const modalTitle = document.getElementById('modalTitle');
        const methodField = document.getElementById('methodField');

        // URL dasar untuk store (Tambah Data)
        const storeUrl = "{{ route('admin.katalog.store') }}";

        // Fungsi untuk mode Tambah
        function openModal() {
            modalTitle.innerText = "Tambah Paket Layanan";
            form.action = storeUrl;
            methodField.value = "POST";
            
            // Reset isi form
            form.reset();
            
            modal.style.display = 'flex';
        }

        // Fungsi untuk mode Edit
        function openModalEdit(paket) {
            modalTitle.innerText = "Edit Paket Layanan";
            
            // Ubah action form ke rute update (contoh: /admin/katalog/1)
            form.action = `/admin/katalog/${paket.id}`;
            methodField.value = "PUT"; // Framework Laravel butuh ini untuk metode update
            
            // Isi nilai input form dengan data yang ada
            document.getElementById('nama_paket').value = paket.nama_paket;
            document.getElementById('kategori').value = paket.kategori;
            document.getElementById('harga').value = paket.harga;
            document.getElementById('deskripsi').value = paket.deskripsi;
            
            modal.style.display = 'flex';
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        // Tutup modal jika user mengklik area luar kotak form
        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>