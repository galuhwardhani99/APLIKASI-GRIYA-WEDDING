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
                                <img src="{{ asset('storage/' . $layanan->foto) }}" alt="{{ $layanan->nama_layanan }}">
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
                                <img src="{{ asset('storage/' . $paket->foto) }}" alt="{{ $paket->nama_paket }}">
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
        <img src="{{ asset('images/logo.jpg') }}" alt="Griya Rias Elly Jr." style="width: 100%; border-radius: 10px;">            
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
            {{-- GANTI dengan data asli --}}
            <div><b>Alamat</b><span>{{ config('services.griya.location') }}</span></div>
            <div><b>Jam Layanan</b><span>[Senin - Minggu, 08.00 - 20.00]</span></div>
            <div><b>WhatsApp</b><span>+{{ $whatsapp }}</span></div>
        </div>
    </div>
</section>

@endsection
