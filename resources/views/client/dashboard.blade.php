@extends('layouts.app')
@section('title', 'Dashboard Client')

@section('content')

<div class="client-dashboard-shell">
    <aside class="client-sidebar">
        <a class="client-sidebar-brand" href="{{ route('client.dashboard') }}">
            <span>GRIYA RIAS</span><strong>Elly Jr.</strong><small>Area Client</small>
        </a>
        
        {{-- Area Profil User Client --}}
        <div class="client-sidebar-user">
            <span class="client-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            <div>
                <strong>{{ auth()->user()->name }}</strong>
                <small>Client</small>
                {{-- Link cepat Edit Profil di bawah teks Client --}}
                <a href="{{ route('user.profile.edit') }}" style="display: inline-block; font-size: 0.75rem; color: #C58F43; text-decoration: none; font-weight: 600; margin-top: 2px;">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Profil
                </a>
            </div>
        </div>

        {{-- Navigasi Client --}}
        <nav class="client-sidebar-nav" aria-label="Navigasi client">
            <span class="client-nav-label">MENU UTAMA</span>
            <a class="{{ request()->routeIs('client.dashboard') ? 'active' : '' }}" href="{{ route('client.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a>
            <a href="{{ route('client.katalog.layanan') }}"><i class="fa-solid fa-scissors"></i> Katalog Layanan</a>
            <a href="{{ route('client.katalog.paket') }}"><i class="fa-solid fa-box-open"></i> Katalog Paket</a>
            <a href="{{ route('reservasi.create') }}"><i class="fa-regular fa-calendar-check"></i> Form Reservasi</a>
            
            <span class="client-nav-label client-nav-spaced">AKTIVITAS & AKUN</span>
            <a href="{{ route('client.riwayat.reservasi') }}"><i class="fa-regular fa-calendar"></i> Riwayat Reservasi</a>
            <a href="{{ route('client.riwayat.transaksi') }}"><i class="fa-solid fa-receipt"></i> Riwayat Transaksi</a>
            
            {{-- Menu Pengaturan Akun Baru --}}
            <a class="{{ request()->routeIs('user.profile.*') ? 'active' : '' }}" href="{{ route('user.profile.edit') }}">
                <i class="fa-solid fa-user-gear"></i> Pengaturan Akun
            </a>
        </nav>

        <div class="client-sidebar-footer">
            <a href="{{ route('home') }}"><i class="fa-solid fa-globe"></i> Halaman Utama</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"><i class="fa-solid fa-right-from-bracket"></i> Keluar Akun</button>
            </form>
        </div>
    </aside>
    <div class="client-dashboard-main">

@php
    $namaDepan = explode(' ', trim(auth()->user()->name))[0];
    $judul = 'Selamat Datang, ' . $namaDepan;
@endphp

{{-- ================= HERO ================= --}}
<section class="hero" id="beranda">
    <div class="orb o1" data-speed="0.18"><i></i></div>
    <div class="orb o2" data-speed="0.30"><i></i></div>
    <div class="orb o3" data-speed="0.10"><i></i></div>

    <div class="hero-inner">
        <span class="badge fu" style="--d:50ms">Dashboard Client</span>

        <h1 class="hero-title">
            @foreach (explode(' ', $judul) as $i => $kata)
                <span class="w"><span style="--i:{{ $i }}">{{ $kata }}</span></span>
            @endforeach
        </h1>

        <p class="hero-sub fu" style="--d:900ms">
            Temukan layanan yang tepat untuk hari istimewa Anda. Jelajahi paket, lihat portofolio kami, lalu pesan jadwal acara Anda.
        </p>

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

<section class="client-overview-stats" aria-label="Ringkasan dashboard">
    <article><span>KATALOG LAYANAN</span><strong>{{ $layanansCount }} layanan</strong></article>
    <article><span>KATALOG PAKET</span><strong>{{ $paketsCount }} paket</strong></article>
    <article><span>RESERVASI SAYA</span><strong>{{ $reservasisCount }} pengajuan</strong></article>
</section>

