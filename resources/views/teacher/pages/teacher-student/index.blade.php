@extends('teacher.layouts.app')
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
</style>
@endsection
@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h5 class="fw-semibold text-white mb-2">Informasi Kelas</h5>
                    <h4 class="fw-semibold text-white mb-2">{{ $classroom->name }}</h4>
                    <h6 class="fw-semibold text-white mb-2">Data siswa dan jadwal pelajaran kelas Anda</h6>
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

    <ul class="nav nav-pills p-3 mb-3 rounded align-items-center card flex-row" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center active gap-2"
                id="pills-students-tab"
                data-bs-toggle="pill"
                href="#pills-students"
                role="tab"
                aria-controls="pills-students"
                aria-selected="true">
                <i class="ti ti-users fs-5"></i>
                Daftar Siswa
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2"
                id="pills-schedule-tab"
                data-bs-toggle="pill"
                href="#pills-schedule"
                role="tab"
                aria-controls="pills-schedule"
                aria-selected="false">
                <i class="ti ti-calendar fs-5"></i>
                Jadwal Pelajaran
            </a>
        </li>
    </ul>

    <div class="card mt-4">
        <div class="card-body p-0">
            <div class="tab-content p-3" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-students" role="tabpanel"
                    aria-labelledby="pills-students-tab" tabindex="0">
                    <div class="col-lg-6 col-md-12 mb-3">
                        <form class="d-flex flex-column flex-md-row gap-2">
                            <div class="position-relative flex-grow-1">
                                <input type="text" name="search" class="form-control product-search ps-5" id="input-search" placeholder="Cari..." value="{{ old('search', request('search')) }}">
                                <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                            </div>
                            <div class="d-flex flex-column flex-md-row gap-2">
                                <select name="gender" class="form-select">
                                    <option value="">Tampilkan semua</option>
                                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>

                                <div>
                                    <button type="submit" class="btn btn-primary btn-md w-100 w-md-auto" style="background-color: #0b97d1">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive rounded-2 mb-4">
                        <table class="table border text-nowrap customize-table mb-0 align-middle">
                            <thead class="fs-4">
                                <tr>
                                    <th class="text-white">No</th>
                                    <th class="text-white">Nama</th>
                                    <th class="text-white">Jenis Kelamin</th>
                                    <th class="text-white">NISN</th>
                                    <th class="text-white text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($classroomStudents as $classroomStudent)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $classroomStudent->student->user->avatar ?? asset('assets/images/default-user.jpeg') }}"
                                                    class="rounded-circle" width="40" height="40">
                                                <div class="ms-3">
                                                    <h6 class="fs-4 fw-semibold mb-0">{{ $classroomStudent->student->user->name }}
                                                    </h6>
                                                    <span class="fw-normal">{{ $classroomStudent->classroom->name }}</span>
                                                </div>
                                            </div>

                                        </td>
                                        <td>{{ $classroomStudent->student->gender->label() }}</td>
                                        <td>{{ $classroomStudent->student->nisn }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <a type="button" class="text-primary btn-detail"
                                                    data-name="{{ $classroomStudent->student->user->name }}"
                                                    data-email="{{ $classroomStudent->student->user->email }}"
                                                    data-nisn="{{ $classroomStudent->student->nisn }}"
                                                    data-classroom="{{ $classroomStudent->classroom->name }}"
                                                    data-gender="{{ $classroomStudent->student->gender->label() }}"
                                                    data-religion="{{ $classroomStudent->student->religion->name }}"
                                                    data-birth_place="{{ $classroomStudent->student->birth_place }}"
                                                    data-birth_date="{{ Carbon\Carbon::parse($classroomStudent->student->birth_date)->format('d F Y') }}"
                                                    data-number_kk="{{ $classroomStudent->student->number_kk }}"
                                                    data-nik="{{ $classroomStudent->student->nik }}"
                                                    data-childnumber="{{ $classroomStudent->student->order_child }}"
                                                    data-number_akta="{{ $classroomStudent->student->number_akta }}"
                                                    data-numbersibling="{{ $classroomStudent->student->count_siblings }}"
                                                    data-address="{{ $classroomStudent->student->address }}"
                                                    data-image="{{ $classroomStudent->student->user->avatar ?? asset('assets/images/default-user.jpeg') }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24">
                                                        <g fill="none" stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="1.5">
                                                            <path d="M3 13c3.6-8 14.4-8 18 0" />
                                                            <path d="M12 17a3 3 0 1 1 0-6a3 3 0 0 1 0 6" />
                                                        </g>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center align-middle">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt=""
                                                    width="300px">
                                                <p class="fs-5 text-dark text-center mt-2">
                                                    Belum ada data
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-schedule" role="tabpanel" aria-labelledby="pills-schedule-tab"
                    tabindex="0">

                    <div class="card card-body">
                        <h4 class="mb-4 fw-bolder">Jadwal Mengajar Hari Ini</h4>
                        <div class="border rounded-pill p-1 d-inline-block w-100" style="max-width: 600px;">
                            <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active rounded-pill" id="pills-senin-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-senin" type="button" role="tab" aria-controls="pills-senin"
                                        aria-selected="true">
                                        Senin
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link rounded-pill" id="pills-selasa-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-selasa" type="button" role="tab" aria-controls="pills-selasa"
                                        aria-selected="false">
                                        Selasa
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link rounded-pill" id="pills-rabu-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-rabu" type="button" role="tab" aria-controls="pills-rabu"
                                        aria-selected="false">
                                        Rabu
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link rounded-pill" id="pills-kamis-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-kamis" type="button" role="tab" aria-controls="pills-kamis"
                                        aria-selected="false">
                                        Kamis
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link rounded-pill" id="pills-jumat-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-jumat" type="button" role="tab" aria-controls="pills-jumat"
                                        aria-selected="false">
                                        Jumat
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content mt-4" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-senin" role="tabpanel" aria-labelledby="pills-senin-tab">
                                @include('teacher.pages.dashboard.panes.schedule-tab.tab-monday')
                            </div>
                            <div class="tab-pane fade" id="pills-selasa" role="tabpanel" aria-labelledby="pills-selasa-tab">
                                @include('teacher.pages.dashboard.panes.schedule-tab.tab-tuesday')
                            </div>
                            <div class="tab-pane fade" id="pills-rabu" role="tabpanel" aria-labelledby="pills-rabu-tab">
                                @include('teacher.pages.dashboard.panes.schedule-tab.tab-wednesday')
                            </div>
                            <div class="tab-pane fade" id="pills-kamis" role="tabpanel" aria-labelledby="pills-kamis-tab">
                                @include('teacher.pages.dashboard.panes.schedule-tab.tab-thursday')
                            </div>
                            <div class="tab-pane fade" id="pills-jumat" role="tabpanel" aria-labelledby="pills-jumat-tab">
                                @include('teacher.pages.dashboard.panes.schedule-tab.tab-friday')
                            </div>
                            <div class="tab-pane fade" id="pills-sabtu" role="tabpanel" aria-labelledby="pills-sabtu-tab">
                                @include('teacher.pages.dashboard.panes.schedule-tab.tab-saturday')
                            </div>
                            <div class="tab-pane fade" id="pills-minggu" role="tabpanel" aria-labelledby="pills-minggu-tab">
                                @include('teacher.pages.dashboard.panes.schedule-tab.tab-sunday')
                            </div>
                        </div>
                    </div>
                    
                    {{-- <div class="table-responsive rounded-2 mb-4">
                        <table class="table border text-nowrap customize-table mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="text-black">No</th>
                                    <th class="text-black">Hari</th>
                                    <th class="text-black">Mata Pelajaran</th>
                                    <th class="text-black">Guru</th>
                                    <th class="text-black">Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $days = [
                                        'monday' => 'Senin',
                                        'tuesday' => 'Selasa',
                                        'wednesday' => 'Rabu',
                                        'thursday' => 'Kamis',
                                        'friday' => 'Jumat',
                                        'saturday' => 'Sabtu',
                                        'sunday' => 'Minggu'
                                    ];
                                @endphp
                                @forelse ($lessonSchedules as $schedule)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $days[$schedule->day] ?? $schedule->day }}</span>
                                        </td>
                                        <td>
                                            <h6 class="fs-4 fw-semibold mb-0">{{ $schedule->teacherSubject->subject->name }}</h6>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $schedule->teacherSubject->employee->user->avatar ?? asset('assets/images/default-user.jpeg') }}"
                                                    class="rounded-circle" width="35" height="35">
                                                <div class="ms-2">
                                                    <span class="fw-normal">{{ $schedule->teacherSubject->employee->user->name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ $schedule->lessonHourStart->start ?? '-' }} -
                                                {{ $schedule->lessonHourEnd->end ?? '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center align-middle">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt=""
                                                    width="300px">
                                                <p class="fs-5 text-dark text-center mt-2">
                                                    Belum ada jadwal pelajaran
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    @include('teacher.pages.teacher-student.widgets.modal-detail')
@endsection

@section('script')
    @include('teacher.pages.teacher-student.script.script-detail')
    @include('teacher.pages.teacher-student.widgets.tab-styles')
@endsection
