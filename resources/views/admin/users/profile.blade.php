<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun - Griya Rias Elly Jr.</title>
    
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-light: #FDFBF7; 
            --bg-card: #FFFFFF; 
            --gold-primary: #C58F43;
            --gold-hover: #A87632;
            --text-dark: #241A16; 
            --text-muted: #8C8279; 
            --border-color: #EFE8DE;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: var(--bg-light); color: var(--text-dark); font-family: 'Plus Jakarta Sans', sans-serif; display: flex; min-height: 100vh; }

        /* Sidebar Client */
        .client-sidebar {
            width: 260px;
            flex: 0 0 260px;
            background: #fff;
            border-right: 1px solid var(--border-color);
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: sticky;
            top: 0;
            z-index: 20;
            box-shadow: 2px 0 14px rgba(36, 26, 22, 0.03);
        }
        .client-sidebar-brand {
            padding: 4px 12px 20px;
            border-bottom: 1px solid var(--border-color);
            text-decoration: none;
            display: flex;
            flex-direction: column;
        }
        .client-sidebar-brand span { font-size: .67rem; letter-spacing: .2em; color: var(--gold-primary); font-weight: 700; text-transform: uppercase; }
        .client-sidebar-brand strong { font-family: 'Playfair Display', serif; color: var(--text-dark); font-size: 1.55rem; line-height: 1.2; }
        .client-sidebar-brand small { color: var(--text-muted); margin-top: 4px; }

        /* User Profile di Sidebar */
        .client-sidebar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 10px;
            margin: 16px 0;
            background: #FAFAFA;
            border: 1px solid var(--border-color);
            border-radius: 10px;
        }
        .client-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #F4E6D2;
            color: var(--gold-hover);
            display: grid;
            place-items: center;
            font-weight: 800;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .client-sidebar-user strong { font-size: .88rem; color: var(--text-dark); display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .client-sidebar-user small { font-size: .75rem; color: var(--text-muted); display: block; }

        /* Navigasi Sidebar */
        .client-sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex: 1;
            overflow-y: auto;
            padding-right: 4px;
        }
        .client-nav-label { font-size: .65rem; letter-spacing: .12em; font-weight: 800; color: #A59A8E; padding: 10px 12px 4px; display: block; }

        .client-sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #55483F;
            font-size: .86rem;
            font-weight: 600;
            padding: 11px 12px;
            border-radius: 8px;
            transition: .2s;
        }
        .client-sidebar-nav a i { width: 18px; text-align: center; color: var(--text-muted); }
        .client-sidebar-nav a:hover { background: #FBF5EC; color: var(--gold-hover); }
        .client-sidebar-nav a.active { background: var(--gold-primary); color: #fff; }
        .client-sidebar-nav a.active i { color: #fff; }

        /* Footer Sidebar */
        .client-sidebar-footer {
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
            display: grid;
            gap: 7px;
        }
        .client-sidebar-footer > a {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #55483F;
            font-size: .86rem;
            font-weight: 600;
            padding: 11px 12px;
            border-radius: 8px;
        }
        .client-sidebar-footer button {
            width: 100%;
            border: 1px solid #F1D0D0;
            background: #FFF5F5;
            color: #B33B3B;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 8px;
            font: 600 .85rem 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
        }

        /* Main Content */
        .main-content { flex: 1; padding: 40px; min-width: 0; }
        .page-header { margin-bottom: 24px; }
        .page-title { font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--text-dark); margin-bottom: 6px; }
        .page-sub { color: var(--text-muted); font-size: 0.9rem; }

        .profile-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 32px;
            max-width: 680px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 8px; }
        .form-control {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.9rem;
            outline: none;
            background: #FAFAFA;
            color: var(--text-dark);
            transition: border-color 0.2s;
        }
        .form-control:focus { border-color: var(--gold-primary); background: #FFF; }
        
        .btn-gold-save {
            background-color: var(--gold-primary);
            color: #FFFFFF;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.2s;
        }
        .btn-gold-save:hover { background-color: var(--gold-hover); }

        .alert-success-custom {
            background-color: #E8F5E9;
            color: #2E7D32;
            border: 1px solid #C8E6C9;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <!-- Sidebar Client -->
    <aside class="client-sidebar">
        <a class="client-sidebar-brand" href="{{ route('client.dashboard') }}">
            <span>GRIYA RIAS</span><strong>Elly Jr.</strong><small>Area Client</small>
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
            <a href="{{ route('client.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a>
            <a href="{{ route('client.katalog.layanan') }}"><i class="fa-solid fa-scissors"></i> Katalog Layanan</a>
            <a href="{{ route('client.katalog.paket') }}"><i class="fa-solid fa-box-open"></i> Katalog Paket</a>
            <a href="{{ route('client.jadwal.index') }}"><i class="fa-regular fa-calendar-days"></i> Jadwal Acara</a>
            <a href="{{ route('reservasi.create') }}"><i class="fa-regular fa-calendar-check"></i> Form Reservasi</a>
            
            <span class="client-nav-label" style="margin-top: 12px;">AKTIVITAS & AKUN</span>
            <a href="{{ route('client.riwayat.reservasi') }}"><i class="fa-regular fa-calendar"></i> Riwayat Reservasi</a>
            <a href="{{ route('client.riwayat.transaksi') }}"><i class="fa-solid fa-receipt"></i> Riwayat Transaksi</a>
            <a href="{{ route('user.profile.edit') }}" class="active">
                <i class="fa-solid fa-user-gear"></i> Pengaturan Akun
            </a>
        </nav>

        <div class="client-sidebar-footer">
    <a href="{{ auth()->user()->role === 'client' ? route('client.home') : route('home') }}"><i class="fa-solid fa-globe"></i> {{ auth()->user()->role === 'client' ? 'Halaman Client' : 'Halaman Utama' }}</a>
    <form id="logout-form-client" action="{{ route('logout') }}" method="POST" style="margin: 0;">
        @csrf
        <button type="button" onclick="confirmLogoutClient()"><i class="fa-solid fa-right-from-bracket"></i> Keluar Akun</button>
    </form>
</div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header">
            <h1 class="page-title">Pengaturan Akun</h1>
            <p class="page-sub">Kelola data diri dan kata sandi akun Anda.</p>
        </div>

        <div class="profile-card">
            @if(session('success'))
                <div class="alert-success-custom">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('user.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama Lengkap --}}
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? auth()->user()->name) }}" required>
                    @error('name') <small style="color: #DC2626;">{{ $message }}</small> @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label>Alamat Email <small style="color: #8C8279;">(Sesuai registrasi)</small></label>
                    <input type="email" class="form-control" value="{{ $user->email ?? auth()->user()->email }}" readonly style="background-color: #FAFAFA; color: #8C8279; cursor: not-allowed;">
                </div>

                {{-- No. WhatsApp --}}
                <div class="form-group">
                    <label>No. WhatsApp / Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? auth()->user()->no_hp ?? '') }}" placeholder="Contoh: 081234567890" required>
                    @error('phone') <small style="color: #DC2626;">{{ $message }}</small> @enderror
                </div>

                {{-- Alamat --}}
                <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <textarea name="address" class="form-control" rows="3" placeholder="Masukkan alamat domisili atau alamat acara Anda">{{ old('address', $user->address ?? auth()->user()->alamat ?? '') }}</textarea>
                    @error('address') <small style="color: #DC2626;">{{ $message }}</small> @enderror
                </div>

                <hr style="border: 0; border-top: 1px solid #EFE8DE; margin: 28px 0 20px 0;">

                <h4 style="font-size: 1rem; color: #241A16; margin-bottom: 4px;">Ubah Password</h4>
                <p style="font-size: 0.8rem; color: #8C8279; margin-bottom: 16px;">Biarkan kosong jika tidak ingin mengganti password saat ini.</p>

                {{-- Password Baru --}}
                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
                    @error('password') <small style="color: #DC2626;">{{ $message }}</small> @enderror
                </div>

                {{-- Konfirmasi Password Baru --}}
                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                </div>

                <button type="submit" class="btn-gold-save">
                    <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </main>

</body>
<!-- SweetAlert2 CDN & Script Konfirmasi -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmLogoutClient() {
        Swal.fire({
            title: 'Keluar dari Akun?',
            text: 'Anda harus masuk kembali untuk membuat atau melihat reservasi.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#C58F43',
            cancelButtonColor: '#8C8279',
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form-client').submit();
            }
        });
    }
</script>
</html>
