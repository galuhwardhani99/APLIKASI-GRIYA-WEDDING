<!-- Sidebar Admin Panel -->
<aside class="sidebar">
    <!-- Brand Sidebar -->
    <div class="sidebar-brand">
        <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Griya Rias Elly Jr." class="sidebar-logo-img">
        <div class="brand-text">
            <h2>GRIYA RIAS</h2>
            <p class="brand-title">Elly Jr.</p>
            <p class="brand-sub">Area Admin</p>
        </div>
    </div>

    <!-- Informasi User Admin -->
    <div class="admin-sidebar-user">
        <span class="admin-sidebar-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</span>
        <div>
            <strong>{{ auth()->user()->name ?? 'Administrator' }}</strong>
            <!-- Tambahan Link Kelola Akun -->
            <a href="{{ route('admin.users.index') }}" style="display:inline-block; margin-top: 4px; font-size: 0.75rem; color: var(--gold-primary); text-decoration: none; font-weight: 600;">
                <i class="fa-solid fa-user-gear"></i> Kelola Akun
            </a>
        </div>
    </div>
    
    <nav>
        <ul class="nav-menu">
            <li class="admin-nav-label">MENU UTAMA</li>
            
            <li>
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-shapes"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.layanan.index') }}" class="nav-item {{ request()->routeIs('admin.layanan.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-scissors"></i> Kelola Layanan
                </a>
            </li>
            <li>
                <a href="{{ route('admin.paket.index') }}" class="nav-item {{ request()->routeIs('admin.paket.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-box-open"></i> Kelola Paket
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
            
            <li class="admin-nav-label" style="padding-top:14px;">AKTIVITAS</li>
            <li>
                <a href="#" class="nav-item {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}">
                    <i class="fa-regular fa-calendar"></i> Jadwal Acara
                </a>
            </li>
            <li>
                <a href="#" class="nav-item">
                    <i class="fa-solid fa-chart-column"></i> Laporan Transaksi
                </a>
            </li>
        </ul>
    </nav>
    
    <!-- Bottom Actions -->
    <div class="sidebar-footer">
        <a href="{{ route('home') }}" class="btn-sidebar-home">
            <i class="fa-solid fa-globe"></i> Halaman Utama
        </a>
        
        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="btn-sidebar-logout">
                <i class="fa-solid fa-right-from-bracket"></i> Keluar Akun
            </button>
        </form>
    </div>
</aside>