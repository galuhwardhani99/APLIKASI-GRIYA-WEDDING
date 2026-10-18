<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Griya Rias Elly Jr.')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}">

    <!-- Google Fonts & Font Awesome Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --bg-light: #FDFBF7; 
            --bg-card: #FFFFFF; 
            --gold-primary: #C58F43;
            --gold-hover: #A87632;
            --text-dark: #241A16; 
            --text-muted: #8C8279; 
            --border-color: #EFE8DE;
            --danger-color: #EF4444;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body { 
            background-color: var(--bg-light); 
            color: var(--text-dark); 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            display: flex; 
            min-height: 100vh; 
        }

        /* Styling Kunci Sidebar */
        .sidebar { 
            width: 260px; 
            min-width: 260px; /* Kunci lebar agar tidak menciut/melar */
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
            align-items: center; 
            gap: 12px; 
            padding-bottom: 20px; 
            border-bottom: 1px solid var(--border-color); 
        }

        /* PEMBATASAN UKURAN LOGO (Mencegah Gambar Raksasa) */
        .sidebar-logo-img { 
            width: 42px !important; 
            height: 42px !important; 
            max-width: 42px !important; 
            max-height: 42px !important; 
            object-fit: cover; 
            border-radius: 6px; 
            flex-shrink: 0;
        }

        .brand-text h2 { 
            font-family: 'Playfair Display', serif; 
            color: var(--gold-primary); 
            font-size: 0.67rem; 
            letter-spacing: .2em; 
            line-height: 1.2; 
            margin-bottom: 2px; 
        }

        .brand-title { 
            font-family: 'Playfair Display', serif; 
            font-size: 1.15rem; 
            color: var(--text-dark); 
            font-weight: 700; 
            line-height: 1.1; 
            margin: 0; 
        }

        .brand-sub { 
            font-size: 0.75rem; 
            color: var(--text-muted); 
            margin: 0; 
        }

        .admin-sidebar-user { display:flex; align-items:center; gap:11px; padding:16px 8px; border-bottom:1px solid var(--border-color); }
        .admin-sidebar-avatar { width:40px; height:40px; border-radius:50%; display:grid; place-items:center; background:#f4e6d2; color:#93622d; font-weight:800; flex-shrink: 0; }
        .admin-sidebar-user strong, .admin-sidebar-user small { display:block; }
        .admin-sidebar-user strong { font-size:.86rem; }
        .admin-sidebar-user small { color:var(--text-muted); font-size:.72rem; margin-top:3px; }
        .admin-nav-label { list-style:none; font-size:.65rem; letter-spacing:.12em; font-weight:800; color:#a59a8e; padding:2px 12px 4px; }

        .nav-menu { list-style: none; display: flex; flex-direction: column; gap: 5px; }
        .nav-item { padding: 11px 12px; border-radius: 8px; color: var(--text-dark); text-decoration: none; font-size: 0.88rem; display: flex; align-items: center; gap: 12px; transition: all 0.2s; font-weight: 500; }
        .nav-item i { width: 20px; text-align: center; color: var(--text-muted); }
        .nav-item:hover { background-color: rgba(197, 143, 67, 0.08); color: var(--gold-primary); }
        .nav-item.active { background-color: var(--gold-primary); color: #fff; font-weight: 600; }
        .nav-item.active i { color: #fff; }

        /* Bottom Actions Sidebar */
        .sidebar-footer { margin-top: auto; padding-top: 16px; border-top: 1px solid var(--border-color); display: flex; flex-direction: column; gap: 8px; }
        .btn-sidebar-home { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 8px; color: var(--text-dark); background-color: var(--bg-light); border: 1px solid var(--border-color); text-decoration: none; font-size: 0.88rem; font-weight: 600; transition: all 0.2s ease; }
        .btn-sidebar-home:hover { background-color: rgba(197, 143, 67, 0.12); color: var(--gold-primary); border-color: var(--gold-primary); }
        .btn-sidebar-logout { width: 100%; display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 8px; color: #DC2626; background-color: #FEF2F2; border: 1px solid #FCA5A5; font-size: 0.88rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; font-family: inherit; }
        .btn-sidebar-logout:hover { background-color: #FEE2E2; color: #991B1B; border-color: #F87171; }

        /* Main Content Container */
        .main-content { 
            flex: 1; 
            padding: 40px; 
            overflow-x: hidden; 
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Include Sidebar Terpusat -->
    @include('partials.sidebar') <!-- Sesuaikan dengan nama path file sidebar kamu (misal: 'admin.partials.sidebar' atau 'partials.sidebar') -->

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Script Global SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#C58F43',
                    background: '#FFFFFF',
                    color: '#241A16'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#EF4444',
                    background: '#FFFFFF',
                    color: '#241A16'
                });
            @endif
        });
    </script>

    @stack('scripts')
</body>
</html>