@extends('backend.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <h4 class="mb-4">Laporan Buku Besar</h4>

    {{-- Filter Form --}}
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-2">
            <label class="form-label">Tipe Akun</label>
            <select name="tipe" class="form-select">
                <option value="">Semua Tipe</option>
                @foreach(['Aset','Kewajiban','Ekuitas','Pendapatan','Beban'] as $type)
                    <option value="{{ $type }}" {{ request('tipe') == $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="akun_id" class="form-label">Pilih Akun</label>
            <select name="akun_id" class="form-select" required>
                <option value="">-- Pilih Akun --</option>
                @foreach($allAccounts as $acc)
                    <option value="{{ $acc->id }}" {{ request('akun_id') == $acc->id ? 'selected' : '' }}>
                        {{ $acc->kode_akun }} - {{ $acc->nama_akun }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label for="start_date" class="form-label">Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control" value="{{ request('start_date', \Carbon\Carbon::now()->startOfMonth()->toDateString()) }}">
        </div>

        <div class="col-md-2">
            <label for="end_date" class="form-label">Tanggal Selesai</label>
            <input type="date" name="end_date" class="form-control" value="{{ request('end_date', \Carbon\Carbon::now()->toDateString()) }}">
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">Tampilkan</button>
            <a href="{{ route('laporan.buku_besar') }}" class="btn btn-secondary me-2">Reset</a>
            @if(isset($akun))
                <a href="{{ route('laporan.buku_besar.pdf', request()->all()) }}" class="btn btn-danger">Export PDF</a>
            @endif
        </div>
    </form>

    {{-- Tampilkan laporan hanya jika akun dipilih --}}
    @if(isset($akun))
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="mb-2">Akun: {{ $akun->kode_akun }} - {{ $akun->nama_akun }}</h5>
                <p class="mb-0">Periode: {{ \Carbon\Carbon::parse(request('start_date', now()->startOfMonth()))->format('d/m/Y') }} - {{ \Carbon\Carbon::parse(request('end_date', now()))->format('d/m/Y') }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>No. Jurnal</th>
                            <th>Keterangan</th>
                            <th>Debet</th>
                            <th>Kredit</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $saldo = 0; @endphp
                        @foreach($entries->sortBy('jurnal.tanggal') as $entry)
                            @php
                                $saldo += $entry->debit - $entry->kredit;
                            @endphp
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($entry->jurnal->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ $entry->jurnal->no_jurnal }}</td>
                                <td>{{ $entry->jurnal->keterangan }}</td>
                                <td class="text-end">{{ number_format($entry->debit, 0, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($entry->kredit, 0, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($saldo, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach

                        @if($entries->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data transaksi.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            Silakan pilih akun dan periode terlebih dahulu untuk melihat Buku Besar.
        </div>
    @endif
</div>
@endsection
