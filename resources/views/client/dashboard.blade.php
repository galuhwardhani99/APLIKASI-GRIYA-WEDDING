@extends('layouts.app')
@section('title', 'Dashboard Client')

@section('content')

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

        <div class="hero-actions fu" style="--d:1100ms">
            <a href="#katalog" class="btn btn-gold">Lihat Katalog Paket</a>
            <a href="{{ route('reservasi.create') }}" class="btn btn-outline">Cek Ketersediaan Tanggal</a>
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

@endsection
