<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Buku Besar</title>
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

        td.text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <h3>Laporan Buku Besar</h3>
    <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>

    @foreach($akuns as $akun)
        @php
            $saldoAwal = optional($akun->saldoAwal->first())->jumlah ?? 0;
            $saldo = $saldoAwal;
        @endphp

        @if($akun->jurnalDetails->isNotEmpty() || $saldoAwal != 0)
            <h4>{{ $akun->kode_akun }} - {{ $akun->nama_akun }}</h4>

            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th class="text-left">No Jurnal</th>
                        <th class="text-left">Keterangan</th>
                        <th>Debet</th>
                        <th>Kredit</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Baris Saldo Awal --}}
                    <tr>
                        <td class="text-center">-</td>
                        <td class="text-left">-</td>
                        <td class="text-left"><strong>Saldo Awal</strong></td>
                        <td class="text-right">-</td>
                        <td class="text-right">-</td>
                        <td class="text-right"><strong>{{ number_format($saldoAwal, 0, ',', '.') }}</strong></td>
                    </tr>

                    {{-- Transaksi --}}
                    @foreach($akun->jurnalDetails->sortBy('jurnal.tanggal') as $entry)
                        @php
                            $debit = $entry->debit ?? $entry->debet ?? 0;
                            $kredit = $entry->kredit ?? 0;
                            $saldo += $debit - $kredit;
                        @endphp
                        <tr>
                            <td class="text-center">{{ \Carbon\Carbon::parse($entry->jurnal->tanggal)->format('d/m/Y') }}</td>
                            <td class="text-left">{{ $entry->jurnal->no_jurnal }}</td>
                            <td class="text-left">{{ $entry->jurnal->keterangan }}</td>
                            <td class="text-right">{{ number_format($debit, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($kredit, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($saldo, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach
</body>
</html>
