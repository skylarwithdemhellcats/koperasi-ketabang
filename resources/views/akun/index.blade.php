@extends('backend.app') {{-- Gunakan layout backend agar sidebar muncul --}}

@section('title', 'Daftar Akun')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Daftar Akun</h4>
            <a href="{{ route('akun.create') }}" class="btn btn-success">+ Tambah Akun</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode Akun</th>
                        <th>Nama Akun</th>
                        <th>Tipe</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accounts as $a)
                    <tr>
                        <td>{{ $a->kode_akun }}</td>
                        <td>{{ $a->nama_akun }}</td>
                        <td>{{ $a->tipe }}</td>
                        <td>{{ $a->kategori }}</td>
                        <td>
                            <span class="badge bg-{{ $a->status ? 'success' : 'secondary' }}">
                                {{ $a->status ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>{{ $a->deskripsi }}</td>
                        <td>
                            <a href="{{ route('akun.edit', $a->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('akun.destroy', $a->id) }}" method="POST" style="display:inline-block">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus akun ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
