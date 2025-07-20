@extends('backend.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <h4 class="mb-4">Laporan Buku Besar</h4>

    {{-- Filter Form --}}
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label class="form-label">Tipe Akun</label>
            <select name="tipe" class="form-select">
                <option value="">Semua Tipe</option>
                @foreach(['Aset','Kewajiban','Ekuitas','Pendapatan','Beban'] as $type)
                    <option value="{{ $type }}" {{ request('tipe') == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control"
                   value="{{ request('start_date', now()->startOfMonth()->toDateString()) }}">
        </div>

        <div class="col-md-3">
            <label class="form-label">Tanggal Selesai</label>
            <input type="date" name="end_date" class="form-control"
                   value="{{ request('end_date', now()->toDateString()) }}">
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">Tampilkan</button>

            <a href="{{ route('laporan.buku-besar.pdf', request()->only('tipe','start_date','end_date')) }}"
               target="_blank" class="btn btn-danger">Cetak PDF</a>
        </div>
    </form>

    {{-- Loop tiap akun --}}
    @forelse($akuns as $akun)
        @php
            $saldoAwal = optional($akun->saldoAwal->first())->jumlah ?? 0;
            $saldo = $saldoAwal;
        @endphp

        <div class="card mb-4">
            <div class="card-header bg-light">
                <strong>{{ $akun->kode_akun }} - {{ $akun->nama_akun }}</strong>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered mb-0">
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
                        {{-- Saldo Awal --}}
                        <tr>
                            <td colspan="5"><strong>Saldo Awal</strong></td>
                            <td class="text-end">
                                <strong>{{ number_format($saldoAwal, 0, ',', '.') }}</strong>
                            </td>
                        </tr>

                        {{-- Detail Jurnal --}}
                        @forelse($akun->jurnalDetails->sortBy('jurnal.tanggal') as $entry)
                            @php
                                $debit = $entry->debit ?? $entry->jurnal->debit ?? 0;
                                $kredit = $entry->kredit ?? $entry->jurnal->kredit ?? 0;
                                $saldo += $debit - $kredit;
                            @endphp
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($entry->jurnal->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ $entry->jurnal->no_jurnal }}</td>
                                <td>{{ $entry->jurnal->keterangan }}</td>
                                <td class="text-end">{{ number_format($debit, 0, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($kredit, 0, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($saldo, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="alert alert-warning">Tidak ada akun ditemukan untuk tipe ini.</div>
    @endforelse
</div>
@endsection
