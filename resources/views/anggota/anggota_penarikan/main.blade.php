@extends('layouts.anggota')

@section('title', 'Penarikan')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl text-center text-white font-semibold pb-6">Data Penarikan</h2>

    {{-- Dummy Alerts --}}
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Sukses!</strong>
        <span class="block sm:inline">Contoh notifikasi berhasil</span>
    </div>

    {{-- Table Container --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="flex flex-wrap justify-between items-center p-4 space-y-2 md:space-y-0">
            {{-- Dummy Date Filter --}}
            <form method="GET" class="flex gap-2">
                <input type="date" class="border rounded px-2 py-1">
                <span class="text-sm self-center">to</span>
                <input type="date" class="border rounded px-2 py-1">
                <button type="submit" class="bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600 transition">
                    <i class="fas fa-print"></i>
                </button>
            </form>

            {{-- Dummy Search --}}
            <form method="GET" class="flex items-center gap-2">
                <input type="search" placeholder="Search" class="border rounded px-3 py-1">
                <button type="submit" class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600 transition">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left text-gray-700">
                <thead class="uppercase text-xs font-semibold text-gray-600 bg-gray-100">
                    <tr>
                        <th class="px-4 py-3">Kode Penarikan</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Nasabah</th>
                        <th class="px-4 py-3">Jumlah Penarikan</th>
                        <th class="px-4 py-3">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @for($i = 1; $i <= 5; $i++)
                        <tr>
                            <td class="px-4 py-2">TRK{{ 1000 + $i }}</td>
                            <td class="px-4 py-2">{{ now()->format('d-m-Y') }}</td>
                            <td class="px-4 py-2">Dummy Nasabah {{ $i }}</td>
                            <td class="px-4 py-2">Rp {{ number_format(500000 + $i * 50000, 2, ',', '.') }}</td>
                            <td class="px-4 py-2">Contoh keterangan</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <div class="p-4 text-sm text-gray-600">
            Menampilkan 5 dari 5 entri (dummy data)
        </div>
    </div>

    <div class="text-center mt-12">
        <a href="{{ route('anggota.penarikan.index') }}" class="inline-block bg-white px-6 py-3 text-sm font-medium text-gray-800 rounded-2xl shadow-sm hover:shadow-md hover:bg-gray-50 transition duration-300">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>
</div>
@endsection
