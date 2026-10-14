<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Acara - Admin Griya Rias Elly Jr.</title>
    
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
            --success-green: #4E9F70;
            --btn-blue: #4F80E2;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: var(--bg-light); color: var(--text-dark); font-family: 'Plus Jakarta Sans', sans-serif; display: flex; min-height: 100vh; }

        /* Sidebar Styles */
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

        .sidebar-footer { margin-top: auto; padding-top: 16px; border-top: 1px solid var(--border-color); display: flex; flex-direction: column; gap: 8px; }
        .btn-sidebar-home { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 8px; color: var(--text-dark); background-color: var(--bg-light); border: 1px solid var(--border-color); text-decoration: none; font-size: 0.88rem; font-weight: 600; }
        .btn-sidebar-logout { width: 100%; display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 8px; color: #DC2626; background-color: #FEF2F2; border: 1px solid #FCA5A5; font-size: 0.88rem; font-weight: 600; cursor: pointer; }

        /* Content Layout */
        .main-content { flex: 1; padding: 32px 40px; }
        .layout-grid { display: grid; grid-template-columns: 1fr 340px; gap: 24px; }

        .section-title { font-family: 'Playfair Display', serif; color: var(--gold-primary); font-size: 1.35rem; margin-bottom: 20px; }

        /* Card List Jadwal */
        .jadwal-list { display: flex; flex-direction: column; gap: 16px; }
        .jadwal-card {
            background-color: #FFFDF9;
            border: 1px solid var(--border-color);
            border-left: 4px solid var(--gold-primary);
            border-radius: 12px;
            padding: 18px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }
        .btn-sm {
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        } 

        .badge-date {
            background-color: var(--gold-primary);
            color: #FFF;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            display: inline-block;
            margin-bottom: 6px;
        }

        .client-name { font-weight: 700; font-size: 1rem; color: var(--text-dark); }
        .location-info { font-size: 0.82rem; color: var(--text-muted); margin-top: 2px; }

        .card-actions { display: flex; gap: 8px; }
        .btn-validasi { background-color: var(--success-green); color: #fff; border: none; padding: 8px 14px; border-radius: 6px; font-size: 0.82rem; font-weight: 600; cursor: pointer; }
        .btn-ubah { background-color: var(--btn-blue); color: #fff; border: none; padding: 8px 14px; border-radius: 6px; font-size: 0.82rem; font-weight: 600; cursor: pointer; }

        /* Panel WA Direct */
        .panel-wa {
            background-color: #FFFDF9;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
        }

        .wa-title { font-size: 0.95rem; font-weight: 700; color: var(--gold-primary); display: flex; align-items: center; gap: 8px; margin-bottom: 8px; }
        .wa-desc { font-size: 0.78rem; color: var(--text-muted); line-height: 1.4; margin-bottom: 14px; }
        
        .wa-box {
            background-color: #FAFAFA;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 12px;
            font-size: 0.8rem;
            color: var(--text-dark);
            margin-bottom: 16px;
            line-height: 1.5;
        }

        .btn-kirim-wa {
            width: 100%;
            background-color: #10B981;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        /* Modal Ubah Tanggal */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(36, 26, 22, 0.6); display: none; justify-content: center; align-items: center; z-index: 9999; backdrop-filter: blur(4px); }
        .modal-overlay.show { display: flex; }
        .modal-card { background-color: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; width: 100%; max-width: 420px; padding: 24px; }
    </style>
</head>
<body>

    <!-- Sidebar Admin -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo">
            <div class="brand-text">
                <h2>Admin Panel</h2>
                <p>Griya Rias Elly Jr.</p>
            </div>
        </div>
        <nav>
            <ul class="nav-menu">
                <li><a href="{{ route('admin.dashboard') }}" class="nav-item"><i class="fa-solid fa-shapes"></i> Dashboard</a></li>
                <li><a href="{{ route('admin.katalog.index') }}" class="nav-item"><i class="fa-solid fa-box-open"></i> Kelola Katalog</a></li>
                <li><a href="{{ route('admin.portofolio.index') }}" class="nav-item"><i class="fa-solid fa-images"></i> Galeri Portofolio</a></li>
                <li><a href="{{ route('admin.jadwal.index') }}" class="nav-item active"><i class="fa-regular fa-calendar"></i> Jadwal Acara</a></li>
                <li><a href="#" class="nav-item"><i class="fa-solid fa-chart-column"></i> Laporan Transaksi</a></li>
            </ul>
        </nav>

        <div class="sidebar-footer">
             <a href="{{ route('home') }}" class="btn-sidebar-home"><i class="fa-solid fa-globe"></i> Halaman Utama</a>
             <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                 @csrf
                 <button type="submit" class="btn-sidebar-logout"><i class="fa-solid fa-right-from-bracket"></i> Keluar Akun</button>
             </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="layout-grid">
            
            <!-- Kolom Kiri: Daftar Jadwal Acara -->
            <div>
                <h1 class="section-title">Kelola Jadwal Acara Terdaftar</h1>

                <div class="jadwal-list">
                    @forelse($reservasi as $item)
                        <div class="jadwal-card">
                            <div>
                                <span class="badge-date">
                                    {{ \Carbon\Carbon::parse($item->tanggal_acara)->translatedFormat('d F Y') }} • {{ strtoupper($item->jenis_acara ?? 'FULL DAY') }}
                                </span>
                                <div class="client-name">{{ $item->user->name ?? 'Pelanggan' }} ({{ $item->detail_acara ?? 'Rias Pengantin' }})</div>
                                <div class="location-info">Lokasi: {{ $item->lokasi ?? 'Lokasi Klien' }}</div>
                            </div>

                            <div class="card-actions">
                                <!-- Tombol Pilih untuk WA -->
                                <button class="btn-sm" style="background:#10B981; color:#fff;" 
                                    onclick="pilihPelangganWA('{{ $item->user->name ?? 'Pelanggan' }}', '{{ $item->user->no_hp ?? '' }}', '{{ \Carbon\Carbon::parse($item->tanggal_acara)->translatedFormat('d F Y') }}')">
                                    <i class="fa-brands fa-whatsapp"></i> WA
                                </button>

                                <form action="{{ route('admin.jadwal.validasi', $item->id_reservasi) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-validasi">
                                        {{ ($item->jadwal &&$item->jadwal->status_validasi == 'Tervalidasi') ? 'Tervalidasi' : 'Validasi' }}
                                    </button>
                                </form>
                                <button class="btn-ubah" onclick="openModalUbah({{ $item->id_reservasi }}, '{{$item->tanggal_acara }}')">Ubah Tanggal</button>
                            </div>
                        </div>
                    @empty
                        <div style="background:#fff; border:1px solid var(--border-color); padding:30px; text-align:center; border-radius:12px; color:var(--text-muted);">
                            Belum ada jadwal acara terdaftar.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Kolom Kanan: Kirim WhatsApp Direct (Sudah Dirapikan & Tunggal) -->
            <div>
                <div class="panel-wa">
                    <div class="wa-title"><i class="fa-regular fa-comment-dots"></i> Kirim WhatsApp Direct</div>
                    <p class="wa-desc">Pilih tombol WA pada daftar pelanggan di sebelah kiri untuk mengisi pesan secara otomatis.</p>

                    <!-- Preview Pesan Dinamis -->
                    <div class="wa-box" id="waPreviewBox">
                        Klik tombol WA pada salah satu pelanggan untuk memuat pesan pengingat otomatis.
                    </div>

                    <!-- Tombol Kirim WA -->
                    <a href="#" id="btnKirimWA" target="_blank" class="btn-kirim-wa">
                        <i class="fa-paper-plane"></i> KIRIM WA NOTIFIKASI
                    </a>
                </div>
            </div>

        </div>
    </main>

    <!-- Modal Ubah Tanggal -->
    <div class="modal-overlay" id="modalUbah">
        <div class="modal-card">
            <h3 style="font-family:'Playfair Display', serif; margin-bottom:16px;">Ubah Tanggal Acara</h3>
            <form id="formUbahTanggal" method="POST">
                @csrf
                @method('PUT')
                <div style="margin-bottom:16px;">
                    <label style="display:block; font-size:0.8rem; font-weight:700; margin-bottom:6px;">Tanggal Acara Baru</label>
                    <input type="date" name="tanggal_acara" id="tanggal_acara" required style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:8px;">
                </div>
                <div style="display:flex; gap:10px;">
                    <button type="button" onclick="closeModalUbah()" style="flex:1; padding:10px; border:1px solid var(--border-color); background:none; border-radius:8px; cursor:pointer;">Batal</button>
                    <button type="submit" style="flex:1; padding:10px; background:var(--gold-primary); color:#fff; border:none; border-radius:8px; font-weight:700; cursor:pointer;">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openModalUbah(id, tanggal) {
            const form = document.getElementById('formUbahTanggal');
            form.action = `/admin/jadwal/update-tanggal/${id}`;
            document.getElementById('tanggal_acara').value = tanggal;
            document.getElementById('modalUbah').classList.add('show');
        }

        function pilihPelangganWA(nama, noHp, tanggal) {
            let formattedPhone = noHp.replace(/^0/, '62');
            let pesan = `Halo Kak ${nama}, ini pengingat dari Griya Rias Elly Jr. mengenai jadwal acara Anda pada tanggal ${tanggal}. Perias kami akan tiba di lokasi sesuai jadwal. Terima kasih!`;
            
            document.getElementById('waPreviewBox').innerText = pesan;
            
            let waLink = `https://wa.me/${formattedPhone}?text=${encodeURIComponent(pesan)}`;
            document.getElementById('btnKirimWA').setAttribute('href', waLink);
        }

        function closeModalUbah() {
            document.getElementById('modalUbah').classList.remove('show');
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