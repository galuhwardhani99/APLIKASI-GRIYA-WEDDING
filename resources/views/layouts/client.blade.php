<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Area Client - Griya Rias Elly Jr.')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}">

    <!-- Google Fonts & Font Awesome Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS SweetAlert2 & Fancybox -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

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

        html {
            scroll-behavior: smooth;
            overflow-y: scroll; /* Konsisten menampilkan scrollbar di semua halaman & level zoom */
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-dark);
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex;
            min-height: 100vh;
            overflow-x: clip; /* Menggunakan clip agar sticky sidebar tidak rusak */
            -webkit-font-smoothing: antialiased;
        }

        body.modal-open {
            overflow: hidden !important;
        }

        .swal2-container { z-index: 10000 !important; }

        /* SIDEBAR CLIENT STICKY & RESPONSIF ZOOM */
        /* STYLING BAWAAN LARAVEL PAGINATION (TANPA TAILWIND) */
        .history-pagination nav,
        .pager nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            width: 100%;
            background: #FFFFFF;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 14px 20px;
            margin-top: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        }

        /* Sembunyikan navigasi mobile bawaan Laravel yang bertumpuk */
        .history-pagination nav > div:first-child,
        .pager nav > div:first-child {
            display: none !important;
        }

        .history-pagination nav > div:last-child,
        .pager nav > div:last-child {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            width: 100%;
        }

        /* Teks "Showing 1 to 10 of 11 results" */
        .history-pagination nav p,
        .pager nav p {
            margin: 0;
            font-size: 0.84rem;
            color: var(--text-muted);
            font-weight: 500;
        }
        .history-pagination nav p span,
        .pager nav p span {
            font-weight: 700;
            color: var(--text-dark);
        }

        /* Container tombol nomor halaman & panah */
        .history-pagination nav > div:last-child > div:last-child,
        .pager nav > div:last-child > div:last-child {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Reset dan rapikan semua tombol & link nomor halaman */
        .history-pagination nav a,
        .history-pagination nav span[aria-current="page"] > span,
        .history-pagination nav span[aria-disabled="true"] > span,
        .pager nav a,
        .pager nav span[aria-current="page"] > span,
        .pager nav span[aria-disabled="true"] > span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 12px;
            border-radius: 8px;
            border: 1px solid var(--border-dark);
            background-color: #FFFFFF;
            color: var(--text-dark);
            font-size: 0.85rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        /* Hover pada tombol aktif/klikable */
        .history-pagination nav a:hover,
        .pager nav a:hover {
            background-color: #FBF5EC;
            border-color: var(--gold-primary);
            color: var(--gold-hover);
        }

        /* Halaman yang sedang aktif */
        .history-pagination nav span[aria-current="page"] > span,
        .pager nav span[aria-current="page"] > span {
            background-color: var(--gold-primary);
            border-color: var(--gold-primary);
            color: #FFFFFF;
            box-shadow: 0 2px 6px rgba(197, 143, 67, 0.25);
        }

        /* Tombol disabled (Previous/Next saat di ujung) */
        .history-pagination nav span[aria-disabled="true"] > span,
        .pager nav span[aria-disabled="true"] > span {
            opacity: 0.45;
            cursor: not-allowed;
            background-color: #F5F3F0;
        }

        /* Kecilkan ikon SVG panah kiri & kanan agar proporsional */
        .history-pagination nav svg,
        .pager nav svg {
            width: 16px !important;
            height: 16px !important;
            display: block;
        }

        .client-sidebar {
            width: 260px;
            min-width: 260px;
            flex: 0 0 260px;
            height: 100vh;
            position: sticky;
            top: 0;
            align-self: flex-start;
            background-color: var(--bg-card);
            border-right: 1px solid var(--border-dark);
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            z-index: 99;
            overflow: hidden;
            box-shadow: 2px 0 12px rgba(36, 26, 22, 0.04);
        }

        .client-sidebar-brand {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding-bottom: 18px;
            padding-left: 10px;
            border-bottom: 1px solid var(--border-color);
            border-left: 3px solid var(--gold-primary);
            text-decoration: none;
            flex-shrink: 0;
        }
        .client-sidebar-brand span {
            font-family: 'Playfair Display', serif;
            font-size: 0.67rem;
            letter-spacing: 0.25em;
            color: var(--gold-primary);
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .client-sidebar-brand strong {
            font-family: 'Playfair Display', serif;
            color: var(--text-dark);
            font-size: 1.55rem;
            font-weight: 700;
            line-height: 1.1;
        }
        .client-sidebar-brand small {
            color: var(--text-muted);
            font-size: 0.75rem;
            margin-top: 2px;
            font-weight: 600;
        }

        .client-sidebar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 10px;
            margin: 14px 0;
            background: #FAFAFA;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            flex-shrink: 0;
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
        .client-sidebar-user strong {
            font-size: 0.86rem;
            color: var(--text-dark);
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .client-sidebar-user small {
            font-size: 0.72rem;
            color: var(--text-muted);
            display: block;
            margin-top: 2px;
            font-weight: 600;
        }

        .client-sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex: 1 1 auto;
            min-height: 0;
            overflow-y: auto;
            padding-right: 4px;
            scrollbar-width: thin;
            scrollbar-color: #EFE8DE transparent;
            overscroll-behavior: contain;
        }
        .client-sidebar-nav::-webkit-scrollbar { width: 4px; }
        .client-sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .client-sidebar-nav::-webkit-scrollbar-thumb { background-color: #EFE8DE; border-radius: 4px; }

        .client-nav-label {
            font-size: 0.65rem;
            letter-spacing: 0.12em;
            font-weight: 800;
            color: #A59A8E;
            padding: 8px 12px 4px;
        }

        .client-sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #55483F;
            font-size: 0.86rem;
            font-weight: 600;
            padding: 10px 12px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .client-sidebar-nav a i {
            width: 18px;
            text-align: center;
            color: #9B8877;
            font-size: 0.98rem;
        }
        .client-sidebar-nav a:hover {
            background: #FBF5EC;
            color: var(--gold-hover);
        }
        .client-sidebar-nav a.active {
            background: var(--gold-primary);
            color: #FFFFFF;
            box-shadow: 0 4px 10px rgba(197, 143, 67, 0.25);
        }
        .client-sidebar-nav a.active i {
            color: #FFFFFF;
        }

        .badge-client-notif {
            background-color: #16A34A;
            color: #FFFFFF;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 9999px;
            margin-left: auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 20px;
            height: 20px;
            box-shadow: 0 2px 5px rgba(22, 163, 74, 0.3);
        }
        .client-sidebar-nav a.active .badge-client-notif {
            background-color: #FFFFFF;
            color: #C58F43;
            box-shadow: none;
        }

        .client-sidebar-footer {
            margin-top: auto;
            padding-top: 14px;
            border-top: 1px solid var(--border-color);
            display: grid;
            gap: 7px;
            flex-shrink: 0;
        }
        .client-sidebar-footer > a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 8px;
            color: #55483F;
            text-decoration: none;
            font-size: 0.86rem;
            font-weight: 600;
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }
        .client-sidebar-footer > a i { width: 18px; text-align: center; color: #9B8877; }
        .client-sidebar-footer > a:hover { background: #FBF5EC; color: var(--gold-hover); }

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
            font: 600 0.85rem 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .client-sidebar-footer button:hover {
            background: #FEE2E2;
            color: #991B1B;
            border-color: #F87171;
        }

        /* MAIN CONTENT AREA KONSISTEN */
        .client-main-content {
            flex: 1;
            min-width: 0;
            padding: 36px 40px;
            background-color: var(--bg-light);
        }

        /* GLOBAL PAGINATION CLIENT */
        /* PAGINATION KONSISTEN DENGAN ADMIN */
        .pagination-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            padding: 16px 20px;
            border-top: 1px solid #F0EBE6;
            background: #FFFFFF;
        }
        .pagination-info {
            font-size: 0.84rem;
            color: var(--text-muted);
            font-weight: 500;
        }
        .pagination-info strong {
            color: var(--text-dark);
            font-weight: 700;
        }
        .pagination-links {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .page-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-width: 34px;
            height: 34px;
            padding: 0 12px;
            border-radius: 8px;
            border: 1px solid var(--border-dark);
            background: #FFFFFF;
            color: var(--text-dark);
            font-size: 0.82rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .page-btn:hover:not(.disabled):not(.active) {
            background: #FBF5EC;
            border-color: var(--gold-primary);
            color: var(--gold-hover);
        }
        .page-btn.active {
            background: var(--gold-primary);
            border-color: var(--gold-primary);
            color: #FFFFFF;
            box-shadow: 0 2px 6px rgba(197, 143, 67, 0.25);
        }
        .page-btn.disabled {
            opacity: 0.45;
            cursor: not-allowed;
            background: #F5F3F0;
        }

        @media (max-width: 768px) {
            body { display: block; }
            .client-sidebar {
                position: relative;
                width: 100%;
                min-width: 0;
                height: auto;
                border-right: 0;
                border-bottom: 1px solid var(--border-dark);
            }
            .client-sidebar-nav { max-height: 300px; }
            .client-main-content { padding: 24px 18px; }
        }
    </style>

    @stack('styles')
</head>
<body>

    @include('partials.client-sidebar')

    <main class="client-main-content">
        @yield('content')
    </main>

    <!-- Scripts Global -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        function confirmLogoutClient() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Keluar dari Akun?',
                    text: 'Anda harus masuk kembali untuk membuat atau melihat reservasi.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#C58F43',
                    cancelButtonColor: '#8C8279',
                    confirmButtonText: 'Ya, Keluar',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    background: '#FFFFFF',
                    color: '#241A16'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('logout-form-client').submit();
                    }
                });
            } else if (confirm('Apakah Anda yakin ingin keluar dari akun?')) {
                document.getElementById('logout-form-client').submit();
            }
        }

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

            if (typeof Fancybox !== 'undefined') {
                Fancybox.bind('[data-fancybox]', {
                    compact: false,
                    idle: false,
                    animated: true,
                    showClass: "f-fadeIn",
                    hideClass: "f-fadeOut",
                    Images: { zoom: true },
                    Toolbar: {
                        display: {
                            left: ["infobar"],
                            middle: ["zoomIn", "zoomOut", "toggle1to1", "rotateCCW", "rotateCW"],
                            right: ["slideshow", "fullscreen", "close"],
                        },
                    },
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>