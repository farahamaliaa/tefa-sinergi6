<style>
    .table-custom-header th {
        background-color: #0896D1 !important;
        color: #fff;
    }
    .btn-primary {
        background-color: #0896D1 !important;
        border-color: #0896D1 !important;
    }

    .btn-primary:hover {
        background-color: #067aa7 !important;
        border-color: #067aa7 !important;
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

    .card.card-body {
        box-shadow: none !important;
        border: 1px solid #E0E6ED !important;
        border-radius: 10px !important;
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


<div class="card card-body">
    <h4>Daftar Siswa</h4>
    <div class="row mb-3 mt-3">
        <div class="col-lg-6 col-md-12 mb-3">
            <form class="d-flex flex-column flex-md-row gap-2" action="/school/students">
                <div class="position-relative flex-grow-1">
                    <input type="text" name="name" class="form-control product-search ps-5" id="input-search" placeholder="Cari..." value="{{ old('name', request('name')) }}">
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                </div>
                <div class="d-flex flex-column flex-md-row gap-2">
                    <select name="gender" class="form-select">
                        <option value="">Tampilkan semua</option>
                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <select name="class" class="form-select">
                        <option value="">Pilih Kelas</option>
                        @foreach ($classrooms as $classroom)
                        <option value="{{ $classroom->name }}" {{ request('class') == $classroom->name ? 'selected' : '' }}>{{ $classroom->name }}</option>
                        @endforeach
                    </select>
                    {{-- <div>
                        <button type="submit" class="btn btn-primary btn-md w-100 w-md-auto">Filter</button>
                    </div> --}}
                </div>
            </form>
        </div>
        <div class="col-lg-6 col-md-12 mb-3 d-flex justify-content-md-end align-items-md-center d-none d-lg-flex">
            <a class="btn btn-import w-lg-auto" href="#" data-bs-toggle="modal" data-bs-target="#import-student">
                <svg width="20" height="25" viewBox="0 0 28 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.7699 8.92256V23.1726M13.7699 8.92256L18.5199 13.6726M13.7699 8.92256L9.0199 13.6726M22.4782 16.8392C24.8833 16.8392 26.4366 14.8901 26.4366 12.4851C26.4365 11.5329 26.1243 10.607 25.5478 9.84915C24.9712 9.09133 24.1622 8.54338 23.2446 8.28923C23.1034 6.51346 22.3674 4.8372 21.1557 3.53146C19.9439 2.22573 18.3272 1.36684 16.5669 1.09366C14.8066 0.820475 13.0056 1.14897 11.4551 2.02602C9.90454 2.90308 8.69515 4.27744 8.0224 5.9269C6.60599 5.53427 5.09162 5.72038 3.81244 6.44431C2.53325 7.16823 1.59403 8.37065 1.2014 9.78707C0.808771 11.2035 0.994888 12.7178 1.71881 13.997C2.44273 15.2762 3.64516 16.2154 5.06157 16.6081" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>  Import
            </a>
        </div>

        <!-- untuk tampilan mobile -->
        <div class="col-lg-6 col-md-12 mb-3 d-flex justify-content-md-end align-items-md-center d-lg-none">
            <a class="btn btn-success w-100" href="#" data-bs-toggle="modal" data-bs-target="#import-student">
                <svg width="28" height="25" viewBox="0 0 28 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13.7699 8.92256V23.1726M13.7699 8.92256L18.5199 13.6726M13.7699 8.92256L9.0199 13.6726M22.4782 16.8392C24.8833 16.8392 26.4366 14.8901 26.4366 12.4851C26.4365 11.5329 26.1243 10.607 25.5478 9.84915C24.9712 9.09133 24.1622 8.54338 23.2446 8.28923C23.1034 6.51346 22.3674 4.8372 21.1557 3.53146C19.9439 2.22573 18.3272 1.36684 16.5669 1.09366C14.8066 0.820475 13.0056 1.14897 11.4551 2.02602C9.90454 2.90308 8.69515 4.27744 8.0224 5.9269C6.60599 5.53427 5.09162 5.72038 3.81244 6.44431C2.53325 7.16823 1.59403 8.37065 1.2014 9.78707C0.808771 11.2035 0.994888 12.7178 1.71881 13.997C2.44273 15.2762 3.64516 16.2154 5.06157 16.6081" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                    Import
            </a>
        </div>
    </div>

    @if (session('error_rows'))
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan pada baris berikut:</strong>
            <ul>
                @foreach (session('error_rows') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="table-responsive rounded-3 mb-4">
        <table class="table border text-nowrap customize-table mb-0 align-middle">
            <thead class="text-dark fs-4 table-custom-header">
                <tr class="">
                    <th class="text-white">No</th>
                    <th class="text-white">Nama</th>
                    <th class="text-white">Jenis Kelamin</th>
                    <th class="text-white">NISN</th>
                    <th class="text-white">RFID</th>
                    <th class="text-white">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $student->image ? asset('storage/' . $student->image) : asset('assets/images/default-user.jpeg') }}" class="rounded-circle me-2 user-profile" style="object-fit: cover" width="40" height="40" alt="" />
                                <div class="ms-3">
                                    <h6 class="fs-4 fw-semibold mb-0 text-start">{{ $student->user->name }}</h6>
                                    <span class="fw-normal">{{ $student->classroomStudents->isNotEmpty() ? $student->classroomStudents->first()->classroom->name : 'Tidak dalam kelas' }}</span>
                                </div>
                            </div>
                        </td>
                        {{-- @dd($student->user->roles->pluck('name')[0]) --}}
                        <td>{{ $student->gender->value == 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>{{ $student->nisn }}</td>
                        <td>
                            {{ $student->modelHasRfid ? $student->modelHasRfid->rfid : '-' }}
                            <button type="button" class="btn btn-rounded btn-warning p-1 ms-2 btn-rfid"
                                data-name="{{ $student->user->name }}"
                                data-id="{{ $student->id }}"
                                data-rfid="{{ $student->modelHasRfid ? $student->modelHasRfid->rfid : 'Kosong' }}"
                                data-old-rfid="{{ $student->modelHasRfid ? $student->modelHasRfid->rfid : 'Kosong' }}"
                                data-role="Student">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M21 12a1 1 0 0 0-1 1v6a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h6a1 1 0 0 0 0-2H5a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-6a1 1 0 0 0-1-1m-15 .76V17a1 1 0 0 0 1 1h4.24a1 1 0 0 0 .71-.29l6.92-6.93L21.71 8a1 1 0 0 0 0-1.42l-4.24-4.29a1 1 0 0 0-1.42 0l-2.82 2.83l-6.94 6.93a1 1 0 0 0-.29.71m10.76-8.35l2.83 2.83l-1.42 1.42l-2.83-2.83ZM8 13.17l5.93-5.93l2.83 2.83L10.83 16H8Z" />
                                </svg>
                            </button>
                        </td>
                        <td>
                        <div class="dropdown dropstart">
                            <a href="#" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="category">
                                    <div class="category-business"></div>
                                    <div class="category-social"></div>
                                    <span class="more-options text-dark">
                                        <i class="ti ti-dots-vertical fs-5"></i>
                                    </span>
                                </div>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">
                                <li>
                                    <button class="btn-detail dropdown-item d-flex align-items-center gap-3"
                                        data-id="{{ $student->id }}" data-name="{{ $student->user->name }}"
                                        data-email="{{ $student->user->email }}" data-nisn="{{ $student->nisn }}"
                                        data-religion_id="{{ $student->religion_id }}"
                                        data-gender="{{ $student->gender }}"
                                        data-birth_place="{{ $student->birth_place }}"
                                        data-birth_date="{{ $student->birth_date }}" data-nik="{{ $student->nik }}"
                                        data-number_kk="{{ $student->number_kk }}"
                                        data-number_akta="{{ $student->number_akta }}"
                                        data-order_child="{{ $student->order_child }}"
                                        data-count_siblings="{{ $student->count_siblings }}"
                                        data-address="{{ $student->address }}"
                                        data-rfid="{{ $student->modelHasRfid ? $student->modelHasRfid->rfid : 'Kosong' }}"
                                        data-image="{{ $student->image ? asset('storage/' . $student->image) : asset('assets/images/default-user.jpeg') }}"
                                    ><i class="fs-4 ti ti-eye"></i>Detail</button>
                                </li>
                                <li>
                                    <button class="btn-update dropdown-item d-flex align-items-center gap-3"
                                        data-id="{{ $student->id }}" data-name="{{ $student->user->name }}"
                                        data-email="{{ $student->user->email }}" data-nisn="{{ $student->nisn }}"
                                        data-religion_id="{{ $student->religion_id }}"
                                        data-gender="{{ $student->gender }}"
                                        data-birth_place="{{ $student->birth_place }}"
                                        data-birth_date="{{ $student->birth_date }}" data-nik="{{ $student->nik }}"
                                        data-number_kk="{{ $student->number_kk }}"
                                        data-number_akta="{{ $student->number_akta }}"
                                        data-order_child="{{ $student->order_child }}"
                                        data-count_siblings="{{ $student->count_siblings }}"
                                        data-address="{{ $student->address }}">
                                        <i class="fs-4 ti ti-edit"></i>Edit</button>
                                </li>
                                <li>
                                    <button data-id="{{ $student->id }}" class="btn-delete dropdown-item d-flex align-items-center text-danger gap-3"><i class="fs-4 ti ti-trash"></i>Hapus</button>
                                </li>
                            </ul>
                        </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center align-middle">
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt="" width="300px">
                                <p class="fs-5 text-dark text-center mt-2">
                                    Siswa belum ditambahkan
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination justify-content-end mb-0">
        <x-paginate-component :paginator="$students->appends(request()->input())" />
    </div>
</div>
