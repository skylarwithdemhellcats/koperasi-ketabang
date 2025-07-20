<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Neraca Saldo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
        }

        th {
            background-color: #eee;
            text-align: center;
        }

        td.text-left {
            text-align: left;
        }

        td.text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <h3>Laporan Neraca Saldo</h3>
    <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Kode Akun</th>
                <th class="text-left">Nama Akun</th>
                <th>Debet</th>
                <th>Kredit</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalDebet = 0;
                $totalKredit = 0;
            @endphp

            @foreach($data as $item)
                @php
                    $debet = $item['debit'];
                    $kredit = $item['kredit'];
                    $totalDebet += $debet;
                    $totalKredit += $kredit;
                @endphp
                <tr>
                    <td>{{ $item['akun']->kode_akun }}</td>
                    <td class="text-left">{{ $item['akun']->nama_akun }}</td>
                    <td class="text-right">{{ number_format($debet, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($kredit, 0, ',', '.') }}</td>
                </tr>
            @endforeach

        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" class="text-right">Total</th>
                <th class="text-right">{{ number_format($totalDebet, 0, ',', '.') }}</th>
                <th class="text-right">{{ number_format($totalKredit, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
