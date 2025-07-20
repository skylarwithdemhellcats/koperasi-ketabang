<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Koperasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #005BAC;
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
        }

        .logo {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .subtitle {
            font-size: 1.1rem;
        }

        .menu-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 25px;
            margin-top: 40px;
        }

        .menu-card {
            background-color: #fff;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            color: #005BAC;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s ease-in-out;
            text-decoration: none;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            text-decoration: none;
        }

        .menu-card i {
            font-size: 2.2rem;
            margin-bottom: 12px;
        }

        .menu-label {
            font-weight: 600;
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="text-center">
            <div class="logo mb-1">Koperasi Merah Putih</div>
            <div class="subtitle">Dashboard Anggota</div>
        </div>

        <div class="menu-container mt-5">
            <a href="{{ route('anggota.simpanan.pokok') }}" class="menu-card">
                <i class="bi bi-wallet2"></i>
                <div class="menu-label">Simpanan</div>
            </a>

            <a href="{{ route('anggota.pinjaman.user') }}" class="menu-card">
                <i class="bi bi-credit-card"></i>
                <div class="menu-label">Pinjaman</div>
            </a>

            <a href="{{ route('anggota.penarikan.user') }}" class="menu-card">
                <i class="bi bi-bank2"></i>
                <div class="menu-label">Penarikan</div>
            </a>
        </div>
    </div>
</body>
</html>
