<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Jurnal Umum</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Jurnal Umum</h2>

    @foreach($jurnals as $jurnal)
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d/m/Y') }}<br>
        <strong>Keterangan:</strong> {{ $jurnal->keterangan }}</p>

        <table>
            <thead>
                <tr>
                    <th>Akun</th>
                    <th>Debit (Rp)</th>
                    <th>Kredit (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jurnal->details as $detail)
                    <tr>
                        <td>{{ $detail->akun->kode_akun }} - {{ $detail->akun->nama_akun }}</td>
                        <td>{{ number_format($detail->debit, 2, ',', '.') }}</td>
                        <td>{{ number_format($detail->kredit, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
    @endforeach
</body>
</html>
