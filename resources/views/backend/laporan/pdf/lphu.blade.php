<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>LPHU PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background-color: #eee; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
    </style>
</head>
<body>
    <h3 class="text-center">Laporan Perhitungan Hasil Usaha (LPHU)</h3>
    <p class="text-center">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>

    <h4>Pendapatan</h4>
    <table>
        <thead>
            <tr>
                <th>Kode Akun</th>
                <th>Nama Akun</th>
                <th class="text-end">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendapatan as $akun)
                @php $jumlah = $akun->jurnalDetails->sum('kredit'); @endphp
                <tr>
                    <td>{{ $akun->kode_akun }}</td>
                    <td>{{ $akun->nama_akun }}</td>
                    <td class="text-end">{{ number_format($jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="fw-bold">
                <td colspan="2" class="text-center">Total Pendapatan</td>
                <td class="text-end">{{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <h4>Beban</h4>
    <table>
        <thead>
            <tr>
                <th>Kode Akun</th>
                <th>Nama Akun</th>
                <th class="text-end">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($beban as $akun)
                @php $jumlah = $akun->jurnalDetails->sum('debit'); @endphp
                <tr>
                    <td>{{ $akun->kode_akun }}</td>
                    <td>{{ $akun->nama_akun }}</td>
                    <td class="text-end">{{ number_format($jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="fw-bold">
                <td colspan="2" class="text-center">Total Beban</td>
                <td class="text-end">{{ number_format($totalBeban, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <h4 class="text-center">Hasil Usaha</h4>
    <h2 class="text-center text-success">{{ number_format($hasilUsaha, 0, ',', '.') }}</h2>
</body>
</html>
