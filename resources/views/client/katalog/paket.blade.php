<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Katalog Paket - Griya Rias Elly Jr.</title>
    
    <!-- FAVICON -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}">

    <!-- Google Fonts & Font Awesome Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS Fancybox (Pustaka Zoom & Lightbox Foto) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

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

        body { 
            background-color: var(--bg-light); 
            color: var(--text-dark); 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            margin: 0;
            min-height: 100vh;
        }

        .client-shell { display: flex; min-height: 100vh; }
        .client-sidebar { width: 260px; min-width: 260px; height: 100vh; position: sticky; top: 0; display: flex; flex-direction: column; padding: 24px 15px; background: #fff; border-right: 1px solid var(--border-color); }
        .client-sidebar-brand { display: block; padding: 4px 12px 20px; border-bottom: 1px solid var(--border-color); text-decoration: none; }
        .client-sidebar-brand span { display: block; font-size: .67rem; letter-spacing: .2em; color: var(--gold-primary); font-weight: 700; text-transform: uppercase; }
        .client-sidebar-brand strong { display: block; font-family: 'Playfair Display', serif; color: var(--text-dark); font-size: 1.55rem; line-height: 1.2; }
        .client-sidebar-brand small { display: block; color: var(--text-muted); margin-top: 4px; }
        .client-sidebar-user { display: flex; align-items: center; gap: 12px; padding: 16px 12px; margin: 16px 0; border: 1px solid var(--border-color); border-radius: 12px; }
        .client-avatar { width: 40px; height: 40px; flex: 0 0 40px; display: grid; place-items: center; border-radius: 50%; background: #F5E8D5; color: var(--gold-hover); font-weight: 800; }
        .client-sidebar-user strong { display: block; color: var(--text-dark); font-size: .88rem; }
        .client-sidebar-user small { display: block; color: var(--text-muted); font-size: .75rem; }
        .client-sidebar-nav { display: flex; flex-direction: column; gap: 4px; }
        .client-nav-label { display: block; padding: 10px 12px 4px; color: #A59A8E; font-size: .65rem; letter-spacing: .12em; font-weight: 800; }
        .client-sidebar-nav a, .client-sidebar-footer a { display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: 8px; color: #62564D; text-decoration: none; font-weight: 600; font-size: .86rem; }
        .client-sidebar-nav a i, .client-sidebar-footer a i { width: 18px; text-align: center; color: var(--text-muted); }
        .client-sidebar-nav a:hover, .client-sidebar-footer a:hover { background: #FBF5EC; color: var(--gold-hover); }
        .client-sidebar-nav a.active { background: var(--gold-primary); color: #fff; }
        .client-sidebar-nav a.active i { color: #fff; }
        .client-sidebar-footer { margin-top: auto; padding-top: 14px; border-top: 1px solid var(--border-color); }
        .client-main { flex: 1; min-width: 0; }

        .wrap { max-width: 1240px; margin: auto; padding: 40px 22px; }
        
        .header, .tools, .tools form, .actions { display: flex; align-items: center; gap: 12px; }
        .header, .tools { justify-content: space-between; }
        .header { margin-bottom: 28px; }
        
        .eyebrow { 
            color: var(--gold-primary); 
            font-size: 11px; 
            letter-spacing: .12em; 
            text-transform: uppercase; 
            font-weight: 700; 
        }

        h1 { 
            margin: 6px 0; 
            color: var(--text-dark); 
            font-family: 'Playfair Display', serif; 
            font-size: 32px; 
        }

        p.subtitle { color: var(--text-muted); margin: 4px 0; font-size: 0.95rem; }

        .btn { 
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
            gap: 8px;
            padding: 10px 18px; 
            border-radius: 8px; 
            background: var(--gold-primary); 
            color: #fff; 
            text-decoration: none; 
            border: 0; 
            font-weight: 600; 
            font-size: 14px; 
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(197, 143, 67, 0.15);
        }
        .btn:hover { background: var(--gold-hover); }

        .btn-light { 
            background: #fff; 
            color: var(--text-dark); 
            border: 1px solid var(--border-color); 
            box-shadow: none; 
        }
        .btn-light:hover { background: #f5eee7; }

        /* Filter Panel */
        .filter-panel { 
            background: var(--bg-card); 
            padding: 20px; 
            border: 1px solid var(--border-color); 
            border-radius: 12px; 
            margin-bottom: 28px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        }
        .tools form { width: 100%; flex-wrap: wrap; }
        .tools input, .tools select { 
            min-width: 170px; 
            flex: 1; 
            padding: 11px 14px; 
            border: 1px solid var(--border-color); 
            border-radius: 8px; 
            font-family: inherit; 
            font-size: 0.9rem;
            background: #FAFAFA; 
            color: var(--text-dark);
            outline: none;
        }
        .tools input:focus, .tools select:focus {
            border-color: var(--gold-primary);
            background: #FFF;
        }

        /* Card Grid Layout */
        .grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 24px; }
        .card { 
            background: var(--bg-card); 
            border: 1px solid var(--border-color); 
            border-radius: 14px; 
            padding: 18px; 
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02); 
            display: flex; 
            flex-direction: column; 
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
        }

        /* Foto Container dengan Overlay Zoom */
        .photo-wrapper {
            position: relative;
            height: 220px;
            border-radius: 10px;
            overflow: hidden;
            background: #f1e7df;
            margin-bottom: 16px;
            display: block;
            cursor: pointer;
        }

        .photo-img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
            transition: transform 0.3s ease;
        }

        .photo-overlay {
            position: absolute;
            inset: 0;
            background: rgba(36, 26, 22, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            font-size: 1.5rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .photo-wrapper:hover .photo-img {
            transform: scale(1.06);
        }

        .photo-wrapper:hover .photo-overlay {
            opacity: 1;
        }

        .photo-placeholder {
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.9rem;
            padding: 16px;
            text-align: center;
        }

        .category { 
            font-size: 0.8rem; 
            color: var(--gold-primary); 
            font-weight: 700; 
            text-transform: uppercase; 
            letter-spacing: .05em;
            margin-bottom: 6px; 
        }

        .card h2 { 
            font-family: 'Playfair Display', serif; 
            font-size: 20px; 
            font-weight: 700;
            margin: 0 0 8px; 
            color: var(--text-dark);
        }
        
        .desc { line-height: 1.6; flex: 1; color: var(--text-muted); font-size: 0.88rem; }
        .price { font-size: 20px; font-weight: 800; color: var(--gold-primary); margin-top: 14px; }
        
        .card-link { 
            display: inline-flex; 
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 16px; 
            padding: 10px;
            background-color: rgba(197, 143, 67, 0.1);
            color: var(--gold-primary); 
            font-weight: 700; 
            font-size: 0.88rem;
            text-decoration: none; 
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .card-link:hover {
            background-color: var(--gold-primary);
            color: #FFFFFF;
        }

        .empty { grid-column: 1 / -1; padding: 48px; text-align: center; background: #fff; border-radius: 12px; border: 1px solid var(--border-color); color: var(--text-muted); }
        
        .pager { margin-top: 32px; }
        .pager nav { display: flex; justify-content: center; }
        .pager nav > div:first-child { display: none; }
        .pager nav > div:last-child { display: flex; align-items: center; gap: 6px; }
        .pager span, .pager a { padding: 8px 14px; background: white; border: 1px solid var(--border-color); border-radius: 8px; text-decoration: none; color: var(--text-dark); font-weight: 600; font-size: 0.88rem; }
        .pager span[aria-current=page] { background: var(--gold-primary); color: white; border-color: var(--gold-primary); }
        .pager svg { width: 16px; height: 16px; }

        @media(max-width: 850px) {
            .grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .header { align-items: flex-start; flex-direction: column; }
        }
        @media(max-width: 560px) {
            .grid { grid-template-columns: 1fr; }
            .wrap { padding: 24px 14px; }
            .tools form { align-items: stretch; flex-direction: column; }
            .tools input, .tools select { width: 100%; }
        }
        @media(max-width: 850px) {
            .client-shell { flex-direction: column; }
            .client-sidebar { width: 100%; min-width: 0; height: auto; position: relative; border-right: 0; border-bottom: 1px solid var(--border-color); }
            .client-sidebar-nav { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .client-nav-label { grid-column: 1 / -1; }
            .client-sidebar-footer { margin-top: 16px; }
        }
    </style>
</head>
<body>

<div class="client-shell">
    <aside class="client-sidebar">
        <a class="client-sidebar-brand" href="{{ route('client.dashboard') }}"><span>Griya Rias</span><strong>Elly Jr.</strong><small>Area Client</small></a>
        <div class="client-sidebar-user">
            <span class="client-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            <div><strong>{{ auth()->user()->name }}</strong><small>Client</small></div>
        </div>
        <nav class="client-sidebar-nav">
            <span class="client-nav-label">MENU UTAMA</span>
            <a href="{{ route('client.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a>
            <a href="{{ route('client.katalog.layanan') }}"><i class="fa-solid fa-scissors"></i> Katalog Layanan</a>
            <a href="{{ route('client.katalog.paket') }}" class="{{ request()->routeIs('client.katalog.paket*') ? 'active' : '' }}"><i class="fa-solid fa-box-open"></i> Katalog Paket</a>
            <a href="{{ route('client.jadwal.index') }}"><i class="fa-regular fa-calendar-days"></i> Jadwal Acara</a>
            <a href="{{ route('reservasi.create') }}"><i class="fa-regular fa-calendar-check"></i> Form Reservasi</a>
            <span class="client-nav-label" style="margin-top:12px">AKTIVITAS &amp; AKUN</span>
            <a href="{{ route('client.riwayat.reservasi') }}"><i class="fa-regular fa-calendar"></i> Riwayat Reservasi</a>
            <a href="{{ route('client.riwayat.transaksi') }}"><i class="fa-solid fa-receipt"></i> Riwayat Transaksi</a>
            <a href="{{ route('user.profile.edit') }}"><i class="fa-solid fa-user-gear"></i> Pengaturan Akun</a>
        </nav>
        <div class="client-sidebar-footer"><a href="{{ route('client.home') }}"><i class="fa-solid fa-globe"></i> Halaman Client</a></div>
    </aside>
    <div class="client-main">
<main class="wrap">
    <header class="header">
        <div>
            <span class="eyebrow">Griya Rias Elly Jr.</span>
            <h1>Katalog Paket</h1>
            <p class="subtitle">Temukan paket berdasarkan nama, kategori, atau kisaran harga.</p>
        </div>
        <div class="actions">
            <a class="btn" href="{{ route('client.katalog.layanan') }}"><i class="fa-solid fa-scissors"></i> Lihat Katalog Layanan</a>
        </div>
    </header>

    <section class="filter-panel">
        <div class="tools">
            <form method="GET" action="{{ route('client.katalog.paket') }}">
                <input type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari nama, kategori, atau deskripsi...">
                <select name="kategori">
                    <option value="">Semua kategori</option>
                    @foreach($kategoriPakets as $kategori)
                        <option value="{{ $kategori->id }}" @selected((string)($filters['kategori'] ?? '') === (string)$kategori->id)>{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
                <input type="number" min="0" name="harga_min" value="{{ $filters['harga_min'] ?? '' }}" placeholder="Harga minimum">
                <input type="number" min="0" name="harga_max" value="{{ $filters['harga_max'] ?? '' }}" placeholder="Harga maksimum">
                <button class="btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Cari &amp; Filter</button>
                <a class="btn btn-light" href="{{ route('client.katalog.paket') }}">Reset</a>
            </form>
        </div>
    </section>

    <section class="grid">
        @forelse($pakets as $paket)
            <article class="card">
                @if($paket->foto)
                    <!-- Pembungkus Fancybox Lightbox untuk Zoom In / Out -->
                    <a href="{{ asset('storage/' . $paket->foto) }}" 
                       data-fancybox="paket-gallery" 
                       data-caption="<strong>{{ $paket->nama_paket }}</strong><br>{{ $paket->deskripsi }}" 
                       class="photo-wrapper">
                        <img src="{{ asset('storage/' . $paket->foto) }}" alt="{{ $paket->nama_paket }}" class="photo-img">
                        <div class="photo-overlay">
                            <i class="fa-solid fa-magnifying-glass-plus"></i>
                        </div>
                    </a>
                @else
                    <div class="photo-wrapper">
                        <div class="photo-placeholder">{{ $paket->kategoriPaket?->nama_kategori ?? $paket->nama_paket }}</div>
                    </div>
                @endif

                @if($paket->kategoriPaket?->nama_kategori)
                    <div class="category">{{ $paket->kategoriPaket->nama_kategori }}</div>
                @endif

                <h2>{{ $paket->nama_paket }}</h2>
                <p class="desc">{{ $paket->deskripsi ?: 'Informasi lebih lanjut mengenai paket ini dapat ditanyakan kepada tim kami.' }}</p>
                
                <p class="price">Rp {{ number_format($paket->harga,0,',','.') }}</p>
                
                <a class="card-link" target="_blank" rel="noopener" href="https://wa.me/{{ config('services.griya.whatsapp') }}?text={{ urlencode('Halo, saya ingin memilih paket ' . $paket->nama_paket) }}">
                    <i class="fa-brands fa-whatsapp" style="font-size: 1.1rem;"></i> Pilih Paket
                </a>
            </article>
        @empty
            <div class="empty">Tidak ada paket yang cocok dengan pencarian atau filter Anda.</div>
        @endforelse
    </section>

    <div class="pager">
        {{ $pakets->links() }}
    </div>
</main>
    </div>
</div>

<!-- JS Fancybox (Fitur Zoom In & Out) -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    Fancybox.bind('[data-fancybox="paket-gallery"]', {
        compact: false,
        idle: false,
        animated: true,
        showClass: "f-fadeIn",
        hideClass: "f-fadeOut",
        Images: {
            zoom: true,
        },
        Toolbar: {
            display: {
                left: ["infobar"],
                middle: ["zoomIn", "zoomOut", "toggle1to1", "rotateCCW", "rotateCW"],
                right: ["slideshow", "fullscreen", "close"],
            },
        },
    });
</script>

</body>
</html>
