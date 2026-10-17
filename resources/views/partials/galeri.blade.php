<section class="section" id="galeri">
    <div class="container">
        <div class="section-head reveal">
            <h2>Galeri Portofolio</h2>
            <p>Beberapa hasil rias dan acara yang pernah kami kerjakan</p>
        </div>

        <div class="cards">
            @forelse ($portofolios as $portofolio)
                <article class="card">
                    <div class="card-img rose">
                        <img src="{{ asset('storage/' . $portofolio->gambar) }}" alt="{{ $portofolio->judul }}">
                    </div>
                    <h3>{{ $portofolio->judul }}</h3>
                    <p>{{ $portofolio->deskripsi }}</p>
                </article>
            @empty
                <p class="gd-empty">Belum ada portofolio yang ditampilkan.</p>
            @endforelse
        </div>

        <div class="reveal" style="text-align:center;margin-top:36px">
            <a href="{{ route('galeri') }}" class="btn btn-gold">Tampilkan Selengkapnya</a>
        </div>
    </div>
</section>
