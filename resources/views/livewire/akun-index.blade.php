<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Daftar Akun</h4>
        <div>
            <a href="{{ route('akun.create') }}" class="btn btn-success">
                <i class="fa fa-plus me-1"></i> Tambah Akun
            </a>
            <button wire:click="exportExcel" class="btn btn-outline-success">
                <i class="fa fa-file-excel me-1"></i> Export Excel
            </button>
        </div>
    </div>

    {{-- Filter --}}
    <div class="mb-3">
        <input type="text" class="form-control" placeholder="Cari nama akun..." wire:model.debounce.300ms="search">
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover m-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($akunList as $akun)
                        <tr>
                            <td>{{ $akun->kode }}</td>
                            <td>{{ $akun->nama }}</td>
                            <td>
                                @php
                                    $tipeColor = match($akun->tipe) {
                                        'Aset' => 'primary',
                                        'Liabilitas' => 'danger',
                                        'Ekuitas' => 'success',
                                        'Pendapatan' => 'info',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $tipeColor }}">
                                    {{ $akun->tipe }}
                                </span>
                            </td>
                            <td>{{ $akun->kategori ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $akun->status == 'Aktif' ? 'success' : 'secondary' }}">
                                    {{ $akun->status }}
                                </span>
                            </td>
                            <td>{{ $akun->deskripsi ?? '-' }}</td>
                            <td>
                                <a href="{{ route('akun.edit', $akun->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button wire:click="delete({{ $akun->id }})" class="btn btn-sm btn-danger"
                                    onclick="confirm('Yakin hapus akun ini?') || event.stopImmediatePropagation()">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Data tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 p-2">
                {{ $akunList->links() }}
            </div>
        </div>
    </div>
</div>
