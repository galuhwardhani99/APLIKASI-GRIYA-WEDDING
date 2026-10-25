@extends('layouts.app')
@section('title', !empty($clientPage) ? 'Halaman Client' : 'Beranda')

@push('styles')
<!-- CSS Fancybox untuk Zoom In/Out & Galeri -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
<style>
    @if (!empty($clientPage))
        .client-home-dashboard-action { display: flex; justify-content: center; margin-top: 30px; }
        .client-home-dashboard-button { min-width: 210px; padding: 14px 32px; font-size: 0.9rem; }
    @endif

    /* Styles Kartu Gambar dengan Overlay Icon Kaca Pembesar */
    .card-img-wrapper {
        position: relative;
        display: block;
        cursor: pointer;
        overflow: hidden;
        width: 100%;
        height: 100%;
    }
    .card-img-wrapper img {
        transition: transform 0.3s ease;
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .card-img-overlay {
        position: absolute;
        inset: 0;
        background: rgba(24, 18, 15, 0.45);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #FFFFFF;
        font-size: 1.5rem;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 2;
    }
    .card-img-wrapper:hover img {
        transform: scale(1.05);
    }
    .card-img-wrapper:hover .card-img-overlay {
        opacity: 1;
    }

    .about-img-wrapper {
        position: relative;
        display: block;
        cursor: pointer;
        overflow: hidden;
        border-radius: 10px;
    }
    .about-img-wrapper img {
        transition: transform 0.3s ease;
    }
    .about-img-wrapper:hover img {
        transform: scale(1.03);
    }
    .about-img-wrapper:hover .card-img-overlay {
        opacity: 1;
    }
</style>
@endpush

@section('content')

{{-- ================= HERO ================= --}}
<section class="hero" id="beranda">
    <div class="orb o1" data-speed="0.18"><i></i></div>
    <div class="orb o2" data-speed="0.30"><i></i></div>
    <div class="orb o3" data-speed="0.10"><i></i></div>

    <div class="hero-inner">
        <span class="badge fu" style="--d:50ms">{{ !empty($clientPage) ? 'Ruang Istimewa Anda di Griya Rias Elly Jr.' : 'Elegansi & Keanggunan Acara Spesial' }}</span>

        <h1 class="hero-title">
            @php($judulHero = !empty($clientPage) ? 'Selamat Datang, ' . explode(' ', trim(auth()->user()->name))[0] : 'Tampil Mempesona di Hari Paling Bahagia Anda')
            @foreach (explode(' ', $judulHero) as $i => $kata)
                <span class="w"><span style="--i:{{ $i }}">{{ $kata }}</span></span>
            @endforeach
        </h1>

        <p class="hero-sub fu" style="--d:900ms">
            @if (!empty($clientPage))
                Senang melihat Anda kembali. Temukan inspirasi, layanan, dan paket terbaik untuk membantu merencanakan momen istimewa Anda bersama kami.
            @else
                Melayani jasa tata rias pengantin tradisional/modern, acara resmi, hingga perencanaan lengkap Wedding &amp; Event Organizer.
            @endif
        </p>

        @if (!empty($clientPage))
            <div class="client-home-dashboard-action fu" style="--d:1100ms">
                <a href="{{ route('client.dashboard') }}" class="btn-pill-center client-home-dashboard-button">DASHBOARD<br>CLIENT</a>
            </div>
        @endif

    </div>
</section>

{{-- ================= MARQUEE ================= --}}
<div class="marquee" aria-hidden="true">
    <div class="marquee-track">
        @for ($i = 0; $i < 2; $i++)
            <span>Rias Pengantin</span><b>✦</b>
            <span>Wedding Organizer</span><b>✦</b>
            <span>Event Organizer</span><b>✦</b>
            <span>Rias Wisuda</span><b>✦</b>
            <span>Prewedding</span><b>✦</b>
        @endfor
    </div>
</div>

{{-- ================= LAYANAN UNGGULAN ================= --}}
<section class="section" id="layanan-unggulan">
    <div class="container">
        <div class="section-head reveal">
            <h2>Layanan Unggulan</h2>
            <p>Layanan pilihan dari Griya Rias Elly Jr.</p>
        </div>

        <div class="cards">
            @forelse ($layanans as $i => $layanan)
                <div class="reveal" style="--d:{{ $i * 140 }}ms">
                    <article class="card tilt">
                        <div class="card-img {{ $i % 2 ? 'sand' : 'rose' }}">
                            @if ($layanan->foto)
                                <a href="{{ asset('storage/' . $layanan->foto) }}" 
                                   data-fancybox="gallery" 
                                   data-caption="<strong>{{ $layanan->nama_layanan }}</strong><br>Rp {{ number_format($layanan->harga, 0, ',', '.') }}"
                                   class="card-img-wrapper">
                                    <img src="{{ asset('storage/' . $layanan->foto) }}" alt="{{ $layanan->nama_layanan }}">
                                    <div class="card-img-overlay">
                                        <i class="fa-solid fa-magnifying-glass-plus"></i>
                                    </div>
                                </a>
                            @else
                                <span>{{ $layanan->nama_layanan }}</span>
                            @endif
                        </div>
                        <h3>{{ $layanan->nama_layanan }}</h3>
                        <p>{{ $layanan->deskripsi ?: 'Informasi layanan dapat ditanyakan kepada tim kami.' }}</p>
                        @if ($layanan->variasi)<p class="subtle">{{ $layanan->variasi }}</p>@endif
                        <div class="price">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</div>
                    </article>
                </div>
            @empty
                <p class="gd-empty">Belum ada layanan unggulan untuk ditampilkan.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- ================= PAKET UNGGULAN ================= --}}
