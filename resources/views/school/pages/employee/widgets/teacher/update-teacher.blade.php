<!-- modal edit -->
<div class="modal fade" id="modal-update-teacher" tabindex="-1" aria-labelledby="editPegawaiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header p-0" style="border:none;">
                <div style="background-color: #1AA6D8; width:100%; padding: 12px 20px; border-top-left-radius: .5rem; border-top-right-radius: .5rem; display:flex; align-items:center; justify-content:space-between;">
                    <h5 class="modal-title text-white mb-0" id="editPegawaiLabel">Edit Guru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                <div class="wizard-content">
                    <form id="form-update" class="tab-wizard wizard-circle wizard clearfix" role="application" method="POST" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <section>
                            <div class="row mx-3">
                                <div class="col-md-12 text-center mb-4">
                                    <div id="drop-zone-edit" style="position:relative; width:150px; height:150px; margin:0 auto; border:2px dashed #DCE9EF; border-radius:50%; display:flex; align-items:center; justify-content:center; background:#FBFDFF; cursor:pointer; transition:all 0.3s ease;">
                                        <img id="employeeImagePreview" class="rounded-circle" src="{{ asset('assets/images/default-user.jpeg') }}" alt="Preview" style="object-fit: cover; width: 150px; height: 150px; position:absolute; z-index:2;" onerror="this.onerror=null;this.src='{{ asset('assets/images/default-user.jpeg') }}';" />
                                        <div id="drop-zone-overlay" style="position:absolute; width:100%; height:100%; border-radius:50%; display:flex; align-items:center; justify-content:center; z-index:3; opacity:0; transition:opacity 0.3s ease; background: rgba(15, 159, 198, 0.15);">
                                            <div style="text-align:center; pointer-events:none;">
                                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-bottom:2px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" stroke="#098FC6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><polyline points="17 8 12 3 7 8" stroke="#098FC6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><line x1="12" y1="3" x2="12" y2="15" stroke="#098FC6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                <div style="color:#098FC6; font-size:11px; font-weight:600; white-space:nowrap;">Ubah Foto</div>
                                            </div>
                                        </div>
                                        <div id="drop-zone-initial-icon" style="position:absolute; width:100%; height:100%; border-radius:50%; display:flex; align-items:center; justify-content:center; z-index:1; pointer-events:none;">
                                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z" fill="#098FC6" opacity="0.4"/></svg>
                                        </div>
                                        <input type="file" name="image" id="employeeImage" onchange="previewEditTeacherImage(event)" style="display:none">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Nama <span class="text-danger" style="font-size: larger;">*</span></label>
                                        <input type="text" name="name" placeholder="Masukkan nama" id="name-edit" class="form-control rounded-input mb-3" value="{{ old('name') }}">
                                        @error('name', 'update')
                                        <strong class="text-danger error-edit-teacher mb-2">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">NIP <span class="text-danger" style="font-size: larger;">*</span></label>
                                        <input type="number" name="nip" placeholder="Masukkan nip" id="nip-edit" class="form-control rounded-input mb-3" value="{{ old('nip') }}">
                                        @error('nip', 'update')
                                        <strong class="text-danger error-edit-teacher mb-2">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Agama</label>
                                        <select name="religion_id" id="edit-religion-teacher" class="form-select rounded-input">
                                            <option>Pilih agama..</option>
                                            @foreach ($religions as $religion)
                                            <option value="{{ $religion->id }}" {{ old('religion_id') == $religion->id ? 'selected' : '' }}>{{ $religion->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('religion_id', 'update')
                                        <strong class="text-danger error-edit-teacher mb-2">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Tanggal Lahir <span class="text-danger" style="font-size: larger;">*</span></label>
                                        <input type="date" name="birth_date" id="birth_date-edit-teacher" class="form-control rounded-input mb-3" value="{{ old('birth_date') }}">
                                        @error('birth_date', 'update')
                                        <strong class="text-danger error-edit-teacher mb-2">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Tempat Lahir <span class="text-danger" style="font-size: larger;">*</span></label>
                                        <input type="text" placeholder="Masukkan tempat lahir" class="form-control rounded-input" id="birth_place-edit-teacher" name="birth_place" value="{{ old('birth_place') }}">
                                        @error('birth_place', 'update')
                                        <strong class="text-danger error-edit-teacher mb-2">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Jenis Kelamin <span class="text-danger" style="font-size: larger;">*</span></label>
                                    <div class="form-check d-flex align-items-center mt-2">
                                        <div class="custom-control custom-radio me-4">
                                            <input type="radio" class="custom-control-input" id="maleEdit" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="maleEdit">Laki-laki</label>
                                        </div>
                                        <div class="custom-control custom-radio me-4">
                                            <input type="radio" class="custom-control-input" id="femaleEdit" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="femaleEdit">Perempuan</label>
                                        </div>
                                        @error('gender', 'update')
                                            <strong class="text-danger error-edit-teacher mb-2">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3 mx-4">
                                <button type="button" class="btn btn-primary next-step" style="background:#098FC6; border-color:#098FC6;">Berikutnya</button>
                            </div>
                        </section>

                        <section>
                            <div class="row mx-3 pt-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">NIK <span class="text-danger" style="font-size: larger;">*</span></label>
                                        <input type="text" name="nik" placeholder="Masukkan nik" id="nik-edit" class="form-control rounded-input mb-3" value="{{ old('nik') }}">
                                        @error('nik', 'update')
                                        <strong class="text-danger error-edit-teacher mb-2">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">No Telp <span class="text-danger" style="font-size: larger;">*</span></label>
                                        <input type="text" name="phone_number" placeholder="Masukkan no telp" id="phone-edit" class="form-control rounded-input mb-3" value="{{ old('phone_number') }}">
                                        @error('phone_number', 'update')
                                        <strong class="text-danger error-edit-teacher mb-2">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Email <span class="text-danger" style="font-size: larger;">*</span></label>
                                        <input type="text" name="email" placeholder="Masukkan email" id="email-edit" class="form-control rounded-input mb-3" value="{{ old('email') }}">
                                        @error('email', 'update')
                                        <strong class="text-danger error-edit-teacher mb-2">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Status</label>
                                        <select name="active" id="status-edit" class="form-select rounded-input mb-3">
                                            <option value="1">Aktif</option>
                                            <option value="0">NonAktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h6>Alamat <span class="text-danger" style="font-size: larger;">*</span></h6>
                                        <textarea name="address" placeholder="Masukkan alamat" id="address-edit" class="form-control rounded-input mb-3" rows="3">{{ old('address') }}</textarea>
                                        @error('address', 'update')
                                        <strong class="text-danger error-edit-teacher mb-2">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3 mx-4">
                                <button type="button" class="btn mb-1 waves-effect waves-light btn-rounded btn-primary ms-3 prev-step" style="background:#098FC6; border-color:#098FC6;">Kembali</button>
                                <button type="submit" class="btn mb-1 waves-effect waves-light btn-rounded btn-primary ms-3" style="background:#098FC6; border-color:#098FC6;">Simpan</button>
                            </div>
                        </section>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-input { border-radius: 10px; background: #F6F9FB; border: 1px solid rgba(0,0,0,0.06); }
    #drop-zone-edit {
        transition: all 0.3s ease;
    }
    #drop-zone-edit:hover {
        border-color: #098FC6;
        background: #EEF9FF;
    }
    #drop-zone-edit:hover #drop-zone-overlay {
        opacity: 1 !important;
    }
    #drop-zone-edit:hover #drop-zone-initial-icon {
        opacity: 0;
    }
    #drop-zone-edit.drag-over {
        border-color: #098FC6;
        background: #EEF9FF;
    }
    #drop-zone-edit.drag-over #drop-zone-overlay {
        opacity: 1 !important;
    }
    #drop-zone-edit.drag-over #drop-zone-initial-icon {
        opacity: 0;
    }
    .btn-close-white { filter: invert(1) brightness(2); }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropZone = document.getElementById('drop-zone-edit');
        const fileInput = document.getElementById('employeeImage');
        const overlay = document.getElementById('drop-zone-overlay');
        
        if (!dropZone || !fileInput) return;

        // Click to upload
        dropZone.addEventListener('click', function (e) {
            if (e.target !== fileInput) {
                fileInput.click();
            }
        });

        // Drag and drop events
        ['dragenter', 'dragover'].forEach(function (evt) {
            dropZone.addEventListener(evt, function (e) {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.add('drag-over');
            }, false);
        });

        ['dragleave', 'dragend', 'drop'].forEach(function (evt) {
            dropZone.addEventListener(evt, function (e) {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.remove('drag-over');
            }, false);
        });

        dropZone.addEventListener('drop', function (e) {
            const files = e.dataTransfer.files;
            if (files && files.length) {
                const dt = new DataTransfer();
                for (let i = 0; i < files.length; i++) dt.items.add(files[i]);
                fileInput.files = dt.files;
                previewEditTeacherImage({ target: fileInput });
            }
        });
    });

    function previewEditTeacherImage(e) {
        const input = e.target;
        if (input.files && input.files[0]) {
            const url = URL.createObjectURL(input.files[0]);
            const preview = document.getElementById('employeeImagePreview');
            preview.src = url;
        }
    }
</script>
