@extends('backend.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Edit Saldo Awal</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('saldo-awal.update', $saldo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="akun_id">Akun</label>
            <select name="akun_id" id="akun_id" class="form-control" required>
                @foreach($akun as $a)
                    <option value="{{ $a->id }}" {{ $a->id == $saldo->akun_id ? 'selected' : '' }}>
                        {{ $a->kode_akun }} - {{ $a->nama_akun }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Bulan</label>
            <input type="number" name="bulan" class="form-control" min="1" max="12" value="{{ $saldo->bulan }}" required>
        </div>

        <div class="mb-3">
            <label>Tahun</label>
            <input type="number" name="tahun" class="form-control" min="2000" value="{{ $saldo->tahun }}" required>
        </div>

        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" step="0.01" value="{{ $saldo->jumlah }}" required>
        </div>

        <button class="btn btn-primary">Perbarui</button>
        <a href="{{ route('saldo-awal.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