<section class="section section-sand" id="katalog">
    <div class="container">
        <div class="section-head reveal">
            <h2>Paket Unggulan</h2>
            <p>Paket pilihan untuk membantu merencanakan momen istimewa Anda.</p>
        </div>
        <div class="cards">
            @forelse ($pakets as $i => $paket)
                <div class="reveal" style="--d:{{ $i * 140 }}ms">
                    <article class="card tilt">
                        <div class="card-img {{ $i % 2 ? 'rose' : 'sand' }}">
                            @if ($paket->foto)
                                <a href="{{ asset('storage/' . $paket->foto) }}" 
                                   data-fancybox="gallery" 
                                   data-caption="<strong>{{ $paket->nama_paket }}</strong><br>Rp {{ number_format($paket->harga, 0, ',', '.') }}"
                                   class="card-img-wrapper">
                                    <img src="{{ asset('storage/' . $paket->foto) }}" alt="{{ $paket->nama_paket }}">
                                    <div class="card-img-overlay">
                                        <i class="fa-solid fa-magnifying-glass-plus"></i>
                                    </div>
                                </a>
                            @else
                                <span>{{ $paket->kategoriPaket?->nama_kategori ?? $paket->nama_paket }}</span>
                            @endif
                        </div>
                        <h3>{{ $paket->nama_paket }}</h3>
                        <p>{{ $paket->deskripsi ?: 'Informasi lebih lanjut mengenai paket ini dapat ditanyakan kepada tim kami.' }}</p>
                        <div class="price">Rp {{ number_format($paket->harga, 0, ',', '.') }}</div>
                    </article>
                </div>
            @empty
                <p class="gd-empty">Belum ada paket unggulan untuk ditampilkan.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- ================= TENTANG KAMI ================= --}}
<section class="section section-sand" id="tentang">
    <div class="container about">
        <div class="about-img reveal">
            <a href="{{ asset('images/logo.jpg') }}" 
               data-fancybox="gallery" 
               data-caption="<strong>Griya Rias Elly Jr.</strong><br>Make Up &amp; Event Organizer" 
               class="about-img-wrapper">
                <img src="{{ asset('images/logo.jpg') }}" alt="Griya Rias Elly Jr." style="width: 100%; border-radius: 10px;">
                <div class="card-img-overlay">
                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                </div>
            </a>
            <div class="about-badge">Make Up &amp; Event Organizer</div>
        </div>

        <div class="about-text">
            <h2 class="reveal">Tentang Griya Rias Elly Jr.</h2>
            <p class="reveal" style="--d:100ms">
                Griya Rias Elly Jr. melayani tata rias pengantin tradisional maupun modern, rias acara resmi, hingga perencanaan lengkap Wedding &amp; Event Organizer. Kami membantu setiap momen spesial tampil elegan dan berjalan lancar.
            </p>

            <div class="stats reveal" style="--d:200ms">
                <div><strong data-count="10" data-suffix="+">0</strong><span>Tahun Pengalaman</span></div>
                <div><strong data-count="500" data-suffix="+">0</strong><span>Klien Dilayani</span></div>
                <div><strong data-count="100" data-suffix="+">0</strong><span>Acara Terlaksana</span></div>
            </div>
        </div>
    </div>
</section>

{{-- ================= GALERI ================= --}}
@include('partials.galeri')

{{-- ================= KONTAK ================= --}}
<section class="contact" id="kontak">
    <div class="container">
        <h2 class="reveal">Siap Merencanakan Hari Istimewa Anda?</h2>
        <p class="reveal" style="--d:100ms">Hubungi kami atau langsung pesan jadwal untuk memastikan tanggal acara Anda tersedia.</p>

        <div class="hero-actions reveal" style="--d:200ms">
            <a class="btn btn-gold" target="_blank" rel="noopener"
               href="https://wa.me/{{ $whatsapp }}?text={{ urlencode('Halo Griya Rias Elly Jr., saya ingin bertanya tentang layanan.') }}">
                Chat via WhatsApp
            </a>
            <a href="{{ auth()->check() && ! auth()->user()->isAdmin() ? '#kontak' : route('login') }}" class="btn btn-outline">Pesan Jadwal</a>
        </div>

        <div class="contact-info reveal" style="--d:300ms">
            <div><b>Alamat</b><span>{{ config('services.griya.location') }}</span></div>
            <div><b>Jam Layanan</b><span>Senin - Minggu, 08.00 - 20.00</span></div>
            <div><b>WhatsApp</b><span>+{{ $whatsapp }}</span></div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<!-- JS Fancybox -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    Fancybox.bind('[data-fancybox="gallery"]', {
        compact: false,
        idle: false,
        animated: true,
        showClass: "f-fadeIn",
        hideClass: "f-fadeOut",
        Images: { zoom: true },
        Toolbar: {
            display: {
                left: ["infobar"],
                middle: ["zoomIn", "zoomOut", "toggle1to1", "rotateCCW", "rotateCW"],
                right: ["slideshow", "fullscreen", "close"],
            },
        },
    });
</script>
@endpush