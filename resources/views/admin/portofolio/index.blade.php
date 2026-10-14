<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Portofolio - Admin Griya Rias Elly Jr.</title>
    
    <!-- FAVICON (Logo di Tab Browser) -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}">

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: var(--bg-light); color: var(--text-dark); font-family: 'Plus Jakarta Sans', sans-serif; display: flex; min-height: 100vh; }

        .sidebar { width: 260px; background-color: var(--bg-card); border-right: 1px solid var(--border-color); padding: 24px 16px; display: flex; flex-direction: column; gap: 20px; box-shadow: 2px 0 10px rgba(0,0,0,0.02); }
        .sidebar-brand { display: flex; align-items: center; gap: 12px; padding-bottom: 20px; border-bottom: 1px solid var(--border-color); }
        .sidebar-brand img { width: 42px; height: 42px; object-fit: cover; border-radius: 6px; }
        .brand-text h2 { font-family: 'Playfair Display', serif; color: var(--gold-primary); font-size: 1.15rem; line-height: 1.2; margin-bottom: 2px; }
        .brand-text p { font-size: 0.78rem; color: var(--text-muted); }

        .nav-menu { list-style: none; display: flex; flex-direction: column; gap: 8px; }
        .nav-item { padding: 12px 16px; border-radius: 8px; color: var(--text-dark); text-decoration: none; font-size: 0.95rem; display: flex; align-items: center; gap: 12px; transition: all 0.2s; font-weight: 500; }
        .nav-item i { width: 20px; text-align: center; color: var(--text-muted); }
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

        .main-content { flex: 1; padding: 40px; }
        .header-action { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; }
        .page-title { font-family: 'Playfair Display', serif; color: var(--text-dark); font-size: 1.5rem; }

        .btn-gold { background-color: var(--gold-primary); color: #fff; border: none; padding: 10px 18px; border-radius: 8px; font-size: 0.9rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(197, 143, 67, 0.2); }
        .btn-gold:hover { background-color: var(--gold-hover); }

        .portfolio-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; }
        .portfolio-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.02); }
        .portfolio-img { 
            width: 100%; 
            height: 320px; 
            object-fit: contain; 
            background-color: #FAFAFA;
        }
        .portfolio-body { padding: 16px; }
        .portfolio-title { font-family: 'Playfair Display', serif; font-size: 1.1rem; font-weight: 700; margin-bottom: 4px; }
        .portfolio-cat { font-size: 0.8rem; color: var(--gold-primary); font-weight: 600; text-transform: uppercase; margin-bottom: 12px; }
        .portfolio-actions { display: flex; gap: 8px; margin-top: 12px; }

        .btn-sm { padding: 6px 12px; border: none; border-radius: 6px; font-size: 0.8rem; font-weight: 600; cursor: pointer; color: #fff; display: inline-flex; align-items: center; gap: 6px; }
        .btn-edit { background-color: #3B82F6; }
        .btn-delete { background-color: #EF4444; }

        /* Modal Styles */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(36, 26, 22, 0.6); display: none; justify-content: center; align-items: center; z-index: 9999; backdrop-filter: blur(4px); }
        .modal-overlay.show { display: flex; }
        .modal-card { background-color: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; width: 100%; max-width: 520px; padding: 28px; }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px; }
        .form-group { margin-bottom: 16px; }
        .modal-card label { display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 6px; }
        .modal-card input, .modal-card select, .modal-card textarea { width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 8px; background-color: #FAFAFA; font-family: inherit; }
        .modal-actions { display: flex; gap: 12px; margin-top: 24px; }
        .btn-cancel { flex: 1; background: transparent; border: 1px solid #D6CEC3; padding: 10px; border-radius: 8px; cursor: pointer; font-weight: 600; color: var(--text-muted); }
        .btn-save { flex: 1; background: var(--gold-primary); color: #fff; border: none; padding: 10px; border-radius: 8px; cursor: pointer; font-weight: 600; }
    </style>
</head>
<body>

    <!-- Sidebar Admin Panel -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Griya Rias Elly Jr.">
            <div class="brand-text">
                <h2>Admin Panel</h2>
                <p>Griya Rias Elly Jr.</p>
            </div>
        </div>
        <nav>
            <ul class="nav-menu">
                <li><a href="{{ route('admin.dashboard') }}" class="nav-item"><i class="fa-solid fa-shapes"></i> Dashboard</a></li>
                <li><a href="{{ route('admin.katalog.index') }}" class="nav-item"><i class="fa-solid fa-box-open"></i> Kelola Katalog</a></li>
                <li><a href="{{ route('admin.portofolio.index') }}" class="nav-item active"><i class="fa-solid fa-images"></i> Galeri Portofolio</a></li>
                <li><a href="#" class="nav-item"><i class="fa-regular fa-calendar"></i> Jadwal Acara</a></li>
                <li><a href="#" class="nav-item"><i class="fa-solid fa-chart-column"></i> Laporan Transaksi</a></li>
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
            <h1 class="page-title">Galeri Portofolio Hasil Rias</h1>
            <button class="btn-gold" onclick="openModal()"><i class="fa-solid fa-plus"></i> Upload Foto Baru</button>
        </div>

        <div class="portfolio-grid">
            @forelse($portofolios as $item)
                <div class="portfolio-card">
                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="portfolio-img">
                    <div class="portfolio-body">
                        <div class="portfolio-cat">{{ $item->kategori }}</div>
                        <h3 class="portfolio-title">{{ $item->judul }}</h3>
                        <p style="font-size: 0.85rem; color: var(--text-muted);">{{ Str::limit($item->deskripsi, 60) }}</p>
                        
                        <div class="portfolio-actions">
                            <button class="btn-sm btn-edit" onclick="openModalEdit({{ json_encode($item) }})">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </button>
                            
                            <form action="{{ route('admin.portofolio.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="confirmDelete(event, this)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-delete">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 40px; background: #fff; border-radius: 12px; border: 1px solid var(--border-color);">
                    Belum ada foto portofolio yang diunggah.
                </div>
            @endforelse
        </div>
    </main>

    <!-- Modal Form -->
    <div class="modal-overlay" id="portofolioModal">
        <div class="modal-card">
            <div class="modal-header">
                <h2 class="modal-title" id="modalTitle">Tambah Foto Portofolio</h2>
                <button onclick="closeModal()" style="background:none; border:none; cursor:pointer; font-size:1.2rem; color:var(--text-muted);"><i class="fa-solid fa-xmark"></i></button>
            </div>
            
            <form id="portofolioForm" action="{{ route('admin.portofolio.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST">
                
                <div class="form-group">
                    <label>Judul Portofolio</label>
                    <input type="text" name="judul" id="judul" placeholder="Contoh: Rias Pengantin Sunda Siger Gold" required>
                </div>
                
                <!-- Dropdown Kategori Dinamis Mengambil dari Tabel Katalog (Paket) -->
                <div class="form-group">
                    <label>Kategori Rias / Acara</label>
                    <select name="kategori" id="kategori" required>
                        <option value="" disabled selected>-- Pilih Kategori --</option>
                        @forelse($kategoriList as $kat)
                            <option value="Foto {{ $kat }}">Foto {{ $kat }}</option>
                        @empty
                            <option value="" disabled>Belum ada kategori di Kelola Katalog</option>
                        @endforelse
                    </select>
                </div>

                <div class="form-group">
                    <label>File Foto Gambar</label>
                    <input type="file" name="gambar" id="gambar" accept="image/*">
                    <small style="color: var(--text-muted); font-size: 0.75rem;">Format: JPG, PNG, WEBP (Maks: 2MB)</small>
                </div>

                <div class="form-group">
                    <label>Deskripsi Singkat</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" placeholder="Keterangan riasan atau lokasi acara..."></textarea>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn-save">Simpan Portofolio</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Notifikasi & Modal -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const modal = document.getElementById('portofolioModal');
        const form = document.getElementById('portofolioForm');
        const modalTitle = document.getElementById('modalTitle');
        const methodField = document.getElementById('methodField');

        function openModal() {
            modalTitle.innerText = "Tambah Foto Portofolio";
            form.action = "{{ route('admin.portofolio.store') }}";
            methodField.value = "POST";
            document.getElementById('gambar').required = true;
            form.reset();
            modal.classList.add('show');
        }

        function confirmDelete(event, form) {
            event.preventDefault();

            Swal.fire({
                title: 'Hapus Foto Portofolio?',
                text: "Foto yang dihapus tidak dapat dikembalikan!",
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

        function openModalEdit(item) {
            modalTitle.innerText = "Edit Foto Portofolio";
            form.action = `/admin/portofolio/${item.id}`;
            methodField.value = "PUT";
            
            document.getElementById('judul').value = item.judul || '';
            document.getElementById('kategori').value = item.kategori || '';
            document.getElementById('deskripsi').value = item.deskripsi || '';
            document.getElementById('gambar').required = false;
            
            modal.classList.add('show');
        }

        function closeModal() {
            modal.classList.remove('show');
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