@extends('layouts.nasabah')

@section('content')
<div class="container">
    <h2 class="mb-4">Form Pengajuan Penarikan Simpanan</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('anggota.penarikan.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="jenis_simpanan" class="form-label">Jenis Simpanan</label>
            <select name="jenis_simpanan" class="form-control" required>
                <option value="">-- Pilih Jenis Simpanan --</option>
                <option value="sukarela">Simpanan Sukarela</option>
                <option value="insidental">Simpanan Insidental</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah Penarikan</label>
            <input type="number" name="jumlah" class="form-control" placeholder="Masukkan jumlah penarikan" required>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Penarikan</label>
            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label for="alasan" class="form-label">Alasan Penarikan</label>
            <textarea name="alasan" class="form-control" rows="3" placeholder="Tuliskan alasan penarikan" required></textarea>
        </div>

        <button type="submit" class="btn btn-danger">Ajukan Penarikan</button>
    </form>
</div>
@endsection
