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
            <form action="{{ route('school.parent.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
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

<script>
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
                
                let studentNames = parent.students.map(s => s.user ? s.user.name : s.name).join(', ');
                
                // Extract unique classrooms
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
                            <button class="btn btn-sm me-1" style="background-color: rgba(255, 193, 7, 0.1); color: #ffc107; border: none;" title="Edit">
                                <i class="ti ti-pencil"></i>
                            </button>
                            <button class="btn btn-sm" style="background-color: rgba(220, 53, 69, 0.1); color: #dc3545; border: none;" title="Hapus">
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