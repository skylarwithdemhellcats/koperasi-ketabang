@extends('backend.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <h4 class="mb-4">Laporan Perhitungan Hasil Usaha (LPHU)</h4>

    {{-- Filter Form --}}
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
            <a href="{{ route('laporan.lphu') }}" class="btn btn-secondary">Reset</a>
            <a href="{{ route('laporan.lphu.pdf', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
            class="btn btn-success" target="_blank">Cetak PDF</a>
        </div>
    </form>

    {{-- Pendapatan --}}
    <div class="card mb-4">
        <div class="card-header bg-light fw-bold">Pendapatan</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
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
        </div>
    </div>

    {{-- Beban --}}
    <div class="card mb-4">
        <div class="card-header bg-light fw-bold">Beban</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
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
        </div>
    </div>

    {{-- Hasil Usaha --}}
    <div class="card">
        <div class="card-body text-center">
            <h5>Hasil Usaha</h5>
            <h3 class="text-success">{{ number_format($hasilUsaha, 0, ',', '.') }}</h3>
        </div>
    </div>
</div>
@endsection
