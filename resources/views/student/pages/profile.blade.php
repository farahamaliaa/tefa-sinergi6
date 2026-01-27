@extends('student.layouts.app')

@section('style')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0896D1;
            --secondary-color: #f5f8fa;
            --text-color: #181c32;
            --muted-color: #a1a5b7;
        }

        body {
            background-color: white;
            font-family: 'Inter', sans-serif;
        }

        .card-custom {
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.05);
            background: #fff;
        }

        .profile-sidebar {
            position: relative;
            overflow: hidden;
            background-image: url("{{ asset('assets/images/background/profile-user-top.png') }}");
            background-repeat: no-repeat;
            background-size: contain;
            background-position: top;
        }

        .profile-img-container {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 2rem auto 1rem;
        }

        .profile-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            color: #0896D1;
            font-weight: 600;
            padding: 0.35rem 1rem;
            border-radius: 50rem;
            font-size: 0.85rem;
            display: inline-block;
            margin-left: 0.5rem;
        }

        .nav-custom .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: var(--muted-color);
            font-weight: 500;
            border-radius: 50rem;
            margin-bottom: 0.5rem;
            transition: all 0.2s ease;
        }

        .nav-custom .nav-link:hover {
            color: var(--primary-color);
            background-color: var(--secondary-color);
        }

        .nav-custom .nav-link.active {
            background-color: var(--primary-color);
            color: white;
            box-shadow: none;
        }

        .nav-custom .nav-link i {
            margin-right: 1rem;
            font-size: 1.25rem;
        }

        .form-control-custom {
            background-color: #f9f9f9;
            border: 1px solid #DDE2E9;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            color: #5e6278;
            font-weight: 500;
            transition: all 0.2s;
        }

        .form-control-custom:focus {
            background-color: #f1faff;
            border-color: #0896D1;
            box-shadow: none;
            color: #181c32;
        }

        .input-group-text-custom {
            background-color: #f9f9f9;
            border: 1px solid #DDE2E9;
            border-left: none;
            border-radius: 0 0.75rem 0.75rem 0;
            padding: 0.75rem 1rem;
            transition: all 0.2s;
        }

        .form-control-custom:focus+.input-group-text-custom {
            background-color: #f1faff;
            border-color: #0896D1;
        }

        .form-control-custom:disabled,
        .form-control-custom[readonly] {
            background-color: #f5f8fa;
            color: #a1a5b7;
        }

        .form-label-custom {
            font-weight: 600;
            color: #181c32;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .btn-edit {
            background-color: #0896D1;
            color: white;
            border-radius: 50rem;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: all 0.2s;
            border: none;
        }

        .btn-edit:hover {
            background-color: #0084cf;
            color: white;
        }

        .decoration {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(0, 158, 247, 0.2);
            z-index: 0;
            pointer-events: none;
        }

        .wave-top-left {
            top: -50px;
            left: -50px;
            width: 200px;
            height: 200px;
        }

        .wave-top-right {
            top: 20px;
            right: -30px;
            width: 150px;
            height: 150px;
            border-color: rgba(0, 158, 247, 0.1);
        }

        .btn-outline-primary:hover {
            background-color: #F5F8FA;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid p-0">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="card card-custom profile-sidebar h-100">
                    <div class="decoration wave-top-left"></div>
                    <div class="decoration wave-top-right"></div>

                    <div class="card-body text-center pt-2">
                        <!-- Read View for Profile Image -->
                        <div id="profile-img-read" class="profile-img-container">
                            <img src="{{ $student->image ? asset('storage/' . $student->image) : asset('assets/images/default-user.jpeg') }}"
                                alt="Profile" class="profile-img">
                        </div>

                        <!-- Edit View for Profile Image -->
                        <div id="profile-img-edit" class="profile-img-container d-none position-relative">
                            <img src="{{ $student->image ? asset('storage/' . $student->image) : asset('assets/images/default-user.jpeg') }}"
                                alt="Profile" class="profile-img" id="preview-image">
                            <label for="image-upload"
                                class="btn btn-primary position-absolute rounded-circle p-0 d-flex justify-content-center align-items-center"
                                style="bottom: 0; right: 0; width: 36px; height: 36px; border: 2px solid white; background-color: #0896D1;">
                                <i class="ti ti-camera fs-5 text-white"></i>
                            </label>
                        </div>

                        <h4 class="fw-bold mb-1 text-dark">{{ $user->name }} <span
                                class="status-badge bg-light-primary">Aktif</span></h4>
                        <p class="text-muted mb-4 fs-3">Siswa</p>

                        <div class="nav flex-column nav-custom text-start mt-4" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill"
                                href="#v-pills-profile" role="tab" aria-selected="true" onclick="cancelEditMode()">
                                <i class="ti ti-user fs-6"></i>
                                Informasi Pribadi
                            </a>
                            <a class="nav-link mt-3" id="v-pills-security-tab" data-bs-toggle="pill"
                                href="#v-pills-security" role="tab" aria-selected="false">
                                <i class="ti ti-lock fs-6"></i>
                                Login & Password
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="d-grid mt-3">
                                @csrf
                                <button type="submit" class="nav-link">
                                    <i class="ti ti-logout fs-6"></i>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="col-lg-9">
                <div class="card card-custom">
                    <div class="card-body p-4 p-md-5">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="tab-content" id="v-pills-tabContent">
                            <!-- Profile/Personal Info Tab -->
                            <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel">
                                <!-- Read Only View -->
                                <div id="profile-read-view">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h3 class="fw-semibold text-dark m-0">Informasi Pribadi</h3>
                                        <button type="button" class="btn btn-edit" id="btn-enable-edit">
                                            <i class="ti ti-edit me-2"></i> Edit
                                        </button>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label-custom">Nama Lengkap</label>
                                            <input type="text" class="form-control form-control-custom"
                                                value="{{ $user->name }}" readonly disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-custom">NISN</label>
                                            <input type="text" class="form-control form-control-custom"
                                                value="{{ $student->nisn ?? '-' }}" readonly disabled>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label-custom">Email</label>
                                            <input type="email" class="form-control form-control-custom"
                                                value="{{ $user->email }}" readonly disabled>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label-custom">NIK</label>
                                            <input type="text" class="form-control form-control-custom"
                                                value="{{ $student->nik ?? '-' }}" readonly disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-custom">Jenis Kelamin</label>
                                            <input type="text" class="form-control form-control-custom"
                                                value="{{ $student->gender?->value == 'male' ? 'Laki-laki' : 'Perempuan' }}"
                                                readonly disabled>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label-custom">Tanggal Lahir</label>
                                            <input type="text" class="form-control form-control-custom"
                                                value="{{ $student->birth_date ? \Carbon\Carbon::parse($student->birth_date)->translatedFormat('d F, Y') : '-' }}"
                                                readonly disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-custom">Tempat Lahir</label>
                                            <input type="text" class="form-control form-control-custom"
                                                value="{{ $student->birth_place ?? '-' }}" readonly disabled>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label-custom">Alamat</label>
                                            <input type="text" class="form-control form-control-custom"
                                                value="{{ $student->address ?? '-' }}" readonly disabled>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label-custom">No. KK</label>
                                            <input type="text" class="form-control form-control-custom"
                                                value="{{ $student->number_kk ?? '-' }}" readonly disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-custom">Agama</label>
                                            <input type="text" class="form-control form-control-custom"
                                                value="{{ $student->religion->name ?? '-' }}" readonly disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-custom">No. Akta</label>
                                            <input type="text" class="form-control form-control-custom"
                                                value="{{ $student->number_akta ?? '-' }}" readonly disabled>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label-custom">Anak ke</label>
                                            <input type="text" class="form-control form-control-custom"
                                                value="{{ $student->order_child ?? '-' }}" readonly disabled>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label-custom">Jumlah Saudara</label>
                                            <input type="text" class="form-control form-control-custom"
                                                value="{{ $student->count_siblings ?? '-' }}" readonly disabled>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit View (Hidden by default) -->
                                <form id="profile-edit-view" action="{{ route('student.profile.update') }}"
                                    method="POST" enctype="multipart/form-data" class="d-none">
                                    @csrf
                                    @method('PUT')

                                    <h3 class="fw-semibold text-dark mb-4">Edit Informasi</h3>

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label-custom">Nama Lengkap <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control form-control-custom"
                                                value="{{ old('name', $user->name) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-custom">NISN</label>
                                            <input type="text" class="form-control form-control-custom"
                                                value="{{ $student->nisn ?? '-' }}" readonly>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label-custom">Email <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control form-control-custom"
                                                value="{{ old('email', $user->email) }}" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label-custom">NIK</label>
                                            <input type="text" class="form-control form-control-custom"
                                                value="{{ $student->nik ?? '-' }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-custom">Jenis Kelamin <span
                                                    class="text-danger">*</span></label>
                                            <select name="gender" class="form-select form-control-custom" required>
                                                <option value="male"
                                                    {{ old('gender', $student->gender?->value) == 'male' ? 'selected' : '' }}>
                                                    Laki-laki</option>
                                                <option value="female"
                                                    {{ old('gender', $student->gender?->value) == 'female' ? 'selected' : '' }}>
                                                    Perempuan</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label-custom">Tanggal Lahir</label>
                                            <input type="date" name="birth_date"
                                                class="form-control form-control-custom"
                                                value="{{ old('birth_date', $student->birth_date ?? '') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-custom">Tempat Lahir</label>
                                            <input type="text" name="birth_place"
                                                class="form-control form-control-custom"
                                                value="{{ old('birth_place', $student->birth_place ?? '') }}">
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label-custom">Alamat</label>
                                            <input type="text" name="address" class="form-control form-control-custom"
                                                value="{{ old('address', $student->address ?? '') }}">
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label-custom">No. KK</label>
                                            <input type="text" class="form-control form-control-custom"
                                                value="{{ $student->number_kk ?? '-' }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-custom">Agama <span
                                                    class="text-danger">*</span></label>
                                            <select name="religion_id" class="form-select form-control-custom" required>
                                                <option value="" disabled>Pilih Agama</option>
                                                @foreach ($religions as $religion)
                                                    <option value="{{ $religion->id }}"
                                                        {{ old('religion_id', $student->religion_id) == $religion->id ? 'selected' : '' }}>
                                                        {{ $religion->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-custom">No. Akta</label>
                                            <input type="text" class="form-control form-control-custom"
                                                value="{{ $student->number_akta ?? '-' }}" readonly>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label-custom">Anak ke</label>
                                            <input type="text" class="form-control form-control-custom"
                                                value="{{ $student->order_child ?? '-' }}" readonly>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label-custom">Jumlah Saudara</label>
                                            <input type="text" class="form-control form-control-custom"
                                                value="{{ $student->count_siblings ?? '-' }}" readonly>
                                        </div>
                                    </div>

                                    <div class="mt-4 d-none">
                                        <label class="form-label-custom">Foto Profil</label>
                                        <input type="file" name="image" class="form-control form-control-custom"
                                            id="image-upload" onchange="previewImage(this)">
                                    </div>

                                    <div class="d-flex gap-3 mt-4">
                                        <button type="button" class="btn btn-outline-primary w-100 py-2 rounded-3"
                                            id="btn-cancel-edit"
                                            style="border-color: var(--primary-color); color: var(--primary-color);">Batalkan
                                            Perubahan</button>
                                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-3"
                                            style="background-color: var(--primary-color); border-color: var(--primary-color);">Simpan
                                            Perubahan</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Security Tab -->
                            <div class="tab-pane fade" id="v-pills-security" role="tabpanel">
                                <form action="{{ route('student.profile.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <h3 class="fw-bold text-dark mb-1">Ubah Kata Sandi</h3>
                                    <p class="text-muted mb-4">Silakan ubah kata sandi Anda</p>

                                    <div class="mb-4 position-relative">
                                        <label class="form-label-custom">Sandi Lama <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" name="current_password"
                                                class="form-control form-control-custom border-end-0"
                                                placeholder="Masukkan Sandi Lama" id="current_password">
                                            <span class="input-group-text input-group-text-custom"
                                                style="cursor: pointer;"
                                                onclick="togglePassword('current_password', this)">
                                                <i class="ti ti-eye-off fs-5 text-muted"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-4 position-relative">
                                        <label class="form-label-custom">Sandi Baru <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" name="password"
                                                class="form-control form-control-custom border-end-0"
                                                placeholder="Masukkan Sandi Baru" id="password">
                                            <span class="input-group-text input-group-text-custom"
                                                style="cursor: pointer;" onclick="togglePassword('password', this)">
                                                <i class="ti ti-eye-off fs-5 text-muted"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-4 position-relative">
                                        <label class="form-label-custom">Konfirmasi Sandi <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" name="password_confirmation"
                                                class="form-control form-control-custom border-end-0"
                                                placeholder="Masukkan Konfirmasi Sandi" id="password_confirmation">
                                            <span class="input-group-text input-group-text-custom"
                                                style="cursor: pointer;"
                                                onclick="togglePassword('password_confirmation', this)">
                                                <i class="ti ti-eye-off fs-5 text-muted"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <h6 class="fw-semibold">Kata Sandi harus mengandung:</h6>
                                        <ul class="text-muted small ps-3 mb-0" style="list-style-type: disc;">
                                            <li class="mb-1">Minimal 8 Karakter</li>
                                            <li class="mb-1">Gunakan kombinasi huruf besar dan kecil</li>
                                            <li class="mb-1">Minimal satu angka</li>
                                            <li class="mb-1">Minimal 1 karakter khusus</li>
                                            <li>Hindari kata yang mudah ditebak</li>
                                        </ul>
                                    </div>

                                    <div class="d-flex gap-3 mt-5">
                                        <button type="button" class="btn btn-outline-primary w-100 py-2 rounded-3"
                                            style="border-color: var(--primary-color); color: var(--primary-color);">Batalkan
                                            Perubahan</button>
                                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-3"
                                            style="background-color: var(--primary-color); border-color: var(--primary-color);">Simpan
                                            Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const readView = document.getElementById('profile-read-view');
            const editView = document.getElementById('profile-edit-view');
            const imgReadView = document.getElementById('profile-img-read');
            const imgEditView = document.getElementById('profile-img-edit');
            const btnEnableEdit = document.getElementById('btn-enable-edit');
            const btnCancelEdit = document.getElementById('btn-cancel-edit');

            if (btnEnableEdit && btnCancelEdit) {
                btnEnableEdit.addEventListener('click', function() {
                    readView.classList.add('d-none');
                    editView.classList.remove('d-none');
                    if (imgReadView && imgEditView) {
                        imgReadView.classList.add('d-none');
                        imgEditView.classList.remove('d-none');
                    }
                });

                btnCancelEdit.addEventListener('click', function() {
                    cancelEditMode();
                });
            }
        });

        function cancelEditMode() {
            const readView = document.getElementById('profile-read-view');
            const editView = document.getElementById('profile-edit-view');
            const imgReadView = document.getElementById('profile-img-read');
            const imgEditView = document.getElementById('profile-img-edit');

            if (readView && editView) {
                editView.classList.add('d-none');
                readView.classList.remove('d-none');
            }
            if (imgReadView && imgEditView) {
                imgEditView.classList.add('d-none');
                imgReadView.classList.remove('d-none');
            }
        }

        function togglePassword(inputId, iconSpan) {
            const input = document.getElementById(inputId);
            const icon = iconSpan.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('ti-eye-off');
                icon.classList.add('ti-eye');
            } else {
                input.type = "password";
                icon.classList.remove('ti-eye');
                icon.classList.add('ti-eye-off');
            }
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
