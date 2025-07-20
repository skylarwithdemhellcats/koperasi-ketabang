@extends('backend.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <h4 class="mb-4">Neraca (Balance Sheet)</h4>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('laporan.neraca.pdf', ['tanggal' => $tanggal]) }}" target="_blank" class="btn btn-danger">
            Cetak PDF
        </a>
        </div>
    </form>

    <div class="card p-3">
        <h5 class="text-center fw-bold mb-3">KOPERASI MERAH PUTIH</h5>
        <p class="text-center">NERACA (BALANCE SHEET)<br>Per Tanggal: {{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}</p>

        {{-- ASETS --}}
        <h6 class="mt-4">ASET</h6>
        <ul class="list-group mb-3">
            @foreach($asetData as $item)
                <li class="list-group-item d-flex justify-content-between">
                    <span>{{ $item['akun']->kode_akun }} - {{ $item['akun']->nama_akun }}</span>
                    <strong>{{ number_format($item['saldo'], 0, ',', '.') }}</strong>
                </li>
            @endforeach
            <li class="list-group-item d-flex justify-content-between fw-bold">
                <span>Total Aset</span>
                <span>{{ number_format($totalAset, 0, ',', '.') }}</span>
            </li>
        </ul>

        {{-- LIABILITAS --}}
        <h6>LIABILITAS</h6>
        <ul class="list-group mb-3">
            @foreach($liabilitasData as $item)
                <li class="list-group-item d-flex justify-content-between">
                    <span>{{ $item['akun']->kode_akun }} - {{ $item['akun']->nama_akun }}</span>
                    <strong>{{ number_format($item['saldo'], 0, ',', '.') }}</strong>
                </li>
            @endforeach
            <li class="list-group-item d-flex justify-content-between fw-bold">
                <span>Total Liabilitas</span>
                <span>{{ number_format($totalLiabilitas, 0, ',', '.') }}</span>
            </li>
        </ul>

        {{-- EKUITAS --}}
        <h6>EKUITAS</h6>
        <ul class="list-group mb-3">
            @foreach($ekuitasData as $item)
                <li class="list-group-item d-flex justify-content-between">
                    <span>{{ $item['akun']->kode_akun }} - {{ $item['akun']->nama_akun }}</span>
                    <strong>{{ number_format($item['saldo'], 0, ',', '.') }}</strong>
                </li>
            @endforeach
            <li class="list-group-item d-flex justify-content-between fw-bold">
                <span>Total Ekuitas</span>
                <span>{{ number_format($totalEkuitas, 0, ',', '.') }}</span>
            </li>
        </ul>

        {{-- TOTAL CHECK --}}
        <h6 class="mt-3">TOTAL LIABILITAS + EKUITAS</h6>
        <p><strong>{{ number_format($totalLiabilitas + $totalEkuitas, 0, ',', '.') }}</strong></p>

        @if($totalAset != ($totalLiabilitas + $totalEkuitas))
            <div class="alert alert-danger">
                <strong>X NERACA TIDAK SEIMBANG</strong><br>
                Total Aset: {{ number_format($totalAset, 0, ',', '.') }}<br>
                Total Liabilitas + Ekuitas: {{ number_format($totalLiabilitas + $totalEkuitas, 0, ',', '.') }}
            </div>
        @else
            <div class="alert alert-success">
                ✅ Neraca Seimbang.
            </div>
        @endif
    </div>
</div>
@endsection
