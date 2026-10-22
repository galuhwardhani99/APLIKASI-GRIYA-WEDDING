<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Akun Pengguna - Admin Griya Rias Elly Jr.</title>
    
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
        body { 
            background-color: var(--bg-light); 
            color: var(--text-dark); 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            display: flex; 
            min-height: 100vh; 
        }
        
        .sidebar { 
            width: 260px; 
            background-color: var(--bg-card); 
            border-right: 1px solid var(--border-color); 
            padding: 24px 16px; 
            display: flex; 
            flex-direction: column; 
            gap: 20px; 
            box-shadow: 2px 0 10px rgba(0,0,0,0.02);
        }
        .sidebar-brand { 
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding-bottom: 20px; 
            border-bottom: 1px solid var(--border-color); 
            padding-left: 12px;
        }
        .sidebar-brand img {
            width: 42px;
            height: 42px;
            object-fit: cover;
            border-radius: 6px;
        }
        .brand-text h2 { 
            font-family: 'Playfair Display', serif; 
            color: var(--gold-primary); 
            font-size: 0.67rem; 
            letter-spacing: .2em;
            line-height: 1.2;
            margin-bottom: 2px;
        }
        .brand-text p { font-size: 0.78rem; color: var(--text-muted); }

        .admin-sidebar-user { display:flex; align-items:center; gap:11px; padding:16px 8px; border-bottom:1px solid var(--border-color); }
        .admin-sidebar-avatar { width:40px; height:40px; border-radius:50%; display:grid; place-items:center; background:#f4e6d2; color:#93622d; font-weight:800; }
        .admin-sidebar-user strong,.admin-sidebar-user small { display:block; }
        .admin-sidebar-user strong { font-size:.86rem; }
        .admin-sidebar-user small { color:var(--text-muted); font-size:.72rem; margin-top:3px; }
        .admin-nav-label { list-style:none; font-size:.65rem; letter-spacing:.12em; font-weight:800; color:#a59a8e; padding:2px 12px 4px; }

        .nav-menu { list-style: none; display: flex; flex-direction: column; gap: 5px; }
        .nav-item { 
            padding: 11px 12px; 
            border-radius: 8px; 
            color: var(--text-dark); 
            text-decoration: none; 
            font-size: 0.88rem; 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            transition: all 0.2s; 
            font-weight: 500;
        }
        .nav-item i { width: 20px; text-align: center; font-size: 1.1rem; color: var(--text-muted); }
        .nav-item:hover { background-color: rgba(197, 143, 67, 0.08); color: var(--gold-primary); }
        .nav-item.active { background-color: var(--gold-primary); color: #fff; font-weight: 600; }
        .nav-item.active i { color: #fff; }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .btn-sidebar-home {
            display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 8px;
            color: var(--text-dark); background-color: var(--bg-light); border: 1px solid var(--border-color);
            text-decoration: none; font-size: 0.88rem; font-weight: 600; transition: all 0.2s ease;
        }
        .btn-sidebar-home:hover { background-color: rgba(197, 143, 67, 0.12); color: var(--gold-primary); border-color: var(--gold-primary); }
        .btn-sidebar-logout {
            width: 100%; display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 8px;
            color: #DC2626; background-color: #FEF2F2; border: 1px solid #FCA5A5; font-size: 0.88rem; font-weight: 600; cursor: pointer; font-family: inherit;
        }
        .btn-sidebar-logout:hover { background-color: #FEE2E2; color: #991B1B; border-color: #F87171; }
        
        .main-content { flex: 1; padding: 40px; max-width: 900px; }
        
        .form-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        }
        .form-header {
            font-family: 'Playfair Display', serif;
            color: var(--text-dark);
            font-size: 1.5rem;
            margin-bottom: 6px;
        }
        .form-subtitle {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 24px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.9rem;
            outline: none;
            font-family: inherit;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            border-color: var(--gold-primary);
        }
        .btn-action {
            background-color: var(--gold-primary);
            color: #FFFFFF;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-action:hover {
            background-color: var(--gold-hover);
        }
        .btn-secondary-custom {
            background-color: #F3F0EC;
            color: var(--text-dark);
            border: 1px solid var(--border-color);
            margin-right: 10px;
        }
        .btn-secondary-custom:hover {
            background-color: #EFE8DE;
        }
    </style>
</head>
<body>

    <!-- Sidebar Admin -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Griya Rias Elly Jr.">
            <div class="brand-text">
                <h2>GRIYA RIAS</h2>
                <p style="font-family:'Playfair Display',serif;font-size:1.25rem;color:#241a16;font-weight:700;">Elly Jr.</p>
                <p>Area Admin</p>
            </div>
        </div>

        <div class="admin-sidebar-user">
            <span class="admin-sidebar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            <div>
                <strong>{{ auth()->user()->name }}</strong>
                <small>Administrator</small>
                <a href="{{ route('admin.users.index') }}" style="display: inline-block; font-size: 0.75rem; color: #C58F43; text-decoration: none; font-weight: 600; margin-top: 3px;">
                    <i class="fa-solid fa-user-gear"></i> Kelola Akun
                </a>
            </div>
        </div>
        
        <nav>
            <ul class="nav-menu">
                <li class="admin-nav-label">MENU UTAMA</li>
                <li><a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-shapes"></i> Dashboard</a></li>
                <li><a href="{{ route('admin.layanan.index') }}" class="nav-item {{ request()->routeIs('admin.layanan.*') ? 'active' : '' }}"><i class="fa-solid fa-scissors"></i> Kelola Layanan</a></li>
                <li><a href="{{ route('admin.paket.index') }}" class="nav-item {{ request()->routeIs('admin.paket.*') ? 'active' : '' }}"><i class="fa-solid fa-box-open"></i> Kelola Paket</a></li>
                <li><a href="{{ route('admin.kategori-paket.index') }}" class="nav-item {{ request()->routeIs('admin.kategori-paket.*') ? 'active' : '' }}"><i class="fa-solid fa-tags"></i> Kategori Paket</a></li>
                <li><a href="{{ route('admin.portofolio.index') }}" class="nav-item {{ request()->routeIs('admin.portofolio.*') ? 'active' : '' }}"><i class="fa-solid fa-images"></i> Galeri Portofolio</a></li>
                
                <li class="admin-nav-label" style="padding-top:14px;">AKTIVITAS</li>
                <li><a href="{{ route('admin.jadwal.index') }}" class="nav-item {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}"><i class="fa-regular fa-calendar"></i> Jadwal Acara</a></li>
                <li><a href="#" class="nav-item"><i class="fa-solid fa-chart-column"></i> Laporan Transaksi</a></li>
            </ul>
        </nav>
        
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

    <!-- Main Content -->
    <main class="main-content">
        <div class="form-card">
            <h1 class="form-header">Edit Data Pengguna</h1>
            <p class="form-subtitle">Perbarui informasi akun client atau administrator sistem.</p>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    @error('name') <small style="color: #DC2626;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Alamat Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    @error('email') <small style="color: #DC2626;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>No. WhatsApp / Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required>
                    @error('phone') <small style="color: #DC2626;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Role / Hak Akses</label>
                    <select name="role" class="form-control" required>
                        <option value="client" {{ $user->role == 'client' ? 'selected' : '' }}>Client</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role') <small style="color: #DC2626;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <textarea name="address" class="form-control" rows="3">{{ old('address', $user->address) }}</textarea>
                    @error('address') <small style="color: #DC2626;">{{ $message }}</small> @enderror
                </div>

                <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 24px 0;">

                <div class="form-group">
                    <label>Password Baru <small style="color: var(--text-muted);">(Opsional, minimal 8 karakter)</small></label>
                    <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                    @error('password') <small style="color: #DC2626;">{{ $message }}</small> @enderror
                </div>

                <div style="display: flex; gap: 10px; margin-top: 28px;">
                    <a href="{{ route('admin.users.index') }}" class="btn-action btn-secondary-custom" style="text-align: center; text-decoration: none;">Batal</a>
                    <button type="submit" class="btn-action"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>