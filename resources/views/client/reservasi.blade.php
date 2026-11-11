<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Reservasi - Griya Rias Elly Jr.</title>
    
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: var(--bg-light); color: var(--text-dark); font-family: 'Plus Jakarta Sans', sans-serif; display: flex; min-height: 100vh; }

        /* SweetAlert2 Z-Index Overrides */
        .swal2-container { z-index: 10000 !important; }

        /* Sidebar Styling (Konsisten) */
        .client-sidebar {
            width: 260px;
            flex: 0 0 260px;
            background: #FFF;
            border-right: 1px solid var(--border-color);
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: sticky;
            top: 0;
            z-index: 20;
            box-shadow: 2px 0 14px rgba(36, 26, 22, 0.03);
        }
        .client-sidebar-brand {
            padding: 4px 12px 20px;
            border-bottom: 1px solid var(--border-color);
            text-decoration: none;
            display: flex;
            flex-direction: column;
        }
        .client-sidebar-brand span { font-size: .67rem; letter-spacing: .2em; color: var(--gold-primary); font-weight: 700; text-transform: uppercase; }
        .client-sidebar-brand strong { font-family: 'Playfair Display', serif; color: var(--text-dark); font-size: 1.55rem; line-height: 1.2; }
        .client-sidebar-brand small { color: var(--text-muted); margin-top: 4px; }

        .client-sidebar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 10px;
            margin: 16px 0;
            background: #FAFAFA;
            border: 1px solid var(--border-color);
            border-radius: 10px;
        }
        .client-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #F4E6D2;
            color: var(--gold-hover);
            display: grid;
            place-items: center;
            font-weight: 800;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .client-sidebar-user strong { font-size: .88rem; color: var(--text-dark); display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .client-sidebar-user small { font-size: .75rem; color: var(--text-muted); display: block; }

        .client-sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex: 1;
            overflow-y: auto;
            padding-right: 4px;
        }
        .client-nav-label { font-size: .65rem; letter-spacing: .12em; font-weight: 800; color: #A59A8E; padding: 10px 12px 4px; display: block; }

        .client-sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #55483F;
            font-size: .86rem;
            font-weight: 600;
            padding: 11px 12px;
            border-radius: 8px;
            transition: .2s;
        }
        .client-sidebar-nav a i { width: 18px; text-align: center; color: var(--text-muted); }
        .client-sidebar-nav a:hover { background: #FBF5EC; color: var(--gold-hover); }
        .client-sidebar-nav a.active { background: var(--gold-primary); color: #FFF; }
        .client-sidebar-nav a.active i { color: #FFF; }

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
            color: #55483F;
            font-size: .86rem;
            font-weight: 600;
            padding: 11px 12px;
            border-radius: 8px;
        }
        .client-sidebar-footer button {
            width: 100%;
            border: 1px solid #F1D0D0;
            background: #FFF5F5;
            color: #B33B3B;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 8px;
            font: 600 .85rem 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
        }

        /* Main Content Layout */
        .main-content { flex: 1; padding: 40px; min-width: 0; }
        .page-header { margin-bottom: 24px; }
        .page-title { font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--text-dark); margin-bottom: 6px; }
        .page-sub { color: var(--text-muted); font-size: 0.9rem; }

        /* Form Layout Grid */
        .reservation-layout { display: grid; grid-template-columns: 1fr; gap: 28px; align-items: start; }
        .reservation-main { display: flex; flex-direction: column; gap: 24px; }
        
        .reservation-panel {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        }
        .reservation-panel-heading { display: flex; align-items: center; gap: 14px; margin-bottom: 20px; }
        .reservation-step {
            width: 36px; height: 36px; border-radius: 10px; background: #F7EDDD; color: var(--gold-hover);
            font-weight: 800; display: grid; place-items: center; font-size: 0.9rem; flex-shrink: 0;
        }
        .reservation-panel-heading h2 { font-family: 'Playfair Display', serif; font-size: 1.25rem; color: var(--text-dark); }
        .reservation-panel-heading p { color: var(--text-muted); font-size: 0.82rem; }

        .reservation-fields { display: grid; gap: 16px; }
        .reservation-fields-two { grid-template-columns: 1fr 1fr; }
        .reservation-field-event-date { grid-column: 1; grid-row: 1; }
        .reservation-field-event-start { grid-column: 1; grid-row: 2; }
        .reservation-field-event-end { grid-column: 2; grid-row: 2; }
        .reservation-field-full { grid-column: 1 / -1; }
        
        .reservation-field label { display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 6px; }
        .reservation-field label span { color: #DC2626; }
        .reservation-field input, .reservation-field textarea {
            width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 8px;
            font-family: inherit; font-size: 0.88rem; background: #FAFAFA; color: var(--text-dark); outline: none;
        }
        .reservation-field input:focus, .reservation-field textarea:focus { border-color: var(--gold-primary); background: #FFF; }
        .reservation-field input[readonly] { background: #F4E6D2; color: var(--text-muted); cursor: not-allowed; }

        .reservation-choice-types { display: grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap: 14px; margin: 4px 0 16px; }
        .reservation-type-card {
            display: flex; align-items: center; gap: 12px; width: 100%; padding: 14px; border: 1px solid var(--border-color);
            border-radius: 12px; background: #FFF; text-align: left; cursor: pointer; transition: all .2s;
        }
        .reservation-type-card:hover:not(:disabled) { border-color: var(--gold-primary); transform: translateY(-2px); }
        .reservation-type-card.selected { border-color: var(--gold-primary); background: #FDF8EF; box-shadow: 0 0 0 2px rgba(197, 143, 67, 0.2); }
        .reservation-type-card:disabled { opacity: .5; cursor: not-allowed; }
        .reservation-type-icon { width: 40px; height: 40px; border-radius: 10px; background: #F7EDDD; color: var(--gold-hover); display: grid; place-items: center; font-size: 1.1rem; flex-shrink: 0; }
        .reservation-type-card strong { display: block; color: var(--text-dark); font-size: 0.88rem; }
        .reservation-type-card small { display: block; color: var(--text-muted); font-size: 0.75rem; }

        .reservation-choice-list { display: grid; gap: 10px; margin-top: 10px; }
        .reservation-choice-list[hidden] { display: none !important; }
        .reservation-package-option {
            display: flex; align-items: flex-start; gap: 12px; padding: 12px 14px; border: 1px solid var(--border-color);
            border-radius: 10px; background: #FFF; cursor: pointer; transition: .2s;
        }
        .reservation-package-option:hover, .reservation-package-option.selected { border-color: var(--gold-primary); background: #FDF8EF; }
        .reservation-package-option input[type="radio"], .reservation-package-option input[type="checkbox"] {
            appearance:none; width:20px; height:20px; flex:0 0 20px; margin:1px 0 0; position:relative;
            border:2px solid #CFC4B8; border-radius:5px; background:#FFF; cursor:pointer;
        }
        .reservation-package-option input[type="radio"]:checked, .reservation-package-option input[type="checkbox"]:checked {
            border-color:var(--gold-primary); background:var(--gold-primary); box-shadow:0 0 0 3px rgba(197,143,67,.14);
        }
        .reservation-package-option input[type="radio"]:checked::after, .reservation-package-option input[type="checkbox"]:checked::after {
            content:"✓"; position:absolute; inset:0; display:grid; place-items:center; color:#FFF; font-size:.8rem; font-weight:800;
        }
        .reservation-package-option input:focus-visible { outline:3px solid rgba(197,143,67,.3); outline-offset:2px; }
        .reservation-package-info { flex: 1; display: flex; flex-direction: column; gap: 2px; }
        .reservation-package-info strong { color: var(--text-dark); font-size: 0.88rem; }
        .reservation-package-info small { color: var(--gold-primary); font-weight: 600; font-size: 0.78rem; }
        .reservation-package-info span { color: var(--text-muted); font-size: 0.8rem; }
        .reservation-package-price { font-weight: 800; color: var(--gold-primary); font-size: 0.95rem; }

        /* Floating reservation summary */
        .reservation-summary-trigger {
            position: fixed; z-index: 1000; left: 50%; bottom: 20px; transform: translateX(-50%);
            display: flex; align-items: center; justify-content: space-between; gap: 24px;
            width: min(420px, calc(100% - 32px)); padding: 15px 20px; border: 0; border-radius: 12px;
            background: var(--gold-primary); color: #FFF; box-shadow: 0 8px 28px rgba(36,26,22,.22);
            font: 700 .95rem 'Plus Jakarta Sans', sans-serif; cursor: pointer;
        }
        .reservation-summary-trigger:hover { background: var(--gold-hover); }
        .reservation-summary-trigger strong { white-space: nowrap; }
        .reservation-summary {
            position: fixed; z-index: 1001; left: 50%; top: 50%; transform: translate(-50%, -46%);
            width: min(620px, calc(100% - 32px)); max-height: min(82vh, 680px); overflow-y: auto;
            background: rgba(255,255,255,.98); border: 1px solid rgba(239,232,222,.95); border-radius: 24px;
            padding: 30px; box-shadow: 0 24px 80px rgba(36,26,22,.24), 0 4px 16px rgba(36,26,22,.08);
            animation: reservation-modal-in .22s ease-out forwards;
        }
        @keyframes reservation-modal-in { from { opacity:0; transform:translate(-50%, -42%) scale(.97); } to { opacity:1; transform:translate(-50%, -50%) scale(1); } }
        .reservation-summary-backdrop { position: fixed; inset: 0; z-index: 1000; background: rgba(36,26,22,.38); backdrop-filter: blur(6px); animation: reservation-backdrop-in .18s ease-out forwards; }
        @keyframes reservation-backdrop-in { from { opacity:0; } to { opacity:1; } }
        .reservation-summary-backdrop[hidden] { display: none !important; }
        .reservation-summary[hidden] { display: none !important; }
        .reservation-summary-heading { position:relative; display:flex; align-items:flex-start; justify-content:space-between; gap:18px; padding-top:8px; padding-bottom:18px; border-bottom:1px solid var(--border-color); }
        .reservation-summary-heading h2 { font-family: 'Playfair Display', serif; font-size: 1.55rem; color: var(--text-dark); margin:0; letter-spacing:-.02em; }
        .reservation-summary-heading::before { content:'RINGKASAN PESANAN'; position:absolute; margin-top:-17px; color:var(--gold-primary); font-size:.62rem; letter-spacing:.14em; font-weight:800; }
        .reservation-summary-close { width:36px; height:36px; display:grid; place-items:center; border:1px solid var(--border-color); background:#FFF; color:var(--text-muted); font-size:1rem; cursor:pointer; padding:0; border-radius:50%; transition:.2s; }
        .reservation-summary-close:hover { background:#FDF8EF; color:var(--gold-hover); border-color:var(--gold-primary); transform:rotate(90deg); }
        .reservation-summary-row { display: flex; justify-content: space-between; align-items:flex-start; gap:20px; margin:0; padding:16px 0; font-size: 0.88rem; color: var(--text-muted); }
        .reservation-summary-row + .reservation-summary-row { border-top:1px dashed var(--border-color); }
        .reservation-summary-row strong { color: var(--text-dark); text-align:right; max-width:65%; }
        .reservation-summary-total {
            display: flex; justify-content: space-between; align-items: center; padding: 18px 0 0;
            border-top: 1px solid var(--border-color); margin-top: 4px; font-weight: 700;
        }
        .reservation-summary-total strong { font-size: 1.2rem; color: var(--gold-primary); }
        
        .reservation-submit {
            width: 100%; margin-top: 20px; padding: 12px; background: var(--gold-primary); color: #FFF;
            border: none; border-radius: 8px; font-weight: 700; font-size: 0.9rem; cursor: pointer; transition: .2s;
        }
        .reservation-submit:hover:not(:disabled) { background: var(--gold-hover); }
        .reservation-submit:disabled { opacity: 0.6; cursor: not-allowed; }

        @media(max-width: 600px) {
            .reservation-summary { width: calc(100% - 20px); padding: 26px 20px 22px; border-radius:20px; }
            .reservation-summary-heading h2 { font-size:1.3rem; }
            .reservation-summary-row { font-size:.82rem; }
            .reservation-summary-trigger { bottom:14px; width:calc(100% - 24px); }
        }

        .reservation-alert { padding: 12px 16px; background: #FEF2F2; border: 1px solid #FCA5A5; color: #991B1B; border-radius: 10px; margin-bottom: 20px; font-size: 0.88rem; }
        .reservation-error { color: #DC2626; font-size: 0.78rem; margin-top: 4px; display: block; }

        @media(max-width: 992px) {
            .reservation-layout { grid-template-columns: 1fr; }
            .reservation-fields-two { grid-template-columns: 1fr; }
            .reservation-field-event-date,
            .reservation-field-event-start,
            .reservation-field-event-end { grid-column: 1; grid-row: auto; }
        }
    </style>
</head>
<body>

    <!-- Sidebar Client -->
    <aside class="client-sidebar">
        <a class="client-sidebar-brand" href="{{ route('client.dashboard') }}">
            <span>GRIYA RIAS</span><strong>Elly Jr.</strong><small>Area Client</small>
        </a>
        
        <div class="client-sidebar-user">
            <span class="client-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            <div style="min-width: 0;">
                <strong>{{ auth()->user()->name }}</strong>
                <small>Client</small>
            </div>
        </div>

        <nav class="client-sidebar-nav">
            <span class="client-nav-label">MENU UTAMA</span>
            <a href="{{ route('client.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a>
            <a href="{{ route('client.katalog.layanan') }}"><i class="fa-solid fa-scissors"></i> Katalog Layanan</a>
            <a href="{{ route('client.katalog.paket') }}"><i class="fa-solid fa-box-open"></i> Katalog Paket</a>
            <a href="{{ route('client.jadwal.index') }}"><i class="fa-regular fa-calendar-days"></i> Jadwal Acara</a>
            <a href="{{ route('reservasi.create') }}" class="active"><i class="fa-regular fa-calendar-check"></i> Form Reservasi</a>
            
            <span class="client-nav-label" style="margin-top: 12px;">AKTIVITAS & AKUN</span>
            <a href="{{ route('client.riwayat.reservasi') }}"><i class="fa-regular fa-calendar"></i> Riwayat Reservasi</a>
            
            @if(Route::has('client.riwayat.transaksi'))
                <a href="{{ route('client.riwayat.transaksi') }}"><i class="fa-solid fa-receipt"></i> Riwayat Transaksi</a>
            @else
                <a href="{{ route('client.dashboard') }}" onclick="alert('Fitur Riwayat Transaksi tersedia pada Sprint 3.'); return false;"><i class="fa-solid fa-receipt"></i> Riwayat Transaksi</a>
            @endif

            <a href="{{ route('user.profile.edit') }}"><i class="fa-solid fa-user-gear"></i> Pengaturan Akun</a>
        </nav>

        <div class="client-sidebar-footer">
            <a href="{{ route('client.home') }}"><i class="fa-solid fa-globe"></i> Halaman Client</a>
            <form id="logout-form-client" action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="button" onclick="confirmLogoutClient()"><i class="fa-solid fa-right-from-bracket"></i> Keluar Akun</button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header">
            <h1 class="page-title">Ajukan Reservasi</h1>
            <p class="page-sub">Lengkapi detail acara dan pilih layanan yang Anda inginkan. Tim kami akan mengonfirmasi pemesanan Anda.</p>
        </div>

        @if ($errors->any())
            <div class="reservation-alert" role="alert">
                <strong>Periksa kembali data reservasi Anda:</strong>
                <ul style="margin-left: 20px; margin-top: 6px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reservasi.store') }}" method="POST" id="reservation-form">
            @csrf
            <div class="reservation-layout">
                <div class="reservation-main">
                    <!-- SECTION 1: PEMESAN -->
                    <section class="reservation-panel">
                        <div class="reservation-panel-heading">
                            <span class="reservation-step">01</span>
                            <div>
                                <h2>Informasi Pemesan</h2>
                                <p>Data ini diambil dari profil akun Anda.</p>
                            </div>
                        </div>
                        <div class="reservation-fields reservation-fields-two">
                            <div class="reservation-field">
                                <label for="customer-name">Nama Pemesan</label>
                                <input id="customer-name" type="text" value="{{ $user->name }}" readonly>
                            </div>
                            <div class="reservation-field">
                                <label for="customer-phone">Nomor WhatsApp</label>
                                <input id="customer-phone" type="text" value="{{ $user->phone ?: ($user->no_hp ?: 'Nomor belum diisi di profil') }}" readonly>
                            </div>
                        </div>
                    </section>

                    <!-- SECTION 2: DETAIL ACARA -->
                    <section class="reservation-panel">
                        <div class="reservation-panel-heading">
                            <span class="reservation-step">02</span>
                            <div>
                                <h2>Detail Acara & Persiapan Rias</h2>
                                <p>Tentukan tanggal, opsi layanan, serta jadwal persiapan dandan Anda.</p>
                            </div>
                        </div>
                        <div class="reservation-fields reservation-fields-two">
                            <div class="reservation-field reservation-field-event-date">
                                <label for="tgl_acara">Tanggal Acara / Rias <span>*</span></label>
                                <input id="tgl_acara" name="tgl_acara" type="date" min="{{ now()->toDateString() }}" value="{{ old('tgl_acara') }}" required>
                                @error('tgl_acara') <small class="reservation-error">{{ $message }}</small> @enderror
                            </div>

                            <!-- Opsi Tipe Reservasi Sesuai Revisi Dosen -->
                            <div class="reservation-field reservation-field-full">
                                <label>Tipe Layanan Acara <span>*</span></label>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 4px;">
                                    <label style="border: 1px solid var(--border-color); padding: 12px; border-radius: 8px; cursor: pointer; display: flex; align-items: flex-start; gap: 8px; background: #FFF;" id="label-tipe-lengkap">
                                        <input type="radio" name="tipe_reservasi" value="lengkap" checked style="margin-top: 3px;">
                                        <div>
                                            <strong style="display: block; font-size: 0.88rem; color: var(--text-dark);">Rias + Acara (Wedding/Lengkap)</strong>
                                            <small style="color: var(--text-muted); font-size: 0.78rem;">Termasuk persiapan dandan 3 jam sebelum acara & penggunaan venue acara hari itu.</small>
                                        </div>
                                    </label>
                                    <label style="border: 1px solid var(--border-color); padding: 12px; border-radius: 8px; cursor: pointer; display: flex; align-items: flex-start; gap: 8px; background: #FFF;" id="label-tipe-rias-saja">
                                        <input type="radio" name="tipe_reservasi" value="rias_saja" style="margin-top: 3px;">
                                        <div>
                                            <strong style="display: block; font-size: 0.88rem; color: var(--text-dark);">Rias Saja (Maks. 3 Jam)</strong>
                                            <small style="color: var(--text-muted); font-size: 0.78rem;">SOP Durasi Rias 3 Jam (Cth: 07:00 - 10:00). Setelah 3 jam, slot berikutnya dapat dibooking client lain.</small>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="reservation-field reservation-field-event-start">
                                <label for="waktu_mulai">Waktu Mulai Rias <span>*</span></label>
                                <input id="waktu_mulai" name="waktu_mulai" type="time" value="{{ old('waktu_mulai') }}" required>
                                @error('waktu_mulai') <small class="reservation-error">{{ $message }}</small> @enderror
                            </div>

                            <div class="reservation-field reservation-field-event-end">
                                <label for="waktu_selesai">Estimasi Selesai Rias (SOP 3 Jam) <span>*</span></label>
                                <input id="waktu_selesai" name="waktu_selesai" type="time" value="{{ old('waktu_selesai') }}" readonly style="background: #F4E6D2;">
                                @error('waktu_selesai') <small class="reservation-error">{{ $message }}</small> @enderror
                            </div>

                            <div class="reservation-field reservation-field-full">
                                <label style="display:flex;align-items:center;gap:9px;cursor:pointer;">
                                    <input id="full_day_booking" name="full_day" type="checkbox" value="1" @checked(old('full_day')) style="width:16px;height:16px;accent-color:var(--gold-primary);">
                                    Booking seharian (Full day acara: 09:00 - 21:00)
                                </label>
                            </div>

                            <div id="availability-hint" class="reservation-field reservation-field-full" aria-live="polite" style="color:var(--text-muted);font-size:.82rem;">
                                Pilih tanggal untuk melihat jam dandan yang masih kosong.
                            </div>

                            <div class="reservation-field reservation-field-full">
                                <label for="lokasi_acara">Lokasi Acara / Rias <span>*</span></label>
                                <textarea id="lokasi_acara" name="lokasi_acara" rows="3" maxlength="2000" placeholder="Nama gedung, alamat lengkap, dan patokan lokasi..." required>{{ old('lokasi_acara') }}</textarea>
                                @error('lokasi_acara') <small class="reservation-error">{{ $message }}</small> @enderror

                                <div style="display: flex; gap: 8px; margin-top: 10px; margin-bottom: 6px;">
                                    <input type="text" id="map-search-input" placeholder="Cari nama gedung, jalan, atau tempat (Cth: Polinema Kediri)..." style="flex: 1; padding: 8px 12px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.85rem; background: #FFF;">
                                    <button type="button" id="map-search-btn" class="btn" style="padding: 8px 14px; font-size: 0.85rem; border-radius: 6px;"><i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                                </div>
                                
                                <div id="map-picker" style="width: 100%; height: 260px; border-radius: 8px; margin-top: 10px; border: 1px solid var(--border-color);"></div>
                                <small style="color: var(--text-muted); display: block; margin-top: 4px;"><i class="fa-solid fa-location-dot" style="color: var(--gold-primary);"></i> Klik atau geser pin pada peta untuk menandai lokasi acara Anda secara otomatis.</small>
                            </div>

                            <div class="reservation-field reservation-field-full">
                                <label for="catatan">Catatan Tambahan <small style="color: var(--text-muted); font-weight: 400;">(Opsional)</small></label>
                                <textarea id="catatan" name="catatan" rows="3" maxlength="2000" placeholder="Ceritakan kebutuhan khusus atau detail acara Anda...">{{ old('catatan') }}</textarea>
                                @error('catatan') <small class="reservation-error">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </section>

                    <!-- SECTION 3: ITEM LAYANAN / PAKET -->
                    <section class="reservation-panel">
                        <div class="reservation-panel-heading">
                            <span class="reservation-step">03</span>
                            <div>
                                <h2>Pilih Layanan atau Paket</h2>
                                <p>Pilih satu paket atau satu maupun beberapa layanan.</p>
                            </div>
                        </div>
                        @php($jenisDipilih = old('jenis_pesanan',$selectedPackageId ? 'paket' : ''))
                        <input type="hidden" name="jenis_pesanan" id="jenis_pesanan" value="{{ $jenisDipilih }}">
                        
                        <div class="reservation-choice-types">
                            <button type="button" class="reservation-type-card {{ $jenisDipilih === 'paket' ? 'selected' : '' }}" data-type-choice="paket" @disabled($pakets->isEmpty())>
                                <span class="reservation-type-icon"><i class="fa-solid fa-box-open"></i></span>
                                <div>
                                    <strong>Pilih Paket</strong>
                                    <small>Paket penawaran lengkap</small>
                                </div>
                            </button>
                            <button type="button" class="reservation-type-card {{ $jenisDipilih === 'layanan' ? 'selected' : '' }}" data-type-choice="layanan" @disabled($layanans->isEmpty())>
                                <span class="reservation-type-icon"><i class="fa-solid fa-scissors"></i></span>
                                <div>
                                    <strong>Pilih Layanan</strong>
                                    <small>Layanan rias terpisah</small>
                                </div>
                            </button>
                        </div>
                        @error('jenis_pesanan') <small class="reservation-error">{{ $message }}</small> @enderror
                        @error('id_item') <small class="reservation-error">{{ $message }}</small> @enderror
                        @error('id_items') <small class="reservation-error">{{ $message }}</small> @enderror

                        <!-- LIST PAKET -->
                        <div class="reservation-choice-list" id="paket-options" data-options="paket" @if($jenisDipilih !== 'paket') hidden @endif>
                            @forelse ($pakets as $paket)
                                <label class="reservation-package-option" style="align-items: flex-start; padding: 16px;">
                                    <input type="radio" name="id_item" value="paket:{{ $paket->id }}" data-name="{{ $paket->nama_paket }}" data-price="{{ $paket->harga }}" @checked(old('id_item', $selectedItemValue) === 'paket:' . $paket->id && $jenisDipilih === 'paket')" style="margin-top: 4px;">
                                    <div class="reservation-package-info" style="display: flex; flex-direction: column; gap: 6px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                            <strong style="font-size: 0.95rem; color: var(--text-dark);">{{ $paket->nama_paket }}</strong>
                                            <span class="reservation-package-price" style="font-size: 1rem; font-weight: 800; color: var(--gold-primary);">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                                        </div>
                                        <small style="color: var(--gold-hover); font-weight: 700;">{{ $paket->kategoriPaket?->nama_kategori }}</small>
                                        
                                        @if($paket->deskripsi)
                                            <div style="background: #FDF8EF; border: 1px solid #F5E6CC; border-radius: 8px; padding: 10px 12px; margin-top: 4px; font-size: 0.82rem; color: #55483F; line-height: 1.5;">
                                                <strong style="display: block; color: var(--gold-hover); margin-bottom: 4px;"><i class="fa-solid fa-list-check" style="margin-right: 5px;"></i> Benefit &amp; Fasilitas Paket:</strong>
                                                <div style="white-space: pre-line;">{!! nl2br(e($paket->deskripsi)) !!}</div>
                                            </div>
                                        @endif
                                    </div>
                                </label>
                            @empty
                                <div style="text-align: center; color: var(--text-muted); padding: 16px;">Belum ada paket aktif.</div>
                            @endforelse
                        </div>

                        <!-- LIST LAYANAN -->
                        <div class="reservation-choice-list" id="layanan-options" data-options="layanan" @if($jenisDipilih !== 'layanan') hidden @endif>
                            @forelse ($layanans as $layanan)
                                <label class="reservation-package-option" style="align-items: flex-start; padding: 16px;">
                                    <input type="checkbox" name="id_items[]" value="{{ $layanan->id_layanan }}" data-name="{{ $layanan->nama_layanan }}" data-price="{{ $layanan->harga }}" @checked(in_array((string) $layanan->id_layanan, array_map('strval', (array) old('id_items', [])), true) && $jenisDipilih === 'layanan')" style="margin-top: 4px;">
                                    <div class="reservation-package-info" style="display: flex; flex-direction: column; gap: 6px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                            <strong style="font-size: 0.95rem; color: var(--text-dark);">{{ $layanan->nama_layanan }}</strong>
                                            <span class="reservation-package-price" style="font-size: 1rem; font-weight: 800; color: var(--gold-primary);">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</span>
                                        </div>
                                        
                                        @if($layanan->variasi)
                                            <small style="color: var(--gold-hover); font-weight: 700;">{{ $layanan->variasi }}</small>
                                        @endif
                                        
                                        @if($layanan->deskripsi)
                                            <div style="background: #FDF8EF; border: 1px solid #F5E6CC; border-radius: 8px; padding: 10px 12px; margin-top: 4px; font-size: 0.82rem; color: #55483F; line-height: 1.5;">
                                                <strong style="display: block; color: var(--gold-hover); margin-bottom: 4px;"><i class="fa-solid fa-circle-info" style="margin-right: 5px;"></i> Detail Layanan:</strong>
                                                <div style="white-space: pre-line;">{!! nl2br(e($layanan->deskripsi)) !!}</div>
                                            </div>
                                        @endif
                                    </div>
                                </label>
                            @empty
                                <div style="text-align: center; color: var(--text-muted); padding: 16px;">Belum ada layanan aktif.</div>
                            @endforelse
                        </div>
                    </section>
                </div>

                <button class="reservation-summary-trigger" type="button" id="summary-trigger" aria-expanded="false" aria-controls="reservation-summary">
                    <span>Rincian Reservasi</span>
                    <strong id="summary-trigger-total">Rp 0 <i class="fa-solid fa-chevron-up" style="margin-left:6px;"></i></strong>
                </button>

                <!-- RINCIAN RESERVASI POPUP -->
                <div class="reservation-summary-backdrop" id="summary-backdrop" hidden></div>
                <aside class="reservation-summary" id="reservation-summary" aria-labelledby="summary-heading" hidden>
                    <div class="reservation-summary-heading">
                        <h2 id="summary-heading">Rincian Reservasi</h2>
                        <button class="reservation-summary-close" type="button" id="summary-close" aria-label="Tutup rincian reservasi"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                    <div class="reservation-summary-row">
                        <span id="summary-item-label">Pilihan</span>
                        <strong id="summary-package-name">Belum ada pilihan</strong>
                    </div>
                    <div class="reservation-summary-row">
                        <span>Harga Pilihan</span>
                        <strong id="summary-unit-price">Rp 0</strong>
                    </div>
                    <div class="reservation-summary-total">
                        <span>Estimasi Total</span>
                        <strong id="summary-total">Rp 0</strong>
                    </div>
                    <p style="font-size: 0.78rem; color: var(--text-muted); margin-top: 14px; line-height: 1.5;">
                        Harga akhir dan ketersediaan jadwal akan dikonfirmasi oleh admin setelah reservasi diajukan.
                    </p>
                    <p style="font-size: 0.78rem; color: var(--gold-hover); margin-top: 8px; line-height: 1.5;">
                        Setelah reservasi dikirim, pembayaran dapat dilakukan melalui gateway atau unggah bukti pembayaran dari menu Riwayat Reservasi.
                    </p>
                    <button class="reservation-submit" type="button" id="submit-btn">
                        Ajukan Reservasi Sekarang <i class="fa-solid fa-arrow-right" style="margin-left: 6px;"></i>
                    </button>
                </aside>
            </div>
        </form>
    </main>

    <!-- SweetAlert2 CDN & Script Logic -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- 1. DEKLARASI ELEMEN DOM ---
            const reservationForm = document.getElementById('reservation-form');
            const submitBtn = document.getElementById('submit-btn');
            const typeInput = document.getElementById('jenis_pesanan');
            const typeButtons = document.querySelectorAll('[data-type-choice]');
            const optionGroups = document.querySelectorAll('[data-options]');
            const packageName = document.getElementById('summary-package-name');
            const unitPrice = document.getElementById('summary-unit-price');
            const total = document.getElementById('summary-total');
            const itemLabel = document.getElementById('summary-item-label');
            const summaryPopup = document.getElementById('reservation-summary');
            const summaryTrigger = document.getElementById('summary-trigger');
            const summaryClose = document.getElementById('summary-close');
            const summaryBackdrop = document.getElementById('summary-backdrop');
            const summaryTriggerTotal = document.getElementById('summary-trigger-total');
            const tglAcaraInput = document.getElementById('tgl_acara');
            const waktuMulaiInput = document.getElementById('waktu_mulai');
            const waktuSelesaiInput = document.getElementById('waktu_selesai');
            const fullDayInput = document.getElementById('full_day_booking');
            const lokasiAcaraInput = document.getElementById('lokasi_acara');
            const availabilityHint = document.getElementById('availability-hint');
            const tipeReservasiInputs = document.querySelectorAll('input[name="tipe_reservasi"]');
            const labelLengkap = document.getElementById('label-tipe-lengkap');
            const labelRiasSaja = document.getElementById('label-tipe-rias-saja');

            let bookedSchedules = [];
            let lastConflictKey = '';
            let previousTimes = null;
            const formatPrice = value => new Intl.NumberFormat('id-ID').format(value);

            // --- 2. UTILITY WAKTU & OPERASIONAL ---
            const JAM_BUKA_ACARA = 9 * 60;   // 540 menit (09:00)
            const JAM_BUKA_RIAS = 3 * 60;    // 180 menit (03:00 Subuh)
            const JAM_TUTUP = 21 * 60;       // 1260 menit (21:00)

            const timeToMinutes = time => {
                const [hours, minutes] = (time || '00:00').slice(0, 5).split(':').map(Number);
                return (hours * 60) + minutes;
            };
            const minutesToTime = minutes => `${String(Math.floor(minutes / 60)).padStart(2, '0')}:${String(minutes % 60).padStart(2, '0')}`;
            const schedulesForDate = date => bookedSchedules.filter(schedule => schedule.date === date);
            const isScheduleFullDay = schedule => schedule.full_day || (!schedule.start && !schedule.end);

            function getFreeSlots(date) {
                const busy = schedulesForDate(date).map(schedule => ({
                    start: isScheduleFullDay(schedule) ? JAM_BUKA_ACARA : Math.max(JAM_BUKA_RIAS, timeToMinutes(schedule.start)),
                    end: isScheduleFullDay(schedule) ? JAM_TUTUP : Math.min(JAM_TUTUP, timeToMinutes(schedule.end))
                })).sort((a, b) => a.start - b.start);
                
                const slots = [];
                let cursor = JAM_BUKA_RIAS;
                busy.forEach(interval => {
                    if (interval.start > cursor) slots.push([minutesToTime(cursor), minutesToTime(interval.start)]);
                    cursor = Math.max(cursor, interval.end);
                });
                if (cursor < JAM_TUTUP) slots.push([minutesToTime(cursor), minutesToTime(JAM_TUTUP)]);
                return slots.filter(slot => timeToMinutes(slot[1]) > timeToMinutes(slot[0]));
            }

            // --- 3. SINKRONISASI TIPE RESERVASI & EFEK HIGHLIGHT ---
            function updateTipeHighlight() {
                const selectedValue = document.querySelector('input[name="tipe_reservasi"]:checked')?.value;
                if (labelLengkap && labelRiasSaja) {
                    if (selectedValue === 'lengkap') {
                        labelLengkap.style.borderColor = 'var(--gold-primary)';
                        labelLengkap.style.background = '#FDF8EF';
                        labelRiasSaja.style.borderColor = 'var(--border-color)';
                        labelRiasSaja.style.background = '#FFF';
                    } else if (selectedValue === 'rias_saja') {
                        labelRiasSaja.style.borderColor = 'var(--gold-primary)';
                        labelRiasSaja.style.background = '#FDF8EF';
                        labelLengkap.style.borderColor = 'var(--border-color)';
                        labelLengkap.style.background = '#FFF';
                    }
                }
            }

            function calculateEndTime() {
                if (!waktuMulaiInput.value) return;

                const tipeSelected = document.querySelector('input[name="tipe_reservasi"]:checked')?.value;
                
                if (fullDayInput.checked || tipeSelected === 'lengkap') {
                    waktuSelesaiInput.value = '21:00';
                } else if (tipeSelected === 'rias_saja') {
                    const startMinutes = timeToMinutes(waktuMulaiInput.value);
                    const endMinutes = startMinutes + (3 * 60); // SOP 3 Jam
                    if (endMinutes <= (24 * 60)) {
                        waktuSelesaiInput.value = minutesToTime(endMinutes);
                    }
                }
            }

            function syncTipeAndPackage() {
                const tipeSelected = document.querySelector('input[name="tipe_reservasi"]:checked')?.value;
                const selectedItem = document.querySelector('#paket-options input[name="id_item"]:checked') 
                    || document.querySelector('#layanan-options input[name="id_items[]"]:checked');

                if (!selectedItem) {
                    updateSummary();
                    return;
                }

                const itemName = selectedItem.dataset.name || '';
                const itemNameLower = itemName.toLowerCase();
                const isWeddingOrFull = itemNameLower.includes('wedding') || itemNameLower.includes('pengantin') || itemNameLower.includes('dekorasi') || itemNameLower.includes('lengkap');

                if (isWeddingOrFull) {
                    if (tipeSelected !== 'lengkap') {
                        const radioLengkap = document.querySelector('input[name="tipe_reservasi"][value="lengkap"]');
                        if (radioLengkap) radioLengkap.checked = true;
                    }
                    fullDayInput.checked = true;
                } else {
                    const wasFullDay = fullDayInput.checked || tipeSelected === 'lengkap';

                    if (tipeSelected !== 'rias_saja') {
                        const radioRiasSaja = document.querySelector('input[name="tipe_reservasi"][value="rias_saja"]');
                        if (radioRiasSaja) radioRiasSaja.checked = true;
                    }
                    
                    fullDayInput.checked = false;

                    if (wasFullDay) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Tipe Layanan Disesuaikan',
                            html: `Anda memilih <strong>${itemName}</strong>.<br>Opsi otomatis diubah ke <strong>Rias Saja (SOP Maks. 3 Jam)</strong> dan centang <em>Full Day</em> dilepas.`,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true,
                            background: '#FFFFFF',
                            color: '#241A16'
                        });
                    }
                }

                updateTipeHighlight();
                syncFullDayInputs();
                calculateEndTime();
                updateSummary();
            }

            // --- 4. FUNGSIONALITAS KALKULASI RINGKASAN HARGA & OPSI ---
            function updateSummary() {
                const currentType = typeInput.value || 'paket';
                
                const selectedItems = currentType === 'layanan'
                    ? [...document.querySelectorAll('#layanan-options input[name="id_items[]"]:checked')]
                    : [...document.querySelectorAll('#paket-options input[name="id_item"]:checked')];

                const price = selectedItems.reduce((sum, item) => sum + Number(item.dataset.price || 0), 0);
                const names = selectedItems.map(item => item.dataset.name);

                itemLabel.textContent = currentType === 'paket' ? 'Paket dipilih' : (currentType === 'layanan' ? 'Layanan dipilih' : 'Pilihan');
                packageName.textContent = names.length ? names.join(', ') : 'Belum ada pilihan';
                unitPrice.textContent = 'Rp ' + formatPrice(price);
                total.textContent = 'Rp ' + formatPrice(price);
                summaryTriggerTotal.innerHTML = 'Rp ' + formatPrice(price) + ' <i class="fa-solid fa-chevron-up" style="margin-left:6px;"></i>';
            }

            function showOptions(type) {
                typeInput.value = type;
                typeButtons.forEach(button => {
                    const active = button.dataset.typeChoice === type;
                    button.classList.toggle('selected', active);
                });
                optionGroups.forEach(group => {
                    const active = group.dataset.options === type;
                    group.hidden = !active;
                    const inputs = [...group.querySelectorAll('input')];
                    inputs.forEach((input, index) => {
                        input.disabled = !active;
                        input.required = active && type === 'paket' && index === 0;
                    });
                });
                updateOptionButtonStyles();
                updateSummary();
            }

            function updateOptionButtonStyles() {
                document.querySelectorAll('.reservation-package-option').forEach(label => {
                    label.classList.toggle('selected', Boolean(label.querySelector('input:checked')));
                });
            }

            // --- 5. EVENT LISTENERS PERUBAHAN INPUT ---
            tipeReservasiInputs.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'rias_saja') {
                        fullDayInput.checked = false;
                        syncFullDayInputs();
                    } else if (this.value === 'lengkap') {
                        fullDayInput.checked = true;
                        syncFullDayInputs();
                    }
                    updateTipeHighlight();
                    calculateEndTime();
                    hasTimeConflict(true);
                    updateSummary();
                });
            });

            waktuMulaiInput.addEventListener('change', () => {
                calculateEndTime();
                updateSummary();
            });

            document.querySelectorAll('input[name="id_item"], input[name="id_items[]"]').forEach(input => {
                input.addEventListener('change', () => {
                    syncTipeAndPackage();
                    updateOptionButtonStyles();
                    updateSummary();
                });
            });

            // --- 6. PENCARIAN LOKASI PETA (OSM NOMINATIM) ---
            const searchInput = document.getElementById('map-search-input');
            const searchBtn = document.getElementById('map-search-btn');

            async function searchLocation(query) {
                if (!query.trim()) return;
                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`);
                    const results = await response.json();
                    
                    if (results && results.length > 0) {
                        const lat = parseFloat(results[0].lat);
                        const lon = parseFloat(results[0].lon);
                        const displayName = results[0].display_name;

                        map.setView([lat, lon], 16);
                        marker.setLatLng([lat, lon]);
                        lokasiAcaraInput.value = displayName;
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'Lokasi Tidak Ditemukan',
                            text: 'Coba gunakan kata kunci nama gedung atau jalan yang lebih spesifik.',
                            confirmButtonColor: '#C58F43',
                            background: '#FFFFFF',
                            color: '#241A16'
                        });
                    }
                } catch (error) {
                    console.error('Gagal melakukan pencarian lokasi:', error);
                }
            }

            if (searchBtn && searchInput) {
                searchBtn.addEventListener('click', () => searchLocation(searchInput.value));
                searchInput.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        searchLocation(searchInput.value);
                    }
                });
            }

            // --- 7. INISIALISASI PETA LEAFLET ---
            const defaultLat = -7.8480; 
            const defaultLng = 112.0178;

            const map = L.map('map-picker').setView([defaultLat, defaultLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            let marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

            async function updateAddress(lat, lng) {
                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
                    const data = await response.json();
                    if (data && data.display_name) {
                        lokasiAcaraInput.value = data.display_name;
                    }
                } catch (error) {
                    console.error('Gagal mengambil detail alamat:', error);
                }
            }

            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;
                marker.setLatLng([lat, lng]);
                updateAddress(lat, lng);
            });

            marker.on('dragend', function(e) {
                const position = marker.getLatLng();
                updateAddress(position.lat, position.lng);
            });

            // --- 8. HINT & VALIDASI JADWAL OPERASIONAL ---
            function updateAvailabilityHint() {
                if (!tglAcaraInput.value) {
                    availabilityHint.textContent = 'Pilih tanggal untuk melihat jam dandan yang masih kosong.';
                    return;
                }
                const slots = getFreeSlots(tglAcaraInput.value);
                availabilityHint.textContent = slots.length
                    ? `Jam kosong (03:00 - 21:00): ${slots.map(slot => `${slot[0]}–${slot[1]}`).join(', ')}`
                    : 'Tidak ada jam kosong pada tanggal ini (Full).';
            }

            function validateOperationalHours() {
                if (fullDayInput.checked) return true;

                const startMin = timeToMinutes(waktuMulaiInput.value);
                const endMin = timeToMinutes(waktuSelesaiInput.value);
                const tipeSelected = document.querySelector('input[name="tipe_reservasi"]:checked')?.value;

                if (!waktuMulaiInput.value || !waktuSelesaiInput.value) return true;

                const jamBukaEfektif = (tipeSelected === 'rias_saja') ? JAM_BUKA_RIAS : JAM_BUKA_ACARA;
                const labelJamBuka = (tipeSelected === 'rias_saja') ? '03:00 Subuh' : '09:00 Pagi';

                if (startMin < jamBukaEfektif || startMin > JAM_TUTUP || endMin > JAM_TUTUP) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Diluar Jam Operasional',
                        text: `Untuk layanan ${tipeSelected === 'rias_saja' ? 'Rias Saja' : 'Rias + Acara'}, waktu rias dapat dimulai antara pukul ${labelJamBuka} sampai 21:00 malam.`,
                        confirmButtonColor: '#C58F43',
                        background: '#FFFFFF',
                        color: '#241A16'
                    });
                    return false;
                }

                if (endMin <= startMin) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Waktu Tidak Valid',
                        text: 'Waktu selesai harus lebih besar daripada waktu mulai.',
                        confirmButtonColor: '#C58F43',
                        background: '#FFFFFF',
                        color: '#241A16'
                    });
                    return false;
                }

                return true;
            }

            function hasTimeConflict(showPopup = false) {
                const date = tglAcaraInput.value;
                const start = fullDayInput.checked ? '09:00' : waktuMulaiInput.value;
                const end = fullDayInput.checked ? '21:00' : waktuSelesaiInput.value;
                if (!date || !start || !end || timeToMinutes(end) <= timeToMinutes(start)) return false;

                const requestedFullDay = fullDayInput.checked || (start === '09:00' && end === '21:00');
                const conflict = schedulesForDate(date).find(schedule => {
                    if (requestedFullDay || isScheduleFullDay(schedule)) return true;
                    return timeToMinutes(start) < timeToMinutes(schedule.end)
                        && timeToMinutes(end) > timeToMinutes(schedule.start);
                });
                if (!conflict) {
                    lastConflictKey = '';
                    return false;
                }

                const conflictKey = `${date}-${start}-${end}`;
                if (showPopup && lastConflictKey !== conflictKey) {
                    const slots = getFreeSlots(date);
                    const freeHours = slots.length ? slots.map(slot => `${slot[0]}–${slot[1]}`).join(', ') : 'Tidak ada jam kosong.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Jam Tidak Tersedia',
                        html: `Waktu yang dipilih sudah berbenturan dengan booking lain.<br><strong>Jam yang masih kosong:</strong> ${freeHours}`,
                        confirmButtonColor: '#EF4444',
                        background: '#FFFFFF',
                        color: '#241A16'
                    });
                    lastConflictKey = conflictKey;
                }
                return true;
            }

            function syncFullDayInputs() {
                if (fullDayInput.checked) {
                    if (!previousTimes) previousTimes = [waktuMulaiInput.value, waktuSelesaiInput.value];
                    waktuMulaiInput.value = '09:00';
                    waktuSelesaiInput.value = '21:00';
                    waktuMulaiInput.readOnly = true;
                    waktuSelesaiInput.readOnly = true;
                } else {
                    waktuMulaiInput.readOnly = false;
                    waktuSelesaiInput.readOnly = false;
                    if (waktuMulaiInput.value === '09:00' && waktuSelesaiInput.value === '21:00' && previousTimes) {
                        [waktuMulaiInput.value, waktuSelesaiInput.value] = previousTimes;
                    }
                    previousTimes = null;
                }
                updateAvailabilityHint();
                hasTimeConflict(true);
            }

            // --- 9. NOTIFIKASI SESSION FLASH ---
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Reservasi Berhasil Diajukan!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#C58F43',
                    background: '#FFFFFF',
                    color: '#241A16'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mengajukan Reservasi',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#EF4444',
                    background: '#FFFFFF',
                    color: '#241A16'
                });
            @endif

            @if(session('booking_conflict'))
                const bookingConflict = @json(session('booking_conflict'));
                const freeHoursAfterConflict = bookingConflict.free_slots?.length
                    ? bookingConflict.free_slots.map(slot => `${slot[0]}–${slot[1]}`).join(', ')
                    : 'Tidak ada jam kosong.';
                Swal.fire({
                    icon: 'error',
                    title: 'Jam Tidak Tersedia',
                    html: `Waktu yang dipilih sudah dibooking client lain.<br><strong>Jam yang masih kosong:</strong> ${freeHoursAfterConflict}`,
                    confirmButtonColor: '#EF4444',
                    background: '#FFFFFF',
                    color: '#241A16'
                });
            @endif

            // --- 10. SUBMIT FORM & POPUP ---
            if (submitBtn) {
                submitBtn.addEventListener('click', function (e) {
                    e.preventDefault();

                    if (!tglAcaraInput.value || !waktuMulaiInput.value || !waktuSelesaiInput.value) {
                        setSummaryOpen(false);
                        Swal.fire({
                            icon: 'warning',
                            title: 'Detail Acara Belum Lengkap',
                            text: 'Silakan isi Tanggal, Waktu Mulai, dan Waktu Selesai acara.',
                            confirmButtonColor: '#C58F43'
                        });
                        return;
                    }

                    if (!validateOperationalHours()) {
                        setSummaryOpen(false);
                        return;
                    }

                    if (!lokasiAcaraInput.value.trim()) {
                        setSummaryOpen(false);
                        lokasiAcaraInput.focus();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Lokasi Belum Diisi',
                            text: 'Silakan isi kolom Lokasi Acara terlebih dahulu.',
                            confirmButtonColor: '#C58F43'
                        });
                        return;
                    }

                    if (hasTimeConflict(true)) {
                        setSummaryOpen(false);
                        return;
                    }

                    const selectedItems = typeInput.value === 'layanan'
                        ? [...document.querySelectorAll('#layanan-options input[name="id_items[]"]:checked')]
                        : [...document.querySelectorAll('#paket-options input[name="id_item"]:checked')];
                    
                    if (!selectedItems.length) {
                        setSummaryOpen(false);
                        Swal.fire({
                            icon: 'warning',
                            title: 'Pilihan Belum Lengkap',
                            text: 'Silakan pilih paket atau layanan terlebih dahulu di bagian bawah.',
                            confirmButtonColor: '#C58F43',
                            background: '#FFFFFF',
                            color: '#241A16'
                        });
                        return;
                    }

                    const itemName = selectedItems.map(item => item.dataset.name || 'Pilihan Rias').join(', ');
                    const eventDate = tglAcaraInput.value || '-';

                    Swal.fire({
                        title: 'Konfirmasi Pengajuan Reservasi?',
                        html: `Apakah Anda yakin ingin mengajukan reservasi untuk <strong>${itemName}</strong> pada tanggal <strong>${eventDate}</strong>?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#C58F43',
                        cancelButtonColor: '#8C8279',
                        confirmButtonText: 'Ya, Ajukan Sekarang',
                        cancelButtonText: 'Periksa Kembali',
                        reverseButtons: true,
                        background: '#FFFFFF',
                        color: '#241A16'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Memproses Reservasi...',
                                text: 'Mohon tunggu sebentar.',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            reservationForm.submit();
                        }
                    });
                });
            }

            // --- 11. FETCH API & INITIALIZATION ---
            fetch('{{ route("api.jadwal.tervalidasi") }}')
                .then(response => response.json())
                .then(schedules => {
                    bookedSchedules = schedules;
                    updateAvailabilityHint();
                    hasTimeConflict(false);
                })
                .catch(error => console.error('Gagal memuat jadwal booking:', error));

            tglAcaraInput.addEventListener('change', () => {
                lastConflictKey = '';
                updateAvailabilityHint();
                hasTimeConflict(true);
            });
            
            [waktuMulaiInput, waktuSelesaiInput].forEach(input => input.addEventListener('change', () => {
                if (validateOperationalHours()) {
                    hasTimeConflict(true);
                }
            }));
            
            fullDayInput.addEventListener('change', syncFullDayInputs);

            function setSummaryOpen(open) {
                summaryPopup.hidden = !open;
                summaryBackdrop.hidden = !open;
                summaryTrigger.setAttribute('aria-expanded', String(open));
                if (open) summaryClose.focus();
                else summaryTrigger.focus();
            }

            summaryTrigger.addEventListener('click', () => setSummaryOpen(summaryPopup.hidden));
            summaryClose.addEventListener('click', () => setSummaryOpen(false));
            document.addEventListener('keydown', event => {
                if (event.key === 'Escape' && !summaryPopup.hidden) setSummaryOpen(false);
            });

            typeButtons.forEach(button => button.addEventListener('click', () => showOptions(button.dataset.typeChoice)));

            // Inisialisasi awal saat halaman pertama dimuat
            const initialType = typeInput.value || 'paket';
            showOptions(initialType);
            syncFullDayInputs();
            updateTipeHighlight();
            calculateEndTime();
            syncTipeAndPackage();
            updateSummary();
        });

        function confirmLogoutClient() {
            Swal.fire({
                title: 'Keluar dari Akun?',
                text: 'Anda harus masuk kembali untuk membuat atau melihat reservasi.',
                icon: 'question',
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
                    document.getElementById('logout-form-client').submit();
                }
            });
        }
    </script>
</body>
</html>