@extends('layouts.anggota')

@section('title', 'Simpanan')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl text-center text-white font-semibold text-gray-800 pb-6">Data Simpanan</h2>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="flex flex-wrap justify-between items-center p-4 space-y-2 md:space-y-0">
            <form class="flex gap-2">
                <input type="date" name="start_date" class="border rounded px-2 py-1" value="">
                <span class="text-sm self-center">To</span>
                <input type="date" name="end_date" class="border rounded px-2 py-1" value="">
                <a href="#" class="bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600 transition"><i class="fas fa-print"></i></a>
            </form>

            <form class="flex items-center gap-2">
                <input type="search" name="search" class="border rounded px-3 py-1" placeholder="Search" value="">
                <button type="submit" class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600 transition">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left text-gray-700">
                <thead class="uppercase text-xs font-semibold text-gray-600">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Kode Transaksi</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Transaksi</th>
                        <th class="px-4 py-3">Jenis Simpanan</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="px-4 py-2">1</td>
                        <td class="px-4 py-2">SMP-0001</td>
                        <td class="px-4 py-2">2025-07-20</td>
                        <td class="px-4 py-2">Rp 1.000.000,00</td>
                        <td class="px-4 py-2">Simpanan Pokok</td>
                        <td class="px-4 py-2 flex gap-2">
                            <a href="{{ route('simpanan.show') }}" class="text-blue-500 hover:text-blue-700" title="Show"><i class="fas fa-eye"></i></a>
                            {{-- <a href="{{ route('simpanan.show', $tabungan->simpanan_id) }}" class="text-blue-500 hover:text-blue-700" title="Show"><i class="fas fa-eye"></i></a> --}}
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2">2</td>
                        <td class="px-4 py-2">SMP-0002</td>
                        <td class="px-4 py-2">2025-07-18</td>
                        <td class="px-4 py-2">Rp 500.000,00</td>
                        <td class="px-4 py-2">Simpanan Wajib</td>
                        <td class="px-4 py-2 flex gap-2">
                            <a href="#" class="text-blue-500 hover:text-blue-700" title="Show"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                    <!-- Add more dummy rows if needed -->
                </tbody>
            </table>
        </div>

        <div class="p-4 text-sm text-gray-600">
            Menampilkan 2 dari 2 entri
        </div>
    </div>

    <div class="text-center mt-12">
        <a href="{{ route('welcome') }}" class="inline-block bg-white px-6 py-3 text-sm font-medium text-gray-800 rounded-2xl shadow-sm hover:shadow-md hover:bg-gray-50 transition duration-300">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Halaman Utama
        </a>
    </div>
</div>
@endsection
