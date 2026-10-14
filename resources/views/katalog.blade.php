<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Katalog - Admin Griya Rias Elly Jr.</title>
    
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
            gap: 24px; 
            box-shadow: 2px 0 10px rgba(0,0,0,0.02);
        }

        .sidebar-brand { text-align: center; padding-bottom: 24px; border-bottom: 1px solid var(--border-color); }
        .sidebar-brand h2 { font-family: 'Playfair Display', serif; color: var(--gold-primary); font-size: 1.2rem; margin-bottom: 4px; }
        .sidebar-brand p { font-size: 0.8rem; color: var(--text-muted); }

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
            justify-content: center;
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

    <!-- Sidebar Admin -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h2>Admin Panel</h2>
            <p>Griya Rias Elly Jr.</p>
        </div>
<<<<<<< HEAD

        <nav class="flex flex-col gap-3">
            <!-- Menu Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-[#d79d57] text-[#241712] font-bold' : 'text-gray-400 hover:bg-[#432d22] hover:text-white' }} transition duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="text-sm font-medium">Dashboard</span>
            </a>
            
            <!-- Menu Kelola Katalog -->
            <a href="{{ route('admin.katalog.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.katalog*') ? 'bg-[#d79d57] text-[#241712] font-bold' : 'text-gray-400 hover:bg-[#432d22] hover:text-white' }} transition duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <span class="text-sm font-bold">Kelola Katalog</span>
            </a>

            <!-- Menu Jadwal Acara -->
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-[#432d22] hover:text-white transition duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="text-sm font-medium">Jadwal Acara</span>
            </a>

            <!-- Menu Laporan Transaksi -->
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-[#432d22] hover:text-white transition duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                <span class="text-sm font-medium">Laporan Transaksi</span>
            </a>
=======
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
>>>>>>> f6f1e2703e6814a15be976d70ce6583ee0cced41
        </nav>
        
        <!-- Tombol Kembali ke Halaman Utama -->
        <div style="margin-top: auto;">
             <a href="{{ route('home') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.85rem; display: flex; align-items: center; gap: 8px;">
                 <i class="fa-solid fa-arrow-left"></i> Halaman Utama
             </a>
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
                        <th style="text-align: center;">Kategori</th>
                        <th style="text-align: center;">Harga</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
<<<<<<< HEAD
                <tbody class="divide-y divide-[#432d22]">
                    @isset($katalogs)
                        @forelse($katalogs as $item)
                            <tr class="hover:bg-[#3a271d] transition duration-150">
                                <td class="py-4 px-6 text-sm font-medium text-gray-200">{{ $item->nama_paket }}</td>
                                <td class="py-4 px-6 text-sm text-gray-400 text-center">{{ $item->kategori }}</td>
                                <td class="py-4 px-6 text-sm text-gray-400 text-center">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td class="py-4 px-6 text-sm text-center">
                                    <span class="text-green-500 font-semibold tracking-wide">Aktif</span>
                                </td>
                                <td class="py-4 px-6 text-sm text-center space-x-2">
                                    <button class="bg-[#2563eb] hover:bg-blue-700 text-white px-4 py-1.5 rounded text-xs font-medium transition shadow">Edit</button>
                                    <button class="bg-[#dc2626] hover:bg-red-700 text-white px-4 py-1.5 rounded text-xs font-medium transition shadow">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 px-6 text-center text-sm text-gray-400">Belum ada data paket layanan.</td>
                            </tr>
                        @endforelse
                    @else
                        <tr>
                            <td colspan="5" class="py-6 px-6 text-center text-sm text-gray-400">Belum ada data paket layanan.</td>
=======
                <tbody>
                    @php
                        $dataPakets = isset($pakets) ?$pakets : (isset($katalogs) ?$katalogs : []);
                    @endphp

                    @forelse($dataPakets as$paket)
                        <tr>
                            <td style="font-weight: 600;">{{ $paket->nama_paket }}</td>
                            <td style="text-align: center; color: var(--text-muted);">{{ $paket->kategori }}</td>
                            <td style="text-align: center; color: var(--gold-primary); font-weight: 600;">
                                Rp {{ number_format($paket->harga, 0, ',', '.') }}
                            </td>
                            <td style="text-align: center;">
                                <span class="badge-active">{{ $paket->status ?? 'Aktif' }}</span>
                            </td>
                            <td class="action-btns">
                                <button class="btn-sm btn-edit" onclick="openModalEdit({{ json_encode($paket) }})">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>
                                
                                <form action="{{ route('admin.katalog.destroy', $paket->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sm btn-delete">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
>>>>>>> f6f1e2703e6814a15be976d70ce6583ee0cced41
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
            
<<<<<<< HEAD
            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-xl font-bold">&times;</button>

            <h3 class="text-gray-900 font-serif font-bold text-lg mb-4 border-b pb-2">Form Tambah / Edit Paket Layanan</h3>

            <!-- Form Mengarah ke rute admin katalog store -->
            <form action="{{ route('admin.katalog.store') }}" method="POST">
=======
            <form id="paketForm" action="{{ route('admin.katalog.store') }}" method="POST">
>>>>>>> f6f1e2703e6814a15be976d70ce6583ee0cced41
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
    <!-- Ubah type menjadi text dan panggil fungsi formatRupiah saat di-input -->
    <input type="text" name="harga" id="harga" placeholder="7.500.000" onkeyup="formatRupiah(this)" required>
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

        // Fungsi memformat angka menjadi format ribuan dengan titik secara real-time
function formatRupiah(element) {
    let value = element.value.replace(/[^0-9]/g, ''); // Hapus semua karakter selain angka
    if (value) {
        element.value = new Intl.NumberFormat('id-ID').format(value);
    } else {
        element.value = '';
    }
}

        function openModalEdit(paket) {
            modalTitle.innerText = "Edit Paket Layanan";
            form.action = `/admin/katalog/${paket.id}`;
            methodField.value = "PUT";
            
            document.getElementById('nama_paket').value = paket.nama_paket || '';
            document.getElementById('kategori').value = paket.kategori || '';
            document.getElementById('harga').value = new Intl.NumberFormat('id-ID').format(paket.harga || 0);
            document.getElementById('deskripsi').value = paket.deskripsi || '';
            
            modal.classList.add('show');
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