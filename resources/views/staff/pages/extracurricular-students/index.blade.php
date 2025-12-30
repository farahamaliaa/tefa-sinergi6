@extends('staff.layouts.app')
@section('style')
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

        .nav-pills .nav-link.active {
            background-color: #098FC6 !important;
            color: #fff !important;
        }

        .nav-pills .nav-link {
            color: #098FC6;
            border-radius: 8px;
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

        .table-header-custom th {
            background-color: #0891CA !important;
            color: white !important;
        }
    </style>
@endsection
@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    {{-- <h5 class="fw-semibold text-white mb-2">Daftar Siswa Ekstrakurikuler</h5> --}}
                    <h4 class="fw-semibold text-white mb-2">Ekstrakurikuler {{ $extracurricular->name }}</h4>
                    <h6 class="fw-semibold text-white mb-2">Jadwal dan daftar Siswa Eskul {{ $extracurricular->name }}</h6>
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

    <div class="card card-body">
        {{-- <h4 class="mb-4">Jadwal Kegiatan Ekstrakulikuler {{ $extracurricular->name }}</h4> --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <h4 class="mb-4">Jadwal Kegiatan Ekstrakulikuler {{ $extracurricular->name }}</h4>
            {{-- <form action="" method="GET" class="d-flex flex-wrap align-items-end gap-3" id="filter-schedule-form">
                <div class="" style="min-width: 200px;">
                    <label class="form-label">Hari</label>
                    <select name="day" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Hari</option>
                        @foreach (App\Enums\DayEnum::cases() as $day)
                            <option value="{{ $day->value }}" {{ request('day') == $day->value ? 'selected' : '' }}>
                                {{ ucfirst($day->label()) }}</option>
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
                    <button type="submit" class="btn btn-import" style="background-color: #098CC3; color: white">
                        Simpan
                    </button>
                </div>
            </form> --}}
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal-create-schedule" style="background-color: #098CC3">
                    <i class="ti ti-plus"></i> Tambah Jadwal
                </button>
            </div>
        </div>

        <div class="table-responsive rounded-3 mb-4">
            <table class="table border text-nowrap customize-table mb-0 align-middle">
                <thead class="text-dark fs-4 rounded-3 table-header-custom">
                    <tr class="">
                        <th class="fs-4 fw-semibold mb-0 text-white">No</th>
                        <th class="fs-4 fw-semibold mb-0 text-white">Hari</th>
                        <th class="fs-4 fw-semibold mb-0 text-white">Jam Mulai</th>
                        <th class="fs-4 fw-semibold mb-0 text-white">Jam Selesai</th>
                        <th class="fs-4 fw-semibold mb-0 text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" class="text-center align-middle">
                            <div class="d-flex flex-column justify-content-center align-items-center py-3">
                                <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt=""
                                    width="150px">
                                <p class="fs-5 text-dark text-center mt-2">
                                    Belum ada jadwal
                                </p>
                            </div>
                        </td>
                    </tr>
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

    <div class="row mb-3 mt-3">
        <div class="col-lg-6 col-md-12 mb-3">
            <form class="d-flex flex-column flex-md-row gap-2" action="/school/students">
                <div class="position-relative flex-grow-1">
                    <input type="text" name="name" class="form-control product-search ps-5" id="input-search"
                        placeholder="Cari..." value="{{ old('name', request('name')) }}">
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
                            <option value="{{ $classroom->name }}"
                                {{ request('class') == $classroom->name ? 'selected' : '' }}>{{ $classroom->name }}
                            </option>
                        @endforeach
                    </select>
                    <div>
                        <button type="submit" class="btn btn-primary btn-md w-100 w-md-auto"
                            style="background-color: #098CC3">Filter</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="">
            <div class="table-responsive rounded-3 mb-4">
                <table class="table border text-nowrap customize-table mb-0 align-middle">
                    <thead class="fs-4 table-header-custom">
                        <tr>
                            <th class="text-black">No</th>
                            <th class="text-black">Nama</th>
                            <th class="text-black">Jenis Kelamin</th>
                            <th class="text-black">Kelas</th>
                            <th class="text-black">NISN</th>
                            <th class="text-black">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($extracurricularStudents as $extracurricularStudent)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $extracurricularStudent->student->user->avatar ?? asset('assets/images/default-user.jpeg') }}"
                                            class="rounded-circle" width="40" height="40">
                                        <div class="ms-3">
                                            <h6 class="fs-4 fw-semibold mb-0">
                                                {{ $extracurricularStudent->student->user->name }}</h6>
                                            <span
                                                class="fw-normal">{{ $extracurricularStudent->student->classroomStudents->first()->classroom->name ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $extracurricularStudent->student->gender->label() }}</td>
                                <td>{{ $extracurricularStudent->student->classroomStudents->first()->classroom->name ?? 'N/A' }}
                                </td>
                                <td>{{ $extracurricularStudent->student->nisn }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center align-middle">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt=""
                                            width="300px">
                                        <p class="fs-5 text-dark text-center mt-2">
                                            Belum ada siswa
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
