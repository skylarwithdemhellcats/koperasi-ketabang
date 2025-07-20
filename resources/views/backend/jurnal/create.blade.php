@extends('backend.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <h4 class="mb-4">Buat Jurnal Umum Baru</h4>

    <form action="{{ route('jurnal.store') }}" method="POST">
        @csrf
        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Masukkan keterangan transaksi..." required></textarea>
                </div>

                <hr>
                <h5 class="mb-3">Detail Jurnal</h5>

                <table class="table table-bordered" id="jurnal-table">
                    <thead class="table-light">
                        <tr>
                            <th>Akun</th>
                            <th>Debet (Rp)</th>
                            <th>Kredit (Rp)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="jurnal-body">
                        <tr>
                            <td>
                                <select name="akun_id[]" class="form-select" required>
                                    <option value="">-- Pilih Akun --</option>
                                    @foreach($akuns as $akun)
                                        <option value="{{ $akun->id }}">{{ $akun->kode }} - {{ $akun->nama_akun }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" name="debit[]" class="form-control debit-input" value="0" required></td>
                            <td><input type="number" name="kredit[]" class="form-control kredit-input" value="0" required></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <button type="button" class="btn btn-primary btn-sm" id="add-row">+ Tambah Baris</button>

                <hr>
                <div class="d-flex justify-content-between fw-bold">
                    <div>Total</div>
                    <div>
                        Debet: Rp <span id="total-debit">0</span> &nbsp; | &nbsp;
                        Kredit: Rp <span id="total-kredit">0</span> &nbsp;
                        <span id="balance-status" class="ms-3 badge bg-danger">Belum Balance</span>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-success w-100">Simpan Jurnal</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function updateTotals() {
        let totalDebit = 0;
        let totalKredit = 0;

        document.querySelectorAll('.debit-input').forEach(input => {
            totalDebit += parseFloat(input.value) || 0;
        });
        document.querySelectorAll('.kredit-input').forEach(input => {
            totalKredit += parseFloat(input.value) || 0;
        });

        document.getElementById('total-debit').innerText = totalDebit.toLocaleString();
        document.getElementById('total-kredit').innerText = totalKredit.toLocaleString();

        const balanceStatus = document.getElementById('balance-status');
        if (totalDebit === totalKredit) {
            balanceStatus.classList.remove('bg-danger');
            balanceStatus.classList.add('bg-success');
            balanceStatus.innerText = 'Balance';
        } else {
            balanceStatus.classList.remove('bg-success');
            balanceStatus.classList.add('bg-danger');
            balanceStatus.innerText = 'Belum Balance';
        }
    }

    document.getElementById('add-row').addEventListener('click', () => {
        const row = document.querySelector('#jurnal-body tr').cloneNode(true);
        row.querySelectorAll('input').forEach(input => input.value = 0);
        row.querySelector('select').value = '';
        document.getElementById('jurnal-body').appendChild(row);
        updateTotals();
    });

    document.getElementById('jurnal-body').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            if (document.querySelectorAll('#jurnal-body tr').length > 1) {
                e.target.closest('tr').remove();
                updateTotals();
            }
        }
    });

    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('debit-input') || e.target.classList.contains('kredit-input')) {
            updateTotals();
        }
    });

    updateTotals();
</script>
@endsection
