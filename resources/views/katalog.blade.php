<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Katalog - Griya Wedding</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,600&display=swap');
        .font-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-[#241712] text-gray-200 font-sans flex h-screen overflow-hidden">

    <!-- Sidebar Admin Panel -->
    <aside class="w-64 bg-[#312018] h-[95vh] p-5 flex flex-col rounded-xl my-auto ml-4 shadow-2xl border border-[#432d22]">
        <div class="text-center mb-8 mt-4 border-b border-[#432d22] pb-6">
            <h2 class="text-[#d79d57] text-xl font-bold font-serif tracking-wide">Admin Panel</h2>
            <p class="text-xs text-gray-400 mt-1">Griya Rias Elly J.</p>
        </div>

        <nav class="flex flex-col gap-3">
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-[#432d22] hover:text-white transition duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="text-sm font-medium">Dashboard</span>
            </a>
            
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-[#d79d57] text-[#241712] transition shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <span class="text-sm font-bold">Kelola Katalog</span>
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-[#432d22] hover:text-white transition duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="text-sm font-medium">Jadwal Acara</span>
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-[#432d22] hover:text-white transition duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                <span class="text-sm font-medium">Laporan Transaksi</span>
            </a>
        </nav>
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 p-8 overflow-y-auto relative">
        <!-- Header Halaman -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-[#d79d57] text-3xl font-serif font-bold tracking-wide">Daftar Paket Rias & WO</h1>
            <button onclick="openModal()" class="bg-[#d79d57] text-[#241712] px-5 py-2.5 rounded-lg font-bold text-sm flex items-center gap-2 hover:bg-[#c48946] transition shadow-lg border border-[#e5a963]">
                <svg class="w-4 h-4 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                Tambah Paket Baru
            </button>
        </div>

        <!-- Tabel Data Dinamis -->
        <div class="bg-[#312018] rounded-xl shadow-2xl border border-[#432d22] overflow-hidden mt-6">
            <table class="w-full text-left border-collapse">
                <thead class="bg-[#241712] bg-opacity-40">
                    <tr>
                        <th class="py-4 px-6 text-[#d79d57] font-semibold text-[11px] uppercase tracking-widest border-b border-[#432d22]">Nama Paket</th>
                        <th class="py-4 px-6 text-[#d79d57] font-semibold text-[11px] uppercase tracking-widest border-b border-[#432d22] text-center">Kategori</th>
                        <th class="py-4 px-6 text-[#d79d57] font-semibold text-[11px] uppercase tracking-widest border-b border-[#432d22] text-center">Harga</th>
                        <th class="py-4 px-6 text-[#d79d57] font-semibold text-[11px] uppercase tracking-widest border-b border-[#432d22] text-center">Status</th>
                        <th class="py-4 px-6 text-[#d79d57] font-semibold text-[11px] uppercase tracking-widest border-b border-[#432d22] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#432d22]">
                    @isset($katalogs)
                        @forelse($katalogs as $item)
                            <tr class="hover:bg-[#3a271d] transition duration-150">
                                <td class="py-4 px-6 text-sm font-medium text-gray-200">{{ $item->nama_paket }}</td>
                                <td class="py-4 px-6 text-sm text-gray-400 text-center">{{ $item->kategori }}</td>
                                <td class="py-4 px-6 text-sm text-gray-400 text-center">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td class="py-4 px-6 text-sm text-center">
                                    <span class="text-green-500 font-semibold tracking-wide">Aktif</span>
                                </td>
                                <td class="py-4 px-6 text-sm text-center space-x-2">
                                    <button class="bg-[#2563eb] hover:bg-blue-700 text-white px-4 py-1.5 rounded text-xs font-medium transition shadow">Edit</button>
                                    <button class="bg-[#dc2626] hover:bg-red-700 text-white px-4 py-1.5 rounded text-xs font-medium transition shadow">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 px-6 text-center text-sm text-gray-400">Belum ada data paket yang ditambahkan.</td>
                            </tr>
                        @endforelse
                    @else
                        <tr>
                            <td colspan="5" class="py-6 px-6 text-center text-sm text-gray-400">Belum ada data paket yang ditambahkan.</td>
                        </tr>
                    @endisset
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal Form Tambah / Edit Paket -->
    <div id="paketModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden flex items-center justify-center z-50">
        <div class="bg-[#fcf8f2] text-gray-800 w-full max-w-lg p-6 rounded-2xl shadow-2xl border-2 border-[#d79d57] relative mx-4">
            
            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-xl font-bold">&times;</button>

            <h3 class="text-gray-900 font-serif font-bold text-lg mb-4 border-b pb-2">Form Tambah / Edit Paket Layanan</h3>

            <!-- Form Mengarah ke rute POST /katalog -->
            <form action="{{ url('/katalog') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Paket Layanan</label>
                    <input type="text" name="nama_paket" placeholder="Contoh: Paket Rias Pengantin Exclusive" required class="w-full text-sm px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#d79d57] bg-white">
                </div>

                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Kategori</label>
                        <input type="text" name="kategori" placeholder="Rias Pengantin" required class="w-full text-sm px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#d79d57] bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Harga (Rp)</label>
                        <input type="number" name="harga" placeholder="7500000" required class="w-full text-sm px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#d79d57] bg-white">
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Deskripsi Paket</label>
                    <textarea name="deskripsi" rows="3" placeholder="Tuliskan rincian fasilitas paket..." class="w-full text-sm px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#d79d57] bg-white"></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-2 rounded-lg text-sm font-medium transition">Batal</button>
                    <button type="submit" class="bg-[#d79d57] hover:bg-[#c48946] text-white px-5 py-2 rounded-lg text-sm font-bold shadow transition">Simpan Paket</button>
                </div>
            </form>

        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('paketModal').classList.remove('hidden');
        }
        function closeModal() {
            document.getElementById('paketModal').classList.add('hidden');
        }
    </script>

</body>
</html>