<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Acara & Ketersediaan - Griya Rias Elly Jr.</title>
    
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- FullCalendar CDN -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

    <style>
        :root {
            --bg-light: #FDFBF7; 
            --bg-card: #FFFFFF; 
            --gold-primary: #C58F43;
            --gold-hover: #A87632;
            --text-dark: #241A16; 
            --text-muted: #8C8279; 
            --border-color: #EFE8DE;
            --success-green: #2E7D32;
            --danger-red: #DC2626;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: var(--bg-light); color: var(--text-dark); font-family: 'Plus Jakarta Sans', sans-serif; display: flex; min-height: 100vh; }

        /* Sidebar Styling (Sama Persis dengan Dashboard Client) */
        .client-sidebar {
            width: 260px;
            flex: 0 0 260px;
            background: #fff;
            border-right: 1px solid var(--border-color);
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: sticky;
            top: 0;
            z-index: 20;
            box-shadow: 2px 0 14px #241a1608;
        }
        .client-sidebar-brand {
            padding: 4px 12px 20px;
            border-bottom: 1px solid var(--border-color);
            text-decoration: none;
            display: flex;
            flex-direction: column;
        }
        .client-sidebar-brand span { font-size: .67rem; letter-spacing: .2em; color: var(--gold-primary); font-weight: 700; }
        .client-sidebar-brand strong { font-family: 'Playfair Display', serif; color: var(--text-dark); font-size: 1.55rem; line-height: 1.2; }
        .client-sidebar-brand small { color: var(--text-muted); margin-top: 4px; }

        /* User Profile di Sidebar */
        .client-sidebar-user {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 20px 8px;
            border-bottom: 1px solid var(--border-color);
        }
        .client-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f4e6d2;
            color: #93622d;
            display: grid;
            place-items: center;
            font-weight: 800;
            flex-shrink: 0;
        }
        .client-sidebar-user strong, .client-sidebar-user small { display: block; }
        .client-sidebar-user strong { font-size: .86rem; max-width: 160px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .client-sidebar-user small { font-size: .72rem; color: var(--text-muted); margin-top: 3px; }

        /* Navigasi Sidebar */
        .client-sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 5px;
            padding-top: 20px;
            flex: 1;
            overflow-y: auto;
            padding-right: 4px;
        }
        .client-nav-label { font-size: .65rem; letter-spacing: .12em; font-weight: 800; color: #a59a8e; padding: 0 12px 7px; display: block; }
        .client-nav-spaced { padding-top: 18px; }

        .client-sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #55483f;
            font-size: .86rem;
            font-weight: 600;
            padding: 11px 12px;
            border-radius: 8px;
            transition: .2s;
        }
        .client-sidebar-nav a i { width: 18px; text-align: center; color: var(--text-muted); }
        .client-sidebar-nav a:hover { background: #fbf5ec; color: var(--gold-primary); }
        .client-sidebar-nav a.active { background: var(--gold-primary); color: #fff; }
        .client-sidebar-nav a.active i { color: #fff; }

        /* Footer Sidebar */
        .client-sidebar-footer {
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
            display: grid;
            gap: 7px;
        }
        .client-sidebar-footer > a {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #55483f;
            font-size: .86rem;
            font-weight: 600;
            padding: 11px 12px;
            border-radius: 8px;
        }
        .client-sidebar-footer form { margin: 0; }
        .client-sidebar-footer button {
            width: 100%;
            border: 1px solid #f1d0d0;
            background: #fff5f5;
            color: #b33b3b;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 8px;
            font: 600 .85rem 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
        }

        /* Main Content */
        .main-content { flex: 1; padding: 40px; min-width: 0; }
        .page-header { margin-bottom: 24px; }
        .page-title { font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--text-dark); margin-bottom: 6px; }
        .page-sub { color: var(--text-muted); font-size: 0.9rem; }

        /* Calendar Card Container */
        .calendar-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 28px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); }
        
        /* Legend Keterangan Warna */
        .legend-box { display: flex; gap: 20px; margin-bottom: 20px; font-size: 0.85rem; font-weight: 600; }
        .legend-item { display: flex; align-items: center; gap: 8px; }
        .dot { width: 14px; height: 14px; border-radius: 50%; }
        .dot-green { background-color: var(--success-green); }
        .dot-red { background-color: var(--danger-red); }

        /* FullCalendar Custom Styling */
        #calendar { max-width: 100%; margin: 0 auto; }
        .fc-event { cursor: pointer; border-radius: 6px; padding: 4px; font-weight: 600; }
        
        .btn-reservasi-cta {
            display: inline-block;
            margin-top: 24px;
            background-color: var(--gold-primary);
            color: #fff;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            box-shadow: 0 4px 12px rgba(197, 143, 67, 0.2);
        }
        .btn-reservasi-cta:hover { background-color: var(--gold-hover); }
    </style>
