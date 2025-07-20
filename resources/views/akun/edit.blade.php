@extends('backend.app')

@section('title', 'Edit Akun')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Edit Akun</h4>
        </div>

        <form action="{{ route('akun.update', $akun->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Kode Akun</label>
                <input type="text" name="kode_akun" class="form-control" value="{{ old('kode_akun', $akun->kode_akun) }}" required>
                @error('kode_akun')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Akun</label>
                <input type="text" name="nama_akun" class="form-control" value="{{ old('nama_akun', $akun->nama_akun) }}" required>
                @error('nama_akun')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Tipe</label>
                <select name="tipe" class="form-control" required>
                    <option value="Aset" {{ $akun->tipe == 'Aset' ? 'selected' : '' }}>Aset</option>
                    <option value="Liabilitas" {{ $akun->tipe == 'Liabilitas' ? 'selected' : '' }}>Liabilitas</option>
                    <option value="Ekuitas" {{ $akun->tipe == 'Ekuitas' ? 'selected' : '' }}>Ekuitas</option>
                    <option value="Pendapatan" {{ $akun->tipe == 'Pendapatan' ? 'selected' : '' }}>Pendapatan</option>
                    <option value="Beban" {{ $akun->tipe == 'Beban' ? 'selected' : '' }}>Beban</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <input type="text" name="kategori" class="form-control" value="{{ old('kategori', $akun->kategori) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $akun->deskripsi) }}</textarea>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" name="status" class="form-check-input" {{ $akun->status ? 'checked' : '' }}>
                <label class="form-check-label">Aktif</label>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('akun.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
