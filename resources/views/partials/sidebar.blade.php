<aside class="sidebar">
    <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
        <div class="brand-text">
            <h2>GRIYA RIAS</h2>
            <h1 class="brand-title">Elly Jr.</h1>
            <p class="brand-sub">Area Admin</p>
        </div>
    </a>

    @auth
        <div class="admin-sidebar-user">
            <span class="admin-sidebar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            <div style="min-width: 0;">
                <strong>{{ auth()->user()->name }}</strong>
                <small>Administrator</small>
            </div>
        </div>
    @endauth

    <ul class="nav-menu">
        <li class="admin-nav-label">MENU UTAMA</li>
        <li>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
                <i class="fa-solid fa-shapes"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.layanan.index') }}" class="nav-item {{ request()->routeIs('admin.layanan.*') ? 'active' : '' }}">
                <i class="fa-solid fa-scissors"></i> Katalog Layanan
            </a>
        </li>
        <li>
            <a href="{{ route('admin.paket.index') }}" class="nav-item {{ request()->routeIs('admin.paket.*') ? 'active' : '' }}">
                <i class="fa-solid fa-box-open"></i> Katalog Paket
            </a>
        </li>
        <li>
            <a href="{{ route('admin.kategori-paket.index') }}" class="nav-item {{ request()->routeIs('admin.kategori-paket.*') ? 'active' : '' }}">
                <i class="fa-solid fa-tags"></i> Kategori Paket
            </a>
        </li>
        <li>
            <a href="{{ route('admin.portofolio.index') }}" class="nav-item {{ request()->routeIs('admin.portofolio.*') ? 'active' : '' }}">
                <i class="fa-solid fa-images"></i> Galeri Portofolio
            </a>
        </li>

        <li class="admin-nav-label admin-nav-spaced">AKTIVITAS &amp; AKUN</li>
        <li>
            <a href="{{ route('admin.jadwal.index') }}" class="nav-item {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}">
                <i class="fa-regular fa-calendar"></i> Jadwal Acara
            </a>
        </li>
        <li>
            <!-- Dihubungkan ke route transaksi jika ada, atau gunakan route('admin.dashboard') / '#' tanpa memicu void -->
            @if(Route::has('admin.transaksi.index'))
                <a href="{{ route('admin.transaksi.index') }}" class="nav-item {{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-column"></i> Laporan Transaksi
                </a>
            @else
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}" onclick="alert('Fitur Laporan Transaksi sedang dalam pengembangan.'); return false;">
                    <i class="fa-solid fa-chart-column"></i> Laporan Transaksi
                </a>
            @endif
        </li>
        <li>
            <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear"></i> Kelola Akun
            </a>
        </li>
        <li>
            <a href="{{ route('user.profile.edit') }}" class="nav-item {{ request()->routeIs('user.profile.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-gear"></i> Pengaturan Akun
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <a href="{{ route('home') }}" class="btn-sidebar-home"><i class="fa-solid fa-globe"></i> Halaman Utama</a>
        <form id="logout-form-admin" action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="button" class="btn-sidebar-logout" onclick="confirmLogoutAdmin()">
                <i class="fa-solid fa-right-from-bracket"></i> Keluar Akun
            </button>
        </form>
    </div>
</aside>

<script>
    function confirmLogoutAdmin() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Keluar dari Panel Admin?',
                text: "Sesi admin Anda akan diakhiri.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#C58F43',
                cancelButtonColor: '#8C8279',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                background: '#FFFFFF',
                color: '#241A16'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form-admin').submit();
                }
            });
        } else {
            if (confirm('Apakah Anda yakin ingin keluar dari akun admin?')) {
                document.getElementById('logout-form-admin').submit();
            }
        }
    }
</script>
