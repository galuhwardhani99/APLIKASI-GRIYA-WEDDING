<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Favicon (Logo Tab Browser) -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
    
    <!-- CSRF Token untuk Keamanan Sesi -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Beranda') - Griya Rias Elly Jr.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS SweetAlert2 untuk Popup -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        /* ================= UI SHARPNESS & CONTRAST ENHANCEMENT ================= */
        :root {
            --gold-primary: #B9833B;
            --gold-dark: #9C6F32;
            --text-main: #1A1A1A;
            --border-crisp: #E2D9CC;
            --border-dark: #2A2421;
        }

        body {
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Topbar Tajam & Kontras Tinggi */
        .topbar {
            background-color: #1F1916;
            border-bottom: 2px solid var(--gold-primary);
        }

        .topbar-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 6px 32px;
            width: 100%;
            position: relative;
            font-weight: 600;
            font-size: 0.8rem;
            color: #FDFBF7;
        }

        .topbar-logout-form {
            position: absolute;
            right: 32px;
        }

        .topbar-logout-btn {
            background: #2A221E;
            border: 1px solid #C58F43;
            color: #FDFBF7;
            padding: 4px 14px;
            border-radius: 4px;
            font-size: 0.72rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Plus Jakarta Sans', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .topbar-logout-btn:hover {
            background: #DC2626;
            border-color: #DC2626;
            color: #FFFFFF;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.4);
        }

        /* Header Navigation Tajam */
        header.nav {
            background: #FFFFFF;
            border-bottom: 1px solid var(--border-crisp);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .nav-side.nav-right {
            gap: 20px !important;
            align-items: center;
        }

        .client-home-page .nav-inner {
            grid-template-columns: auto auto auto;
            justify-content: center;
            column-gap: 36px;
        }

        .client-home-page .nav-left { justify-content: flex-end; }
        .client-home-page .nav-right { justify-content: flex-start; }

        /* Teks Navigasi Lebih Jelas */
        .nav-link {
            font-weight: 700 !important;
            color: #2D2622 !important;
            font-size: 0.85rem;
            letter-spacing: 0.03em;
            transition: color 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--gold-primary) !important;
        }

        /* Brand Logo Tajam */
        .brand {
            border-left: 2px solid var(--gold-primary);
            padding-left: 14px;
            padding-right: 12px;
        }

        .brand small {
            font-weight: 800;
            color: var(--gold-primary);
            letter-spacing: 0.25em;
        }

        .brand strong {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            color: #1A1A1A;
            font-weight: 700;
        }

        /* Tombol Utama Tajam & Solid */
        .btn-pill-center {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            line-height: 1.2;
            padding: 8px 24px;
            border-radius: 50px;
            background: var(--gold-primary);
            border: 1px solid #A06F2D;
            color: #FFFFFF !important;
            font-weight: 800;
            font-size: 0.78rem;
            letter-spacing: 0.06em;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(185, 131, 59, 0.25);
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .btn-pill-center:hover {
            background-color: var(--gold-dark);
            border-color: #835B25;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(185, 131, 59, 0.35);
        }

        .btn-link {
            font-weight: 700;
            color: #2D2622;
            padding: 8px 16px;
            border-radius: 6px;
            border: 1px solid var(--border-crisp);
            transition: all 0.2s ease;
        }

        .btn-link:hover {
            border-color: var(--gold-primary);
            color: var(--gold-primary);
            background: #FAF7F2;
        }

        /* Footer Tajam */
        .footer {
            background: #171311;
            border-top: 3px solid var(--gold-primary);
            color: #E5DFD7;
        }

        .footer-brand {
            font-family: 'Playfair Display', serif;
            color: #FFFFFF;
            font-size: 1.3rem;
            font-weight: 700;
        }

        .footer-brand small {
            color: var(--gold-primary);
            font-weight: 800;
            display: block;
            font-size: 0.7rem;
            letter-spacing: 0.2em;
        }

        /* Location Modal Penegasan Border */
        .location-modal-card {
            border: 1px solid var(--border-crisp);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            border-radius: 12px;
        }

        .location-modal-header {
            border-bottom: 2px solid var(--border-crisp);
        }
    </style>
</head>
<body class="{{ request()->routeIs('client.dashboard') ? 'client-dashboard-page' : '' }} {{ request()->routeIs('client.home') ? 'client-home-page' : '' }}">
    <div class="progress" id="progress"></div>

    @unless(request()->routeIs('client.dashboard'))
    <!-- Topbar Paling Atas (Teks Sambutan + Tombol Keluar Akun) -->
    <div class="topbar">
        <div class="topbar-container">
            <span style="text-align: center;">✨ Welcome to Griya Rias Elly Jr. - Spesialis Tata Rias Pengantin, Wedding &amp; Event Organizer</span>
            
            @auth
                @if (!request()->routeIs('client.home'))
                <form method="POST" action="{{ route('logout') }}" class="topbar-logout-form" style="margin:0;">
                    @csrf
                    <button type="submit" class="topbar-logout-btn">
                        <i class="fa-solid fa-right-from-bracket"></i> Keluar Akun
                    </button>
                </form>
                @endif
            @endauth
        </div>
    </div>

    <!-- Top Navigation Main Bar -->
    <header class="nav" id="nav">
        <div class="nav-inner">
            <nav class="nav-side nav-left">
                @unless(request()->routeIs('client.home'))
                <a href="{{ request()->routeIs('home') ? '#beranda' : route('home') . '#beranda' }}" class="nav-link{{ request()->routeIs('home') ? ' active' : '' }}">Beranda</a>
                @endunless
                <button type="button" class="nav-link location-trigger" data-location-open aria-haspopup="dialog" aria-controls="location-modal">LOKASI</button>
                @unless(request()->routeIs('client.home'))
                <a href="{{ request()->routeIs('home') ? '#katalog' : route('home') . '#katalog' }}" class="nav-link">Katalog WO/EO</a>
                @endunless
                <a href="{{ request()->routeIs('home') ? '#tentang' : route('home') . '#tentang' }}" class="nav-link">Tentang Kami</a>
            </nav>

            <!-- Teks Logo Susun di Tengah -->
            <a href="{{ route('home') }}" class="brand">
                <small>GRIYA RIAS</small>
                <strong>Elly Jr.</strong>
                <em style="padding-right: 6px; display: inline-block;">Make Up &amp; Event Organizer</em>
            </a>

            <nav class="nav-side nav-right">
                <a href="{{ request()->routeIs('home') ? '#galeri' : route('home') . '#galeri' }}" class="nav-link">Galeri Portofolio</a>
                <a href="{{ request()->routeIs('home') ? '#kontak' : route('home') . '#kontak' }}" class="nav-link">Kontak</a>
                
                @auth
                    @unless(request()->routeIs('client.home'))
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('client.dashboard') }}" class="btn-pill-center">
                        @if(auth()->user()->isAdmin())
                            DASHBOARD<br>ADMIN
                        @else
                            DASHBOARD<br>CLIENT
                        @endif
                    </a>
                    @endunless
                @else
                    <a href="{{ route('login') }}" class="btn-link">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-pill-center">DAFTAR</a>
                @endauth
            </nav>

            <button class="burger" id="burger" aria-label="Menu"><span></span><span></span></button>
        </div>
    </header>

    <!-- Mobile Drawer Sidebar -->
    <aside class="drawer" id="drawer">
        @unless(request()->routeIs('client.home'))
        <a href="{{ request()->routeIs('home') ? '#beranda' : route('home') . '#beranda' }}">Beranda</a>
        @endunless
        <button type="button" class="drawer-location-trigger" data-location-open aria-haspopup="dialog" aria-controls="location-modal">LOKASI</button>
        @unless(request()->routeIs('client.home'))
        <a href="{{ request()->routeIs('home') ? '#katalog' : route('home') . '#katalog' }}">Katalog WO/EO</a>
        @endunless
        <a href="{{ request()->routeIs('home') ? '#tentang' : route('home') . '#tentang' }}">Tentang Kami</a>
        <a href="{{ request()->routeIs('home') ? '#galeri' : route('home') . '#galeri' }}">Galeri Portofolio</a>
        <a href="{{ request()->routeIs('home') ? '#kontak' : route('home') . '#kontak' }}">Kontak</a>
        
        @auth
            <div style="padding: 12px 0; border-bottom: 1px solid rgba(0,0,0,0.12); margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center;">
                <strong style="font-size: 0.95rem; color: #1A1A1A;">{{ auth()->user()->name }}</strong>
                @unless(request()->routeIs('client.home'))
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #DC2626; font-weight: 700; font-size: 0.85rem; cursor: pointer;">Keluar</button>
                </form>
                @endunless
            </div>

            @unless(request()->routeIs('client.home'))
            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('client.dashboard') }}" class="btn-pill-center" style="width: 100%; text-align: center;">
                {{ auth()->user()->isAdmin() ? 'DASHBOARD ADMIN' : 'DASHBOARD CLIENT' }}
            </a>
            @endunless
        @else
            <a href="{{ route('login') }}" class="btn-link light">Masuk</a>
            <a href="{{ route('register') }}" class="btn-pill-center" style="width: 100%; text-align: center;">DAFTAR</a>
        @endauth
    </aside>
    @endunless

    <div class="location-modal" id="location-modal" hidden>
        <button class="location-modal-backdrop" type="button" data-location-close aria-label="Tutup peta lokasi"></button>
        <section class="location-modal-card" role="dialog" aria-modal="true" aria-labelledby="location-modal-title" aria-describedby="location-modal-address" tabindex="-1">
            <header class="location-modal-header">
                <div>
                    <span class="location-modal-eyebrow">Temukan lokasi kami</span>
                    <h2 id="location-modal-title"><span aria-hidden="true">⌖</span> Griya Rias Elly Jr.</h2>
                </div>
                <button type="button" class="location-modal-close" data-location-close aria-label="Tutup popup lokasi">&times;</button>
            </header>
            <p class="location-modal-address" id="location-modal-address">{{ config('services.griya.location') }}</p>
            <div class="location-modal-map">
                <iframe
                    src="https://maps.google.com/maps?q={{ urlencode(config('services.griya.location')) }}&amp;z=16&amp;output=embed"
                    title="Peta lokasi Griya Rias Elly Jr."
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    allowfullscreen>
                </iframe>
            </div>
            <footer class="location-modal-footer">
                <span><span aria-hidden="true">●</span> Kabupaten Kediri, Jawa Timur</span>
                <a href="https://www.google.com/maps/dir/?api=1&amp;destination={{ urlencode(config('services.griya.location')) }}" target="_blank" rel="noopener">
                    Buka petunjuk arah <span aria-hidden="true">↗</span>
                </a>
            </footer>
        </section>
    </div>

    <main>
        @yield('content')
    </main>

    @unless(request()->routeIs('client.dashboard'))
    <footer class="footer">
        <div class="container">
            <div class="footer-brand"><small>GRIYA RIAS</small> Elly Jr.</div>
            <p class="footer-description">Make Up &amp; Event Organizer untuk momen spesial Anda.</p>
            <div class="footer-contact">
                <div class="footer-contact-item">
                    <span class="footer-contact-label">WhatsApp</span>
                    <a href="https://wa.me/{{ config('services.griya.whatsapp') }}" target="_blank" rel="noopener">
                        +{{ config('services.griya.whatsapp') }}
                    </a>
                </div>
            </div>
            <p class="footer-copyright">&copy; {{ date('Y') }} Griya Rias Elly Jr. Semua hak dilindungi.</p>
        </div>
    </footer>
    @endunless

    <script src="{{ asset('js/home.js') }}"></script>
    
    <!-- Script SweetAlert2 untuk Notifikasi -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#B9833B'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#B9833B'
                });
            @endif
        });
    </script>
</body>
</html>