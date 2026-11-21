@extends('layouts.client')

@section('title', 'Dashboard Client - Griya Rias Elly Jr.')

@push('styles')
<style>
    @include('partials.card-slider-styles')
    .client-hero { padding-bottom: 20px; }
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
    .client-hero-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(28px, 3.5vw, 42px);
        color: #241A16;
        margin: 14px 0 8px;
    }
    .client-hero-sub {
        color: #8C8279;
        font-size: 0.95rem;
        max-width: 700px;
        line-height: 1.6;
    }

    /* STATS OVERVIEW */
    .client-overview-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        padding: 12px 0 28px;
    }
    .client-overview-stats article {
        background: #FFFFFF;
        border: 1px solid #EFE8DE;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        background: rgba(197, 143, 67, 0.1);
        color: #C58F43;
        display: grid;
        place-items: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    .client-overview-stats span {
        display: block;
        color: #8C8279;
        font-size: .72rem;
        letter-spacing: .06em;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 4px;
    }
    .client-overview-stats strong {
        font-family: 'Playfair Display', serif;
        color: #241A16;
        font-size: 1.4rem;
    }

    /* SECTIONS */
    .client-section { padding: 28px 0; }
    .client-section-sand {
        background: #F7F3ED;
        padding: 32px 28px;
        border-radius: 16px;
        margin: 12px 0;
    }
    .client-section-head { margin-bottom: 24px; }
    .client-section-head h2 {
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        color: #241A16;
    }
    .client-section-head p {
        color: #8C8279;
        font-size: 0.9rem;
        margin-top: 4px;
    }
    
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px;
    }
    .card-item {
        background: #FFFFFF;
        border: 1px solid #EFE8DE;
        border-radius: 14px;
        padding: 18px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        display: flex;
        flex-direction: column;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
    }

    .photo-wrapper {
        position: relative;
        height: 200px;
        border-radius: 10px;
        overflow: hidden;
        background: #F1E7DF;
        margin-bottom: 16px;
        display: block;
        cursor: pointer;
    }
    .photo-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease; }
    .photo-overlay {
        position: absolute;
        inset: 0;
        background: rgba(36, 26, 22, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #FFFFFF;
        font-size: 1.4rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .photo-wrapper:hover .photo-img { transform: scale(1.06); }
    .photo-wrapper:hover .photo-overlay { opacity: 1; }
    .photo-placeholder {
        width: 100%;
        height: 100%;
        display: grid;
        place-items: center;
        color: #8C8279;
        font-weight: 600;
        text-align: center;
        padding: 12px;
    }

    .card-item h3 {
        font-family: 'Playfair Display', serif;
        font-size: 19px;
        margin-bottom: 8px;
        color: #241A16;
    }
    .card-desc { font-size: 0.88rem; color: #8C8279; line-height: 1.5; flex: 1; }
    .card-price { font-size: 1.15rem; font-weight: 800; color: #C58F43; margin-top: 14px; }
    
    .card-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 14px;
        padding: 9px;
        background-color: rgba(197, 143, 67, 0.1);
        color: #C58F43;
        font-weight: 700;
        font-size: 0.85rem;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    .card-link:hover { background-color: #C58F43; color: #FFFFFF; }

    @media(max-width: 992px) {
        .cards-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .client-overview-stats { grid-template-columns: 1fr; gap: 12px; }
    }
    @media(max-width: 768px) {
        .cards-grid { grid-template-columns: 1fr; }
        .client-section-sand { padding: 24px 18px; }
    }
</style>
@endpush

@section('content')
    @php
        $namaDepan = explode(' ', trim(auth()->user()->name))[0];
        $rawPhone = $whatsapp ?? config('services.griya.whatsapp', '6287850875676');
        $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }
    @endphp

    <!-- HERO -->
    <section class="client-hero">
        <span class="badge-client">Dashboard Client</span>
        <h1 class="client-hero-title">Halo! Selamat Datang, {{ $namaDepan }}</h1>
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
        <div class="catalog-slider" data-catalog-slider>
          <div class="catalog-slider-controls">
            <button type="button" class="catalog-slider-button" data-slider-prev aria-label="Layanan sebelumnya"><i class="fa-solid fa-chevron-left"></i></button>
            <button type="button" class="catalog-slider-button" data-slider-next aria-label="Layanan berikutnya"><i class="fa-solid fa-chevron-right"></i></button>
          </div>
        <div class="cards-grid catalog-slider-track" role="region" aria-label="Layanan unggulan" tabindex="0">
            @forelse ($layanans as $layanan)
                @php
                    $msgLayanan = "Halo, saya tertarik dengan layanan " . $layanan->nama_layanan;
                    $waLayananUrl = "https://api.whatsapp.com/send?phone=" . $cleanPhone . "&text=" . urlencode($msgLayanan);
                @endphp
                <article class="card-item slider-item">
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
                    <div class="description-preview">
                        @include('partials.format-description', ['descriptionText' => $layanan->deskripsi ?: 'Informasi layanan dapat ditanyakan langsung.', 'descriptionClass' => 'preview card-desc'])
                        @include('partials.catalog-detail', ['detailKey' => 'dash-layanan-' . $layanan->id_layanan, 'detailTitle' => $layanan->nama_layanan, 'detailDescription' => $layanan->deskripsi ?: 'Informasi layanan dapat ditanyakan langsung.', 'detailImage' => $layanan->foto, 'detailPrice' => $layanan->harga, 'detailExtra' => $layanan->variasi ?? null])
                    </div>
                    <div class="card-price">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</div>
                    
                    <a class="card-link" target="_blank" rel="noopener" href="{{ $waLayananUrl }}">
                        <i class="fa-brands fa-whatsapp"></i> Tanya Layanan
                    </a>
                </article>
            @empty
                <div class="slider-empty" style="text-align: center; color: #8C8279; padding: 30px; background: #FFF; border-radius: 10px;">
                    Belum ada layanan aktif untuk ditampilkan.
                </div>
            @endforelse
        </div>
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
        <div class="catalog-slider" data-catalog-slider>
          <div class="catalog-slider-controls">
            <button type="button" class="catalog-slider-button" data-slider-prev aria-label="Paket sebelumnya"><i class="fa-solid fa-chevron-left"></i></button>
            <button type="button" class="catalog-slider-button" data-slider-next aria-label="Paket berikutnya"><i class="fa-solid fa-chevron-right"></i></button>
          </div>
        <div class="cards-grid catalog-slider-track" role="region" aria-label="Paket favorit" tabindex="0">
            @forelse ($pakets as $paket)
                @php
                    $msgPaket = "Halo, saya berminat dengan paket " . $paket->nama_paket;
                    $waPaketUrl = "https://api.whatsapp.com/send?phone=" . $cleanPhone . "&text=" . urlencode($msgPaket);
                @endphp
                <article class="card-item slider-item">
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
                    <div class="description-preview">
                        @include('partials.format-description', ['descriptionText' => $paket->deskripsi ?: 'Informasi lebih lanjut dapat ditanyakan langsung.', 'descriptionClass' => 'preview card-desc'])
                        @include('partials.catalog-detail', ['detailKey' => 'dash-paket-' . $paket->id, 'detailTitle' => $paket->nama_paket, 'detailDescription' => $paket->deskripsi ?: 'Informasi lebih lanjut dapat ditanyakan langsung.', 'detailImage' => $paket->foto, 'detailPrice' => $paket->harga, 'detailExtra' => $paket->kategoriPaket?->nama_kategori])
                    </div>
                    <div class="card-price">Rp {{ number_format($paket->harga, 0, ',', '.') }}</div>
                    
                    <a class="card-link" target="_blank" rel="noopener" href="{{ $waPaketUrl }}">
                        <i class="fa-brands fa-whatsapp"></i> Pilih Paket
                    </a>
                </article>
            @empty
                <div class="slider-empty" style="text-align: center; color: #8C8279; padding: 30px; background: #FFF; border-radius: 10px;">
                    Belum ada paket aktif untuk ditampilkan.
                </div>
            @endforelse
        </div>
        </div>
        <div style="text-align: center; margin-top: 28px;">
            <a style="background: #C58F43; color: #FFF; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.9rem; display: inline-block;" href="{{ route('client.katalog.paket') }}">
                Lihat Semua Paket <i class="fa-solid fa-arrow-right" style="margin-left: 6px;"></i>
            </a>
        </div>
    </section>
@endsection

@push('scripts')
    @include('partials.card-slider-script')
@endpush
