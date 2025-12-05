<!-- tambah modal -->
<div class="modal fade" id="create-student" tabindex="-1" aria-labelledby="createStudentLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header p-0" style="border:none;">
                <div style="background-color: #1AA6D8; width:100%; padding: 12px 20px; border-top-left-radius: .5rem; border-top-right-radius: .5rem; display:flex; align-items:center; justify-content:space-between;">
                    <h5 class="modal-title text-white mb-0" id="createStudentLabel">Tambah Siswa</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <form id="form-create-student" action="#" method="POST" enctype="multipart/form-data">
                @csrf
                
                @if ($errors->hasBag('create') && $errors->count() > 0)
                    <div class="alert alert-danger mx-3 mt-3" role="alert">
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0" style="padding-left: 20px;">
                            @foreach ($errors->getBag('create')->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <section>
                    <div class="modal-body mx-3" style="max-height: 70vh; overflow-y: auto;">
                        <div class="row">
                            <div class="col-md-12 text-center mb-4">
                                <div id="drop-zone-add-student" style="position:relative; width:150px; height:150px; margin:0 auto; border:2px dashed #DCE9EF; border-radius:50%; display:flex; align-items:center; justify-content:center; background:#FBFDFF; cursor:pointer; transition:all 0.3s ease;">
                                    <img id="create-preview-img" class="rounded-circle" src="{{ asset('assets/images/default-user.jpeg') }}" alt="" style="object-fit: cover; width: 150px; height: 150px; position:absolute; z-index:2;" onerror="this.onerror=null;this.src='{{ asset('assets/images/default-user.jpeg') }}';" />
                                    <div id="drop-zone-overlay-add-student" style="position:absolute; width:100%; height:100%; border-radius:50%; display:flex; align-items:center; justify-content:center; z-index:3; opacity:0; transition:opacity 0.3s ease; background: rgba(15, 159, 198, 0.15);">
                                        <div style="text-align:center; pointer-events:none;">
                                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-bottom:2px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" stroke="#098FC6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><polyline points="17 8 12 3 7 8" stroke="#098FC6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><line x1="12" y1="3" x2="12" y2="15" stroke="#098FC6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            <div style="color:#098FC6; font-size:11px; font-weight:600; white-space:nowrap;">Pilih Foto</div>
                                        </div>
                                    </div>
                                    <div id="drop-zone-initial-icon-add-student" style="position:absolute; width:100%; height:100%; border-radius:50%; display:flex; align-items:center; justify-content:center; z-index:1; pointer-events:none;">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z" fill="#098FC6" opacity="0.4"/></svg>
                                    </div>
                                    <input type="file" name="image" id="imageInputCreate" class="d-none" onchange="previewCreateStudentImage(event)">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="mb-1">Nama <span class="text-danger" style="font-size: larger;">*</span></label>
                                    <input type="text" name="name" class="form-control rounded-input mb-3" placeholder="Masukkan nama" value="{{ old('name') }}">
                                    @error('name', 'create')
                                        <strong class="text-danger error-create" style="font-size: 12px;">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="classroom_id" class="mb-1">Kelas <span class="text-danger" style="font-size: larger;">*</span></label>
                                    <select id="classroom_id" name="classroom_id" class="form-select rounded-input select-icon">
                                        <option value="" selected>Pilih Kelas...</option>
                                        @foreach ($classrooms as $classroom)
                                            <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('classroom_id', 'create')
                                        <strong class="text-danger error-create" style="font-size: 12px;">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1">NISN <span class="text-danger" style="font-size: larger;">*</span></label>
                                    <input type="text" name="nisn" class="form-control rounded-input" placeholder="Masukkan nisn" value="{{ old('nisn') }}">
                                    @error('nisn', 'create')
                                        <strong class="text-danger error-create" style="font-size: 12px;">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1">Jenis kelamin <span class="text-danger" style="font-size: larger;">*</span></label>
                                    <select id="gender" name="gender" class="form-select rounded-input select-icon">
                                        <option value="" selected>Pilih...</option>
                                        <option value="male">Laki-Laki</option>
                                        <option value="female">Perempuan</option>
                                    </select>
                                    @error('gender', 'create')
                                        <strong class="text-danger error-create" style="font-size: 12px;">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1">Agama <span class="text-danger" style="font-size: larger;">*</span></label>
                                    <select id="religion" name="religion_id" class="form-select rounded-input select-icon">
                                        <option selected>Pilih...</option>
                                        @forelse ($religions as $religion)
                                            <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                        @empty
                                            <option disabled>Tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                    @error('religion_id', 'create')
                                        <strong class="text-danger error-create" style="font-size: 12px;">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="birth_date" class="mb-1">Tanggal Lahir <span class="text-danger" style="font-size: larger;">*</span></label>
                                    <input type="date" name="birth_date" class="form-control rounded-input" value="{{ old('birth_date') }}">
                                    @error('birth_date', 'create')
                                        <strong class="text-danger error-create" style="font-size: 12px;">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="birth_place" class="mb-1">Tempat Lahir <span class="text-danger" style="font-size: larger;">*</span></label>
                                    <input type="text" name="birth_place" class="form-control rounded-input" placeholder="Masukkan tempat lahir" value="{{ old('birth_place') }}">
                                    @error('birth_place', 'create')
                                        <strong class="text-danger error-create" style="font-size: 12px;">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik" class="mb-1">NIK <span class="text-danger" style="font-size: larger;">*</span></label>
                                    <input type="number" name="nik" class="form-control rounded-input" placeholder="Masukkan nik" value="{{ old('nik') }}">
                                    @error('nik', 'create')
                                        <strong class="text-danger error-create" style="font-size: 12px;">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3 mx-4 pb-3">
                        <button type="button" class="btn btn-primary next-add-step" style="background:#098FC6; border-color:#098FC6;">Berikutnya</button>
                    </div>
                </section>

                <section style="display:none;">
                    <div class="modal-body mx-3" style="max-height: 70vh; overflow-y: auto;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="number_kk" class="mb-1">Nomor KK <span class="text-danger" style="font-size: larger;">*</span></label>
                                    <input type="number" name="number_kk" class="form-control rounded-input" placeholder="Masukkan nomer kk" value="{{ old('number_kk') }}">
                                    @error('number_kk', 'create')
                                        <strong class="text-danger error-create" style="font-size: 12px;">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="number_akta" class="mb-1">Nomor Akta <span class="text-danger" style="font-size: larger;">*</span></label>
                                    <input type="text" name="number_akta" class="form-control rounded-input" placeholder="Masukkan nomer akta" value="{{ old('number_akta') }}">
                                    @error('number_akta', 'create')
                                        <strong class="text-danger error-create" style="font-size: 12px;">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="mb-1">Email <span class="text-danger" style="font-size: larger;">*</span></label>
                                    <input type="text" name="email" class="form-control rounded-input" placeholder="Masukkan email" value="{{ old('email') }}">
                                    @error('email', 'create')
                                        <strong class="text-danger error-create" style="font-size: 12px;">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="order_child" class="mb-1">Anak Ke- <span class="text-danger" style="font-size: larger;">*</span></label>
                                    <input type="number" name="order_child" class="form-control rounded-input" placeholder="Anak ke-" value="{{ old('order_child') }}">
                                    @error('order_child', 'create')
                                        <strong class="text-danger error-create" style="font-size: 12px;">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="count_siblings" class="mb-1">Jumlah Saudara <span class="text-danger" style="font-size: larger;">*</span></label>
                                    <input type="number" name="count_siblings" class="form-control rounded-input" placeholder="Jumlah saudara" value="{{ old('count_siblings') }}">
                                    @error('count_siblings', 'create')
                                        <strong class="text-danger error-create" style="font-size: 12px;">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3 form-group">
                                    <label for="address" class="mb-1">Alamat <span class="text-danger" style="font-size: larger;">*</span></label>
                                    <textarea placeholder="Masukkan alamat" name="address" id="address" class="form-control rounded-input">{{ old('address') }}</textarea>
                                    @error('address', 'create')
                                        <strong class="text-danger error-create" style="font-size: 12px;">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3 mx-4 pb-3">
                        <button type="button" class="btn btn-light prev-add-step ms-2" style="border-color:#DCE9EF;">Kembali</button>
                        <button type="submit" class="btn ms-2" style="background:#098FC6; border-color:#098FC6; color:white;">Simpan</button>
                    </div>
                </section>
            </form>
        </div>
    </div>
</div>

<style>
    .rounded-input { border-radius: 10px; background: #F6F9FB; border: 1px solid rgba(0,0,0,0.06); }
    .select-icon {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg width='16' height='16' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M7 10l5 5 5-5z' fill='%23098FC6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 36px;
        background-color: #F6F9FB;
    }
    #drop-zone-add-student { transition: all 0.3s ease; }
    #drop-zone-add-student:hover { border-color: #098FC6; background: #EEF9FF; }
    #drop-zone-add-student:hover #drop-zone-overlay-add-student { opacity: 1 !important; }
    #drop-zone-add-student:hover #drop-zone-initial-icon-add-student { opacity: 0; }
    #drop-zone-add-student.drag-over { border-color: #098FC6; background: #EEF9FF; }
    #drop-zone-add-student.drag-over #drop-zone-overlay-add-student { opacity: 1 !important; }
    #drop-zone-add-student.drag-over #drop-zone-initial-icon-add-student { opacity: 0; }
    .btn-close-white { filter: invert(1) brightness(2); }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if ($errors->hasBag('create') && $errors->count() > 0)
            const modal = new bootstrap.Modal(document.getElementById('create-student'));
            modal.show();
        @endif

        const form = document.getElementById('form-create-student');
        const sections = Array.from(form.querySelectorAll('section'));
        let current = 0;

        function initializeSections() {
            sections.forEach((s, i) => {
                s.style.display = i === 0 ? 'block' : 'none';
            });
        }

        function show(idx) {
            sections.forEach((s, i) => {
                s.style.display = i === idx ? 'block' : 'none';
            });
        }

        initializeSections();

        document.querySelectorAll('.next-add-step').forEach(btn => btn.addEventListener('click', function () {
            if (current < sections.length - 1) { 
                current++; 
                show(current); 
                window.scrollTo(0, 0); 
            }
        }));

        document.querySelectorAll('.prev-add-step').forEach(btn => btn.addEventListener('click', function () {
            if (current > 0) { 
                current--; 
                show(current); 
                window.scrollTo(0, 0); 
            }
        }));

        const dropZone = document.getElementById('drop-zone-add-student');
        const fileInput = document.getElementById('imageInputCreate');
        if (dropZone && fileInput) {
            dropZone.addEventListener('click', () => fileInput.click());
            ['dragenter', 'dragover'].forEach(evt => dropZone.addEventListener(evt, e => { 
                e.preventDefault(); 
                dropZone.classList.add('drag-over'); 
            }));
            ['dragleave', 'dragend', 'drop'].forEach(evt => dropZone.addEventListener(evt, e => { 
                e.preventDefault(); 
                dropZone.classList.remove('drag-over'); 
            }));
            dropZone.addEventListener('drop', function (e) {
                const files = e.dataTransfer.files;
                if (files && files.length) {
                    const dt = new DataTransfer();
                    for (let i = 0; i < files.length; i++) dt.items.add(files[i]);
                    fileInput.files = dt.files;
                    previewCreateStudentImage({ target: fileInput });
                }
            });
        }

        const classSelect = document.getElementById('classroom_id');
        const baseUrl = '{{ url("school/students") }}';

        if (classSelect) {
            const setFormAction = (classroomId) => {
                if (classroomId) {
                    form.action = baseUrl + '/' + classroomId;
                } else {
                    form.action = '#';
                }
            };

            if (classSelect.value) {
                setFormAction(classSelect.value);
            }

            classSelect.addEventListener('change', function() {
                setFormAction(this.value);
            });
        }

        form.addEventListener('submit', function (e) {
            const classroomId = classSelect ? classSelect.value : null;
            if (!classroomId || classroomId === '') {
                e.preventDefault();
                alert('Silakan pilih Kelas terlebih dahulu sebelum menyimpan.');
                sections.forEach((s, i) => s.style.display = i === 0 ? 'block' : 'none');
                current = 0;
                return false;
            }
            form.action = baseUrl + '/' + classroomId;
        });
    });

    function previewCreateStudentImage(e) {
        const input = e.target;
        if (input.files && input.files[0]) {
            const url = URL.createObjectURL(input.files[0]);
            const preview = document.getElementById('create-preview-img');
            preview.src = url;
        }
    }
</script>
