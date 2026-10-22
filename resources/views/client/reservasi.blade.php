<!DOCTYPE html>
<html lang="id">
<head>
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
        .reservation-layout { display: grid; grid-template-columns: 1fr 340px; gap: 28px; align-items: start; }
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
        .reservation-package-option:hover { border-color: var(--gold-primary); }
        .reservation-package-info { flex: 1; display: flex; flex-direction: column; gap: 2px; }
        .reservation-package-info strong { color: var(--text-dark); font-size: 0.88rem; }
        .reservation-package-info small { color: var(--gold-primary); font-weight: 600; font-size: 0.78rem; }
        .reservation-package-info span { color: var(--text-muted); font-size: 0.8rem; }
        .reservation-package-price { font-weight: 800; color: var(--gold-primary); font-size: 0.95rem; }

        /* Summary Sticky Card */
        .reservation-summary {
            background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 14px;
            padding: 24px; position: sticky; top: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        }
        .reservation-summary-heading h2 { font-family: 'Playfair Display', serif; font-size: 1.3rem; color: var(--text-dark); margin-bottom: 16px; }
        .reservation-summary-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.88rem; color: var(--text-muted); }
        .reservation-summary-row strong { color: var(--text-dark); }
        .reservation-summary-total {
            display: flex; justify-content: space-between; align-items: center; padding-top: 14px;
            border-top: 1px solid var(--border-color); margin-top: 14px; font-weight: 700;
        }
        .reservation-summary-total strong { font-size: 1.2rem; color: var(--gold-primary); }
        
        .reservation-submit {
            width: 100%; margin-top: 20px; padding: 12px; background: var(--gold-primary); color: #FFF;
            border: none; border-radius: 8px; font-weight: 700; font-size: 0.9rem; cursor: pointer; transition: .2s;
        }
        .reservation-submit:hover:not(:disabled) { background: var(--gold-hover); }
        .reservation-submit:disabled { opacity: 0.6; cursor: not-allowed; }

        .reservation-alert { padding: 12px 16px; background: #FEF2F2; border: 1px solid #FCA5A5; color: #991B1B; border-radius: 10px; margin-bottom: 20px; font-size: 0.88rem; }
        .reservation-error { color: #DC2626; font-size: 0.78rem; margin-top: 4px; display: block; }

        @media(max-width: 992px) {
            .reservation-layout { grid-template-columns: 1fr; }
            .reservation-fields-two { grid-template-columns: 1fr; }
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
                                <h2>Detail Acara</h2>
                                <p>Tentukan tanggal, waktu, dan lokasi acara Anda.</p>
                            </div>
                        </div>
                        <div class="reservation-fields reservation-fields-two">
                            <div class="reservation-field">
                                <label for="tgl_acara">Tanggal Acara <span>*</span></label>
                                <input id="tgl_acara" name="tgl_acara" type="date" min="{{ now()->toDateString() }}" value="{{ old('tgl_acara') }}" required>
                                @error('tgl_acara') <small class="reservation-error">{{ $message }}</small> @enderror
                            </div>
                            <div class="reservation-field">
                                <label for="jumlah_pesanan">Jumlah Pilihan <span>*</span></label>
                                <input id="jumlah_pesanan" name="jumlah_pesanan" type="number" min="1" max="20" value="{{ old('jumlah_pesanan', 1) }}" required>
                                @error('jumlah_pesanan') <small class="reservation-error">{{ $message }}</small> @enderror
                            </div>
                            <div class="reservation-field">
                                <label for="waktu_mulai">Waktu Mulai <span>*</span></label>
                                <input id="waktu_mulai" name="waktu_mulai" type="time" value="{{ old('waktu_mulai') }}" required>
                                @error('waktu_mulai') <small class="reservation-error">{{ $message }}</small> @enderror
                            </div>
                            <div class="reservation-field">
                                <label for="waktu_selesai">Waktu Selesai <span>*</span></label>
                                <input id="waktu_selesai" name="waktu_selesai" type="time" value="{{ old('waktu_selesai') }}" required>
                                @error('waktu_selesai') <small class="reservation-error">{{ $message }}</small> @enderror
                            </div>
                            <div class="reservation-field reservation-field-full">
                                <label for="lokasi_acara">Lokasi Acara <span>*</span></label>
                                <textarea id="lokasi_acara" name="lokasi_acara" rows="3" maxlength="2000" placeholder="Nama gedung, alamat lengkap, dan patokan lokasi..." required>{{ old('lokasi_acara') }}</textarea>
                                @error('lokasi_acara') <small class="reservation-error">{{ $message }}</small> @enderror
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
                                <p>Tentukan kategori pilihan yang diinginkan.</p>
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

                        <!-- LIST PAKET -->
                        <div class="reservation-choice-list" id="paket-options" data-options="paket" @if($jenisDipilih !== 'paket') hidden @endif>
                            @forelse ($pakets as $paket)
                                <label class="reservation-package-option">
                                    <input type="radio" name="id_item" value="paket:{{ $paket->id }}" data-name="{{ $paket->nama_paket }}" data-price="{{ $paket->harga }}" @checked(old('id_item', $selectedItemValue) === 'paket:' . $paket->id &&$jenisDipilih === 'paket')>
                                    <div class="reservation-package-info">
                                        <strong>{{ $paket->nama_paket }}</strong>
                                        <small>{{ $paket->kategoriPaket?->nama_kategori }}</small>
                                        @if($paket->deskripsi)<span>{{$paket->deskripsi }}</span>@endif
                                    </div>
                                    <span class="reservation-package-price">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                                </label>
                            @empty
                                <div style="text-align: center; color: var(--text-muted); padding: 16px;">Belum ada paket aktif.</div>
                            @endforelse
                        </div>

                        <!-- LIST LAYANAN -->
                        <div class="reservation-choice-list" id="layanan-options" data-options="layanan" @if($jenisDipilih !== 'layanan') hidden @endif>
                            @forelse ($layanans as $layanan)
                                <label class="reservation-package-option">
                                    <input type="radio" name="id_item" value="layanan:{{ $layanan->id_layanan }}" data-name="{{ $layanan->nama_layanan }}" data-price="{{ $layanan->harga }}" @checked(old('id_item') === 'layanan:' . $layanan->id_layanan &&$jenisDipilih === 'layanan')>
                                    <div class="reservation-package-info">
                                        <strong>{{ $layanan->nama_layanan }}</strong>
                                        @if($layanan->variasi)<small>{{$layanan->variasi }}</small>@endif
                                        @if($layanan->deskripsi)<span>{{$layanan->deskripsi }}</span>@endif
                                    </div>
                                    <span class="reservation-package-price">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</span>
                                </label>
                            @empty
                                <div style="text-align: center; color: var(--text-muted); padding: 16px;">Belum ada layanan aktif.</div>
                            @endforelse
                        </div>
                    </section>
                </div>

                <!-- STICKY SUMMARY -->
                <aside class="reservation-summary">
                    <div class="reservation-summary-heading">
                        <h2>Rincian Reservasi</h2>
                    </div>
                    <div class="reservation-summary-row">
                        <span id="summary-item-label">Pilihan</span>
                        <strong id="summary-package-name">Belum ada pilihan</strong>
                    </div>
                    <div class="reservation-summary-row">
                        <span>Harga Satuan</span>
                        <strong id="summary-unit-price">Rp 0</strong>
                    </div>
                    <div class="reservation-summary-row">
                        <span>Jumlah Pilihan</span>
                        <strong id="summary-quantity">{{ old('jumlah_pesanan', 1) }}</strong>
                    </div>
                    <div class="reservation-summary-total">
                        <span>Estimasi Total</span>
                        <strong id="summary-total">Rp 0</strong>
                    </div>
                    <p style="font-size: 0.78rem; color: var(--text-muted); margin-top: 14px; line-height: 1.5;">
                        Harga akhir dan ketersediaan jadwal akan dikonfirmasi oleh admin setelah reservasi diajukan.
                    </p>
                    <button class="reservation-submit" type="submit" @disabled($pakets->isEmpty() &&$layanans->isEmpty())>
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
            const reservationForm = document.getElementById('reservation-form');
            const typeInput = document.getElementById('jenis_pesanan');
            const typeButtons = document.querySelectorAll('[data-type-choice]');
            const optionGroups = document.querySelectorAll('[data-options]');
            const quantityInput = document.getElementById('jumlah_pesanan');
            const packageName = document.getElementById('summary-package-name');
            const unitPrice = document.getElementById('summary-unit-price');
            const quantity = document.getElementById('summary-quantity');
            const total = document.getElementById('summary-total');
            const itemLabel = document.getElementById('summary-item-label');
            const tglAcaraInput = document.getElementById('tgl_acara');
            const formatPrice = value => new Intl.NumberFormat('id-ID').format(value);

            // Flash Message Notifikasi SweetAlert2 dari Session Controller
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

            // Intercept Submit Formulir Reservasi dengan Popup Konfirmasi
            if (reservationForm) {
                reservationForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const selectedItem = document.querySelector('input[name="id_item"]:checked');
                    if (!selectedItem) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Pilihan Belum Lengkap',
                            text: 'Silakan pilih paket atau layanan terlebih dahulu.',
                            confirmButtonColor: '#C58F43',
                            background: '#FFFFFF',
                            color: '#241A16'
                        });
                        return;
                    }

                    const itemName = selectedItem.dataset.name || 'Pilihan Rias';
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

            // Pengecekan Tanggal yang Sudah Dibooking Admin
            fetch('{{ route("api.jadwal.tervalidasi") }}')
                .then(response => response.json())
                .then(bookedDates => {
                    tglAcaraInput.addEventListener('input', function () {
                        if (bookedDates.includes(this.value)) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Tanggal Tidak Tersedia',
                                text: 'Tanggal ini sudah dibooking dan divalidasi oleh admin. Silakan pilih tanggal lain.',
                                confirmButtonColor: '#EF4444',
                                background: '#FFFFFF',
                                color: '#241A16'
                            });
                            this.value = '';
                        }
                    });
                })
                .catch(error => console.error('Gagal memuat jadwal tervalidasi:', error));

            function showOptions(type) {
                typeInput.value = type;
                typeButtons.forEach(button => {
                    const active = button.dataset.typeChoice === type;
                    button.classList.toggle('selected', active);
                });
                optionGroups.forEach(group => {
                    const active = group.dataset.options === type;
                    group.hidden = !active;
                    const radios = [...group.querySelectorAll('input[name="id_item"]')];
                    radios.forEach(radio => {
                        radio.disabled = !active;
                        radio.required = active && radios[0] === radio;
                        if (!active) radio.checked = false;
                    });
                });
                updateSummary();
            }

            function updateSummary() {
                const selectedItem = document.querySelector('input[name="id_item"]:checked');
                const selectedQuantity = Math.max(1, Number(quantityInput.value) || 1);
                const selected = selectedItem && !selectedItem.disabled ? selectedItem : null;
                const price = selected ? Number(selected.dataset.price) : 0;

                itemLabel.textContent = typeInput.value === 'paket' ? 'Paket dipilih' : (typeInput.value === 'layanan' ? 'Layanan dipilih' : 'Pilihan');
                packageName.textContent = selected ? selected.dataset.name : 'Belum ada pilihan';
                unitPrice.textContent = 'Rp ' + formatPrice(price);
                quantity.textContent = selectedQuantity;
                total.textContent = 'Rp ' + formatPrice(price * selectedQuantity);
            }

            typeButtons.forEach(button => button.addEventListener('click', () => showOptions(button.dataset.typeChoice)));
            document.querySelectorAll('input[name="id_item"]').forEach(input => input.addEventListener('change', updateSummary));
            quantityInput.addEventListener('input', updateSummary);
            if (typeInput.value) showOptions(typeInput.value);
            else updateSummary();
        });

        // Konfirmasi Logout Client
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