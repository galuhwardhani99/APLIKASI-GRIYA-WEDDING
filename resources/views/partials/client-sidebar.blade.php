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
        
        <span class="client-nav-label" style="margin-top: 12px;">AKTIVITAS &amp; AKUN</span>
        <a href="{{ route('client.riwayat.reservasi') }}" class="{{ request()->routeIs('client.riwayat.reservasi*') ? 'active' : '' }}">
            <i class="fa-regular fa-calendar"></i> Riwayat Reservasi
            @if(isset($clientValidatedCount) && $clientValidatedCount > 0)
                <span class="badge-client-notif" title="Update Validasi Admin">{{ $clientValidatedCount }}</span>
            @endif
        </a>
        
        @if(Route::has('client.riwayat.transaksi'))
            <a href="{{ route('client.riwayat.transaksi') }}" class="{{ request()->routeIs('client.riwayat.transaksi*') ? 'active' : '' }}">
                <i class="fa-solid fa-receipt"></i> Riwayat Transaksi
                @if(isset($clientApprovedReadyToPayCount) && $clientApprovedReadyToPayCount > 0)
                    <span class="badge-client-notif" style="background-color:#D97706;" title="Menunggu Pembayaran">{{ $clientApprovedReadyToPayCount }}</span>
                @endif
            </a>
        @endif

        <a href="{{ route('user.profile.edit') }}" class="{{ request()->routeIs('user.profile.*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-gear"></i> Pengaturan Akun
        </a>
    </nav>

    <div class="client-sidebar-footer">
        <a href="{{ route('client.home') }}"><i class="fa-solid fa-globe"></i> Halaman Utama</a>
        <form id="logout-form-client" action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="button" onclick="confirmLogoutClient()">
                <i class="fa-solid fa-right-from-bracket"></i> Keluar Akun
            </button>
        </form>
    </div>
</aside>