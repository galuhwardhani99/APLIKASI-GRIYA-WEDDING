@extends('layouts.app')
@section('title', 'Selamat Datang')

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

{{-- ================= TENTANG KAMI SINGKAT ================= --}}
<section class="section section-sand" id="tentang">
    <div class="container about">
        <div class="about-text" style="text-align: center; max-width: 800px; margin: 0 auto;">
            <h2 class="reveal">Momen Spesial Anda Dimulai di Sini</h2>
            <p class="reveal" style="--d:100ms">
                Silakan masuk atau daftar untuk mulai melakukan pemesanan jadwal rias, atau lihat layanan lengkap kami di halaman Beranda.
            </p>
            <div class="hero-actions reveal" style="--d:200ms; justify-content: center; margin-top: 24px;">
                <a href="{{ route('home') }}" class="btn btn-gold">Masuk ke Beranda Utama</a>
            </div>
        </div>
    </div>
</section>

@endsection