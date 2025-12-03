<style>
    #update-student .modal-header {
        background-color: #0896D1 !important;
        border-top-left-radius: 10px !important;
        border-top-right-radius: 10px !important;
    }
    
    #update-student .modal-content {
        border-radius: 10px !important;
        overflow: hidden;
        border: none;
    }
    
    #update-student .btn-close {
        filter: invert(1) brightness(200%);
    }

    #update-student .form-control, #update-student .form-select {
        border-radius: 8px;
        border: 1px solid #e0e6ed;
        padding: 10px 15px;
        min-height: 45px;
    }

    #update-student .form-control:focus, #update-student .form-select:focus {
        border-color: #0896D1;
        box-shadow: 0 0 0 0.25rem rgba(8, 150, 209, 0.25);
    }

    #update-student .upload-area-circular {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        border: 2px dashed #dee2e6;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
        margin: 0 auto;
        background-image: url('{{ asset('assets/images/default-user.jpeg') }}');
    }

    #update-student .upload-area-circular:hover {
        border-color: #0896D1;
    }

    #update-student .upload-area-circular .upload-text {
        font-size: 14px;
        color: #6c757d;
    }

    #update-student .upload-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(255, 255, 255, 0.75);
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }

    #update-student .upload-area-circular:hover .upload-overlay {
        opacity: 1;
    }

    #update-student .upload-overlay-content p {
        font-size: 10px;
    }

    #update-student .upload-overlay-content .btn {
        font-size: 10px;
        padding: 5px 10px;
    }

    #update-student .btn-outline-primary {
        border: 1px solid #0896D1;
        color: #0896D1;
        background-color: transparent;
    }

    #update-student .btn-outline-primary:hover {
        background-color: #0896D1;
        color: #fff;
    }
</style>

<div class="modal fade" id="update-student" tabindex="-1" aria-labelledby="importPegawai" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="importPegawai">Edit Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-update" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-4">
                        <!-- Step 1 -->
                        <div id="form-step-1-edit">
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <div class="upload-area-circular" id="upload-area-edit" onclick="document.getElementById('studentImageInput').click()">
                                        <div class="upload-overlay">
                                            <div class="upload-overlay-content text-center">
                                                <i class="ti ti-cloud-upload fs-4 mb-2"></i>
                                                <p class="mb-2">Seret dan Lepas File di sini atau</p>
                                                <button type="button" class="btn btn-primary btn-sm">Pilih File Untuk Diunggah</button>
                                            </div>
                                        </div>
                                    </div>
                                    <input class="form-control d-none" name="image" type="file" id="studentImageInput" accept="image/png,image/jpg,image/jpeg" onchange="previewEditStudentImage(event)">
                                    @error('image', 'edit')
                                        <div class="text-center mt-2"><strong class="text-danger error-edit">{{ $message }}</strong></div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name-edit" class="mb-2">Nama<span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name-edit" class="form-control" placeholder="Masukkan Nama">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email-edit" class="mb-2">Email<span class="text-danger">*</span></label>
                                    <input type="text" name="email" id="email-edit" class="form-control" placeholder="Masukkan email">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nisn-edit" class="mb-2">NISN<span class="text-danger">*</span></label>
                                    <input type="text" name="nisn" id="nisn-edit" class="form-control" placeholder="Masukkan NISN">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="gender-edit" class="mb-2">Jenis Kelamin<span class="text-danger">*</span></label>
                                    <select id="gender-edit" name="gender" class="form-select">
                                        <option value="male">Laki-Laki</option>
                                        <option value="female">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="religion-edit" class="mb-2">Agama<span class="text-danger">*</span></label>
                                    <select id="religion-edit" name="religion_id" class="form-select">
                                        @foreach ($religions as $religion)
                                            <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="birth_date-edit" class="mb-2">Tanggal Lahir<span class="text-danger">*</span></label>
                                    <input type="date" name="birth_date" id="birth_date-edit" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="birth_place-edit" class="mb-2">Tempat Lahir<span class="text-danger">*</span></label>
                                    <input type="text" name="birth_place" id="birth_place-edit" placeholder="Masukkan Tempat Lahir" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nik-edit" class="mb-2">NIK<span class="text-danger">*</span></label>
                                    <input type="number" name="nik" id="nik-edit" class="form-control" placeholder="Masukkan NIK">
                                </div>
                            </div>
                        </div>
                        <!-- Step 2 -->
                        <div id="form-step-2-edit" class="hidden">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="number_kk-edit" class="mb-2">Nomor KK<span class="text-danger">*</span></label>
                                    <input type="number" name="number_kk" id="number_kk-edit" class="form-control" placeholder="Masukkan Nomor KK">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="number_akta-edit" class="mb-2">Nomor Akta<span class="text-danger">*</span></label>
                                    <input type="text" name="number_akta" id="number_akta-edit" placeholder="Masukkan Nomor Akta" class="form-control">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="address-edit" class="mb-2">Alamat<span class="text-danger">*</span></label>
                                    <textarea name="address" id="address-edit" class="form-control" placeholder="Masukkan alamat"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <div id="footer-step-1-edit">
                        <button type="button" class="btn btn-primary" id="btn-next-step-edit">Berikutnya</button>
                    </div>
                    <div id="footer-step-2-edit" class="hidden">
                        <button type="button" class="btn btn-outline-primary" id="btn-prev-step-edit">Kembali</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewEditStudentImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('edit-preview-img');
        const placeholder = document.getElementById('edit-upload-placeholder');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            }
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
            placeholder.style.display = 'block';
        }
    }
</script>

<script>
    function previewEditStudentImage(event) {
        const file = event.target.files[0];
        const uploadArea = document.getElementById('upload-area-edit');
        const placeholder = document.getElementById('edit-upload-placeholder');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                uploadArea.style.backgroundImage = `url('${e.target.result}')`;
                placeholder.style.display = 'none';
            }
            reader.readAsDataURL(file);
        } else {
            uploadArea.style.backgroundImage = "url('{{ asset('assets/images/default-user.jpeg') }}')";
            placeholder.style.display = 'block';
        }
    }
</script>
