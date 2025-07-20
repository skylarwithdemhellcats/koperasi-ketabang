@extends('backend.app')

@section('content')
<div class="container mx-auto py-4">
    <h4 class="mb-1 font-semibold">Tambah Saldo Awal</h4>
    <p class="text-muted mb-4">Set saldo awal untuk akun</p>

    <a href="{{ route('saldo-awal.index') }}" class="btn btn-outline-secondary mb-3">&larr; Kembali ke Daftar</a>

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white d-flex align-items-center">
            <i class="fa fa-wallet me-2"></i>
            <strong>Form Saldo Awal</strong>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('saldo-awal.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="akun_id" class="form-label">Pilih Akun <span class="text-danger">*</span></label>
                        <select name="akun_id" id="akun_id" class="form-select" required>
                            <option value="">-- Pilih Akun --</option>
                            @foreach($accounts as $a)
                                <option value="{{ $a->id }}">{{ $a->kode_akun }} - {{ $a->nama_akun }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="bulan" class="form-label">Bulan <span class="text-danger">*</span></label>
                        <input type="month" name="bulan" id="bulan" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="jumlah" class="form-label">Saldo Awal <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" min="0" required>
                    </div>
                </div>

                <div class="alert alert-warning">
                    <strong>Tips Saldo Awal:</strong>
                    <ul class="mb-0">
                        <li>Saldo awal adalah posisi saldo akun di awal periode</li>
                        <li>Untuk akun <strong>Aset</strong> dan <strong>Beban</strong>: saldo normal di <em>Debit</em></li>
                        <li>Untuk akun <strong>Liabilitas</strong>, <strong>Ekuitas</strong>, dan <strong>Pendapatan</strong>: saldo normal di <em>Kredit</em></li>
                        <li>Masukkan nilai absolut (tanpa tanda minus)</li>
                    </ul>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i> Simpan Saldo Awal
                    </button>
                    <a href="{{ route('saldo-awal.index') }}" class="btn btn-secondary">
                        <i class="fa fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
