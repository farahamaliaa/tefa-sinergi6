<style>
    .card {
        border: 1px solid #E0E6ED !important; 
        box-shadow: none !important;
    }

    .card-hover:hover {
        border-color: #00A9D9 !important;
        transition: .2s ease-in-out;
    }

    .card.header-wave {
        border-radius: 14px !important;
        overflow: hidden !important;
    }

    .nav-pills .nav-link:hover {
        background-color: #0A8ABF20;
        color: #098FC6;
    }
    .header-wave {
        background-color: #1A94C8 !important;
        border-radius: 14px;
        position: relative;
        overflow: hidden;
    }

    .header-wave::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 256px;
        background: url("{{ asset('assets/images/wave-header.png') }}");
        background-size: cover;
        opacity: 1;
    }
</style>

@extends('school.layouts.app')

@section('content')

    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Orang Tua</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    Daftar - orang ua
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n3">
                        <img src="{{ asset('assets/images/background/book.png') }}" alt=""
                            class="img-fluid img-header-floating">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card mt-4">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-semibold mb-2 text-dark">Daftar Orang Tua</h4>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="row mb-3 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="ti ti-search"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Cari" id="searchInput">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterKelas">
                    <option value="">Kelas</option>
                    <option value="XI RPL 1">XI RPL 1</option>
                </select>
            </div>
            <div class="col-md-5 text-end">
                <a href="{{ route('school.parent.download-template') }}" class="btn btn-outline-success me-2">
                    <i class="ti ti-download"></i> Template
                </a>
                <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#importParentModal">
                    <i class="ti ti-file-import"></i> Import
                </button>
                <button class="btn text-white" style="background-color: #0993CD;" data-bs-toggle="modal" data-bs-target="#createParentModal">
                    <i class="ti ti-plus"></i> Tambah Orang Tua
                </button>
            </div>
        </div>

        <div class="table-responsive rounded-2">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">No</th>
                        <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">Nama Orang Tua</th>
                        <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">Nama Anak</th>
                        <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">Jurusan/Kelas</th>
                        <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">Nomor HP</th>
                        <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="parent-table-body" style="background-color: white;">
                    @forelse($parents as $parent)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $parent->user->image ? asset('storage/' . $parent->user->image) : asset('admin_assets/dist/images/profile/user-1.jpg') }}" alt="avatar" 
                                     class="rounded-circle me-2" 
                                     style="width: 40px; height: 40px; object-fit: cover;">
                                <div>
                                    <div class="fw-semibold">{{ $parent->user->name }}</div>
                                    <small class="text-muted">{{ $parent->user->gender}}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            {{ $parent->students->map(fn($s) => $s->user ? $s->user->name : $s->name)->implode(', ') }}
                        </td>
                        <td>
                            {{ $parent->students->map(fn($s) => $s->classroomStudents->first()?->classroom?->name)->unique()->filter()->implode(', ') }}
                        </td>
                        <td>{{ $parent->phone_number ?? '-' }}</td>
                        <td>
                            <button class="btn btn-sm me-1" style="background-color: rgba(9, 147, 205, 0.1); color: #0993CD; border: none;" title="Lihat">
                                <i class="ti ti-eye"></i>
                            </button>
                            <button class="btn btn-sm me-1" style="background-color: rgba(255, 193, 7, 0.1); color: #ffc107; border: none;" title="Edit">
                                <i class="ti ti-pencil"></i>
                            </button>
                            <button class="btn btn-sm" style="background-color: rgba(220, 53, 69, 0.1); color: #dc3545; border: none;" title="Hapus">
                                <i class="ti ti-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data orang tua</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Create Parent -->
