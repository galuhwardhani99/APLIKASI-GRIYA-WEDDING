<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Griya Rias Elly Jr.')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}">

    <!-- Google Fonts & Font Awesome Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
            --border-dark: #D8CEC0;
            --danger-color: #EF4444;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body { 
            background-color: var(--bg-light); 
            color: var(--text-dark); 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            display: flex; 
            min-height: 100vh; 
            -webkit-font-smoothing: antialiased;
        }

        /* Container Sidebar Freeze Teratur & Bergaris Tegas */
        .sidebar { 
            width: 260px; 
            min-width: 260px;
            flex: 0 0 260px;
            height: 100vh;
            position: sticky;
            top: 0; 
            background-color: var(--bg-card); 
            border-right: 1px solid var(--border-dark); 
            padding: 24px 16px; 
            display: flex; 
            flex-direction: column; 
            gap: 0;
            box-shadow: 2px 0 12px rgba(36, 26, 22, 0.04); 
            z-index: 99;
            overflow: hidden;
        }

        /* Header Logo & Brand Tajam */
        .sidebar-brand { 
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding-bottom: 20px; 
            border-bottom: 1px solid var(--border-color); 
            padding-left: 8px;
            text-decoration: none;
            border-left: 3px solid var(--gold-primary);
        }

        .brand-text h2 { 
            font-family: 'Playfair Display', serif; 
            color: var(--gold-primary); 
            font-size: 0.67rem; 
            letter-spacing: .25em; 
            line-height: 1.2; 
            margin-bottom: 2px; 
            font-weight: 800;
        }

        .brand-title { 
            font-family: 'Playfair Display', serif; 
            font-size: 1.55rem;
            color: var(--text-dark); 
            font-weight: 700; 
            line-height: 1.1; 
            margin: 0; 
        }

        .brand-sub { 
            font-size: 0.75rem; 
            color: var(--text-muted); 
            margin-top: 2px; 
            font-weight: 600;
        }

        /* Profil Pengguna Sidebar */
        .admin-sidebar-user { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            padding: 14px 12px; 
            margin: 16px 0; 
            background: #FAFAFA; 
            border: 1px solid var(--border-color); 
            border-radius: 10px; 
        }

        .admin-sidebar-avatar { 
            width: 40px; 
            height: 40px; 
            border-radius: 50%; 
            display: grid; 
            place-items: center; 
            background: #F4E6D2; 
            color: #93622D; 
            font-weight: 800; 
            flex-shrink: 0; 
            border: 1px solid #EAD8BF;
        }

        .admin-sidebar-user strong { font-size: .86rem; color: var(--text-dark); }
        .admin-sidebar-user small { color: var(--text-muted); font-size: .72rem; margin-top: 2px; font-weight: 600; }
        
        /* Label Menu & Scrollbar */
        .admin-nav-label { list-style: none; font-size: .65rem; letter-spacing: .15em; font-weight: 800; color: #A59A8E; padding: 10px 12px 4px; }
        .admin-nav-spaced { margin-top: 12px; }

        .sidebar > nav { display: flex; flex: 1; min-height: 0; }
        .nav-menu { list-style: none; display: flex; flex: 1; min-height: 0; flex-direction: column; gap: 4px; overflow-y: auto; padding-right: 4px; }
        .nav-menu::-webkit-scrollbar { width: 4px; }
        .nav-menu::-webkit-scrollbar-thumb { background-color: #EFE8DE; border-radius: 4px; }
        
        .nav-item { 
            padding: 10px 12px; 
            border-radius: 8px; 
            color: #55483F; 
            text-decoration: none; 
            font-size: .86rem; 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            transition: all .2s ease; 
            font-weight: 600; 
        }

        .nav-item i { width: 18px; text-align: center; color: #9B8877; font-size: 1rem; }
        .nav-item:hover { background-color: #FBF5EC; color: var(--gold-hover); }
        .nav-item.active { background-color: var(--gold-primary); color: #FFF; font-weight: 700; box-shadow: 0 4px 10px rgba(197, 143, 67, 0.25); }
        .nav-item.active i { color: #FFF; }

        /* Tombol Aksi Bawah Sidebar */
        .sidebar-footer { margin-top: auto; padding-top: 16px; border-top: 1px solid var(--border-color); display: grid; gap: 8px; }
        
        .btn-sidebar-home { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            padding: 10px 12px; 
            border-radius: 8px; 
            color: #55483F; 
            text-decoration: none; 
            font-size: .86rem; 
            font-weight: 600; 
            border: 1px solid var(--border-color);
            transition: all .2s ease; 
        }

        .btn-sidebar-home i { width: 18px; text-align: center; color: #9B8877; }
        .btn-sidebar-home:hover { background: #FBF5EC; color: var(--gold-hover); border-color: var(--gold-primary); }

        .btn-sidebar-logout { 
            width: 100%; 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            padding: 10px 12px; 
            border-radius: 8px; 
            color: #B33B3B; 
            background: #FFF5F5; 
            border: 1px solid #F1D0D0; 
            font-size: .85rem; 
            font-weight: 700; 
            cursor: pointer; 
            transition: all .2s ease; 
            font-family: inherit; 
        }

        .btn-sidebar-logout:hover { background-color: #FDE8E8; border-color: #E6B2B2; }

        /* Main Content Container Tajam */
        .main-content { 
            flex: 1; 
            padding: 40px; 
            overflow-x: hidden; 
            min-width: 0;
        }

        @media (max-width: 768px) {
            body { display: block; }
            .sidebar { position: relative; width: 100%; min-width: 0; height: auto; min-height: 0; border-right: 0; border-bottom: 1px solid var(--border-dark); }
            .sidebar > nav { flex: none; }
            .nav-menu { max-height: 360px; }
            .main-content { padding: 24px 18px; }
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Include Sidebar Terpusat -->
    @include('partials.sidebar')

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