</head>
<body>

    <!-- Sidebar Client -->
    <aside class="client-sidebar">
        <a class="client-sidebar-brand" href="{{ route('client.dashboard') }}">
            <span>GRIYA RIAS</span><strong>Elly Jr.</strong><small>Area Client</small>
        </a>
        
        {{-- Area Profil User Client (Yang tadinya ketinggalan) --}}
        <div class="client-sidebar-user">
            <span class="client-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            <div>
                <strong>{{ auth()->user()->name }}</strong>
                <small>Client</small>
                <a href="{{ route('user.profile.edit') }}" style="display: inline-block; font-size: 0.75rem; color: #C58F43; text-decoration: none; font-weight: 600; margin-top: 2px;">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Profil
                </a>
            </div>
        </div>

        <nav class="client-sidebar-nav">
            <span class="client-nav-label">MENU UTAMA</span>
            <a href="{{ route('client.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a>
            <a href="{{ route('client.katalog.layanan') }}"><i class="fa-solid fa-scissors"></i> Katalog Layanan</a>
            <a href="{{ route('client.katalog.paket') }}"><i class="fa-solid fa-box-open"></i> Katalog Paket</a>
            <a href="{{ route('client.jadwal.index') }}" class="active"><i class="fa-regular fa-calendar-days"></i> Jadwal Acara</a>
            <a href="{{ route('reservasi.create') }}"><i class="fa-regular fa-calendar-check"></i> Form Reservasi</a>
            
            <span class="client-nav-label client-nav-spaced">AKTIVITAS & AKUN</span>
            <a href="{{ route('client.riwayat.reservasi') }}"><i class="fa-regular fa-calendar"></i> Riwayat Reservasi</a>
            <a href="{{ route('client.riwayat.transaksi') }}"><i class="fa-solid fa-receipt"></i> Riwayat Transaksi</a>
            <a href="{{ route('user.profile.edit') }}" class="{{ request()->routeIs('user.profile.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-gear"></i> Pengaturan Akun
            </a>
        </nav>

        <div class="client-sidebar-footer" style="padding-top: 16px; border-top: 1px solid var(--border-color); display: grid; gap: 7px;">
            <a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 12px; text-decoration: none; color: #55483f; font-size: .86rem; font-weight: 600; padding: 11px 12px; border-radius: 8px;"><i class="fa-solid fa-globe"></i> Halaman Utama</a>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="width: 100%; border: 1px solid #f1d0d0; background: #fff5f5; color: #b33b3b; display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: 8px; font: 600 .85rem 'Plus Jakarta Sans', sans-serif; cursor: pointer;"><i class="fa-solid fa-right-from-bracket"></i> Keluar Akun</button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header">
            <h1 class="page-title">Kalender Ketersediaan Jadwal</h1>
            <p class="page-sub">Cek tanggal acara yang tersedia sebelum melakukan pemesanan jadwal.</p>
        </div>

        <div class="calendar-card">
            <!-- Indikator Warna (Hanya Tanggal Terisi) -->
            <div class="legend-box">
                <div class="legend-item">
                    <span class="dot dot-red"></span> Tanggal Terisi (Sudah Dibooking)
                </div>
            </div>

            <!-- Elemen Kalender -->
            <div id="calendar"></div>

            <!-- Elemen Kalender -->
            <div id="calendar"></div>

            <div style="text-align: right;">
                <a href="{{ route('reservasi.create') }}" class="btn-reservasi-cta">
                    <i class="fa-solid fa-calendar-plus"></i> Lanjut Buat Reservasi
                </a>
            </div>
        </div>
    </main>

    <!-- Script Inisialisasi FullCalendar -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                // Mengambil event dari endpoint JSON yang sudah diset merah
                events: '{{ route("client.jadwal.json") }}',
                dayCellDidMount: function(info) {
                    // Warna latar default untuk tanggal kosong (hijau lembut / terang)
                    info.el.style.backgroundColor = '#F4FAF6'; 
                },
                eventDidMount: function(info) {
                    // Memastikan kotak tanggal pada event yang dibooking otomatis ikut berubah merah
                    let dateStr = info.event.startStr.split('T')[0];
                    let cellEl = document.querySelector(`.fc-daygrid-day[data-date="${dateStr}"]`);
                    if (cellEl) {
                        cellEl.style.backgroundColor = '#FEE2E2'; // Merah lembut latar kotak
                    }
                }
            });
            calendar.render();
        });
    </script>
</body>
</html>