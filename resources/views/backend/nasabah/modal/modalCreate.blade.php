<!-- The Modal -->
<div class="modal fade" id="buatAnggota" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Nasabah</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('storeNasabah') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Form Fields -->
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" value="{{ old('nama')}}" id="nama" name="nama">
                                <label for="nama">Nama</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" value="{{ old('email')}}" id="email" name="email">
                                <label for="email">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" name="password">
                                <label for="password">Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" value="{{ old('nip')}}" id="nip" name="nip">
                                <label for="nip">No KTP</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="tel" class="form-control" value="{{ old('telphone')}}" id="telphone" name="telphone">
                                <label for="telphone">Telepon</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" value="{{ old('tgl_lahir')}}" id="tgl_lahir" name="tgl_lahir">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="alamat" name="alamat" style="height: 100px">{{ old('alamat')}}</textarea>
                                <label for="alamat">Alamat</label>
                            </div>
                            <div class="row mb-3">
                            <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="rt" name="rt" value="{{ old('rt') }}">
                                        <label for="rt">RT</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="rw" name="rw" value="{{ old('rw') }}">
                                        <label for="rw">RW</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama</label>
                                <select id="agama" name="agama" class="form-select">
                                    <option value="" selected disabled>Pilih Agama</option>
                                    <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                </select>
                                @error('agama')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select id="jenis_kelamin" name="jenis_kelamin" class="form-select">
                                    <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" value="{{ old('pekerjaan')}}" id="pekerjaan" name="pekerjaan">
                                <label for="pekerjaan">Pekerjaan</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" value="{{ old('tgl_gabung')}}" id="tgl_gabung" name="tgl_gabung">
                                <label for="tgl_gabung">Tanggal Gabung</label>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Masukkan Foto</label>
                                <input class="form-control form-control-sm" id="image" name="image" accept="image/*" type="file">
                                @error('image')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <img id="image-preview" src="#" alt="Image Preview" style="display: none; max-width: 50%; height: auto; margin-top: 10px;">
                                <div id="crop-container" style="width: 100%; max-height: 70vh; overflow: hidden; display: none;">
                                    <img id="crop-image" src="#" alt="Crop Image" style="max-width: 100%; height: auto;">
                                </div>
                                <button type="button" class="btn btn-secondary mt-2" id="crop-button" style="display: none;">Crop Image</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary  " data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success  ">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let cropper;
    document.getElementById('image').addEventListener('change', function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('crop-image');
            output.src = reader.result;
            document.getElementById('crop-container').style.display = 'block';

            // Initialize cropper
            if (cropper) {
                cropper.destroy();
            }
            cropper = new Cropper(output, {
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
        var canvas = cropper.getCroppedCanvas();
        var output = document.getElementById('image-preview');
        output.src = canvas.toDataURL();
        output.style.display = 'block';

        document.getElementById('crop-container').style.display = 'none';
        document.getElementById('crop-button').style.display = 'none';
    });
</script>
