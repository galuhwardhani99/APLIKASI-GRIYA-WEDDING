<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Favicon (Logo Tab Browser) -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}">
    
    <!-- CSRF Token untuk Keamanan Sesi -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Beranda') - Griya Rias Elly Jr.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    
    <!-- CSS SweetAlert2 untuk Popup -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        /* Flex Topbar dengan Info & Tombol Keluar di Kanan Atas */
        .topbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 32px;
            width: 100%;
        }

        .topbar-logout-btn {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #FFFFFF;
            padding: 3px 12px;
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
            background: #EF4444;
            border-color: #EF4444;
            color: #FFFFFF;
        }

        .nav-side.nav-right {
            gap: 24px !important;
            align-items: center;
        }

        /* Styling Tombol Utama (Dashboard Admin / Pesan Jadwal) */
        .btn-pill-center {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            line-height: 1.2;
            padding: 10px 22px;
            border-radius: 50px;
            background-color: #B9833B;
            color: #FFFFFF;
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(185, 131, 59, 0.2);
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-pill-center:hover {
            background-color: #9C6F32;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="progress" id="progress"></div>

    <!-- Topbar Paling Atas (Teks Sambutan + Tombol Keluar Akun) -->
    <div class="topbar">
        <div class="topbar-container">
            <span>✨ Welcome to Griya Rias Elly Jr. - Spesialis Tata Rias Pengantin, Wedding &amp; Event Organizer</span>
            
            @auth
                <form method="POST" action="{{ route('logout') }}" style="display:inline; margin:0;">
                    @csrf
                    <button type="submit" class="topbar-logout-btn">
                        <i class="fa-solid fa-right-from-bracket"></i> Keluar Akun
                    </button>
                </form>
            @endauth
        </div>
    </div>

    <!-- Top Navigation Main Bar -->
    <header class="nav" id="nav">
        <div class="nav-inner">
            <nav class="nav-side nav-left">
                <a href="#beranda" class="nav-link active">Beranda</a>
                <a href="#katalog" class="nav-link">Katalog WO/EO</a>
                <a href="#tentang" class="nav-link">Tentang Kami</a>
            </nav>

            <a href="{{ route('home') }}" class="brand">
                <small>GRIYA RIAS</small>
                <strong>Elly Jr.</strong>
                <em>Make Up &amp; Event Organizer</em>
            </a>

            <nav class="nav-side nav-right">
                <a href="#galeri" class="nav-link">Galeri Portofolio</a>
                <a href="#kontak" class="nav-link">Kontak</a>
                
                @auth
                    <!-- Bersih tanpa tulisan 'LOGIN: ADMIN Administrator' -->
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('reservasi.create') }}" class="btn-pill-center">
                        @if(auth()->user()->isAdmin())
                            DASHBOARD<br>ADMIN
                        @else
                            PESAN<br>JADWAL
                        @endif
                    </a>
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
        <a href="#beranda">Beranda</a>
        <a href="#katalog">Katalog WO/EO</a>
        <a href="#tentang">Tentang Kami</a>
        <a href="#galeri">Galeri Portofolio</a>
        <a href="#kontak">Kontak</a>
        
        @auth
            <div style="padding: 12px 0; border-bottom: 1px solid rgba(0,0,0,0.06); margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center;">
                <strong style="font-size: 0.95rem; color: #333;">{{ auth()->user()->name }}</strong>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #A33B3B; font-weight: 600; font-size: 0.85rem; cursor: pointer;">Keluar</button>
                </form>
            </div>

            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('reservasi.create') }}" class="btn-pill-center" style="width: 100%; text-align: center;">
                {{ auth()->user()->isAdmin() ? 'DASHBOARD ADMIN' : 'PESAN JADWAL' }}
            </a>
        @else
            <a href="{{ route('login') }}" class="btn-link light">Masuk</a>
            <a href="{{ route('register') }}" class="btn-pill-center" style="width: 100%; text-align: center;">DAFTAR</a>
        @endauth
    </aside>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-brand"><small>GRIYA RIAS</small> Elly Jr.</div>
            <p>&copy; {{ date('Y') }} Griya Rias Elly Jr. Make Up &amp; Event Organizer.</p>
        </div>
    </footer>

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