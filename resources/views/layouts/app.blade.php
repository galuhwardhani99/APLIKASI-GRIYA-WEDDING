<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Beranda') - Griya Rias Elly Jr.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    
    <!-- CSS SweetAlert2 untuk Popup -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        /* Perbaikan Styling Agar Lebih Longgar, Presisi, dan Estetik */
        .nav-side.nav-right {
            gap: 24px !important; /* Memperlebar jarak antar menu kanan secara keseluruhan */
        }
        .user-profile-group {
            display: flex;
            align-items: center;
            gap: 18px; /* Jarak longgar antara teks profil dan tombol */
            padding-right: 4px;
        }
        .user-meta-box {
            display: flex;
            flex-direction: column;
            text-align: left;
            line-height: 1.3;
            white-space: nowrap;
        }
        .figma-login-label {
            font-size: 0.7rem;
            font-weight: 700;
            color: #8C8279;
            letter-spacing: 0.06em;
        }
        .figma-user-name {
            font-size: 0.95rem;
            font-weight: 700;
            color: #241A16;
            font-family: 'Playfair Display', serif;
        }
        .figma-logout-btn {
            background: none;
            border: none;
            padding: 0;
            font-size: 0.75rem;
            color: #A33B3B;
            cursor: pointer;
            text-align: left;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600;
            margin-top: 3px;
            transition: color 0.2s ease;
        }
        .figma-logout-btn:hover {
            color: #742828;
            text-decoration: underline;
        }

        /* Penyesuaian Tombol Pill agar Teks Center Sempurna */
        .btn-pill-center {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            line-height: 1.2;
            padding: 10px 22px;
            border-radius: 50px;
            background-color: #B9833B; /* Menyesuaikan warna tema tombol utama */
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

    <div class="topbar">✨ Welcome to Griya Rias Elly Jr. - Spesialis Tata Rias Pengantin, Wedding &amp; Event Organizer</div>

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
                
                <!-- Logika Tombol Auth & Guest yang Dirapikan -->
                @auth
                    <div class="user-profile-group">
                        <div class="user-meta-box">
                            <span class="figma-login-label">LOGIN: {{ strtoupper(auth()->user()->role) }}</span>
                            <span class="figma-user-name">{{ auth()->user()->name }}</span>
                            
                            <form method="POST" action="{{ route('logout') }}" style="display:inline; margin: 0;">
                                @csrf
                                <button type="submit" class="figma-logout-btn">Keluar Akun</button>
                            </form>
                        </div>

                        <!-- Tombol dengan teks di-center sempurna -->
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('reservasi.create') }}" class="btn-pill-center">
                            @if(auth()->user()->isAdmin())
                                DASHBOARD<br>ADMIN
                            @else
                                PESAN<br>JADWAL
                            @endif
                        </a>
                    </div>
                @else
                    <!-- Tombol untuk Guest (belum login) -->
                    <a href="{{ route('login') }}" class="btn-link">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-pill-center">DAFTAR</a>
                @endauth
            </nav>

            <button class="burger" id="burger" aria-label="Menu"><span></span><span></span></button>
        </div>
    </header>

    {{-- Menu mobile --}}
    <aside class="drawer" id="drawer">
        <a href="#beranda">Beranda</a>
        <a href="#katalog">Katalog WO/EO</a>
        <a href="#tentang">Tentang Kami</a>
        <a href="#galeri">Galeri Portofolio</a>
        <a href="#kontak">Kontak</a>
        
        <!-- Logika Tombol Auth & Guest di Mobile -->
        @auth
            <div style="padding: 12px 0; border-bottom: 1px solid rgba(0,0,0,0.06); margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <span style="font-size: 0.7rem; color: #888; display: block; font-weight: 700;">LOGIN: {{ strtoupper(auth()->user()->role) }}</span>
                    <strong style="font-size: 0.95rem; color: #333;">{{ auth()->user()->name }}</strong>
                </div>
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
    
    <!-- Script SweetAlert2 untuk memunculkan Popup -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#B9833B'
                });
            @endif

            @if(session('status'))
                Swal.fire({
                    icon: 'success',
                    title: 'Pendaftaran Berhasil',
                    text: '{{ session('status') }}',
                    confirmButtonColor: '#B9833B'
                });
            @endif
        });
    </script>
</body>
</html>