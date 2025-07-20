@extends('layouts.anggota')

@section('title', 'Buat Penarikan')

@section('content')
<div class="max-w-3xl mx-auto mt-10 px-6">
    <h2 class="text-2xl text-center text-white font-bold pb-6">Formulir Penarikan Dana</h2>

    <div class="bg-blue-100 text-blue-800 p-4 rounded mb-6 border border-blue-300 text-center">
        Jumlah saldo anda saat ini adalah <strong><span id="saldoText">0</span></strong>.
    </div>

    <form method="POST" action="{{ route('penarikan.store') }}" enctype="multipart/form-data" class="space-y-6 block p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        @csrf

        {{-- <div>
            <label for="id_anggota" class="block font-medium text-gray-700">Anggota</label>
            <select class="w-full mt-1 p-2 border border-gray-300 rounded @error('id_anggota') border-red-500 @enderror" id="id_anggota" name="id_anggota" required>
                <option value="">Pilih Anggota</option>
                @foreach($anggota as $member)
                    <option value="{{ $member->id }}" data-saldo="{{ $member->saldo }}" {{ old('id_anggota') == $member->id ? 'selected' : '' }}>
                        {{ $member->name }}
                    </option>
                @endforeach
            </select>
            @error('id_anggota')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div> --}}

        <div>
            <label for="tanggal_penarikan" class="block font-medium text-gray-700">Tanggal Penarikan</label>
            <input type="date" id="tanggal_penarikan" name="tanggal_penarikan" value="{{ old('tanggal_penarikan') }}" class="w-full mt-1 p-2 border border-gray-300 rounded @error('tanggal_penarikan') border-red-500 @enderror">
            @error('tanggal_penarikan')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jumlah_penarikan" class="block font-medium text-gray-700">Jumlah Penarikan</label>
            <input type="number" id="jumlah_penarikan" name="jumlah_penarikan" value="{{ old('jumlah_penarikan') }}" class="w-full mt-1 p-2 border border-gray-300 rounded @error('jumlah_penarikan') border-red-500 @enderror">
            @error('jumlah_penarikan')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="keterangan" class="block font-medium text-gray-700">Keterangan</label>
            <textarea id="keterangan" name="keterangan" rows="4" class="w-full mt-1 p-2 border border-gray-300 rounded @error('keterangan') border-red-500 @enderror">{{ old('keterangan') }}</textarea>
            @error('keterangan')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="text-center grid grid-cols-2 gap-x-6">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Simpan</button>
            <a href="{{ route('anggota.penarikan.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded transition duration-200">Kembali</a>
        </div>
    </form>
</div>
@endsection
