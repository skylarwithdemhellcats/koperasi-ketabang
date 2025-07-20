<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Halaman Anggota</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 60px;
        }

        .navbar {
            background-color: #343a40;
        }

        .navbar .nav-link,
        .navbar .navbar-brand {
            color: white;
        }

        .navbar .nav-link:hover {
            color: #ffc107;
        }

        .container {
            max-width: 720px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('anggota.dashboard') }}">Koperasi</a>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('anggota.simpanan.pokok') }}">Simpanan Pokok</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('anggota.simpanan.wajib') }}">Wajib</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('anggota.simpanan.sukarela') }}">Sukarela</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('anggota.simpanan.insidental') }}">Insidental</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('anggota.pinjaman.user') }}">Pinjaman</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('anggota.penarikan.user') }}">Penarikan</a></li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ route('logout') }}"
                           class="nav-link"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                           <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten -->
    <main class="container">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
