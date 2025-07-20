@extends('layouts.anggota')

@section('title', 'Tambah Simpanan')

@section('content')
<div class="max-w-3xl mx-auto mt-10 px-6">
    <h2 class="text-2xl text-center text-white font-bold pb-6">Tambah Simpanan</h2>

    {{-- Dummy Alert for errors (you can remove this later) --}}
    {{-- <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
        Contoh pesan error.
    </div> --}}

    <form method="POST" action="#" enctype="multipart/form-data" class="space-y-6 block p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        @csrf

        <div>
            <label for="kodeTransaksiSimpanan" class="block font-medium text-gray-700">Kode Transaksi</label>
            <input type="text" id="kodeTransaksiSimpanan" name="kodeTransaksiSimpanan" value="SMP-0001" readonly class="w-full mt-1 p-2 border border-gray-300 rounded">
        </div>

        <div>
            <label for="tanggal_simpanan" class="block font-medium text-gray-700">Tanggal Simpanan</label>
            <input type="date" id="tanggal_simpanan" name="tanggal_simpanan" class="w-full mt-1 p-2 border border-gray-300 rounded">
        </div>

        <div>
            <label for="id_anggota" class="block font-medium text-gray-700">Nama Anggota</label>
            <select id="id_anggota" name="id_anggota" class="w-full mt-1 p-2 border border-gray-300 rounded">
                <option disabled selected>Pilih Anggota</option>
                <option value="1">John Doe</option>
                <option value="2">Jane Smith</option>
                <option value="3">Alex Johnson</option>
            </select>
        </div>

        <div>
            <label for="id_jenis_simpanan" class="block font-medium text-gray-700">Jenis Simpanan</label>
            <select id="id_jenis_simpanan" name="id_jenis_simpanan" class="w-full mt-1 p-2 border border-gray-300 rounded">
                <option disabled selected>Pilih Jenis Simpanan</option>
                <option value="1" data-nominal="100000">Simpanan Wajib</option>
                <option value="2" data-nominal="0">Simpanan Sukarela</option>
                <option value="3" data-nominal="250000">Simpanan Pokok</option>
                <option value="4" data-nominal="250000">Simpanan Insidental</option>
            </select>
        </div>

        <div>
            <label for="jml_simpanan" class="block font-medium text-gray-700">Jumlah Simpanan</label>
            <input type="number" id="jml_simpanan" name="jml_simpanan" class="w-full mt-1 p-2 border border-gray-300 rounded">
        </div>

        <div>
            <label for="bukti_pembayaran" class="block font-medium text-gray-700">Bukti Pembayaran</label>
            <input type="file" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/*,application/pdf" class="w-full mt-1 p-2 border border-gray-300 rounded">
        </div>

        <div class="text-center grid grid-cols-2 gap-x-6">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Submit</button>
            <a href="{{ route('anggota.simpanan.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded transition duration-200">Kembali</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenisSelect = document.getElementById('id_jenis_simpanan');
        const jumlahInput = document.getElementById('jml_simpanan');

        jenisSelect.addEventListener('change', function() {
            const selected = jenisSelect.options[jenisSelect.selectedIndex];
            const nominal = selected.getAttribute('data-nominal');
            jumlahInput.value = nominal;
            jumlahInput.readOnly = nominal !== '0';
        });
    });
</script>
@endsection
