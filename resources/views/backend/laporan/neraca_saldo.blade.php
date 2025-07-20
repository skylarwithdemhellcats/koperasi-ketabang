@extends('backend.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <h4 class="mb-4">Laporan Neraca Saldo</h4>

    {{-- Filter Tanggal --}}
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Tanggal Selesai</label>
            <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">Tampilkan</button>
            <a href="{{ route('laporan.neraca_saldo') }}" class="btn btn-secondary me-2">Reset</a>

            {{-- Tombol Cetak PDF --}}
            <a href="{{ route('laporan.neraca_saldo.pdf', ['startDate' => $startDate, 'endDate' => $endDate]) }}"
               target="_blank" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Cetak PDF
            </a>
        </div>
    </form>

    {{-- Tabel --}}
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Kode Akun</th>
                        <th>Nama Akun</th>
                        <th>Debet</th>
                        <th>Kredit</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalDebit = 0; $totalKredit = 0; @endphp
                    @foreach($data as $row)
                        @php
                            $totalDebit += $row['debit'];
                            $totalKredit += $row['kredit'];
                        @endphp
                        <tr>
                            <td>{{ $row['akun']->kode_akun }}</td>
                            <td>{{ $row['akun']->nama_akun }}</td>
                            <td class="text-end">{{ number_format($row['debit'], 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($row['kredit'], 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($row['saldo'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr class="fw-bold">
                        <td colspan="2" class="text-center">Total</td>
                        <td class="text-end">{{ number_format($totalDebit, 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($totalKredit, 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($totalDebit - $totalKredit, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