{{-- ================= KATALOG LAYANAN ================= --}}
<section class="section" id="layanan">
    <div class="container">
        <div class="section-head reveal"><h2>Katalog Layanan</h2><p>Jelajahi layanan Griya Rias Elly Jr.</p><span class="count-pill">{{ $layanansCount }} layanan tersedia</span></div>
        <div class="cards">
            @forelse ($layanans as $i => $layanan)
                <div class="reveal" style="--d:{{ ($i % 3) * 140 }}ms"><article class="card tilt">
                    <div class="card-img {{ $i % 2 ? 'sand' : 'rose' }}">@if($layanan->foto)<img src="{{ asset('storage/' . $layanan->foto) }}" alt="{{ $layanan->nama_layanan }}">@else<span>{{ $layanan->nama_layanan }}</span>@endif</div>
                    <h3>{{ $layanan->nama_layanan }}</h3><p class="clamp">{{ $layanan->deskripsi ?: 'Informasi layanan dapat ditanyakan kepada tim kami.' }}</p>
                    @if($layanan->variasi)<small>{{ $layanan->variasi }}</small>@endif
                    <div class="price">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</div>
                    <a class="card-link" target="_blank" rel="noopener" href="https://wa.me/{{ $whatsapp }}?text={{ urlencode('Halo, saya tertarik dengan layanan ' . $layanan->nama_layanan) }}">Tanya Layanan</a>
                </article></div>
            @empty
                <div class="gd-empty">Belum ada layanan aktif untuk ditampilkan.</div>
            @endforelse
        </div>
        <div class="reveal" style="text-align:center;margin-top:32px"><a class="btn btn-gold" href="{{ route('client.katalog.layanan') }}">Tampilkan Selengkapnya</a></div>
    </div>
</section>

{{-- ================= KATALOG PAKET ================= --}}
<section class="section section-sand" id="katalog">
    <div class="container">
        <div class="section-head reveal">
            <h2>Katalog Paket</h2>
            <p>Pilih paket yang sesuai untuk acara istimewa Anda.</p>
            <span class="count-pill">{{ $paketsCount }} paket tersedia</span>
        </div>
        <div class="cards">
            @forelse ($pakets as $i => $paket)
                <div class="reveal" style="--d:{{ ($i % 3) * 140 }}ms"><article class="card tilt">
                    <div class="card-img {{ $i % 2 ? 'sand' : 'rose' }}">
                        @if ($paket->foto)<img src="{{ asset('storage/' . $paket->foto) }}" alt="{{ $paket->nama_paket }}">@else<span>{{ $paket->kategoriPaket?->nama_kategori }}</span>@endif
                    </div>
                    <h3>{{ $paket->nama_paket }}</h3>
                    <p class="clamp">{{ $paket->deskripsi ?: 'Informasi lebih lanjut mengenai paket ini dapat ditanyakan langsung kepada tim kami.' }}</p>
                    <div class="price-row"><div><small>Harga mulai dari</small><div class="price">Rp {{ number_format($paket->harga, 0, ',', '.') }}</div></div><a class="card-link" target="_blank" rel="noopener" href="https://wa.me/{{ $whatsapp }}?text={{ urlencode('Halo, saya ingin memilih paket ' . $paket->nama_paket) }}">Pilih Paket</a></div>
                </article></div>
            @empty
                <div class="gd-empty">Belum ada paket aktif untuk ditampilkan.</div>
            @endforelse
        </div>
        <div class="reveal" style="text-align:center;margin-top:32px"><a class="btn btn-gold" href="{{ route('client.katalog.paket') }}">Tampilkan Selengkapnya</a></div>
    </div>
</section>

{{-- ================= TENTANG KAMI ================= --}}
<section class="section section-sand" id="tentang">
    <div class="container about">
        <div class="about-img reveal">
            <div class="ph-big"><span>[ Foto Griya Rias Elly Jr. ]</span></div>
            <div class="about-badge">Make Up &amp; Event Organizer</div>
        </div>

        <div class="about-text">
            <h2 class="reveal">Tentang Griya Rias Elly Jr.</h2>
            <p class="reveal" style="--d:100ms">
                {{-- GANTI dengan profil asli Griya Rias Elly Jr. --}}
                Griya Rias Elly Jr. melayani tata rias pengantin tradisional maupun modern, rias acara resmi, hingga perencanaan lengkap Wedding &amp; Event Organizer. Kami membantu setiap momen spesial tampil elegan dan berjalan lancar.
            </p>

            <div class="stats reveal" style="--d:200ms">
                {{-- GANTI angka berikut dengan data asli --}}
                <div><strong data-count="10" data-suffix="+">0</strong><span>Tahun Pengalaman</span></div>
                <div><strong data-count="500" data-suffix="+">0</strong><span>Klien Dilayani</span></div>
                <div><strong data-count="100" data-suffix="+">0</strong><span>Acara Terlaksana</span></div>
            </div>
        </div>
    </div>
