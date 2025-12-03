    <!-- tambah modal -->
    <style>
        .modal-header {
            background-color: #0896D1 !important;
            border-top-left-radius: 10px !important;
            border-top-right-radius: 10px !important;
        }
        
        .modal-content {
            border-radius: 10px !important;
            overflow: hidden;
            border: none;
        }
        
        .btn-close {
            filter: invert(1) brightness(200%);
        }
        
        .upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 40px 20px;
            text-align: center;
            background-color: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s;
            /* background-image: url('{{ asset('assets/images/default-user.jpeg') }}'); */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            min-height: 200px;
        }
        
        .upload-area::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 6px;
        }
        
        .upload-area > * {
            position: relative;
            z-index: 1;
        }
        
        .upload-area:hover {
            border-color: #0896D1;
            background-color: #e7f3f8;
        }
        
        .upload-area i {
            font-size: 48px;
            color: #6c757d;
            margin-bottom: 10px;
        }

        .hidden {
            display: none;
        }
        #create-student .btn-outline-primary {
        border: 1px solid #0896D1;
        color: #0896D1;
        background-color: transparent;
        }

        #create-student .btn-outline-primary:hover {
            background-color: #0896D1;
            color: #fff;
        }
    </style>
    <div class="modal fade" id="create-student" tabindex="-1" aria-labelledby="importPegawai" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="importPegawai">Tambah Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('school.students.store', ['classroom' => $classroom]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body mx-3" style="max-height: 70vh; overflow-y: auto;">
                        <!-- Step 1 -->
                        <div id="form-step-1">
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <label class="mb-2">Foto Siswa <span class="text-muted">(Opsional)</span></label>
                                    <div class="upload-area" id="upload-area-create" onclick="document.getElementById('formFile').click()">
                                        <div id="upload-placeholder">
                                            <i class="ti ti-cloud-upload"></i>
                                            <p class="mb-2">Seret dan Lepas File di sini atau</p>
                                            <button type="button" class="btn btn-primary btn-sm">Pilih File Untuk Diunggah</button>
                                        </div>
                                        <input class="form-control d-none" name="image" type="file" id="formFile" accept="image/png,image/jpg,image/jpeg" onchange="previewImage(event)">
                                    </div>
                                    @error('image', 'create')
                                        <strong class="text-danger error-create">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="mb-1">Nama <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="Masukkan nama" value="{{ old('name') }}">
                                    @error('name', 'create')
                                        <strong class="text-danger error-create">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="mb-1">Email <span class="text-danger">*</span></label>
                                    <input type="text" name="email" class="form-control" placeholder="Masukkan email" value="{{ old('email') }}">
                                    @error('email', 'create')
                                        <strong class="text-danger error-create">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nisn" class="mb-1">NISN <span class="text-danger">*</span></label>
                                    <input type="text" name="nisn" class="form-control" placeholder="Masukkan NISN" value="{{ old('nisn') }}">
                                    @error('nisn', 'create')
                                        <strong class="text-danger error-create">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="mb-1">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select id="gender" name="gender" class="form-select">
                                        <option value="" selected>Pilih...</option>
                                        <option value="male">Laki-Laki</option>
                                        <option value="female">Perempuan</option>
                                    </select>
                                    @error('gender', 'create')
                                        <strong class="text-danger error-create">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="religion" class="mb-1">Agama <span class="text-danger">*</span></label>
                                    <select id="religion" name="religion_id" class="form-select">
                                        <option selected>Pilih...</option>
                                        @forelse ($religions as $religion)
                                            <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                        @empty
                                            <option disabled>Tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                    @error('religion_id', 'create')
                                        <strong class="text-danger error-create">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="birth_date" class="mb-1">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}">
                                    @error('birth_date', 'create')
                                    <strong class="text-danger error-create">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="birth_place" class="mb-1">Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" name="birth_place" class="form-control" placeholder="Masukkan tempat lahir" value="{{ old('birth_place') }}">
                                    @error('birth_place', 'create')
                                        <strong class="text-danger error-create">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nik" class="mb-1">NIK <span class="text-danger">*</span></label>
                                    <input type="number" name="nik" class="form-control" placeholder="Masukkan NIK" value="{{ old('nik') }}">
                                    @error('nik', 'create')
                                        <strong class="text-danger error-create">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Step 2 -->
                        <div id="form-step-2" class="hidden">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="number_kk" class="mb-1">Nomor KK <span class="text-danger">*</span></label>
                                    <input type="number" name="number_kk" class="form-control" placeholder="Masukkan Nomor KK" value="{{ old('number_kk') }}">
                                    @error('number_kk', 'create')
                                        <strong class="text-danger error-create">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="number_akta" class="mb-1">Nomor Akta <span class="text-danger">*</span></label>
                                    <input type="text" name="number_akta" class="form-control" placeholder="Masukkan Nomor Akta" value="{{ old('number_akta') }}">
                                    @error('number_akta', 'create')
                                        <strong class="text-danger error-create">{{ $message }}</strong>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="address" class="mb-1">Alamat <span class="text-danger">*</span></label>
                                    <textarea placeholder="Masukkan alamat" name="address" id="address" class="form-control">{{ old('address') }}</textarea>
                                    @error('address', 'create')
                                        <strong class="text-danger error-create">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div id="footer-step-1">
                            <button type="button" class="btn btn-primary" id="btn-next-step">Berikutnya</button>
                        </div>
                        <div id="footer-step-2" class="hidden">
                            <button type="button" class="btn btn-outline-primary" id="btn-prev-step">Kembali</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const uploadArea = document.getElementById('upload-area-create');
            const placeholder = document.getElementById('upload-placeholder');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    uploadArea.style.backgroundImage = `url('${e.target.result}')`;
                    placeholder.style.display = 'none';
                }
                reader.readAsDataURL(file);
            } else {
                placeholder.style.display = 'block';
            }
        }
    </script>
