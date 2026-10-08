@extends('layouts.app')
@section('title', 'Beranda')

@section('content')

{{-- ================= HERO ================= --}}
<section class="hero" id="beranda">
    <div class="orb o1" data-speed="0.18"><i></i></div>
    <div class="orb o2" data-speed="0.30"><i></i></div>
    <div class="orb o3" data-speed="0.10"><i></i></div>

    <div class="hero-inner">
        <span class="badge fu" style="--d:50ms">Elegansi &amp; Keanggunan Acara Spesial</span>

        <h1 class="hero-title">
            @foreach (explode(' ', 'Tampil Mempesona di Hari Paling Bahagia Anda') as $i => $kata)
                <span class="w"><span style="--i:{{ $i }}">{{ $kata }}</span></span>
            @endforeach
        </h1>

        <p class="hero-sub fu" style="--d:900ms">
            Melayani jasa tata rias pengantin tradisional/modern, acara resmi, hingga perencanaan lengkap Wedding &amp; Event Organizer.
        </p>

        <div class="hero-actions fu" style="--d:1100ms">
            <a href="#katalog" class="btn btn-gold">Lihat Katalog Paket</a>
            <a href="#kontak" class="btn btn-outline">Cek Ketersediaan Tanggal</a>
        </div>
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

{{-- ================= LAYANAN / KATALOG ================= --}}
<section class="section" id="katalog">
    <div class="container">
        <div class="section-head reveal">
            <h2>Layanan Unggulan Kami</h2>
            <p>Pilihan paket terfavorit calon pengantin dan pelaksana acara</p>
        </div>

        <div class="cards">
            @foreach ($layanan as $i => $item)
                <div class="reveal" style="--d:{{ $i * 140 }}ms">
                    <article class="card tilt">
                        <div class="card-img {{ $item['tone'] }}">
                            @if ($item['gambar'])
                                <img src="{{ asset($item['gambar']) }}" alt="{{ $item['judul'] }}">
                            @else
                                <span>{{ $item['label'] }}</span>
                            @endif
                        </div>
                        <h3>{{ $item['judul'] }}</h3>
                        <p>{{ $item['deskripsi'] }}</p>
                        <div class="price">Rp {{ number_format($item['harga'], 0, ',', '.') }}</div>
                    </article>
                </div>
            @endforeach
        </div>
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

{{-- ================= GALERI ================= --}}
<section class="section" id="galeri">
    <div class="container">
        <div class="section-head reveal">
            <h2>Galeri Portofolio</h2>
            <p>Sebagian hasil rias dan acara yang pernah kami kerjakan</p>
        </div>

        <div class="gallery" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
            @forelse ($portofolios as $i => $item)
                <figure class="g reveal" style="--d:{{ $i * 90 }}ms; margin: 0; border-radius: 16px; overflow: hidden; position: relative; box-shadow: 0 4px 20px rgba(0,0,0,0.06); background-color: #FFFFFF;">
                    <div class="g-in" style="width: 100%; height: 380px; overflow: hidden; background-color: #FAFAFA;">
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" style="width: 100%; height: 100%; object-fit: cover; object-position: center; transition: transform 0.4s ease;">
                    </div>
                    <figcaption style="position: absolute; bottom: 0; left: 0; right: 0; padding: 16px; background: linear-gradient(transparent, rgba(36,26,22,0.85)); color: #FFF;">
                        <small style="color: #C58F43; font-weight: 700; text-transform: uppercase; font-size: 0.72rem; letter-spacing: 0.05em;">{{ $item->kategori }}</small>
                        <h4 style="font-size: 1rem; margin-top: 2px; font-family: 'Playfair Display', serif; font-weight: 600;">{{ $item->judul }}</h4>
                    </figcaption>
                </figure>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; color: #8C8279; padding: 40px; background: #FFF; border-radius: 12px; border: 1px solid #EFE8DE;">
                    Belum ada foto portofolio yang diunggah.
                </div>
            @endforelse
        </div>
    </div>
</section>

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
            {{-- GANTI dengan data asli --}}
            <div><b>Alamat</b><span>[Alamat lengkap Griya Rias Elly Jr.]</span></div>
            <div><b>Jam Layanan</b><span>[Senin - Minggu, 08.00 - 20.00]</span></div>
            <div><b>WhatsApp</b><span>+{{ $whatsapp }}</span></div>
        </div>
    </div>
</section>

@endsection