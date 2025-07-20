<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Neraca</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        h2, h4 {
            text-align: center;
            margin: 0;
            padding: 4px;
        }
        .section {
            margin: 20px 0;
        }
        .label {
            font-weight: bold;
        }
        .box {
            border: 1px solid #ccc;
            padding: 6px;
            margin-bottom: 10px;
        }
        .summary {
            font-weight: bold;
            margin-top: 10px;
        }
        .success {
            background-color: #d4edda;
            padding: 8px;
            border-radius: 4px;
            color: #155724;
            margin-top: 10px;
        }
        .fail {
            background-color: #f8d7da;
            padding: 8px;
            border-radius: 4px;
            color: #721c24;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <h2>KOPERASI MERAH PUTIH</h2>
    <h4>NERACA (BALANCE SHEET)</h4>
    <h4>
        Periode:
        @if ($startDate && $endDate)
            {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s.d. {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
        @else
            Semua Periode
        @endif
    </h4>

    <div class="section">
        <div class="label">ASET</div>
        <div class="box">
            Total Aset: Rp {{ number_format($totalAset, 0, ',', '.') }}
        </div>
    </div>

    <div class="section">
        <div class="label">LIABILITAS</div>
        <div class="box">
            Total Kewajiban: Rp {{ number_format($totalKewajiban, 0, ',', '.') }}
        </div>
    </div>

    <div class="section">
        <div class="label">EKUITAS</div>
        <div class="box">
            Total Modal: Rp {{ number_format($totalModal, 0, ',', '.') }}
        </div>
    </div>

    <div class="section">
        <div class="summary">
            TOTAL LIABILITAS + EKUITAS: Rp {{ number_format($totalPasiva, 0, ',', '.') }}
        </div>

        @if ($totalAset == $totalPasiva)
            <div class="success">
                ✅ Neraca Seimbang.
            </div>
        @else
            <div class="fail">
                ❌ Neraca Tidak Seimbang.
            </div>
        @endif
    </div>

</body>
</html>
