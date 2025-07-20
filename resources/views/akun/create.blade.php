@extends('backend.app')

@section('content')
<div class="container">
    <h4>Tambah Akun</h4>

    <form action="{{ route('akun.store') }}" method="POST">
        @csrf

        {{-- Nama Akun --}}
        <div class="mb-3">
            <label>Nama Akun</label>
            <input type="text" name="nama_akun" class="form-control" required>
        </div>

        {{-- Tipe --}}
        <div class="mb-3">
            <label>Tipe</label>
            <select name="tipe" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="Debit">Debit</option>
                <option value="Kredit">Kredit</option>
            </select>
        </div>

        {{-- Kategori (untuk menentukan prefix kode akun) --}}
        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori" class="form-control" required>
                <option value="">-- Pilih Kategori Akun --</option>
                <option value="Aset">Aset</option>
                <option value="Liabilitas">Liabilitas</option>
                <option value="Ekuitas">Ekuitas</option>
                <option value="Pendapatan">Pendapatan</option>
                <option value="Beban">Beban</option>
            </select>
        </div>

        {{-- Deskripsi --}}
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control"></textarea>
        </div>

        {{-- Status --}}
        <div class="form-check mb-3">
            <input type="checkbox" name="status" class="form-check-input" checked>
            <label class="form-check-label">Aktif</label>
        </div>

        {{-- Tombol --}}
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('akun.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
