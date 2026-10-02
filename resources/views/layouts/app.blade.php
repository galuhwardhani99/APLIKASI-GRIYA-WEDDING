@php
    $user = auth()->user();
    $ctaLabel = $user?->isAdmin() ? 'Dashboard Admin' : 'Pesan Jadwal';
    // Client: sementara ke #kontak, nanti diarahkan ke halaman reservasi
    $ctaUrl = $user ? ($user->isAdmin() ? route('admin.dashboard') : '#kontak') : route('login');
@endphp
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
                <a href="{{ $ctaUrl }}" class="btn-pill">{{ $ctaLabel }}</a>
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-link">Keluar</button>
                    </form>
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
        <a href="{{ $ctaUrl }}" class="btn-pill">{{ $ctaLabel }}</a>
        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-link light">Keluar</button>
            </form>
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
</body>
</html>