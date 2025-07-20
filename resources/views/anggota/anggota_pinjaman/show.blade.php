@extends('layouts.anggota')

@section('title', 'Detail Pinjaman')

@section('content')
<div class="container py-5">
    <h2 class="text-center text-white mb-4">Data Pinjaman</h2>

    <div class="bg-white rounded shadow-sm p-4 mb-4">
        <h4>Informasi Pinjaman</h4>
        <div class="row mt-3">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr><th>Kode Pinjaman</th><td>PINJ-001</td></tr>
                    <tr><th>Nama Nasabah</th><td>John Doe</td></tr>
                    <tr><th>Tanggal Pinjam</th><td>01 Juli 2025</td></tr>
                    <tr><th>Jatuh Tempo</th><td>01 Oktober 2025</td></tr>
                    <tr><th>Pinjaman Pokok</th><td>Rp 10.000.000</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr><th>Lama Pinjaman</th><td>3 Bulan</td></tr>
                    <tr><th>Bunga</th><td>2%</td></tr>
                    <tr><th>Total Dengan Bunga</th><td>Rp 10.600.000</td></tr>
                    <tr><th>Status Pengajuan</th><td><span class="text-success">Disetujui</span></td></tr>
                    <tr><th>Dibuat Oleh</th><td>Admin</td></tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Dummy Angsuran Table -->
    <div class="card">
        <div class="card-header"><h5>Daftar Angsuran</h5></div>
        <div class="card-body">
            <button class="btn btn-outline-primary rounded-pill mb-3" data-bs-toggle="modal" data-bs-target="#bayarAngsuranModal">
                Bayar Angsuran
            </button>
            <!-- Modal Bayar Angsuran -->
            <div class="modal fade" id="bayarAngsuranModal" tabindex="-1" aria-labelledby="bayarAngsuranLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form method="POST" action="#" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                            <h5 class="modal-title" id="bayarAngsuranLabel">Bayar Angsuran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                            <div class="mb-3">
                                <label for="bukti_pembayaran" class="form-label">Upload Bukti Pembayaran</label>
                                <input type="file" class="form-control" id="bukti_pembayaran" accept="image/*">
                            </div>

                            <div id="crop-container" style="display: none;">
                                <h6 class="mb-2">Sesuaikan Gambar:</h6>
                                <img id="crop-image" class="img-fluid mb-3">
                                <button type="button" class="btn btn-sm btn-outline-primary" id="crop-button">Crop</button>
                            </div>

                            <div class="mt-3">
                                <label class="form-label">Preview:</label><br>
                                <img id="image-preview" class="img-fluid rounded border shadow-sm" style="display:none; max-width: 100%;">
                            </div>

                            <input type="hidden" name="cropped_image_data" id="cropped_image_data">
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Pembayaran</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Kode Angsuran</th>
                        <th>Tanggal</th>
                        <th>Sisa Pokok</th>
                        <th>Bunga</th>
                        <th>Cicilan Ke-</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ANG-001</td>
                        <td>01 Agustus 2025</td>
                        <td>Rp 6.000.000</td>
                        <td>Rp 200.000</td>
                        <td>1</td>
                        <td><span class="text-warning">Belum Lunas</span></td>
                        <td>Rp 3.400.000</td>
                    </tr>
                    <tr>
                        <td>ANG-002</td>
                        <td>01 September 2025</td>
                        <td>Rp 3.000.000</td>
                        <td>Rp 200.000</td>
                        <td>2</td>
                        <td><span class="text-success">Lunas</span></td>
                        <td>Rp 3.200.000</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6">Total Angsuran</th>
                        <th colspan="2">Rp 6.600.000</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tolak -->
<div class="modal fade" id="tolakModal" tabindex="-1" aria-labelledby="tolakLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Alasan Penolakan</h5></div>
      <div class="modal-body">
        <textarea class="form-control" placeholder="Tulis alasan di sini..."></textarea>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-danger">Tolak</button>
      </div>
    </div>
  </div>
</div>

<div class="text-center mt-12 mb-12">
    <a href="{{ route('anggota.pinjaman.index') }}" class="inline-block bg-white px-6 py-3 text-sm font-medium text-gray-800 rounded-2xl shadow-sm hover:shadow-md hover:bg-gray-50 transition duration-300">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

@push('scripts')
<!-- CropperJS CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet"/>

<!-- CropperJS & Bootstrap Bundle -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let cropper;
    document.getElementById('bukti_pembayaran').addEventListener('change', function(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const image = document.getElementById('crop-image');
            image.src = reader.result;
            document.getElementById('crop-container').style.display = 'block';

            if (cropper) cropper.destroy();
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 1,
                scalable: true,
                zoomable: true,
            });

            document.getElementById('crop-button').style.display = 'inline-block';
        };
        reader.readAsDataURL(event.target.files[0]);
    });

    document.getElementById('crop-button').addEventListener('click', function() {
        const canvas = cropper.getCroppedCanvas();
        const preview = document.getElementById('image-preview');
        preview.src = canvas.toDataURL();
        preview.style.display = 'block';

        // store cropped data in hidden input
        document.getElementById('cropped_image_data').value = canvas.toDataURL();

        document.getElementById('crop-container').style.display = 'none';
        this.style.display = 'none';
    });
</script>
@endpush

@endsection
