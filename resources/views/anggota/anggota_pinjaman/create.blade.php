@extends('layouts.anggota')

@section('title', 'Tambah Pinjaman')

@section('content')
<div class="max-w-3xl mx-auto mt-10 px-6">
    <h2 class="text-2xl text-center text-white font-bold pb-6">Tambah Pinjaman</h2>

    <div class="bg-blue-100 text-blue-800 p-4 rounded mb-6 border border-blue-300">
        Jumlah maksimal pinjaman baru adalah <strong>Rp 500.000</strong>.
    </div>

    <form method="POST" action="#" enctype="multipart/form-data" class="space-y-6 block p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        @csrf

        <div>
            <label for="tanggal_pinjam" class="block font-medium text-gray-700">Tanggal Pinjam</label>
            <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}" class="w-full mt-1 p-2 border border-gray-300 rounded @error('tanggal_pinjam') border-red-500 @enderror">
            @error('tanggal_pinjam')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jml_cicilan" class="block font-medium text-gray-700">Lama (bulan)</label>
            <input type="number" id="jml_cicilan" name="jml_cicilan" value="{{ old('jml_cicilan') }}" class="w-full mt-1 p-2 border border-gray-300 rounded @error('jml_cicilan') border-red-500 @enderror">
            @error('jml_cicilan')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jatuh_tempo" class="block font-medium text-gray-700">Jatuh Tempo</label>
            <input type="text" id="jatuh_tempo" name="jatuh_tempo" value="{{ old('jatuh_tempo') }}" readonly class="w-full mt-1 p-2 border border-gray-300 rounded bg-gray-100 @error('jatuh_tempo') border-red-500 @enderror">
            @error('jatuh_tempo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="bunga_pinjam" class="block font-medium text-gray-700">Bunga Pinjam (%)</label>
            <input type="number" id="bunga_pinjam" name="bunga_pinjam" value="{{ old('bunga_pinjam') }}" class="w-full mt-1 p-2 border border-gray-300 rounded @error('bunga_pinjam') border-red-500 @enderror">
            @error('bunga_pinjam')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jml_pinjam" class="block font-medium text-gray-700">Jumlah Pinjam</label>
            <input type="number" id="jml_pinjam" name="jml_pinjam" value="{{ old('jml_pinjam') }}" class="w-full mt-1 p-2 border border-gray-300 rounded @error('jml_pinjam') border-red-500 @enderror">
            @error('jml_pinjam')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="text-center grid grid-cols-2 gap-x-6">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Simpan</button>
            <a href="{{ route('anggota.pinjaman.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded transition duration-200">Kembali</a>
        </div>
    </form>
</div>
@endsection
