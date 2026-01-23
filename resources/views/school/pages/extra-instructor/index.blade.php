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

    .btn-action {
        border: none !important;
        border-radius: 8px !important;
        padding: 6px 8px !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-detail-action {
        background-color: #0dcaf0 !important;
        color: #fff !important;
    }

    .btn-detail-action:hover {
        background-color: #0bb5d8 !important;
    }

    .btn-edit-action {
        background-color: #FFC107 !important;
        color: #fff !important;
    }

    .btn-edit-action:hover {
        background-color: #e6ae06 !important;
    }

    .btn-delete-action {
        background-color: #DC3545 !important;
        color: #fff !important;
    }

    .btn-delete-action:hover {
        background-color: #bb2d3b !important;
    }
</style>

@extends('school.layouts.app')

@section('content')

    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Pembina Ekstrakurikuler</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    Daftar pembina ekstrakurikuler
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
                    <h4 class="fw-semibold mb-2 text-dark">Daftar Pembina Ekstrakurikuler</h4>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-6">
                    <form action="{{ route('school.extra-instructor.index') }}" method="GET">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="ti ti-search"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Cari nama pembina..."
                                name="search" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('school.extra-instructor.download-template') }}" class="btn btn-outline-success me-2">
                        <i class="ti ti-download"></i> Template
                    </a>
                    <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#importInstructorModal">
                        <i class="ti ti-file-import"></i> Import
                    </button>
                    <button class="btn text-white" style="background-color: #0993CD;" data-bs-toggle="modal" data-bs-target="#createInstructorModal">
                        <i class="ti ti-plus"></i> Tambah Pembina
                    </button>
                </div>
            </div>


            <div class="table-responsive rounded-2">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">No</th>
                            <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">Nama
                                Pembina</th>
                            <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">Email</th>
                            <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">
                                Ekstrakurikuler</th>
                            <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">No HP</th>
                            <!-- <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">Status -->
                            </th>
                            <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: white;">
                        @forelse($pembinas as $index => $pembina)
                            <tr>
                                <td>{{ $pembinas->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $pembina->employee?->image ? asset('storage/' . $pembina->employee->image) : asset('assets/images/default-user.jpeg') }}"
                                            alt="avatar" class="rounded-circle me-2"
                                            style="width: 40px; height: 40px; object-fit: cover;">
                                        <div>
                                            <div class="fw-semibold">{{ $pembina->name }}</div>
                                            <small class="text-muted">{{ $pembina->employee?->gender?->label() ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $pembina->email }}</td>
                                <td>
                                    @if($pembina->employee && $pembina->employee->extracurriculars->count() > 0)
                                        @foreach($pembina->employee->extracurriculars as $eskul)
                                            <span class="badge bg-light-primary text-primary">{{ $eskul->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $pembina->employee?->phone_number ?? '-' }}</td>
                                <!-- <td>
                                    @if($pembina->employee?->status == 'active' || $pembina->employee?->status == 1)
                                        <span class="badge bg-light-success text-success">Aktif</span>
                                    @else
                                        <span class="badge bg-light-danger text-danger">Nonaktif</span>
                                    @endif
                                </td> -->
                                <td>
                                    <div class="dropdown dropstart">
                                        <a href="#" class="text-muted" id="dropdownMenuButton{{ $pembina->id }}"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <div class="category">
                                                <div class="category-business"></div>
                                                <div class="category-social"></div>
                                                <span class="more-options text-dark">
                                                    <i class="ti ti-dots-vertical fs-5"></i>
                                                </span>
                                            </div>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $pembina->id }}"
                                            style="z-index: 20000;">
                                            <li>
                                                <button type="button"
                                                    data-image="{{ $pembina->employee?->image ? asset('storage/' . $pembina->employee->image) : asset('assets/images/default-user.jpeg') }}"
                                                    data-name="{{ $pembina->name }}" data-email="{{ $pembina->email }}"
                                                    data-phone="{{ $pembina->employee?->phone_number }}"
                                                    data-gender="{{ $pembina->employee?->gender?->label() ?? '-' }}"
                                                    data-address="{{ $pembina->employee?->address }}"
                                                    data-extracurriculars="{{ $pembina->employee ? $pembina->employee->extracurriculars->pluck('name')->join(', ') : '-' }}"
                                                    class="dropdown-item d-flex align-items-center gap-3 btn-detail-pembina">
                                                    <i class="fs-4 ti ti-eye"></i>Detail
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button"
                                                    data-id="{{ $pembina->id }}"
                                                    data-name="{{ $pembina->name }}"
                                                    data-email="{{ $pembina->email }}"
                                                    data-phone="{{ $pembina->employee?->phone_number }}"
                                                    data-gender="{{ $pembina->employee?->gender?->value ?? 'male' }}"
                                                    data-address="{{ $pembina->employee?->address }}"
                                                    data-extracurriculars="{{ $pembina->employee ? $pembina->employee->extracurriculars->pluck('id')->join(',') : '' }}"
                                                    class="dropdown-item d-flex align-items-center gap-3 btn-edit-pembina">
                                                    <i class="fs-4 ti ti-pencil"></i>Edit
                                                </button>
                                            </li>
                                            <li>
                                                <form action="{{ route('school.extra-instructor.destroy', $pembina->id) }}" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pembina ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item d-flex align-items-center gap-3 text-danger">
                                                        <i class="fs-4 ti ti-trash"></i>Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt=""
                                            width="150px">
                                        <p class="fs-5 text-dark text-center mt-2">
                                            Belum ada pembina ekstrakurikuler
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($pembinas->count() > 0)
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Menampilkan {{ $pembinas->firstItem() }} - {{ $pembinas->lastItem() }} dari {{ $pembinas->total() }}
                        data
                    </div>
                    <div>
                        {{ $pembinas->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Detail Pembina -->
    <div class="modal fade" id="modal-detail-pembina" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white">Detail Pembina</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <img id="detail-image" src="" alt="avatar" class="rounded-circle"
                            style="width: 100px; height: 100px; object-fit: cover;">
                    </div>
                    <table class="table table-borderless">
                        <tr>
                            <td class="fw-semibold">Nama</td>
                            <td>:</td>
                            <td id="detail-name"></td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Email</td>
                            <td>:</td>
                            <td id="detail-email"></td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">No HP</td>
                            <td>:</td>
                            <td id="detail-phone"></td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Jenis Kelamin</td>
                            <td>:</td>
                            <td id="detail-gender"></td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Alamat</td>
                            <td>:</td>
                            <td id="detail-address"></td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Ekstrakurikuler</td>
                            <td>:</td>
                            <td id="detail-extracurriculars"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createInstructorModal" tabindex="-1" aria-labelledby="createInstructorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0993CD; color: white;">
                    <h5 class="modal-title text-white" id="createInstructorModalLabel">Tambah Pembina Ekstrakurikuler</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('school.extra-instructor.store') }}" method="POST">
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
                                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Masukkan nomor HP">
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
                                <label for="address" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Masukkan alamat">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="extracurricular_ids" class="form-label">Pilih Ekstrakurikuler</label>
                                <select class="form-select" id="extracurricular_ids" name="extracurricular_ids[]" multiple size="4">
                                    @foreach($extracurriculars as $eskul)
                                        <option value="{{ $eskul->id }}">{{ $eskul->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Tahan CTRL untuk memilih lebih dari satu.</small>
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

    <div class="modal fade" id="editInstructorModal" tabindex="-1" aria-labelledby="editInstructorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #FFC107; color: white;">
                    <h5 class="modal-title text-white" id="editInstructorModalLabel">Edit Pembina Ekstrakurikuler</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editInstructorForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="edit_email" name="email" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_phone_number" class="form-label">Nomor HP</label>
                                <input type="text" class="form-control" id="edit_phone_number" name="phone_number">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_gender" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" id="edit_gender" name="gender" required>
                                    <option value="male">Laki-laki</option>
                                    <option value="female">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="edit_address" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="edit_address" name="address">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="edit_extracurricular_ids" class="form-label">Pilih Ekstrakurikuler</label>
                                <select class="form-select" id="edit_extracurricular_ids" name="extracurricular_ids[]" multiple size="4">
                                    @foreach($extracurriculars as $eskul)
                                        <option value="{{ $eskul->id }}">{{ $eskul->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Tahan CTRL untuk memilih lebih dari satu.</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning text-white">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Import Pembina -->
    <div class="modal fade" id="importInstructorModal" tabindex="-1" aria-labelledby="importInstructorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #198754; color: white;">
                    <h5 class="modal-title text-white" id="importInstructorModalLabel">Import Data Pembina</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('school.extra-instructor.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <strong>Format Excel:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Kolom: Nama Pembina, Email, Password, Jenis Kelamin, Nomor HP, Alamat, Ekstrakurikuler</li>
                            </ul>
                        </div>
                        <div class="mb-3">
                            <label for="importFile" class="form-label">Pilih File Excel</label>
                            <input type="file" class="form-control" id="importFile" name="file" accept=".xlsx,.xls,.csv" required>
                            <small class="text-muted">Format: .xlsx, .xls, .csv (max 10MB)</small>
                        </div>
                        <div class="text-center">
                            <a href="{{ route('school.extra-instructor.download-template') }}" class="btn btn-outline-success btn-sm">
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

@endsection

@section('script')
    <script>
        // Detail button handler
        document.querySelectorAll('.btn-detail-pembina').forEach(function (button) {
            button.addEventListener('click', function () {
                document.getElementById('detail-image').src = this.dataset.image;
                document.getElementById('detail-name').textContent = this.dataset.name;
                document.getElementById('detail-email').textContent = this.dataset.email;
                document.getElementById('detail-phone').textContent = this.dataset.phone || '-';
                document.getElementById('detail-gender').textContent = this.dataset.gender;
                document.getElementById('detail-address').textContent = this.dataset.address || '-';
                document.getElementById('detail-extracurriculars').textContent = this.dataset.extracurriculars || '-';

                var modal = new bootstrap.Modal(document.getElementById('modal-detail-pembina'));
                modal.show();
            });
        });

        // Edit button handler
        document.querySelectorAll('.btn-edit-pembina').forEach(function (button) {
            button.addEventListener('click', function () {
                var id = this.dataset.id;
                var form = document.getElementById('editInstructorForm');
                form.action = "{{ url('school/extra-instructor') }}/" + id;

                document.getElementById('edit_name').value = this.dataset.name;
                document.getElementById('edit_email').value = this.dataset.email;
                document.getElementById('edit_phone_number').value = this.dataset.phone || '';
                document.getElementById('edit_gender').value = this.dataset.gender;
                document.getElementById('edit_address').value = this.dataset.address || '';

                // Set selected extracurriculars
                var eskulIds = this.dataset.extracurriculars ? this.dataset.extracurriculars.split(',') : [];
                var selectElement = document.getElementById('edit_extracurricular_ids');
                for (var i = 0; i < selectElement.options.length; i++) {
                    selectElement.options[i].selected = eskulIds.includes(selectElement.options[i].value);
                }

                var modal = new bootstrap.Modal(document.getElementById('editInstructorModal'));
                modal.show();
            });
        });
    </script>
@endsection
