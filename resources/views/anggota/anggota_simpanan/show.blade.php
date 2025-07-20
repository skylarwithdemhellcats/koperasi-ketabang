@extends('layouts.anggota')

@section('title', 'Detail Simpanan')

@section('content')
<div class="max-w-2xl mx-auto px-4 pt-8 pb-16">
    <h2 class="text-2xl text-white font-semibold text-center pb-6">Detail Simpanan</h2>

    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Informasi Simpanan</h3>
            <table class="w-full text-sm text-left text-gray-600">
                <tbody>
                    <tr class="border-b">
                        <th class="py-2 pr-4 font-medium">Kode Transaksi Simpanan</th>
                        <td class="py-2">SM-00123</td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-2 pr-4 font-medium">Tanggal Simpanan</th>
                        <td class="py-2">2025-07-20</td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-2 pr-4 font-medium">Jenis Simpanan</th>
                        <td class="py-2">Simpanan Wajib</td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-2 pr-4 font-medium">Jumlah Simpanan</th>
                        <td class="py-2">Rp 1.000.000,00</td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-2 pr-4 font-medium">Dibuat Oleh</th>
                        <td class="py-2">Petugas Dummy</td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-2 pr-4 font-medium">Update Oleh</th>
                        <td class="py-2">Admin Dummy</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Bukti Pembayaran</h3>
            <div class="text-center">
                <img src="{{ asset('src/bg.jpg') }}" id="proof-image" alt="Bukti Pembayaran" class="w-full max-w-3xl mx-auto rounded-xl shadow cursor-pointer">
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('simpanan.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded transition duration-200">Kembali</a>
        </div>
    </div>
</div>

<!-- Modal Bukti Pembayaran -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" id="modal-image" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const proofImage = document.getElementById('proof-image');
        if (proofImage) {
            proofImage.addEventListener('click', function () {
                const modalImage = document.getElementById('modal-image');
                modalImage.src = proofImage.src;
                const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
                imageModal.show();
            });
        }
    });
</script>
@endsection
