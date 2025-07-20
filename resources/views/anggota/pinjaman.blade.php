@extends('layouts.nasabah')

@section('content')
<div class="container">
    <h2 class="mb-4">Form Pengajuan Pinjaman</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('anggota.pinjaman.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah Pinjaman</label>
            <input type="number" name="jumlah" class="form-control" placeholder="Masukkan jumlah pinjaman" required>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Pengajuan</label>
            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label for="tenor" class="form-label">Tenor (bulan)</label>
            <input type="number" name="tenor" class="form-control" placeholder="Masukkan tenor pinjaman (dalam bulan)" required>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
            <textarea name="keterangan" class="form-control" rows="3" placeholder="Tujuan atau catatan pinjaman"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Ajukan Pinjaman</button>
    </form>
</div>
@endsection
