<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Anggota - Koperasi Merah Putih</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="font-sans bg-[#f4f4f4] text-[#333] flex flex-col min-h-screen bg-white/50" style="background-image: url('{{ asset('src/bg-ketabang.jpg') }}'); background-size: cover; background-position: center;">
    
    <!-- Header -->
    @include('partials.header')

    <!-- Page Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <script>
        const dropdownToggle = document.getElementById('navbarDropdown');
        const chevronIcon = document.getElementById('chevronIcon');

        dropdownToggle?.addEventListener('click', function () {
            setTimeout(() => {
                const isExpanded = dropdownToggle.getAttribute('aria-expanded') === 'true';
                chevronIcon.style.transform = isExpanded ? 'rotate(180deg)' : 'rotate(0deg)';
            }, 100);
        });
    </script>
    @stack('scripts')
</body>
</html>