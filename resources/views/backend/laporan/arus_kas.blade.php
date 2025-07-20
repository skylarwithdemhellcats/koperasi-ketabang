@extends('backend.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <h4 class="mb-4">Laporan Arus Kas</h4>

    {{-- Filter Tanggal --}}
    <form method="GET" action="{{ route('laporan.arus_kas') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="start_date" class="form-label">Dari Tanggal</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
        </div>
        <div class="col-md-3">
            <label for="end_date" class="form-label">Sampai Tanggal</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
        </div>
        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary">Tampilkan</button>
        </div>
        <div class="col-md-3 align-self-end">
            <a href="{{ route('laporan.arus-kas.pdf', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> Cetak PDF
            </a>
        </div>
    </form>

    <div class="row">
        <!-- Kas Masuk -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header fw-bold">Kas Masuk</div>
                <div class="card-body">
                    <h5 class="text-success fw-bold">Rp {{ number_format($kasMasuk, 0, ',', '.') }}</h5>
                </div>
            </div>
        </div>

        <!-- Kas Keluar -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header fw-bold">Kas Keluar</div>
                <div class="card-body">
                    <h5 class="text-danger fw-bold">Rp {{ number_format($kasKeluar, 0, ',', '.') }}</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Saldo Kas -->
    <div class="card">
        <div class="card-body">
            @php $saldoKas = $kasMasuk - $kasKeluar; @endphp
            <h5 class="fw-bold">
                Saldo Kas Akhir:
                <span class="{{ $saldoKas < 0 ? 'text-danger' : 'text-success' }}">
                    Rp {{ number_format($saldoKas, 0, ',', '.') }}
                </span>
            </h5>
        </div>
    </div>
</div>
@endsection
