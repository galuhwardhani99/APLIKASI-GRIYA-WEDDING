<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Griya Rias Elly Jr.')</title>
    
    <!-- Favicon Utama (Berlaku untuk semua view yang meluas dari layout ini) -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}">

    <!-- CSS & Fonts Global -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
</head>
<body>

    <!-- Sidebar Admin -->
    @include('admin.partials.sidebar')

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>