</section>

{{-- ================= GALERI (dari tabel Portofolio) ================= --}}
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
            <a href="{{ route('reservasi.create') }}" class="btn btn-outline">Pesan Jadwal</a>
        </div>

        <div class="contact-info reveal" style="--d:300ms">
            <div><b>Alamat</b><span>{{ config('services.griya.location') }}</span></div>
            <div><b>Jam Layanan</b><span>[Senin - Minggu, 08.00 - 20.00]</span></div>
            <div><b>WhatsApp</b><span>+{{ $whatsapp }}</span></div>
        </div>
    </div>
</section>

    </div>
</div>

<style>
    .client-dashboard-page { background: #fdfbf7; }
    
    .client-dashboard-shell {
        display: flex;
        min-height: 100vh;
        background: #fdfbf7;
        color: #241a16;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* --- SIDEBAR UTAMA --- */
    .client-sidebar {
        width: 260px;
        flex: 0 0 260px;
        background: #fff;
        border-right: 1px solid #efe8de;
        padding: 24px 16px;
        display: flex;
        flex-direction: column;
        height: 100vh;
        position: sticky;
        top: 0;
        z-index: 20;
        box-shadow: 2px 0 14px #241a1608;
    }

    /* Brand Logo & Header Sidebar */
    .client-sidebar-brand {
        padding: 4px 12px 20px;
        border-bottom: 1px solid #efe8de;
        text-decoration: none;
        display: flex;
        flex-direction: column;
    }
    .client-sidebar-brand span { font-size: .67rem; letter-spacing: .2em; color: #b9833b; font-weight: 700; }
    .client-sidebar-brand strong { font-family: 'Playfair Display', serif; color: #3b241c; font-size: 1.55rem; line-height: 1.2; }
    .client-sidebar-brand small { color: #8c8279; margin-top: 4px; }

    /* User Profile Section */
    .client-sidebar-user {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 20px 8px;
        border-bottom: 1px solid #efe8de;
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
    .client-sidebar-user small { font-size: .72rem; color: #8c8279; margin-top: 3px; }

    /* --- NAVIGASI (MEMILIKI SCROLL MANDIRI SUDAH RAPI) --- */
    .client-sidebar-nav {
        display: flex;
        flex-direction: column;
        gap: 5px;
        padding-top: 20px;
        flex: 1;                /* Mengisi sisa area tengah */
        overflow-y: auto;       /* BISA DI-SCROLL TANPA MERUSAK TAMPILAN */
        padding-right: 4px;
        margin-bottom: 12px;
    }
    
    /* Scrollbar halus untuk sidebar */
    .client-sidebar-nav::-webkit-scrollbar { width: 4px; }
    .client-sidebar-nav::-webkit-scrollbar-thumb { background-color: #efe8de; border-radius: 4px; }
    .client-sidebar-nav::-webkit-scrollbar-thumb:hover { background-color: #b9833b; }

    .client-nav-label { font-size: .65rem; letter-spacing: .12em; font-weight: 800; color: #a59a8e; padding: 0 12px 7px; }
    .client-nav-spaced { padding-top: 18px; }

    /* Item Menu Link */
    .client-sidebar-nav a, .client-sidebar-footer > a {
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
    .client-sidebar-nav a i, .client-sidebar-footer i { width: 18px; text-align: center; color: #9b8877; }
    .client-sidebar-nav a:hover, .client-sidebar-footer > a:hover { background: #fbf5ec; color: #9b672e; }
    .client-sidebar-nav a.active { background: #b9833b; color: #fff; }
    .client-sidebar-nav a.active i { color: #fff; }

    /* Footer Sidebar (Kembali Rapi di Bawah) */
    .client-sidebar-footer {
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid #efe8de;
        display: grid;
        gap: 7px;
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

    /* Content Area */
    .client-dashboard-main { min-width: 0; flex: 1; }
    .client-dashboard-main .hero { min-height: 560px; }
    .client-dashboard-main .hero-inner { padding-bottom: 70px; }
    .client-dashboard-main .marquee { overflow: hidden; }
    .client-dashboard-main .section { padding-top: 76px; padding-bottom: 76px; }

    @media(max-width: 900px) {
        .client-sidebar { width: 220px; flex-basis: 220px; padding: 20px 12px; }
    }
    @media(max-width: 680px) {
        .client-dashboard-shell { display: block; }
        .client-sidebar { position: relative; top: auto; width: 100%; height: auto; min-height: 0; padding: 12px 14px; border-right: 0; border-bottom: 1px solid #efe8de; }
        .client-sidebar-brand { padding: 2px 4px 12px; }
        .client-sidebar-user { padding: 12px 4px; }
        .client-sidebar-nav { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 5px; padding-top: 12px; overflow-y: visible; }
        .client-nav-label { grid-column: 1/-1; padding: 4px 8px; }
        .client-nav-spaced { padding-top: 8px; }
        .client-sidebar-nav a { font-size: .78rem; padding: 10px 8px; gap: 8px; }
        .client-sidebar-footer { margin-top: 12px; padding-top: 10px; grid-template-columns: 1fr 1fr; }
        .client-sidebar-footer > a, .client-sidebar-footer button { font-size: .78rem; padding: 9px 8px; gap: 8px; }
        .client-dashboard-main .hero { min-height: 460px; }
        .client-dashboard-main .hero-inner { padding: 70px 20px; }
        .client-dashboard-main .section { padding-top: 52px; padding-bottom: 52px; }
    }
</style>

<style>
    /* Area konten client mengikuti panel terang pada dashboard admin. */
    .client-dashboard-main .hero { min-height:0; padding:44px 40px 24px; text-align:left; background:#fdfbf7; }
    .client-dashboard-main .hero-inner { max-width:none; margin:0; padding:0; }
    .client-dashboard-main .hero .orb { display:none; }
    .client-dashboard-main .hero .badge { background:#f7eddd; border-color:#ead6b9; color:#a87632; font-size:12px; letter-spacing:1.4px; }
    .client-dashboard-main .hero-title { color:#241a16; font-size:clamp(32px,4vw,46px); margin:18px 0 8px; }
    .client-dashboard-main .hero-sub { margin:0; color:#8c8279; font-size:15px; max-width:720px; }
    .client-dashboard-main .w { overflow:visible; }
    .client-dashboard-main .w>span { transform:none; animation:none; }
    .client-dashboard-main .marquee { display:none; }
    .client-overview-stats { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:18px; padding:8px 40px 20px; background:#fdfbf7; }
    .client-overview-stats article { background:#fff; border:1px solid #efe8de; border-radius:12px; padding:20px 22px; box-shadow:0 4px 12px #00000005; }
    .client-overview-stats span { display:block; color:#8c8279; font-size:.7rem; letter-spacing:.06em; font-weight:700; margin-bottom:8px; }
    .client-overview-stats strong { font-family:'Playfair Display',serif; color:#241a16; font-size:1.35rem; }
    .client-dashboard-main .section { padding:50px 40px; background:#fdfbf7; }
    .client-dashboard-main .section-sand { background:#f7f3ed; }
    .client-dashboard-main .section-head { text-align:left; margin-bottom:28px; }
    .client-dashboard-main .section-head h2 { font-size:30px; }
    .client-dashboard-main .section-head p { font-size:14px; }
    .client-dashboard-main .cards { gap:20px; }
    .client-dashboard-main .card { border-radius:14px; padding:18px; box-shadow:0 4px 14px #241a1608; }
    .client-dashboard-main .about { background:#fff; border:1px solid #efe8de; border-radius:14px; padding:24px; }
    .client-dashboard-main .contact { margin:0 40px 40px; border-radius:14px; }
    @media(max-width:680px) {
        .client-dashboard-main .hero { padding:30px 20px 20px; }
        .client-dashboard-main .hero-title { font-size:32px; }
        .client-overview-stats { grid-template-columns:1fr; padding:0 20px 16px; gap:10px; }
        .client-overview-stats article { padding:15px 18px; }
        .client-dashboard-main .section { padding:42px 20px; }
        .client-dashboard-main .section-head { text-align:center; }
        .client-dashboard-main .about { padding:18px; }
        .client-dashboard-main .contact { margin:0 20px 24px; }
    }
</style>

@endsection
