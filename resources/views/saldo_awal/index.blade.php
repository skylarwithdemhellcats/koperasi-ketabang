@extends('backend.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Daftar Saldo Awal</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('saldo-awal.create') }}" class="btn btn-primary mb-3">+ Tambah Saldo Awal</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Akun</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($saldoAwal as $item)
                <tr>
                    <td>{{ $item->akun->kode_akun }} - {{ $item->akun->nama_akun }}</td>
                    <td>{{ $item->bulan }}</td>
                    <td>{{ $item->tahun }}</td>
                    <td>Rp {{ number_format($item->jumlah, 2, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('saldo-awal.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('saldo-awal.destroy', $item->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Belum ada data</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
