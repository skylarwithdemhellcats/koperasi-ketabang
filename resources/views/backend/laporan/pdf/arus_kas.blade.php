<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Arus Kas</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2, h4 { text-align: center; margin: 0; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        .mb-2 { margin-bottom: 6px; }
        .mb-4 { margin-bottom: 12px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table td, .table th { border: 1px solid #000; padding: 6px; }
        .table th { background: #f2f2f2; }
    </style>
</head>
<body>

    <h2>KOPERASI MERAH PUTIH</h2>
    <h4 class="mb-2">LAPORAN ARUS KAS</h4>
    <p class="text-center mb-4">Tanggal Cetak: {{ $tanggalCetak }}</p>

    <table class="table">
        <tr>
            <th style="width: 70%;">Keterangan</th>
            <th class="text-right">Jumlah (Rp)</th>
        </tr>
        <tr>
            <td class="fw-bold">Kas Masuk</td>
            <td class="text-right">{{ number_format($kasMasuk, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="fw-bold">Kas Keluar</td>
            <td class="text-right">{{ number_format($kasKeluar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="fw-bold">Saldo Kas Akhir</td>
            <td class="text-right fw-bold">
                {{ number_format($saldoKas, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    <br><br><br>
    <div style="text-align: right;">
        <p>Mengetahui,</p>
        <br><br>
        <p>_______________________</p>
    </div>

</body>
</html>
