<!-- modal tambah -->
<div class="modal fade" id="create-teacher" tabindex="-1" aria-labelledby="guru" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header p-0" style="border:none;">
                <div
                    style="background-color: #1AA6D8; width:100%; padding: 12px 20px; border-top-left-radius: .5rem; border-top-right-radius: .5rem; display:flex; align-items:center; justify-content:space-between;">
                    <h5 class="modal-title text-white mb-0" id="guru">Tambah Guru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <div class="">
                    <div class="wizard-content">
                        <form action="{{ route('school.teacher.store') }}"
                            class="tab-wizard wizard-circle wizard clearfix" role="application" id="form-add"
                            method="POST" enctype="multipart/form-data">
                            @method('post')
                            @csrf
                            <!-- Step 1 -->
                            <section>
                                <div class="row mx-3 mb-3">
                                    <div class="col-md-12">
                                        <label for="" class="mb-2">Foto Guru (opsional)</label>

                                        <div id="drop-zone" class="mb-3"
                                            style="border:2px dashed #DCE9EF; border-radius:8px; padding:28px; text-align:center; background:#FBFDFF;">
                                            <div style="max-width:420px;margin:0 auto">
                                                {{-- <svg width="36" height="36" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-bottom:8px"><path d="M12 3V15" stroke="#0A98D1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 7l4-4 4 4" stroke="#0A98D1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg> --}}
                                                <svg width="30" height="24" viewBox="0 0 30 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M15.0841 9.92809C15.0592 9.89634 15.0275 9.87066 14.9912 9.85301C14.955 9.83535 14.9152 9.82617 14.8749 9.82617C14.8346 9.82617 14.7948 9.83535 14.7586 9.85301C14.7223 9.87066 14.6906 9.89634 14.6657 9.92809L10.947 14.633C10.9163 14.6721 10.8973 14.7191 10.8921 14.7686C10.8869 14.818 10.8957 14.8679 10.9175 14.9126C10.9393 14.9573 10.9733 14.9949 11.0155 15.0212C11.0577 15.0475 11.1064 15.0614 11.1562 15.0613H13.6099V23.1097C13.6099 23.2558 13.7294 23.3754 13.8755 23.3754H15.8677C16.0138 23.3754 16.1333 23.2558 16.1333 23.1097V15.0646H18.5937C18.8161 15.0646 18.939 14.8089 18.8028 14.6363L15.0841 9.92809Z"
                                                        fill="black" />
                                                    <path
                                                        d="M24.816 6.86309C23.2953 2.85215 19.4205 0 14.8816 0C10.3428 0 6.46797 2.84883 4.94727 6.85977C2.10176 7.60684 0 10.2 0 13.2812C0 16.9502 2.97168 19.9219 6.6373 19.9219H7.96875C8.11484 19.9219 8.23438 19.8023 8.23438 19.6562V17.6641C8.23438 17.518 8.11484 17.3984 7.96875 17.3984H6.6373C5.51836 17.3984 4.46582 16.9535 3.68223 16.1467C2.90195 15.3432 2.48691 14.2607 2.52344 13.1385C2.55332 12.2619 2.85215 11.4385 3.39336 10.7445C3.94785 10.0373 4.7248 9.52266 5.58809 9.29355L6.84648 8.96484L7.30801 7.74961C7.59355 6.99258 7.99199 6.28535 8.49336 5.64453C8.98832 5.00938 9.57463 4.45104 10.2332 3.9877C11.5979 3.02813 13.2049 2.52012 14.8816 2.52012C16.5584 2.52012 18.1654 3.02813 19.5301 3.9877C20.1908 4.45254 20.7752 5.01035 21.2699 5.64453C21.7713 6.28535 22.1697 6.9959 22.4553 7.74961L22.9135 8.96152L24.1686 9.29355C25.9682 9.77832 27.2266 11.4152 27.2266 13.2812C27.2266 14.3803 26.7982 15.4162 26.0213 16.1932C25.6403 16.5764 25.187 16.8803 24.6877 17.0872C24.1885 17.2941 23.6531 17.3999 23.1127 17.3984H21.7812C21.6352 17.3984 21.5156 17.518 21.5156 17.6641V19.6562C21.5156 19.8023 21.6352 19.9219 21.7812 19.9219H23.1127C26.7783 19.9219 29.75 16.9502 29.75 13.2812C29.75 10.2033 27.6549 7.61348 24.816 6.86309Z"
                                                        fill="black" />
                                                </svg>
                                                <div style="color:#2B3E4B; margin-bottom:8px; font-weight:600">Seret dan
                                                    Lepas File di sini atau</div>
                                                <div>
                                                    <label class="btn btn-primary btn-sm"
                                                        style="background:#098FC6; border-color:#098FC6; padding:8px 12px; border-radius:20px; cursor:pointer;">
                                                        Pilih File untuk Diunggah
                                                        <input type="file" name="image" id="image"
                                                            onchange="previewAddImage(event)" style="display:none">
                                                    </label>
                                                </div>
                                                <div class="mt-3">
                                                    <img id="addImagePreview" src="#" alt="Preview"
                                                        style="max-width: 200px; display:none; border-radius:8px;" />
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6  mb-3">
                                        <div class="form-group">
                                            <label for="">Nama <span class="text-danger"
                                                    style="font-size: larger;">*</span></label>
                                            <input type="text" name="name" placeholder="Masukkan nama"
                                                class="form-control rounded-input mb-3" value="{{ old('name') }}">
                                            @error('name', 'create')
                                                <strong
                                                    class="text-danger error-create-teacher mb-2">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="">NIP <span class="text-danger"
                                                    style="font-size: larger;">*</span></label>
                                            <input type="number" name="nip" placeholder="Masukkan nip"
                                                class="form-control rounded-input mb-3" value="{{ old('nip') }}">
                                            @error('nip', 'create')
                                                <strong
                                                    class="text-danger error-create-teacher mb-2">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6  mb-3">
                                        <div class="form-group">
                                            <label for="">Agama</label>
                                            <select name="religion_id" id="" class="form-select rounded-input">
                                                <option value="">Pilih agama..</option>
                                                @foreach ($religions as $religion)
                                                    <option value="{{ $religion->id }}"
                                                        {{ old('religion_id') == $religion->id ? 'selected' : '' }}>
                                                        {{ $religion->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('religion_id', 'create')
                                                <strong
                                                    class="text-danger error-create-teacher mb-2">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="">Tanggal Lahir <span class="text-danger"
                                                    style="font-size: larger;">*</span></label>
                                            <input type="date" name="birth_date" class="form-control rounded-input"
                                                value="{{ old('birth_date') }}">
                                            @error('birth_date', 'create')
                                                <strong
                                                    class="text-danger error-create-teacher mb-2">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="">Tempat Lahir <span class="text-danger"
                                                    style="font-size: larger;">*</span></label>
                                            <input type="text" placeholder="Masukkan tempat lahir"
                                                class="form-control rounded-input" name="birth_place"
                                                value="{{ old('birth_place') }}">
                                            @error('birth_place', 'create')
                                                <strong
                                                    class="text-danger error-create-teacher mb-2">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="">Jenis Kelamin <span class="text-danger"
                                                style="font-size: larger;">*</span></label>
                                        <div class="form-check d-flex align-items-center mt-2">
                                            <div class="custom-control custom-radio me-4">
                                                <input type="radio" class="custom-control-input"
                                                    id="customControlValidationA" name="gender" value="male"
                                                    {{ old('gender') == 'male' ? 'checked' : '' }}>
                                                <label class="custom-control-label"
                                                    for="customControlValidationA">Laki-laki</label>
                                            </div>
                                            <div class="custom-control custom-radio me-4">
                                                <input type="radio" class="custom-control-input"
                                                    id="customControlValidationB" name="gender" value="female"
                                                    {{ old('gender') == 'female' ? 'checked' : '' }}>
                                                <label class="custom-control-label"
                                                    for="customControlValidationB">Perempuan</label>
                                            </div>
                                        </div>
                                        @error('gender', 'create')
                                            <strong
                                                class="text-danger error-create-teacher mb-2">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-3 mx-4">
                                    <button type="button" class="btn btn-primary next-add-step"
                                        style="background:#098FC6; border-color:#098FC6;">Berikutnya</button>
                                </div>
                            </section>

                            <!-- Step 2 -->
                            <section>
                                <div class="row mx-3 pt-4">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="">NIK <span class="text-danger"
                                                    style="font-size: larger;">*</span></label>
                                            <input type="text" placeholder="Masukkan nik" name="nik"
                                                class="form-control rounded-input mb-3" value="{{ old('nik') }}">
                                            @error('nik', 'create')
                                                <strong
                                                    class="text-danger error-create-teacher mb-2">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="">No Telp <span class="text-danger"
                                                    style="font-size: larger;">*</span></label>
                                            <input type="tel" placeholder="Masukkan no telp" name="phone_number"
                                                class="form-control rounded-input mb-3" pattern="[0-9]*"
                                                inputmode="numeric" maxlength="13"
                                                value="{{ old('phone_number') }}">
                                            @error('phone_number', 'create')
                                                <strong
                                                    class="text-danger error-create-teacher mb-2">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="">Email <span class="text-danger"
                                                    style="font-size: larger;">*</span></label>
                                            <input type="text" placeholder="Masukkan email" name="email"
                                                class="form-control rounded-input mb-3" value="{{ old('email') }}">
                                            @error('email', 'create')
                                                <strong
                                                    class="text-danger error-create-teacher mb-2">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="">Status</label>
                                            <select name="active" id="" class="form-select rounded-input">
                                                <option value="1" {{ old('active') == '1' ? 'selected' : '' }}>
                                                    Aktif</option>
                                                <option value="0" {{ old('active') == '0' ? 'selected' : '' }}>
                                                    NonAktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <h6>Alamat <span class="text-danger" style="font-size: larger;">*</span>
                                            </h6>
                                            <textarea name="address" class="form-control rounded-input mb-3" placeholder="Masukkan alamat" rows="3">{{ old('address') }}</textarea>
                                            @error('address', 'create')
                                                <strong
                                                    class="text-danger error-create-teacher mb-2">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-3 mx-4">
                                    <button type="button"
                                        class="btn mb-1 waves-effect waves-light btn-rounded btn-primary ms-3 prev-add-step"
                                        style="background:#098FC6; border-color:#098FC6;">Kembali</button>
                                    <button type="submit"
                                        class="btn mb-1 waves-effect waves-light btn-rounded btn-primary ms-3 next-add-step"
                                        style="background:#098FC6; border-color:#098FC6;">Simpan</button>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        /* Rounded inputs and subtle background to match design */
        .rounded-input {
            border-radius: 10px;
            background: #F6F9FB;
            border: 1px solid rgba(0, 0, 0, 0.06);
        }

        .btn-close-white {
            filter: invert(1) brightness(2);
        }

        #drop-zone label.btn {
            display: inline-block;
        }

        #drop-zone.drag-over {
            border-color: #098FC6;
            background: #EEF9FF;
        }
    </style>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.getElementById('drop-zone');
        if (!dropZone) return;
        const fileInput = dropZone.querySelector('input[type="file"]') || document.getElementById('image');
        const preview = document.getElementById('addImagePreview');

        ['dragenter', 'dragover'].forEach(function(evt) {
            dropZone.addEventListener(evt, function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.add('drag-over');
            }, false);
        });

        ['dragleave', 'dragend', 'drop'].forEach(function(evt) {
            dropZone.addEventListener(evt, function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.remove('drag-over');
            }, false);
        });

        dropZone.addEventListener('drop', function(e) {
            const files = e.dataTransfer.files;
            if (files && files.length) {
                // assign files to the file input
                const dt = new DataTransfer();
                for (let i = 0; i < files.length; i++) dt.items.add(files[i]);
                fileInput.files = dt.files;
                // show preview
                previewFile(fileInput.files[0]);
            }
        });
    });

    function previewAddImage(e) {
        const input = e.target;
        if (input.files && input.files[0]) {
            previewFile(input.files[0]);
        }
    }

    function previewFile(file) {
        const preview = document.getElementById('addImagePreview');
        if (!file) {
            preview.style.display = 'none';
            preview.src = '#';
            return;
        }
        const url = URL.createObjectURL(file);
        preview.src = url;
        preview.style.display = 'block';
    }
</script>
