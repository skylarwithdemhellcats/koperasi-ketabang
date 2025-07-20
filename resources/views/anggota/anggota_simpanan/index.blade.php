@extends('layouts.app')

@section('content')
    <!-- Logo-only Content -->
    <section class="pt-40 pb-12">
        <div class="max-w-4xl mx-auto px-6 flex justify-center items-center">
            <h1 class="text-4xl md:text-5xl font-semibold flex items-center gap-x-2
                    text-white drop-shadow-lg">
                <i class="fa fa-hashtag"></i>
                KOPERASI MERAH PUTIH
            </h1>
        </div>
    </section>

    <!-- Simpanan Feature Landing -->
    <section class="py-16 flex-grow">
        <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-8 px-6">
            <!-- Setor Simpanan -->
            <a href="{{ route('simpanan.create') }}" class="block !no-underline bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition duration-300 hover:bg-gray-50">
                <div class="flex items-center gap-4 mb-2">
                    <i class="fas fa-piggy-bank bg-white text-gray-800 rounded-full p-3 shadow"></i>
                    <h3 class="text-xl font-semibold text-black">Setor Simpanan</h3>
                </div>
                <p class="text-gray-600">Tambahkan dana ke simpanan Anda secara mudah.</p>
            </a>

            <!-- Lihat Simpanan -->
            <a href="{{ route('anggota.simpanan.main') }}" class="block !no-underline bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition duration-300 hover:bg-gray-50">
                <div class="flex items-center gap-4 mb-2">
                    <i class="fas fa-clipboard-list bg-white text-gray-800 rounded-full p-3 shadow"></i>
                    <h3 class="text-xl font-semibold text-black">Lihat Simpanan</h3>
                </div>
                <p class="text-gray-600">Lihat riwayat dan detail simpanan Anda kapan saja.</p>
            </a>
        </div>
    </section>

    <div class="text-center mt-12">
        <a href="{{ route('anggota.dashboard') }}" class="inline-block bg-white px-6 py-3 text-sm font-medium text-gray-800 rounded-2xl shadow-sm hover:shadow-md hover:bg-gray-50 transition duration-300">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Halaman Utama
        </a>
    </div>
@endsection
