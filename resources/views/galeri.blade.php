<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Galeri portofolio Griya Rias Elly Jr. untuk rias pengantin dan Wedding Organizer.">
    <title>Galeri Portofolio - Griya Rias Elly Jr.</title>

    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root { --brown:#3d241d; --brown-deep:#25170f; --cream:#faf6ef; --sand:#f3e6d6; --gold:#c68b3a; --gold-light:#e1b56f; --ink:#3b1f14; --muted:#7a5f55; --line:#ead9bf; --ease:cubic-bezier(.22,1,.36,1); }
        html { scroll-behavior: smooth; }
        body { min-height:100vh; overflow-x:hidden; background:var(--cream); color:var(--ink); font-family:'Plus Jakarta Sans',sans-serif; }
        .font-serif { font-family:'Playfair Display',serif; }
        .site-navbar { background:rgba(250,246,239,.88); backdrop-filter:blur(16px); border-bottom:1px solid rgba(234,217,191,.9); box-shadow:0 8px 30px rgba(59,31,20,.05); }
        .navbar-brand { line-height:1.05; }
        .brand-eyebrow { display:block; color:var(--gold); font-size:.68rem; font-weight:800; letter-spacing:.22em; }
        .brand-name { display:block; color:var(--ink); font-family:'Playfair Display',serif; font-size:1.45rem; }
        .nav-link { color:var(--ink); font-size:.78rem; font-weight:700; letter-spacing:.06em; text-transform:uppercase; }
        .nav-link:hover, .nav-link.active { color:var(--gold); }
        .nav-link.active { position:relative; }
        .nav-link.active::after { position:absolute; right:.5rem; bottom:0; left:.5rem; height:2px; border-radius:2px; background:var(--gold); content:''; }
        .btn-brand { border:0; background:var(--gold); color:var(--brown-deep); font-weight:800; }
        .btn-brand:hover { background:var(--gold-light); color:var(--brown-deep); transform:translateY(-2px); box-shadow:0 10px 24px rgba(198,139,58,.25); }
        .btn-brand, .btn-outline-brand, .filter-btn, .portfolio-card, .portfolio-image img { transition:all .35s var(--ease); }
        .btn-outline-brand { border:1px solid var(--gold); color:var(--gold); font-weight:700; }
        .btn-outline-brand:hover { background:var(--gold); color:var(--brown-deep); transform:translateY(-2px); }
        .hero-gallery { position:relative; overflow:hidden; padding:7rem 0 6rem; background:radial-gradient(circle at 15% 15%,rgba(198,139,58,.22),transparent 28%),linear-gradient(135deg,var(--brown-deep),var(--brown)); color:#eadfd0; }
        .hero-gallery::after { position:absolute; right:-10%; bottom:-65%; width:32rem; height:32rem; border:1px solid rgba(225,181,111,.22); border-radius:50%; content:''; }
        .hero-gallery-inner { position:relative; z-index:1; }
        .eyebrow { color:var(--gold-light); font-size:.72rem; font-weight:800; letter-spacing:.22em; text-transform:uppercase; }
        .hero-gallery h1 { margin:1rem auto; max-width:800px; font-size:clamp(2.6rem,6vw,5.3rem); line-height:1.05; }
        .hero-gallery p { max-width:650px; margin:0 auto; color:#cdb9a8; line-height:1.8; }
        .hero-divider { width:74px; height:3px; margin:1.7rem auto; border-radius:99px; background:var(--gold); }
        .gallery-section { padding:5rem 0 6rem; }
        .section-title { color:var(--ink); font-size:clamp(2rem,4vw,3rem); }
        .section-subtitle { color:var(--muted); }
        .filter-btn { border:1px solid var(--line); border-radius:999px; background:rgba(255,255,255,.64); color:var(--muted); font-size:.78rem; font-weight:700; }
        .filter-btn:hover, .filter-btn.active { border-color:var(--gold); background:var(--gold); color:var(--brown-deep); }
        .portfolio-card { overflow:hidden; border:1px solid rgba(234,217,191,.9); border-radius:1.25rem; background:#fff; box-shadow:0 12px 35px rgba(59,31,20,.07); }
        .portfolio-card:hover { transform:translateY(-8px); box-shadow:0 24px 50px rgba(59,31,20,.14); }
        .portfolio-image { position:relative; height:300px; overflow:hidden; background:var(--sand); }
        .portfolio-image::after { position:absolute; inset:40% 0 0; background:linear-gradient(transparent,rgba(37,23,15,.58)); content:''; pointer-events:none; }
        .portfolio-image img { width:100%; height:100%; object-fit:cover; }
        .portfolio-card:hover .portfolio-image img { transform:scale(1.07); }
        .category-badge { position:absolute; z-index:1; top:1rem; left:1rem; border:1px solid rgba(255,255,255,.25); border-radius:999px; background:rgba(37,23,15,.76); color:#fff; font-size:.65rem; font-weight:800; letter-spacing:.08em; text-transform:uppercase; backdrop-filter:blur(8px); }
        .preview-button { position:absolute; z-index:2; right:1rem; bottom:1rem; width:2.6rem; height:2.6rem; border:0; border-radius:50%; background:rgba(255,255,255,.92); color:var(--ink); }
        .preview-button:hover { background:var(--gold); color:var(--brown-deep); transform:scale(1.08); }
        .portfolio-body { padding:1.35rem 1.4rem 1.5rem; }
        .portfolio-body h2 { margin:0; color:var(--ink); font-size:1.3rem; }
        .portfolio-body p { display:-webkit-box; overflow:hidden; margin:.6rem 0 0; color:var(--muted); font-size:.82rem; line-height:1.7; -webkit-box-orient:vertical; -webkit-line-clamp:2; }
        .empty-state { border:1px dashed #d7c4ac; border-radius:1.25rem; background:#fff; color:var(--muted); }
        .site-footer { padding:4.5rem 0 1.25rem; background:var(--brown); color:#cdb9a8; }
        .footer-title { color:#eadfd0; font-family:'Playfair Display',serif; font-size:1.7rem; }
        .footer-label { color:var(--gold-light); font-size:.68rem; font-weight:800; letter-spacing:.16em; text-transform:uppercase; }
        .footer-link { color:#eadfd0; text-decoration:none; }
        .footer-link:hover { color:var(--gold-light); }
        .footer-bottom { border-top:1px solid rgba(255,255,255,.12); color:#a58f80; font-size:.75rem; }
        .modal-content { overflow:hidden; border:0; border-radius:1.25rem; background:#fffdf9; }
        .modal-header { border-bottom-color:var(--line); }
        .modal-title { color:var(--ink); font-family:'Playfair Display',serif; }
        .modal-body img { max-height:70vh; object-fit:contain; }
        .fade-up { animation:fade-up .8s var(--ease) both; }
        .delay-1 { animation-delay:.1s; }
        .delay-2 { animation-delay:.2s; }
        @keyframes fade-up { from { opacity:0; transform:translateY(18px); } to { opacity:1; transform:none; } }
        @media (max-width:767.98px) { .hero-gallery { padding:5rem 0 4rem; } .gallery-section { padding:3.5rem 0 4.5rem; } .portfolio-image { height:250px; } }
        @media (prefers-reduced-motion:reduce) { html { scroll-behavior:auto; } *,*::before,*::after { animation:none!important; transition:none!important; } }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top site-navbar" aria-label="Navigasi utama">
        <div class="container py-2">
            <a class="navbar-brand" href="{{ route('home') }}" aria-label="Beranda Griya Rias Elly Jr.">
                <span class="brand-eyebrow">GRIYA RIAS</span><span class="brand-name">Elly Jr.</span>
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#galleryNavbar" aria-controls="galleryNavbar" aria-expanded="false" aria-label="Buka menu"><i class="bi bi-list fs-2 text-dark"></i></button>
            <div class="collapse navbar-collapse" id="galleryNavbar">
                <ul class="navbar-nav mx-auto my-3 my-lg-0 gap-lg-2">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#beranda">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#katalog">Katalog WO/EO</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#tentang">Tentang Kami</a></li>
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ route('galeri') }}">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#kontak">Kontak</a></li>
                </ul>
                <div class="d-flex gap-2 align-items-center">
                    @auth
                        <a class="btn btn-brand rounded-pill px-3" href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('client.dashboard') }}">{{ auth()->user()->isAdmin() ? 'Dashboard Admin' : 'Dashboard Saya' }}</a>
                    @else
                        <a class="btn btn-outline-brand rounded-pill px-3" href="{{ route('login') }}">Masuk</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <header class="hero-gallery">
        <div class="container hero-gallery-inner text-center">
            <div class="eyebrow fade-up">Cerita dalam setiap detail</div>
            <h1 class="font-serif fade-up delay-1">Galeri Portofolio</h1>
            <div class="hero-divider fade-up delay-1"></div>
            <p class="fade-up delay-2">Kumpulan momen indah dan hasil karya Griya Rias Elly Jr. dalam mendampingi setiap perayaan istimewa.</p>
        </div>
    </header>

    <main>
        <section class="gallery-section" aria-labelledby="portfolio-heading">
            <div class="container">
                <div class="row align-items-end g-3 mb-4 mb-lg-5">
                    <div class="col-lg-7">
                        <span class="eyebrow">Momen pilihan</span>
                        <h2 id="portfolio-heading" class="font-serif section-title mt-2 mb-2">Karya yang kami banggakan</h2>
                        <p class="section-subtitle mb-0">Lihat inspirasi rias, dekorasi, dan acara yang telah kami bantu wujudkan.</p>
                    </div>
                    @if($portofolios->count())
                        <div class="col-lg-5">
                            <div class="d-flex flex-wrap justify-content-lg-end gap-2" id="portfolioFilters" role="group" aria-label="Filter kategori galeri">
                                <button class="btn filter-btn active px-3 py-2" type="button" data-filter="all">Semua</button>
                                @foreach($portofolios->pluck('kategori')->filter()->unique() as $kategori)
                                    <button class="btn filter-btn px-3 py-2" type="button" data-filter="{{ \Illuminate\Support\Str::slug($kategori) }}">{{ $kategori }}</button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="row g-4" id="portfolioGrid">
                    @forelse($portofolios as $item)
                        @php($categorySlug = \Illuminate\Support\Str::slug($item->kategori ?: 'lainnya'))
                        <div class="col-md-6 col-xl-4 portfolio-item" data-category="{{ $categorySlug }}">
                            <article class="portfolio-card h-100">
                                <div class="portfolio-image">
                                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" loading="lazy">
                                    <span class="category-badge px-3 py-2">{{ $item->kategori ?: 'Portofolio' }}</span>
                                    <button class="preview-button d-inline-flex align-items-center justify-content-center" type="button" data-bs-toggle="modal" data-bs-target="#portfolioModal" data-image="{{ asset('storage/' . $item->gambar) }}" data-title="{{ $item->judul }}" data-description="{{ $item->deskripsi }}" aria-label="Lihat {{ $item->judul }}"><i class="bi bi-arrows-fullscreen"></i></button>
                                </div>
                                <div class="portfolio-body">
                                    <h2 class="font-serif">{{ $item->judul }}</h2>
                                    @if($item->deskripsi)<p>{{ $item->deskripsi }}</p>@endif
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12"><div class="empty-state text-center py-5 px-4"><i class="bi bi-images fs-1 d-block mb-3 text-warning"></i><h2 class="font-serif h3">Belum ada portofolio</h2><p class="mb-0">Karya terbaik kami akan segera ditampilkan di halaman ini.</p></div></div>
                    @endforelse
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="row g-4 pb-4">
                <div class="col-lg-5"><div class="footer-title">Griya Rias Elly Jr.</div><p class="mt-3 mb-0">Make Up &amp; Event Organizer untuk membantu mewujudkan momen spesial Anda dengan elegan.</p></div>
                <div class="col-sm-6 col-lg-3"><div class="footer-label mb-3">Navigasi</div><div class="d-grid gap-2"><a class="footer-link" href="{{ route('home') }}#layanan-unggulan">Layanan</a><a class="footer-link" href="{{ route('home') }}#katalog">Katalog WO/EO</a><a class="footer-link" href="{{ route('home') }}#tentang">Tentang Kami</a></div></div>
                <div class="col-sm-6 col-lg-4"><div class="footer-label mb-3">Hubungi Kami</div><div class="d-grid gap-2"><span><i class="bi bi-geo-alt me-2 text-warning"></i>{{ config('services.griya.location') }}</span><span><i class="bi bi-clock me-2 text-warning"></i>09.00 - 21.00</span><a class="footer-link" href="https://wa.me/{{ ltrim(preg_replace('/\D+/', '', config('services.griya.whatsapp')), '0') }}" target="_blank" rel="noopener"><i class="bi bi-whatsapp me-2 text-warning"></i>+{{ config('services.griya.whatsapp') }}</a></div></div>
            </div>
            <div class="footer-bottom pt-3 text-center">&copy; {{ date('Y') }} Griya Rias Elly Jr. Semua hak dilindungi.</div>
        </div>
    </footer>

    <div class="modal fade" id="portfolioModal" tabindex="-1" aria-labelledby="portfolioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content"><div class="modal-header"><h2 class="modal-title fs-4" id="portfolioModalLabel">Pratinjau Portofolio</h2><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button></div><div class="modal-body p-0"><img id="portfolioModalImage" class="w-100" src="" alt=""><div class="p-4"><h3 id="portfolioModalTitle" class="font-serif h4 mb-2"></h3><p id="portfolioModalDescription" class="text-secondary mb-0"></p></div></div></div></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filters = document.querySelectorAll('[data-filter]');
            const items = document.querySelectorAll('.portfolio-item');
            filters.forEach(function (filter) {
                filter.addEventListener('click', function () {
                    filters.forEach((button) => button.classList.remove('active'));
                    filter.classList.add('active');
                    const selected = filter.dataset.filter;
                    items.forEach(function (item) { item.classList.toggle('d-none', selected !== 'all' && item.dataset.category !== selected); });
                });
            });
            const modal = document.getElementById('portfolioModal');
            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                document.getElementById('portfolioModalImage').src = button.dataset.image;
                document.getElementById('portfolioModalImage').alt = button.dataset.title;
                document.getElementById('portfolioModalTitle').textContent = button.dataset.title;
                document.getElementById('portfolioModalDescription').textContent = button.dataset.description || 'Portofolio Griya Rias Elly Jr.';
            });
        });
    </script>
</body>
</html>
