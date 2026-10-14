<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Portofolio - Griya Rias Elly Jr.</title>
    
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { background-color: #FDFBF7; color: #241A16; font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body>

    <!-- Header Navigation Client -->
    <header class="bg-[#FDFBF7] border-b border-[#EFE8DE] px-8 py-4 flex justify-between items-center sticky top-0 z-40">
        <nav class="flex gap-6 text-xs font-bold tracking-wider uppercase text-[#241A16]">
            <a href="/" class="hover:text-[#C58F43]">Beranda</a>
            <a href="/katalog" class="hover:text-[#C58F43]">Katalog WO/EO</a>
            <a href="/tentang" class="hover:text-[#C58F43]">Tentang Kami</a>
        </nav>

        <div class="text-center">
            <h1 class="font-serif text-lg font-bold text-[#C58F43] tracking-widest uppercase">Griya Rias</h1>
            <h2 class="font-serif text-xl font-bold italic text-[#241A16]">Elly Jr.</h2>
        </div>

        <div class="flex gap-6 items-center text-xs font-bold tracking-wider uppercase">
            <a href="{{ route('galeri') }}" class="text-[#C58F43] border-b-2 border-[#C58F43] pb-1">Galeri Portofolio</a>
            <a href="/kontak" class="hover:text-[#C58F43]">Kontak</a>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="bg-[#C58F43] text-white px-4 py-2 rounded-lg font-bold hover:bg-[#a87632] transition">Dashboard Admin</a>
            @else
                <a href="/login" class="bg-[#C58F43] text-white px-4 py-2 rounded-lg font-bold hover:bg-[#a87632] transition">Login</a>
            @endauth
        </div>
    </header>

    <!-- Section Title -->
    <section class="text-center py-12 px-4">
        <h1 class="font-serif text-4xl font-bold text-[#241A16] mb-3">Galeri Portofolio</h1>
        <p class="text-gray-500 text-sm">Sebagian hasil rias dan acara yang pernah kami kerjakan</p>
    </section>

    <!-- Dynamic Portfolio Grid -->
    <main class="max-w-6xl mx-auto px-6 pb-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($portofolios as $item)
                <div class="bg-white border border-[#EFE8DE] rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition group">
                    <div class="h-64 overflow-hidden relative">
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        <span class="absolute top-3 left-3 bg-[#241A16]/80 text-[#FDFBF7] text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full backdrop-blur-sm">
                            {{ $item->kategori }}
                        </span>
                    </div>
                    <div class="p-5">
                        <h3 class="font-serif font-bold text-lg text-[#241A16] mb-1">{{ $item->judul }}</h3>
                        @if($item->deskripsi)
                            <p class="text-xs text-gray-500 line-clamp-2">{{ $item->deskripsi }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16 text-gray-400 bg-white border border-[#EFE8DE] rounded-2xl">
                    Belum ada portofolio yang ditampilkan.
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>