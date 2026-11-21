@extends('layouts.client')

@section('title', 'Katalog Layanan - Griya Rias Elly Jr.')

@push('styles')
<style>
    .katalog-header, .tools, .tools form, .actions { display: flex; align-items: center; gap: 12px; }
    .katalog-header, .tools { justify-content: space-between; }
    .katalog-header { margin-bottom: 28px; }
    
    .eyebrow { 
        color: var(--gold-primary); 
        font-size: 11px; 
        letter-spacing: .12em; 
        text-transform: uppercase; 
        font-weight: 700; 
    }

    .katalog-title { 
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
    .photo-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease; }
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
    .photo-wrapper:hover .photo-img { transform: scale(1.06); }
    .photo-wrapper:hover .photo-overlay { opacity: 1; }
    .photo-placeholder {
        width: 100%;
        height: 100%;
        display: grid;
        place-items: center;
        color: var(--text-muted);
        font-weight: 600;
        font-size: 0.9rem;
    }

    .card h2 { 
        font-family: 'Playfair Display', serif; 
        font-size: 20px; 
        font-weight: 700;
        margin: 0 0 8px; 
        color: var(--text-dark);
    }
    
    .desc { line-height: 1.6; flex: 1; color: var(--text-muted); font-size: 0.88rem; }
    .variation { font-size: 0.8rem; color: var(--gold-primary); font-weight: 700; text-transform: uppercase; margin-top: 10px; }
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
    

    @media(max-width: 992px) {
        .grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .katalog-header { align-items: flex-start; flex-direction: column; }
    }
    @media(max-width: 560px) {
        .grid { grid-template-columns: 1fr; }
        .tools form { align-items: stretch; flex-direction: column; }
        .tools input, .tools select { width: 100%; }
    }
</style>
@endpush

@section('content')
    <header class="katalog-header">
        <div>
            <span class="eyebrow">Griya Rias Elly Jr.</span>
            <h1 class="katalog-title">Katalog Layanan</h1>
            <p class="subtitle">Cari layanan berdasarkan nama, variasi, atau kisaran harga.</p>
        </div>
        <div class="actions">
            <a class="btn" href="{{ route('client.katalog.paket') }}"><i class="fa-solid fa-box-open"></i> Lihat Katalog Paket</a>
        </div>
    </header>

    <section class="filter-panel">
        <div class="tools">
            <form method="GET" action="{{ route('client.katalog.layanan') }}">
                <input type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari layanan atau deskripsi...">
                <select name="variasi">
                    <option value="">Semua variasi</option>
                    @foreach($variasiOptions as $variasi)
                        <option value="{{ $variasi }}" @selected(($filters['variasi'] ?? '') === $variasi)>{{ $variasi }}</option>
                    @endforeach
                </select>
                <input type="number" min="0" name="harga_min" value="{{ $filters['harga_min'] ?? '' }}" placeholder="Harga minimum">
                <input type="number" min="0" name="harga_max" value="{{ $filters['harga_max'] ?? '' }}" placeholder="Harga maksimum">
                <button class="btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Cari &amp; Filter</button>
                <a class="btn btn-light" href="{{ route('client.katalog.layanan') }}">Reset</a>
            </form>
        </div>
    </section>

    <section class="grid">
        @forelse($layanans as $layanan)
            <article class="card">
                @if($layanan->foto)
                    <a href="{{ asset('storage/' . $layanan->foto) }}" 
                       data-fancybox="katalog-gallery" 
                       data-caption="<strong>{{ $layanan->nama_layanan }}</strong><br>{{ $layanan->deskripsi }}" 
                       class="photo-wrapper">
                        <img src="{{ asset('storage/' . $layanan->foto) }}" alt="{{ $layanan->nama_layanan }}" class="photo-img">
                        <div class="photo-overlay">
                            <i class="fa-solid fa-magnifying-glass-plus"></i>
                        </div>
                    </a>
                @else
                    <div class="photo-wrapper">
                        <div class="photo-placeholder">{{ $layanan->nama_layanan }}</div>
                    </div>
                @endif

                <h2>{{ $layanan->nama_layanan }}</h2>
                <p class="desc">{{ $layanan->deskripsi ?: 'Informasi layanan dapat ditanyakan kepada tim kami.' }}</p>
                
                @if($layanan->variasi)
                    <p class="variation">{{ $layanan->variasi }}</p>
                @endif
                
                <p class="price">Rp {{ number_format($layanan->harga,0,',','.') }}</p>
                
                <a class="card-link" target="_blank" rel="noopener" href="https://wa.me/{{ config('services.griya.whatsapp') }}?text={{ urlencode('Halo, saya tertarik dengan layanan ' . $layanan->nama_layanan) }}">
                    <i class="fa-brands fa-whatsapp" style="font-size: 1.1rem;"></i> Tanya Layanan
                </a>
            </article>
        @empty
            <div class="empty">Tidak ada layanan yang cocok dengan pencarian atau filter Anda.</div>
        @endforelse
    </section>

    <div class="pager">
        {{ $layanans->links() }}
    </div>
@endsection