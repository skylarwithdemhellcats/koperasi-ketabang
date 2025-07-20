@extends('layouts.anggota')

@section('content')
    <!-- Header Section -->
    <section class="pt-40 pb-12">
        <div class="max-w-4xl mx-auto px-6 flex justify-center items-center">
            <h1 class="text-4xl md:text-5xl font-semibold flex items-center gap-x-2 
                    text-white drop-shadow-lg">
                <i class="fas fa-wallet"></i>
                Penarikan Dana
            </h1>
        </div>
    </section>

    <!-- Penarikan Feature -->
    <section class="py-16 flex-grow">
        <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-8 px-6">
            <!-- Ajukan Penarikan -->
            <a href="{{ route('anggota.penarikan.create') }}" class="block !no-underline bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition duration-300 hover:bg-gray-50">
                <div class="flex items-center gap-4 mb-2">
                    <i class="fas fa-money-bill-wave bg-white text-gray-800 rounded-full p-3 shadow"></i>
                    <h3 class="text-xl font-semibold text-black">Ajukan Penarikan</h3>
                </div>
                <p class="text-gray-600">Tarik dana simpanan Anda dengan mudah dan aman.</p>
            </a>

            <!-- Lihat Riwayat Penarikan -->
            <a href="{{ route('anggota.penarikan.main') }}" class="block !no-underline bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition duration-300 hover:bg-gray-50">
                <div class="flex items-center gap-4 mb-2">
                    <i class="fas fa-history bg-white text-gray-800 rounded-full p-3 shadow"></i>
                    <h3 class="text-xl font-semibold text-black">Riwayat Penarikan</h3>
                </div>
                <p class="text-gray-600">Lihat riwayat pengajuan penarikan dana Anda.</p>
            </a>
        </div>
    </section>

    <!-- Back to Main -->
    <div class="text-center mt-12">
        <a href="{{ route('anggota.dashboard') }}" class="inline-block bg-white px-6 py-3 text-sm font-medium text-gray-800 rounded-2xl shadow-sm hover:shadow-md hover:bg-gray-50 transition duration-300">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Halaman Utama
        </a>
    </div>
@endsection
