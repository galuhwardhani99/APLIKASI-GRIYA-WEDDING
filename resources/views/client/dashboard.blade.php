@extends('layouts.app')
@section('title', 'Dashboard Client - Griya Rias Elly Jr.')

@section('content')

<!-- Pustaka External CSS & Font directly in View -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

<style>
    .client-dashboard-shell {
        display: flex;
        min-height: 100vh;
        background: #FDFBF7;
        color: #241A16;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* SIDEBAR CLIENT STICKY */
    .client-sidebar {
        width: 260px;
        flex: 0 0 260px;
        background: #FFFFFF;
        border-right: 1px solid #EFE8DE;
        padding: 24px 16px;
        display: flex;
        flex-direction: column;
        height: 100vh;
        position: sticky;
        top: 0;
        z-index: 20;
        box-shadow: 2px 0 14px rgba(36,26,22,0.03);
    }

    .client-sidebar-brand {
        padding: 4px 12px 20px;
        border-bottom: 1px solid #EFE8DE;
        text-decoration: none;
        display: flex;
        flex-direction: column;
    }
    .client-sidebar-brand span { font-size: .67rem; letter-spacing: .2em; color: #C58F43; font-weight: 700; text-transform: uppercase; }
    .client-sidebar-brand strong { font-family: 'Playfair Display', serif; color: #241A16; font-size: 1.55rem; line-height: 1.2; }
    .client-sidebar-brand small { color: #8C8279; margin-top: 4px; }

    .client-sidebar-user {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 10px;
        margin: 16px 0;
        background: #FAFAFA;
        border: 1px solid #EFE8DE;
        border-radius: 10px;
    }
    .client-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #F4E6D2;
        color: #A87632;
        display: grid;
        place-items: center;
        font-weight: 800;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .client-sidebar-user strong { font-size: .88rem; color: #241A16; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .client-sidebar-user small { font-size: .75rem; color: #8C8279; display: block; }

    .client-sidebar-nav {
        display: flex;
        flex-direction: column;
        gap: 4px;
        flex: 1;
        overflow-y: auto;
        padding-right: 4px;
    }
    .client-sidebar-nav::-webkit-scrollbar { width: 4px; }
    .client-sidebar-nav::-webkit-scrollbar-thumb { background-color: #EFE8DE; border-radius: 4px; }

    .client-nav-label { font-size: .65rem; letter-spacing: .12em; font-weight: 800; color: #A59A8E; padding: 10px 12px 4px; }

    .client-sidebar-nav a, .client-sidebar-footer > a {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        color: #55483F;
        font-size: .86rem;
        font-weight: 600;
        padding: 11px 12px;
        border-radius: 8px;
        transition: all .2s ease;
    }
    .client-sidebar-nav a i, .client-sidebar-footer i { width: 18px; text-align: center; color: #9B8877; }
    .client-sidebar-nav a:hover, .client-sidebar-footer > a:hover { background: #FBF5EC; color: #A87632; }
    .client-sidebar-nav a.active { background: #C58F43; color: #FFFFFF; }
    .client-sidebar-nav a.active i { color: #FFFFFF; }

    .client-sidebar-footer { margin-top: auto; padding-top: 16px; border-top: 1px solid #EFE8DE; display: grid; gap: 7px; }
    .client-sidebar-footer button {
        width: 100%; border: 1px solid #F1D0D0; background: #FFF5F5; color: #B33B3B;
        display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: 8px;
        font: 600 .85rem 'Plus Jakarta Sans', sans-serif; cursor: pointer; transition: .2s;
    }
    .client-sidebar-footer button:hover { background: #FDE8E8; }

    /* CONTENT AREA */
    .client-dashboard-main { min-width: 0; flex: 1; padding-bottom: 40px; }
    
    .client-hero { padding: 40px 40px 20px; background: #FDFBF7; }
    .badge-client {
        display: inline-block;
        padding: 6px 14px;
        background: #F7EDDD;
        border: 1px solid #EAD6B9;
        color: #A87632;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.2px;
        border-radius: 20px;
        text-transform: uppercase;
    }
    .client-hero-title { font-family: 'Playfair Display', serif; font-size: clamp(28px, 3.5vw, 42px); color: #241A16; margin: 14px 0 8px; }
    .client-hero-sub { color: #8C8279; font-size: 0.95rem; max-width: 700px; line-height: 1.6; }

    /* STATS OVERVIEW */
    .client-overview-stats { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 18px; padding: 12px 40px 24px; }
    .client-overview-stats article {
        background: #FFFFFF; border: 1px solid #EFE8DE; border-radius: 12px; padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 16px;
    }
    .stat-icon {
        width: 48px; height: 48px; border-radius: 10px; background: rgba(197, 143, 67, 0.1);
        color: #C58F43; display: grid; place-items: center; font-size: 1.25rem; flex-shrink: 0;
    }
    .client-overview-stats span { display: block; color: #8C8279; font-size: .72rem; letter-spacing: .06em; font-weight: 700; text-transform: uppercase; margin-bottom: 4px; }
    .client-overview-stats strong { font-family: 'Playfair Display', serif; color: #241A16; font-size: 1.4rem; }

    /* SECTIONS */
    .client-section { padding: 40px; }
    .client-section-sand { background: #F7F3ED; }
    .client-section-head { margin-bottom: 24px; }
    .client-section-head h2 { font-family: 'Playfair Display', serif; font-size: 28px; color: #241A16; }
    .client-section-head p { color: #8C8279; font-size: 0.9rem; margin-top: 4px; }
    
    .cards-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 24px; }
    .card-item {
        background: #FFFFFF; border: 1px solid #EFE8DE; border-radius: 14px; padding: 18px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02); display: flex; flex-direction: column;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card-item:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.06); }

    /* FANCYBOX FOTO WRAPPER */
    .photo-wrapper {
        position: relative; height: 200px; border-radius: 10px; overflow: hidden;
        background: #F1E7DF; margin-bottom: 16px; display: block; cursor: pointer;
    }
    .photo-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease; }
    .photo-overlay {
        position: absolute; inset: 0; background: rgba(36, 26, 22, 0.4);
        display: flex; align-items: center; justify-content: center; color: #FFFFFF;
        font-size: 1.4rem; opacity: 0; transition: opacity 0.3s ease;
    }
    .photo-wrapper:hover .photo-img { transform: scale(1.06); }
    .photo-wrapper:hover .photo-overlay { opacity: 1; }
    .photo-placeholder { width: 100%; height: 100%; display: grid; place-items: center; color: #8C8279; font-weight: 600; text-align: center; padding: 12px; }

    .card-item h3 { font-family: 'Playfair Display', serif; font-size: 19px; margin-bottom: 8px; color: #241A16; }
    .card-desc { font-size: 0.88rem; color: #8C8279; line-height: 1.5; flex: 1; }
    .card-price { font-size: 1.15rem; font-weight: 800; color: #C58F43; margin-top: 14px; }
    
    .card-link {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        margin-top: 14px; padding: 9px; background-color: rgba(197, 143, 67, 0.1);
        color: #C58F43; font-weight: 700; font-size: 0.85rem; text-decoration: none;
        border-radius: 8px; transition: all 0.2s ease;
    }
    .card-link:hover { background-color: #C58F43; color: #FFFFFF; }

    /* ABOUT & CONTACT */
    .about-box { background: #FFFFFF; border: 1px solid #EFE8DE; border-radius: 14px; padding: 30px; }
    .about-text h2 { font-family: 'Playfair Display', serif; font-size: 26px; margin-bottom: 12px; }
    .about-text p { color: #8C8279; line-height: 1.6; font-size: 0.92rem; }

    .contact-box {
        margin: 0 40px; padding: 36px; background: linear-gradient(135deg, #241A16 0%, #3D2D26 100%);
        border-radius: 16px; color: #FFFFFF; text-align: center;
    }
    .contact-box h2 { font-family: 'Playfair Display', serif; font-size: 28px; margin-bottom: 8px; }
    .contact-box p { color: #D1C7BD; font-size: 0.95rem; margin-bottom: 24px; }
    .contact-actions { display: flex; justify-content: center; gap: 14px; flex-wrap: wrap; }

    @media(max-width: 992px) {
        .cards-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .client-overview-stats { grid-template-columns: 1fr; gap: 12px; }
    }
    @media(max-width: 768px) {
        .client-dashboard-shell { flex-direction: column; }
        .client-sidebar { width: 100%; height: auto; position: relative; border-right: none; border-bottom: 1px solid #EFE8DE; }
        .cards-grid { grid-template-columns: 1fr; }
        .client-hero, .client-section, .client-overview-stats { padding: 24px 20px; }
        .contact-box { margin: 0 20px; padding: 24px; }
    }
</style>

<div class="client-dashboard-shell">
    <!-- SIDEBAR CLIENT -->
    <aside class="client-sidebar">
        <a class="client-sidebar-brand" href="{{ route('client.dashboard') }}">
            <span>Griya Rias</span>
            <strong>Elly Jr.</strong>
            <small>Area Client</small>
        </a>
        
        <div class="client-sidebar-user">
            <span class="client-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            <div style="min-width: 0;">
                <strong>{{ auth()->user()->name }}</strong>
                <small>Client</small>
            </div>
        </div>

        <nav class="client-sidebar-nav">
            <span class="client-nav-label">MENU UTAMA</span>
            <a href="{{ route('client.dashboard') }}" class="{{ request()->routeIs('client.dashboard*') ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i> Dashboard
            </a>
            <a href="{{ route('client.katalog.layanan') }}" class="{{ request()->routeIs('client.katalog.layanan*') ? 'active' : '' }}">
                <i class="fa-solid fa-scissors"></i> Katalog Layanan
            </a>
            <a href="{{ route('client.katalog.paket') }}" class="{{ request()->routeIs('client.katalog.paket*') ? 'active' : '' }}">
                <i class="fa-solid fa-box-open"></i> Katalog Paket
            </a>
            <a href="{{ route('client.jadwal.index') }}" class="{{ request()->routeIs('client.jadwal.*') ? 'active' : '' }}">
                <i class="fa-regular fa-calendar-days"></i> Jadwal Acara
            </a>
            <a href="{{ route('reservasi.create') }}" class="{{ request()->routeIs('reservasi.create*') ? 'active' : '' }}">
                <i class="fa-regular fa-calendar-check"></i> Form Reservasi
            </a>
            
            <span class="client-nav-label" style="margin-top: 12px;">AKTIVITAS & AKUN</span>
            <a href="{{ route('client.riwayat.reservasi') }}" class="{{ request()->routeIs('client.riwayat.reservasi*') ? 'active' : '' }}">
                <i class="fa-regular fa-calendar"></i> Riwayat Reservasi
            </a>
            
            @if(Route::has('client.riwayat.transaksi'))
                <a href="{{ route('client.riwayat.transaksi') }}" class="{{ request()->routeIs('client.riwayat.transaksi*') ? 'active' : '' }}">
                    <i class="fa-solid fa-receipt"></i> Riwayat Transaksi
                </a>
            @else
                <a href="{{ route('client.dashboard') }}" class="{{ request()->routeIs('client.riwayat.transaksi*') ? 'active' : '' }}" onclick="alert('Fitur Riwayat Transaksi tersedia pada Sprint 3.'); return false;">
                    <i class="fa-solid fa-receipt"></i> Riwayat Transaksi
                </a>
            @endif

            <a href="{{ route('user.profile.edit') }}" class="{{ request()->routeIs('user.profile.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-gear"></i> Pengaturan Akun
            </a>
        </nav>

        <div class="client-sidebar-footer">
            <a href="{{ route('client.home') }}"><i class="fa-solid fa-globe"></i> Halaman Client</a>
            <form id="logout-form-client" action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="button" onclick="confirmLogoutClient()"><i class="fa-solid fa-right-from-bracket"></i> Keluar Akun</button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="client-dashboard-main">
        @php
            $namaDepan = explode(' ', trim(auth()->user()->name))[0];
            
            // Format Nomor HP WhatsApp (Default: 6287850875676)
            $rawPhone = $whatsapp ?? config('services.griya.whatsapp', '6287850875676');
            $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
            if (str_starts_with($cleanPhone, '0')) {
                $cleanPhone = '62' . substr($cleanPhone, 1);
            }
        @endphp

        <!-- HERO -->
        <section class="client-hero">
            <span class="badge-client">Dashboard Client</span>
            <h1 class="client-hero-title">Selamat Datang, {{ $namaDepan }}</h1>
            <p class="client-hero-sub">
                Temukan layanan tata rias terbaik untuk momen istimewa Anda. Jelajahi paket penawaran, cek ketersediaan jadwal, dan ajukan reservasi dengan mudah.
            </p>
        </section>

        <!-- STATS -->
        <section class="client-overview-stats">
            <article>
                <div class="stat-icon"><i class="fa-solid fa-scissors"></i></div>
                <div>
                    <span>Katalog Layanan</span>
                    <strong>{{ $layanansCount }} Layanan</strong>
                </div>
            </article>
            <article>
                <div class="stat-icon"><i class="fa-solid fa-box-open"></i></div>
                <div>
                    <span>Katalog Paket</span>
                    <strong>{{ $paketsCount }} Paket</strong>
                </div>
            </article>
            <article>
                <div class="stat-icon"><i class="fa-regular fa-calendar-check"></i></div>
                <div>
                    <span>Reservasi Saya</span>
                    <strong>{{ $reservasisCount }} Pengajuan</strong>
                </div>
            </article>
        </section>

        <!-- LAYANAN -->
        <section class="client-section">
            <div class="client-section-head">
                <h2>Katalog Layanan Unggulan</h2>
                <p>Pilihan variasi layanan rias profesional untuk berbagai acara Anda.</p>
            </div>
            <div class="cards-grid">
                @forelse ($layanans as $layanan)
                    @php
                        $msgLayanan = "Halo, saya tertarik dengan layanan " . $layanan->nama_layanan;
                        $waLayananUrl = "https://api.whatsapp.com/send?phone=" . $cleanPhone . "&text=" . urlencode($msgLayanan);
                    @endphp
                    <article class="card-item">
                        @if($layanan->foto)
                            <a href="{{ asset('storage/' . $layanan->foto) }}" 
                               data-fancybox="dash-layanan" 
                               data-caption="<strong>{{ $layanan->nama_layanan }}</strong><br>{{ $layanan->deskripsi }}" 
                               class="photo-wrapper">
                                <img src="{{ asset('storage/' . $layanan->foto) }}" alt="{{ $layanan->nama_layanan }}" class="photo-img">
                                <div class="photo-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
                            </a>
                        @else
                            <div class="photo-wrapper">
                                <div class="photo-placeholder">{{ $layanan->nama_layanan }}</div>
                            </div>
                        @endif

                        <h3>{{ $layanan->nama_layanan }}</h3>
                        <p class="card-desc">{{ Str::limit($layanan->deskripsi ?: 'Informasi layanan dapat ditanyakan langsung.', 90) }}</p>
                        <div class="card-price">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</div>
                        
                        <a class="card-link" target="_blank" rel="noopener" href="{{ $waLayananUrl }}">
                            <i class="fa-brands fa-whatsapp"></i> Tanya Layanan
                        </a>
                    </article>
                @empty
                    <div style="grid-column: 1/-1; text-align: center; color: #8C8279; padding: 30px; background: #FFF; border-radius: 10px;">
                        Belum ada layanan aktif untuk ditampilkan.
                    </div>
                @endforelse
            </div>
            <div style="text-align: center; margin-top: 28px;">
                <a style="background: #C58F43; color: #FFF; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.9rem; display: inline-block;" href="{{ route('client.katalog.layanan') }}">
                    Lihat Semua Layanan <i class="fa-solid fa-arrow-right" style="margin-left: 6px;"></i>
                </a>
            </div>
        </section>

        <!-- PAKET -->
        <section class="client-section client-section-sand">
            <div class="client-section-head">
                <h2>Katalog Paket Favorit</h2>
                <p>Paket pilihan lengkap yang dirancang khusus untuk kenyamanan momen Anda.</p>
            </div>
            <div class="cards-grid">
                @forelse ($pakets as $paket)
                    @php
                        $msgPaket = "Halo, saya berminat dengan paket " . $paket->nama_paket;
                        $waPaketUrl = "https://api.whatsapp.com/send?phone=" . $cleanPhone . "&text=" . urlencode($msgPaket);
                    @endphp
                    <article class="card-item">
                        @if($paket->foto)
                            <a href="{{ asset('storage/' . $paket->foto) }}" 
                               data-fancybox="dash-paket" 
                               data-caption="<strong>{{ $paket->nama_paket }}</strong><br>{{ $paket->deskripsi }}" 
                               class="photo-wrapper">
                                <img src="{{ asset('storage/' . $paket->foto) }}" alt="{{ $paket->nama_paket }}" class="photo-img">
                                <div class="photo-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
                            </a>
                        @else
                            <div class="photo-wrapper">
                                <div class="photo-placeholder">{{ $paket->kategoriPaket?->nama_kategori ?? $paket->nama_paket }}</div>
                            </div>
                        @endif

                        <h3>{{ $paket->nama_paket }}</h3>
                        <p class="card-desc">{{ Str::limit($paket->deskripsi ?: 'Informasi lebih lanjut dapat ditanyakan langsung.', 90) }}</p>
                        <div class="card-price">Rp {{ number_format($paket->harga, 0, ',', '.') }}</div>
                        
                        <a class="card-link" target="_blank" rel="noopener" href="{{ $waPaketUrl }}">
                            <i class="fa-brands fa-whatsapp"></i> Pilih Paket
                        </a>
                    </article>
                @empty
                    <div style="grid-column: 1/-1; text-align: center; color: #8C8279; padding: 30px; background: #FFF; border-radius: 10px;">
                        Belum ada paket aktif untuk ditampilkan.
                    </div>
                @endforelse
            </div>
            <div style="text-align: center; margin-top: 28px;">
                <a style="background: #C58F43; color: #FFF; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.9rem; display: inline-block;" href="{{ route('client.katalog.paket') }}">
                    Lihat Semua Paket <i class="fa-solid fa-arrow-right" style="margin-left: 6px;"></i>
                </a>
            </div>
        </section>

        <!-- ABOUT -->
        <section class="client-section">
            <div class="about-box">
                <div class="about-text">
                    <h2>Tentang Griya Rias Elly Jr.</h2>
                    <p>
                        Griya Rias Elly Jr. melayani tata rias pengantin tradisional maupun modern, rias acara resmi, hingga perencanaan lengkap Wedding &amp; Event Organizer. Kami siap membantu mewujudkan momen berkesan Anda dengan riasan yang elegan dan pelayanan profesional.
                    </p>
                </div>
            </div>
        </section>

        <!-- GALERI -->
        @include('partials.galeri')

        <!-- KONTAK -->
        <section class="contact-box">
            @php
                $msgKonsultasi = "Halo Griya Rias Elly Jr., saya ingin berkonsultasi mengenai jadwal dan layanan.";
                $waKonsultasiUrl = "https://api.whatsapp.com/send?phone=" . $cleanPhone . "&text=" . urlencode($msgKonsultasi);
            @endphp
            <h2>Siap Merencanakan Acara Spesial Anda?</h2>
            <p>Konsultasikan kebutuhan rias Anda atau langsung amankan tanggal reservasi sekarang.</p>
            <div class="contact-actions">
                <a target="_blank" rel="noopener" href="{{ $waKonsultasiUrl }}" style="background: #25D366; color: #FFFFFF; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fa-brands fa-whatsapp" style="font-size: 1.2rem;"></i> Chat via WhatsApp
                </a>
                <a href="{{ route('reservasi.create') }}" style="background: #C58F43; color: #FFFFFF; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fa-regular fa-calendar-check"></i> Pesan Jadwal Sekarang
                </a>
            </div>
        </section>
    </div>
</div>

<!-- Pustaka External JS SweetAlert2 & Fancybox -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

<script>
    // FUNGSI KONFIRMASI LOGOUT CLIENT
    function confirmLogoutClient() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Keluar dari Akun?',
                text: 'Anda harus masuk kembali untuk membuat atau melihat reservasi.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#C58F43',
                cancelButtonColor: '#8C8279',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                background: '#FFFFFF',
                color: '#241A16'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form-client').submit();
                }
            });
        } else {
            if (confirm('Apakah Anda yakin ingin keluar dari akun?')) {
                document.getElementById('logout-form-client').submit();
            }
        }
    }

    // FANCYBOX INITIALIZATION
    Fancybox.bind('[data-fancybox]', {
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
@endsection