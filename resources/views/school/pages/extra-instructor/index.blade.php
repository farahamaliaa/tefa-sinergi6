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

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row mb-3 align-items-center">
                <div class="col-md-2">
                    <div class="position-relative flex-grow-1">
                        <input type="text" name="name" class="form-control product-search ps-5" id="input-search"
                            placeholder="Cari..." value="{{ old('name', request('search')) }}">
                        <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex align-items-center gap-2">
                        <select class="form-select" id="filterEkskul">
                            <option value="">Ekstrakurikuler</option>
                            @foreach ($extracurriculars as $eskul)
                                <option value="{{ $eskul->name }}">{{ $eskul->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn text-white" style="background-color: #0993CD;" id="filterBtn">Filter</button>
                    </div>
                </div>
                <div class="col-md-8 text-end">
                    {{-- <a href="{{ route('school.extra-instructor.download-template') }}" class="btn btn-outline-success me-2">
                        <i class="ti ti-download"></i> Template
                    </a> --}}
                    <button class="btn btn-import me-2" data-bs-toggle="modal" data-bs-target="#importInstructorModal">
                        <svg width="20" height="25" viewBox="0 0 28 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M13.7699 8.92256V23.1726M13.7699 8.92256L18.5199 13.6726M13.7699 8.92256L9.0199 13.6726M22.4782 16.8392C24.8833 16.8392 26.4366 14.8901 26.4366 12.4851C26.4365 11.5329 26.1243 10.607 25.5478 9.84915C24.9712 9.09133 24.1622 8.54338 23.2446 8.28923C23.1034 6.51346 22.3674 4.8372 21.1557 3.53146C19.9439 2.22573 18.3272 1.36684 16.5669 1.09366C14.8066 0.820475 13.0056 1.14897 11.4551 2.02602C9.90454 2.90308 8.69515 4.27744 8.0224 5.9269C6.60599 5.53427 5.09162 5.72038 3.81244 6.44431C2.53325 7.16823 1.59403 8.37065 1.2014 9.78707C0.808771 11.2035 0.994888 12.7178 1.71881 13.997C2.44273 15.2762 3.64516 16.2154 5.06157 16.6081"
                                stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg> Import
                    </button>
                    <button class="btn text-white" style="background-color: #0993CD;" data-bs-toggle="modal"
                        data-bs-target="#createInstructorModal">
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
                            <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">
                                Ekstrakurikuler</th>
                            <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">Email</th>
                            <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">No HP</th>
                            <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="instructor-table-body" style="background-color: white;">
                        @forelse($pembinas as $index => $pembina)
                            <tr>
                                <td>{{ $pembinas->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $pembina->employee?->image && Storage::exists($pembina->employee->image) ? asset('storage/' . $pembina->employee->image) : asset('assets/images/default-user.jpeg') }}"
                                            alt="avatar" class="rounded-circle me-2"
                                            style="width: 40px; height: 40px; object-fit: cover;">
                                        <div>
                                            <div class="fw-semibold">{{ $pembina->name }}</div>
                                            <small
                                                class="text-muted">{{ $pembina->employee?->gender?->label() ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($pembina->employee && $pembina->employee->extracurriculars->count() > 0)
                                        @foreach ($pembina->employee->extracurriculars as $eskul)
                                            <span class="badge bg-light-primary text-primary">{{ $eskul->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $pembina->email }}</td>
                                <td>{{ $pembina->employee?->phone_number ?? '-' }}</td>
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
                                                    data-image="{{ $pembina->employee?->image && Storage::exists($pembina->employee->image) ? asset('storage/' . $pembina->employee->image) : asset('assets/images/default-user.jpeg') }}"
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
                                                <button type="button" data-id="{{ $pembina->id }}"
                                                    data-name="{{ $pembina->name }}" data-email="{{ $pembina->email }}"
                                                    data-phone="{{ $pembina->employee?->phone_number }}"
                                                    data-gender="{{ $pembina->employee?->gender?->value ?? 'male' }}"
                                                    data-address="{{ $pembina->employee?->address }}"
                                                    data-extracurriculars="{{ $pembina->employee ? $pembina->employee->extracurriculars->pluck('id')->join(',') : '' }}"
                                                    class="dropdown-item d-flex align-items-center gap-3 btn-edit-pembina">
                                                    <i class="fs-4 ti ti-pencil"></i>Edit
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button" onclick="deleteInstructor('{{ $pembina->id }}')"
                                                    class="dropdown-item d-flex align-items-center gap-3 text-danger">
                                                    <i class="fs-4 ti ti-trash"></i>Hapus
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}"
                                            alt="" width="150px">
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

            @if ($pembinas->count() > 0)
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Menampilkan {{ $pembinas->firstItem() }} - {{ $pembinas->lastItem() }} dari
                        {{ $pembinas->total() }}
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
                <div class="modal-header" style="background-color: #0993CD;">
                    <h5 class="modal-title text-white">Detail Pembina</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
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

    @include('school.pages.extra-instructor.widgets.create-instructor')

    <div class="modal fade" id="editInstructorModal" tabindex="-1" aria-labelledby="editInstructorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #FFC107; color: white;">
                    <h5 class="modal-title text-white" id="editInstructorModalLabel">Edit Pembina Ekstrakurikuler</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editInstructorForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_image" class="form-label">Foto Profil</label>
                                <input type="file" class="form-control" id="edit_image" name="image"
                                    accept="image/*">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
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
                                <label for="edit_phone_number" class="form-label">Nomor HP</label>
                                <input type="tel" class="form-control" id="edit_phone_number" name="phone_number"
                                    pattern="[0-9]*" inputmode="numeric" maxlength="13">
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
                                <select class="form-select" id="edit_extracurricular_ids" name="extracurricular_ids[]"
                                    multiple size="4">
                                    @foreach ($extracurriculars as $eskul)
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

    @include('school.pages.extra-instructor.widgets.import-instructor')

    <x-delete-modal-component />

@endsection

@section('script')
    <script>
        // Detail button handler
        document.querySelectorAll('.btn-detail-pembina').forEach(function(button) {
            button.addEventListener('click', function() {
                document.getElementById('detail-image').src = this.dataset.image;
                document.getElementById('detail-name').textContent = this.dataset.name;
                document.getElementById('detail-email').textContent = this.dataset.email;
                document.getElementById('detail-phone').textContent = this.dataset.phone || '-';
                document.getElementById('detail-gender').textContent = this.dataset.gender;
                document.getElementById('detail-address').textContent = this.dataset.address || '-';
                document.getElementById('detail-extracurriculars').textContent = this.dataset
                    .extracurriculars || '-';

                var modal = new bootstrap.Modal(document.getElementById('modal-detail-pembina'));
                modal.show();
            });
        });

        // Edit button handler
        document.querySelectorAll('.btn-edit-pembina').forEach(function(button) {
            button.addEventListener('click', function() {
                var id = this.dataset.id;
                var form = document.getElementById('editInstructorForm');
                form.action = "{{ url('school/extra-instructor') }}/" + id;

                document.getElementById('edit_name').value = this.dataset.name;
                document.getElementById('edit_email').value = this.dataset.email;
                document.getElementById('edit_phone_number').value = this.dataset.phone || '';
                document.getElementById('edit_gender').value = this.dataset.gender;
                document.getElementById('edit_address').value = this.dataset.address || '';

                // Set selected extracurriculars
                var eskulIds = this.dataset.extracurriculars ? this.dataset.extracurriculars.split(',') :
            [];
                var selectElement = document.getElementById('edit_extracurricular_ids');
                for (var i = 0; i < selectElement.options.length; i++) {
                    selectElement.options[i].selected = eskulIds.includes(selectElement.options[i].value);
                }

                var modal = new bootstrap.Modal(document.getElementById('editInstructorModal'));
                modal.show();
            });
        });

        // Delete function
        function deleteInstructor(id) {
            const form = document.getElementById('form-delete');
            form.action = `/school/extra-instructor/${id}`;

            const modal = new bootstrap.Modal(document.getElementById('modal-delete'));
            modal.show();
        }

        // Filter functionality
        document.getElementById('filterBtn').addEventListener('click', function() {
            var search = document.getElementById('input-search').value;
            var eskul = document.getElementById('filterEkskul').value;
            var url = new URL(window.location.href);

            if (search) url.searchParams.set('search', search);
            else url.searchParams.delete('search');

            if (eskul) url.searchParams.set('eskul', eskul);
            else url.searchParams.delete('eskul');

            window.location.href = url.toString();
        });

        // Enter key for search
        document.getElementById('input-search').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('filterBtn').click();
            }
        });
    </script>
@endsection