<div class="modal fade" id="createParentModal" tabindex="-1" aria-labelledby="createParentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0993CD; color: white;">
                <h5 class="modal-title text-white" id="createParentModalLabel">Tambah Data Orang Tua</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('school.parent.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3 text-center">
                            <div class="position-relative d-inline-block">
                                <img id="create-preview-img" src="{{ asset('assets/images/default-user.jpeg') }}" alt="Preview" class="rounded-circle object-fit-cover" style="width: 150px; height: 150px; object-fit: cover; border: 2px solid #ddd;">
                                <label for="image" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 cursor-pointer" style="cursor: pointer;">
                                    <i class="ti ti-camera"></i>
                                    <input type="file" class="d-none" id="image" name="image" accept="image/*" onchange="previewCreateImage(event)">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" required placeholder="Masukkan nama lengkap">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="Masukkan email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Masukkan password">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone_number" class="form-label">Nomor HP</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" required placeholder="Masukkan nomor HP">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="students" class="form-label">Pilih Siswa (Anak)</label>
                            <select class="form-select" id="students" name="students[]" size="5" multiple style="height: 150px;">
                                @foreach($students as $student)
                                    <option value="{{ $student['id'] }}">{{ $student['name'] }} - {{ $student['classroom'] }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Tahan CTRL untuk memilih lebih dari satu anak.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white" style="background-color: #0993CD;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editParentModal" tabindex="-1" aria-labelledby="editParentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc107; color: white;">
                <h5 class="modal-title text-white" id="editParentModalLabel">Edit Data Orang Tua</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editParentForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                         <div class="col-12 mb-3 text-center">
                            <div class="position-relative d-inline-block">
                                <img id="edit-preview-img" src="" alt="Preview" class="rounded-circle object-fit-cover" style="width: 150px; height: 150px; object-fit: cover; border: 2px solid #ddd;">
                                <label for="edit_image" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 cursor-pointer" style="cursor: pointer;">
                                    <i class="ti ti-pencil"></i>
                                    <input type="file" class="d-none" id="edit_image" name="image" accept="image/*" onchange="previewEditImage(event)">
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                         <div class="col-md-6 mb-3">
                            <label for="edit_password" class="form-label">Password (Kosongkan jika tidak diubah)</label>
                            <input type="password" class="form-control" id="edit_password" name="password">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_phone_number" class="form-label">Nomor HP</label>
                            <input type="text" class="form-control" id="edit_phone_number" name="phone_number" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_gender" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="edit_gender" name="gender" required>
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                        </div>
                         <div class="col-md-6 mb-3">
                            <label for="edit_students" class="form-label">Pilih Siswa (Anak)</label>
                            <select class="form-select" id="edit_students" name="students[]" size="5" multiple style="height: 150px;">
                                @foreach($students as $student)
                                    <option value="{{ $student['id'] }}">{{ $student['name'] }} - {{ $student['classroom'] }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Tahan CTRL untuk memilih lebih dari satu anak.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white" style="background-color: #0993CD;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete Parent -->
<div class="modal fade" id="deleteParentModal" tabindex="-1" aria-labelledby="deleteParentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
             <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteParentModalLabel">Hapus Data Orang Tua</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteParentForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center">
                    <i class="ti ti-alert-circle text-danger display-1"></i>
                    <p class="mt-3">Apakah Anda yakin ingin menghapus data orang tua ini? Data yang dihapus tidak dapat dikembalikan.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus!</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="importParentModal" tabindex="-1" aria-labelledby="importParentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #198754; color: white;">
                <h5 class="modal-title text-white" id="importParentModalLabel">Import Data Orang Tua</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('school.parent.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>Format Excel:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Kolom: Nama Orang Tua, Email, Password, Jenis Kelamin, Nomor HP, Nama Anak</li>
                            <li>Jika 1 orang tua punya beberapa anak, buat baris terpisah untuk setiap anak</li>
                            <li>Baris ke-2 dst dengan orang tua sama, cukup isi Nama Orang Tua dan Nama Anak (email kosong)</li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <label for="importFile" class="form-label">Pilih File Excel</label>
                        <input type="file" class="form-control" id="importFile" name="file" accept=".xlsx,.xls,.csv" required>
                        <small class="text-muted">Format: .xlsx, .xls, .csv (max 10MB)</small>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('school.parent.download-template') }}" class="btn btn-outline-success btn-sm">
                            <i class="ti ti-download"></i> Download Template
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="ti ti-file-import"></i> Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewCreateImage(event) {
        const file = event.target.files[0];
        if (file) {
            document.getElementById('create-preview-img').src = URL.createObjectURL(file);
        }
    }

    function previewEditImage(event) {
        const file = event.target.files[0];
        if (file) {
            document.getElementById('edit-preview-img').src = URL.createObjectURL(file);
        }
    }

    function editParent(data) {
        const parent = JSON.parse(decodeURIComponent(data));
        
        document.getElementById('edit_name').value = parent.name;
        document.getElementById('edit_email').value = parent.email;
        document.getElementById('edit_phone_number').value = parent.phone_number;
        document.getElementById('edit_gender').value = parent.gender;
        
        const studentSelect = document.getElementById('edit_students');
        Array.from(studentSelect.options).forEach(option => {
            option.selected = parent.student_ids.includes(parseInt(option.value));
        });

        const previewImg = document.getElementById('edit-preview-img');
        if (parent.image) {
            previewImg.src = "{{ asset('storage') }}/" + parent.image;
        } else {
             previewImg.src = "{{ asset('assets/images/default-user.jpeg') }}";
        }
        
        const form = document.getElementById('editParentForm');
        form.action = `/school/parent/${parent.id}`;
        
        const modal = new bootstrap.Modal(document.getElementById('editParentModal'));
        modal.show();
    }

    function deleteParent(id) {
         const form = document.getElementById('deleteParentForm');
         form.action = `/school/parent/${id}`;
         
         const modal = new bootstrap.Modal(document.getElementById('deleteParentModal'));
         modal.show();
    }

    setInterval(function() {
        fetch("{{ route('school.parent.index') }}", {
            headers: {
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            }
        })
        .then(response => response.json())
        .then(data => {
            let tbody = document.getElementById('parent-table-body');
            tbody.innerHTML = '';
            
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center">Tidak ada data orang tua</td></tr>';
                return;
            }

            data.forEach((parent, index) => {
                let userImage = parent.user && parent.user.image ? "{{ asset('storage') }}/" + parent.user.image : "{{ asset('admin_assets/dist/images/profile/user-1.jpg') }}";
                let genderLabel = parent.user && parent.user.gender == 'male' ? 'Laki-laki' : 'Perempuan';
                let userName = parent.user ? parent.user.name : '-';
                let userEmail = parent.user ? parent.user.email : '';
                let userGender = parent.user ? parent.user.gender : '';
                let userImageRaw = parent.user ? parent.user.image : null;
                
                let studentNames = parent.students.map(s => s.user ? s.user.name : s.name).join(', ');
                let studentIds = parent.students.map(s => s.id);
                
                let classrooms = [];
                if(parent.students) {
                    parent.students.forEach(s => {
                        if(s.classroom_students && s.classroom_students.length > 0) {
                            if(s.classroom_students[0].classroom) {
                                let cName = s.classroom_students[0].classroom.name;
                                if(!classrooms.includes(cName)) classrooms.push(cName);
                            }
                        }
                    });
                }
                let classroomStr = classrooms.join(', ');

                let phone = parent.phone_number || '-';

                let editData = {
                    id: parent.id,
                    name: userName,
                    email: userEmail,
                    phone_number: parent.phone_number,
                    gender: userGender,
                    image: userImageRaw,
                    student_ids: studentIds
                };
                let editDataStr = encodeURIComponent(JSON.stringify(editData));

                let row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="${userImage}" alt="avatar" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                <div>
                                    <div class="fw-semibold">${userName}</div>
                                    <small class="text-muted">${genderLabel}</small>
                                </div>
                            </div>
                        </td>
                        <td>${studentNames}</td>
                        <td>${classroomStr}</td>
                        <td>${phone}</td>
                        <td>
                             <button class="btn btn-sm me-1" style="background-color: rgba(9, 147, 205, 0.1); color: #0993CD; border: none;" title="Lihat">
                                <i class="ti ti-eye"></i>
                            </button>
                            <button class="btn btn-sm me-1" style="background-color: rgba(255, 193, 7, 0.1); color: #ffc107; border: none;" title="Edit" 
                                onclick="editParent('${editDataStr}')">
                                <i class="ti ti-pencil"></i>
                            </button>
                            <button class="btn btn-sm" style="background-color: rgba(220, 53, 69, 0.1); color: #dc3545; border: none;" title="Hapus"
                                onclick="deleteParent('${parent.id}')">
                                <i class="ti ti-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        })
        .catch(error => console.error('Error fetching parents:', error));
    }, 5000);
</script>
@endsection