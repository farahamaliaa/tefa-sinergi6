@extends('school.layouts.app')
@section('style')
    <style>
        .category-selector .dropdown-menu {
            position: absolute;
            z-index: 1050;
            transform: translate3d(0, 0, 0);
        }

        .select2 {
            width: 100% !important;
        }

        .select2-selection__rendered {
            width: 100%;
            height: 36px;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .select2-selection {
            height: fit-content !important;
            color: #555 !important;
            background-color: #fff !important;
            background-image: none !important;
            border: 1px solid #ccc !important;
            border-radius: 4px !important;
        }

        .card {
            border: 1px solid #E0E6ED !important;
            box-shadow: none !important;
        }

        .card-hover:hover {
            border-color: #00A9D9 !important;
            transition: .2s ease-in-out;
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

        /* Custom Pagination Style */
        .pagination .page-item .page-link {
            border-radius: 8px;
            border: 1px solid #EAEFF4;
            color: #0896D1;
            margin: 0 4px;
            font-weight: 600;
            padding: 6px 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 35px;
            min-width: 35px;
        }

        .pagination .page-item.active .page-link {
            background-color: #0896D1;
            border-color: #0896D1;
            color: #fff;
        }

        .pagination .page-item.disabled .page-link {
            color: #A5A5A5;
            background-color: transparent;
            border-color: #EAEFF4;
        }

        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            border-radius: 8px;
        }

        .pagination .page-item .page-link:hover {
            background-color: #EAEFF4;
            color: #0896D1;
        }

        .pagination .page-item.active .page-link:hover {
            background-color: #0896D1;
            color: #fff;
        }

        .pagination .page-item .page-link.pagination-dots {
            border: none;
            padding-bottom: 12px;
            background-color: transparent;
            color: #000;
            font-weight: 900;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <!-- Card 1: Pengajar -->
        <div class="col-lg-6 d-flex">
            <div class="card position-relative overflow-hidden flex-fill">
                <div class="card-body px-4 py-3 position-relative" style="z-index: 1;">
                    <div class="row align-items-center">
                        <h4 class="mb-3">Pengajar</h4>
                        <div class="col-auto">
                            <img src="{{ $extracurricular->employee->image ? asset('storage/' . $extracurricular->employee->image) : asset('assets/images/default-user.jpeg') }}"
                                alt="Profile Image" class="img-fluid rounded-circle" style="width: 84px; height: 84px;">
                        </div>
                        <div class="col">
                            <h4 class="fw-semibold mb-2">{{ $extracurricular->employee->user->name }}</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb bg-transparent p-0 m-0">
                                    <li class="breadcrumb-item" aria-current="page">Tahun Ajaran
                                        {{ $schoolYear->school_year }}
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <img src="{{ asset('assets/images/background/rightflow.png') }}" alt=""
                    class="position-absolute end-0 bottom-0" style="height: 100%;">
            </div>
        </div>

        <!-- Card 2: Ekstrakulikuler -->
        <div class="col-lg-6 d-flex">
            <div class="card position-relative overflow-hidden flex-fill">
                <div class="card-body px-4 py-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 me-3">
                            <h4 class="mb-3">Ekstrakurikuler</h4>
                            <h4 class="fw-semibold mb-2">{{ $extracurricular->name }}</h4>
                            <div class="mt-3">
                                <span
                                    class="mb-1 badge font-medium bg-light-secondary text-secondary">{{ $extracurricular->extracurricularStudents->count() }}
                                    Total
                                    Siswa</span>
                                <span class="mb-1 badge font-medium bg-light-success text-success">0 Pertemuan</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewBox="0 0 24 24">
                                <path fill="#0896D1"
                                    d="M4.929 19.071a9.953 9.953 0 0 0 6.692 2.906c-.463-2.773.365-5.721 2.5-7.856c2.136-2.135 5.083-2.963 7.856-2.5c-.092-2.433-1.053-4.839-2.906-6.692s-4.26-2.814-6.692-2.906c.463 2.773-.365 5.721-2.5 7.856c-2.136 2.135-5.083 2.963-7.856 2.5a9.944 9.944 0 0 0 2.906 6.692" />
                                <path fill="#0896D1"
                                    d="M15.535 15.535a6.996 6.996 0 0 0-1.911 6.318a9.929 9.929 0 0 0 8.229-8.229a6.999 6.999 0 0 0-6.318 1.911m-7.07-7.07a6.996 6.996 0 0 0 1.911-6.318a9.929 9.929 0 0 0-8.23 8.229a7 7 0 0 0 6.319-1.911" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="row me-3">
                        <div class="col-lg-6 col-md-12 mb-3">
                            <div class="d-flex align-items-center">
                                <span class="mb-1 badge bg-primary p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M12 7q-.825 0-1.412-.587T10 5t.588-1.412T12 3t1.413.588T14 5t-.587 1.413T12 7m0 14q-.625 0-1.062-.437T10.5 19.5v-9q0-.625.438-1.062T12 9t1.063.438t.437 1.062v9q0 .625-.437 1.063T12 21" />
                                    </svg>
                                </span>
                                <h5 class="fw-semibold mb-0" style="font-size: 18px" >Daftar Siswa Mengikuti Ekstrakurikuler</h5>
                            </div>
                        </div>
                    </div> -->
    <div class="card card-body">
        <h4 class="mb-4">Jadwal Kegiatan Ekstrakulikuler {{ $extracurricular->name }}</h4>
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <form action="" method="GET" class="d-flex flex-wrap align-items-end gap-3" id="filter-schedule-form">
                <div class="" style="min-width: 200px;">
                    <label class="form-label">Hari</label>
                    <select name="day" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Hari</option>
                        @foreach(App\Enums\DayEnum::cases() as $day)
                            <option value="{{ $day->value }}" {{ request('day') == $day->value ? 'selected' : '' }}>
                                {{ ucfirst($day->label()) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="" style="min-width: 200px;">
                    <label class="form-label">Jam Mulai</label>
                    <input type="time" name="start_time" class="form-control" onchange="this.form.submit()"
                        value="{{ request('start_time') }}">
                </div>
                <div class="d-flex align-items-center" style="min-height: 40px;">
                    <span class="fw-bold fs-5">-</span>
                </div>
                <div class="" style="min-width: 200px;">
                    <label class="form-label">Jam Selesai</label>
                    <input type="time" name="end_time" class="form-control" onchange="this.form.submit()"
                        value="{{ request('end_time') }}">
                </div>
                <div>
                    <button type="submit" class="btn btn-import">
                        Simpan
                    </button>
                </div>
            </form>
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal-create-schedule">
                    <i class="ti ti-plus"></i> Tambah Jadwal
                </button>
            </div>
        </div>

        <div class="table-responsive rounded-2 mb-4 pt-2">
            <table class="table border text-nowrap customize-table mb-0 align-middle text-center">
                <thead class="text-dark fs-4">
                    <tr class="">
                        <th class="fs-4 fw-semibold mb-0 text-white" style="background-color: #0896D1;">No</th>
                        <th class="fs-4 fw-semibold mb-0 text-white" style="background-color: #0896D1;">Hari</th>
                        <th class="fs-4 fw-semibold mb-0 text-white" style="background-color: #0896D1;">Jam Mulai</th>
                        <th class="fs-4 fw-semibold mb-0 text-white" style="background-color: #0896D1;">Jam Selesai</th>
                        <th class="fs-4 fw-semibold mb-0 text-white" style="background-color: #0896D1;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($extracurricular->schedules as $index => $schedule)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ ucfirst(App\Enums\DayEnum::tryFrom($schedule->day)?->label() ?? $schedule->day) }}</td>
                            <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                            <td>
                                <form action="{{ route('school.extracurricular-schedule.destroy', $schedule->id) }}"
                                    method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center align-middle">
                                <div class="d-flex flex-column justify-content-center align-items-center py-3">
                                    <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt="" width="150px">
                                    <p class="fs-5 text-dark text-center mt-2">
                                        Belum ada jadwal
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- modal --}}
        @include('school.pages.extracurricular.widgets.modal-import')
        @include('school.pages.extracurricular.widgets.modal-create-student')
        @include('school.pages.extracurricular.widgets.modal-create-schedule')
        @include('school.pages.extracurricular.widgets.detail-student')
        <x-delete-modal-component />
    </div>


    <div class="card card-body">
        <h4>Daftar Siswa Anggota Eskul</h4>
        <div class="row mt-3">
            <div class="col-12 col-lg-9 mb-2">
                <div class="col-12 col-md-6 col-lg-4 me-3">
                    <form class="d-flex gap-2" action="/school/extracurricular/{{ $extracurricular->id }}">
                        <div class="position-relative w-70">
                            <input type="text" name="name" class="form-control product-search ps-5" id="input-search"
                                placeholder="Cari..." value="{{ old('name', request()->name) }}">
                            <i
                                class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        </div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>
            </div>
            <div class="col-12 col-lg-3 d-flex justify-content-end gap-2 mb-2">
                <!-- <button type="button" class="btn btn-import " data-bs-toggle="modal" data-bs-target="#modal-import">
                                <svg width="20" height="25" viewBox="0 0 28 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.7699 8.92256V23.1726M13.7699 8.92256L18.5199 13.6726M13.7699 8.92256L9.0199 13.6726M22.4782 16.8392C24.8833 16.8392 26.4366 14.8901 26.4366 12.4851C26.4365 11.5329 26.1243 10.607 25.5478 9.84915C24.9712 9.09133 24.1622 8.54338 23.2446 8.28923C23.1034 6.51346 22.3674 4.8372 21.1557 3.53146C19.9439 2.22573 18.3272 1.36684 16.5669 1.09366C14.8066 0.820475 13.0056 1.14897 11.4551 2.02602C9.90454 2.90308 8.69515 4.27744 8.0224 5.9269C6.60599 5.53427 5.09162 5.72038 3.81244 6.44431C2.53325 7.16823 1.59403 8.37065 1.2014 9.78707C0.808771 11.2035 0.994888 12.7178 1.71881 13.997C2.44273 15.2762 3.64516 16.2154 5.06157 16.6081" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Import Siswa
                            </button> -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-create-student">
                    <i class="ti ti-plus"></i> Tambah Siswa
                </button>
            </div>
        </div>

        <div class="table-responsive rounded-2 mb-4 pt-2">
            <table class="table border text-nowrap customize-table mb-0 align-middle text-center">
                <thead class="text-dark fs-4">
                    <tr class="">
                        <th class="fs-4 fw-semibold mb-0 text-white" style="background-color: #0896D1;">No</th>
                        <th class="fs-4 fw-semibold mb-0 text-white" style="background-color: #0896D1;">Nama</th>
                        <th class="fs-4 fw-semibold mb-0 text-white" style="background-color: #0896D1;">Jenis Kelamin</th>
                        <th class="fs-4 fw-semibold mb-0 text-white" style="background-color: #0896D1;">NISN</th>
                        <th class="fs-4 fw-semibold mb-0 text-white" style="background-color: #0896D1;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($extracurricularStudents as $extracurricularStudent)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $extracurricularStudent->student->user->name }}
                            </td>
                            <td>
                                {{ $extracurricularStudent->student->gender?->label() ?? '-' }}
                            </td>
                            <td>
                                {{ $extracurricularStudent->student->nisn ?? '-' }}
                            </td>
                            <td>
                                <a class="btn-delete-student dropdown-item d-flex align-items-center text-danger gap-3"
                                    data-id="{{ $extracurricularStudent->id }}"><i
                                        class="fs-4 ti ti-trash bg-light-danger p-2 rounded-2"></i></a>
                                <!-- <div class="dropdown dropstart">
                                                                <a href="#" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                                    aria-expanded="false">
                                                                    <div class="category">
                                                                        <div class="category-business"></div>
                                                                        <div class="category-social"></div>
                                                                        <span class="more-options text-dark">
                                                                            <i class="ti ti-dots-vertical fs-5"></i>
                                                                        </span>
                                                                    </div>
                                                                </a>
                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                    <li>
                                                                        <a type="button" class="dropdown-item d-flex align-items-center gap-3 btn-detail"
                                                                            data-image="{{ $extracurricularStudent->student->image ? asset('storage/' . $extracurricularStudent->student->image) : asset('assets/images/default-user.jpeg') }}"
                                                                            data-name="{{ $extracurricularStudent->student->user->name }}"
                                                                            data-email="{{ $extracurricularStudent->student->user->email }}"
                                                                            data-nisn="{{ $extracurricularStudent->student->nisn }}"
                                                                            data-classroom="{{ $extracurricularStudent->student->classroomStudents->isNotEmpty() ? $extracurricularStudent->student->classroomStudents->first()->classroom->name : '-' }}"
                                                                            data-gender="{{ $extracurricularStudent->student->gender->label() }}"
                                                                            data-religion="{{ $extracurricularStudent->student->religion->name }}"
                                                                            data-birthdate="{{ $extracurricularStudent->student->birth_date }}"
                                                                            data-birthplace="{{ $extracurricularStudent->student->birth_place }}"
                                                                            data-number_kk="{{ $extracurricularStudent->student->number_kk }}"
                                                                            data-nik="{{ $extracurricularStudent->student->nik }}"
                                                                            data-order_child="{{ $extracurricularStudent->student->order_child }}"
                                                                            data-number_akta="{{ $extracurricularStudent->student->number_akta }}"
                                                                            data-count_sibling="{{ $extracurricularStudent->student->count_siblings }}"
                                                                            data-address="{{ $extracurricularStudent->student->address }}">
                                                                            <i class="fs-4 ti ti-eye"></i>Detail
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="btn-delete-student dropdown-item d-flex align-items-center text-danger gap-3"
                                                                            data-id="{{ $extracurricularStudent->id }}"><i
                                                                                class="fs-4 ti ti-trash"></i>Hapus</a>
                                                                    </li>
                                                                </ul>
                                                            </div> -->
                            </td>
                        </tr>
                    @empty
                        <td colspan="7" class="text-center align-middle">
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt="" width="300px">
                                <p class="fs-5 text-dark text-center mt-2">
                                    Belum ada data
                                </p>
                            </div>
                        </td>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted">
                Menampilkan {{ $extracurricularStudents->currentPage() }} dari {{ $extracurricularStudents->lastPage() }}
                halaman
            </div>
            <div>
                <x-paginate-component :paginator="$extracurricularStudents" />
            </div>
        </div>

        {{-- modal --}}
        @include('school.pages.extracurricular.widgets.modal-import')
        @include('school.pages.extracurricular.widgets.modal-create-student')
        @include('school.pages.extracurricular.widgets.detail-student')
        <x-delete-modal-component />
    </div>

    <div class="card card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><i class="ti ti-notebook me-2"></i>Jurnal Pembina</h4>
        </div>

        @if(isset($journals) && $journals->count() > 0)
            <div class="row">
                @foreach($journals as $journal)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 border">
                            <div class="card-header text-white" style="background-color: #0896D1;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold">
                                        {{ ucfirst(\App\Enums\DayEnum::tryFrom($journal->schedule->day ?? '')?->label() ?? ($journal->schedule->day ?? '-')) }}
                                    </span>
                                    <span class="badge bg-white text-primary">
                                        {{ $journal->date->format('d M Y') }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <img src="{{ asset('storage/' . $journal->image) }}" class="img-fluid rounded"
                                            style="height: 100px; width: 100%; object-fit: cover;" alt="Dokumentasi">
                                    </div>
                                    <div class="col-8">
                                        <p class="text-muted small mb-2" style="line-height: 1.5;">
                                            {{ Str::limit($journal->description, 100) }}
                                        </p>
                                        <div class="d-flex flex-wrap gap-1">
                                            <span class="badge" style="background-color: #0D9488;">
                                                H: {{ $journal->attendances->where('status', 'hadir')->count() }}
                                            </span>
                                            <span class="badge" style="background-color: #D97706;">
                                                S: {{ $journal->attendances->where('status', 'sakit')->count() }}
                                            </span>
                                            <span class="badge" style="background-color: #2563EB;">
                                                I: {{ $journal->attendances->where('status', 'izin')->count() }}
                                            </span>
                                            <span class="badge" style="background-color: #DC2626;">
                                                A: {{ $journal->attendances->where('status', 'alpha')->count() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <a href="{{ route('school.extracurricular.journal.show', ['extracurricular' => $extracurricular->id, 'journal' => $journal->id]) }}"
                                    class="btn btn-sm btn-primary w-100">
                                    <i class="ti ti-eye me-1"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-4">
                <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt="" width="200px">
                <p class="text-muted mt-2">Belum ada jurnal dari pembina</p>
            </div>
        @endif
    </div>
@endsection
@section('script')
    @include('school.pages.extracurricular.scripts.detail')
    @include('school.pages.extracurricular.scripts.select2')
    @include('school.pages.extracurricular.scripts.script-validation')
@endsection