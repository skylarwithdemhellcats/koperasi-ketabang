@extends('backend.app')

@section('content')
<div class="container">
    <h4 class="mb-3 d-flex justify-content-between align-items-center">
        Jurnal Umum
        <a href="{{ route('jurnal.create') }}" class="btn btn-success btn-sm me-2">
            + Tambah Jurnal
        </a>
        <a href="{{ route('laporan.jurnal_umum.export_pdf') }}" class="btn btn-danger btn-sm">
            Export PDF
        </a>
    </h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No Jurnal</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Total Debit</th>
                <th>Total Kredit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jurnals as $jurnal)
                <tr>
                    <td>{{ $jurnal->no_jurnal }}</td>
                    <td>{{ $jurnal->tanggal }}</td>
                    <td>{{ $jurnal->keterangan }}</td>
                    <td>Rp {{ number_format($jurnal->details->sum('debit'), 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($jurnal->details->sum('kredit'), 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
