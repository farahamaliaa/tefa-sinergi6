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

    .btn-import {
        background-color: #1EB196 !important;
        border-color: #1EB196 !important;
        color: #fff !important;
    }

    .btn-import:hover {
        background-color: #1e9c87 !important;
        border-color: #1e9c87 !important;
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
                                    Daftar Data Orang Tua
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
            <div class="col-md-2">
                <div class="position-relative flex-grow-1">
                    <input type="text" name="name" class="form-control product-search ps-5" id="input-search" placeholder="Cari..." value="{{ old('name', request('name')) }}">
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                </div>
            </div>
            <div class="col-md-2">
                <div class="d-flex align-items-center gap-2">
                    <select class="form-select" id="filterKelas">
                        <option value="">Kelas</option>
                        @foreach($students->pluck('classroom')->unique()->sort() as $class)
                            @if($class && $class != 'No Class')
                                <option value="{{ $class }}">{{ $class }}</option>
                            @endif
                        @endforeach
                    </select>
                    <button class="btn text-white" style="background-color: #0993CD;" id="filterBtn">Filter</button>
                </div>
            </div>
            <div class="col-md-8 text-end">
                {{-- <a href="{{ route('school.parent.download-template') }}" class="btn btn-outline-success me-2">
                    <i class="ti ti-download"></i> Template
                </a> --}}
                <button class="btn btn-import me-2" data-bs-toggle="modal" data-bs-target="#importParentModal">
                                        <svg width="20" height="25" viewBox="0 0 28 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.7699 8.92256V23.1726M13.7699 8.92256L18.5199 13.6726M13.7699 8.92256L9.0199 13.6726M22.4782 16.8392C24.8833 16.8392 26.4366 14.8901 26.4366 12.4851C26.4365 11.5329 26.1243 10.607 25.5478 9.84915C24.9712 9.09133 24.1622 8.54338 23.2446 8.28923C23.1034 6.51346 22.3674 4.8372 21.1557 3.53146C19.9439 2.22573 18.3272 1.36684 16.5669 1.09366C14.8066 0.820475 13.0056 1.14897 11.4551 2.02602C9.90454 2.90308 8.69515 4.27744 8.0224 5.9269C6.60599 5.53427 5.09162 5.72038 3.81244 6.44431C2.53325 7.16823 1.59403 8.37065 1.2014 9.78707C0.808771 11.2035 0.994888 12.7178 1.71881 13.997C2.44273 15.2762 3.64516 16.2154 5.06157 16.6081" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>  Import
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
                            <button class="btn btn-sm me-1" style="background-color: rgba(9, 147, 205, 0.1); color: #0993CD; border: none;" title="Lihat"
                                onclick="detailParent('{{ urlencode(json_encode([
                                    'name' => $parent->user->name,
                                    'email' => $parent->user->email,
                                    'phone_number' => $parent->phone_number,
                                    'gender' => $parent->user->gender,
                                    'image' => $parent->user->image,
                                    'student_details' => $parent->students->map(function($s) {
                                        return [
                                            'name' => $s->user ? $s->user->name : $s->name,
                                            'classroom' => $s->classroomStudents->first()?->classroom?->name ?? '-'
                                        ];
                                    })
                                ])) }}')">
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

@include('school.pages.parent.widgets.create-parent')

@include('school.pages.parent.widgets.edit-parent')

<x-delete-modal-component />

@include('school.pages.parent.widgets.import-parent')
@include('school.pages.parent.widgets.detail-parent')

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
         const form = document.getElementById('form-delete');
         form.action = `/school/parent/${id}`;
         
         const modal = new bootstrap.Modal(document.getElementById('modal-delete'));
         modal.show();
    }

    function detailParent(data) {
        const parent = JSON.parse(decodeURIComponent(data));
        
        document.getElementById('detail_name').textContent = parent.name;
        document.getElementById('detail_email').textContent = parent.email;
        document.getElementById('detail_phone_number').textContent = parent.phone_number || '-';
        document.getElementById('detail_gender').textContent = parent.gender === 'male' ? 'Laki-laki' : 'Perempuan';
        
        const previewImg = document.getElementById('detail-preview-img');
        if (parent.image) {
            previewImg.src = "{{ asset('storage') }}/" + parent.image;
        } else {
             previewImg.src = "{{ asset('assets/images/default-user.jpeg') }}";
        }

        const studentsContainer = document.getElementById('detail_students');
        studentsContainer.innerHTML = '';
        
        if (parent.student_details) {
            parent.student_details.forEach(student => {
                const badge = document.createElement('span');
                badge.className = 'badge bg-light text-dark border';
                badge.textContent = `${student.name} (${student.classroom})`;
                studentsContainer.appendChild(badge);
            });
        } else {
             studentsContainer.textContent = '-';
        }

        const modal = new bootstrap.Modal(document.getElementById('detailParentModal'));
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
                
                let studentDetails = [];
                if(parent.students) {
                    parent.students.forEach(s => {
                        let cName = '-';
                        if(s.classroom_students && s.classroom_students.length > 0 && s.classroom_students[0].classroom) {
                            cName = s.classroom_students[0].classroom.name;
                        }
                        studentDetails.push({
                            name: s.user ? s.user.name : s.name,
                            classroom: cName
                        });
                    });
                }
                
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
                    student_ids: studentIds,
                    student_details: studentDetails
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
                             <button class="btn btn-sm me-1" style="background-color: rgba(9, 147, 205, 0.1); color: #0993CD; border: none;" title="Lihat"
                                onclick="detailParent('${editDataStr}')">
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