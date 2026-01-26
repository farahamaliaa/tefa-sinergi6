@extends('student.layouts.app')

@section('style')
    <style>
        .card-body-with-line::before {
            content: '';
            position: absolute;
            left: 10px;
            height: 85px;
            top: 20px;
            bottom: 0;
            width: 4px;
            background-color: #5D87FF;
            border-radius: 2px;
        }

        .card-body-with-line2::before {
            content: '';
            position: absolute;
            left: 10px;
            height: 85px;
            top: 20px;
            bottom: 0;
            width: 4px;
            background-color: #13DEB9;
            border-radius: 2px;
        }

        .card-body-with-line3::before {
            content: '';
            position: absolute;
            left: 10px;
            height: 85px;
            top: 20px;
            bottom: 0;
            width: 4px;
            background-color: #FA896B;
            border-radius: 2px;
        }

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
            background-color: #46B0DD !important;
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
            /* background: url("{{ asset('assets/images/wave-header.png') }}"); */
            background-size: cover;
            opacity: 1;
        }

        .text-primary {
            color: #0896D1 !important;
        }

        .bg-primary {
            background-color: #0896D1 !important;
        }

        .btn-primary {
            background-color: #0896D1 !important;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-9 col-md-8">
            <div class="card header-wave shadow-none position-relative overflow-hidden d-flex justify-content-center"
                style="min-height: 190px;">
                <img src="{{ asset('assets/images/background/header-right-student.png') }}" alt=""
                    class="position-absolute top-0 end-0 h-100">
                <img src="{{ asset('assets/images/background/header-left-student.png') }}" alt=""
                    class="position-absolute top-0 start-0 h-75">
                <div class="position-relative">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-md-4 text-center">
                            <img src="{{ asset('assets/images/background/header-person-student.png') }}" class="img-fluid"
                                alt="" style="max-height: 200px">
                        </div>
                        <div class="col-lg-9 col-md-8 p-4">
                            <h3 class="fw-semibold text-white mb-2">Hello, {{ auth_user()->name }} 👋</h3>
                            <p class="text-white fs-5 mb-0">Senang melihatmu kembali. Semoga harimu menyenangkan, jangan
                                lupa
                                cek
                                absensi dan jadwal belajar hari ini ya.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card border">
                        <div
                            class="card-body d-flex flex-column flex-lg-row justify-content-lg-between align-items-lg-center">
                            <div class="mb-3 mb-lg-0">
                                <h4 class="mb-3"><b>Absensi Hari Ini:</b></h4>
                                <h4>~</h4>
                            </div>
                            <div class="badge {{ $single_attendance ? ($single_attendance->status->value == 'present' ? 'bg-light-success text-success' : ($single_attendance->status->value == 'sick' || $single_attendance->status->value == 'permit' ? 'bg-light-warning text-warning' : 'bg-light-danger text-danger')) : 'bg-light-danger text-danger' }} fs-5 text-nowrap py-3 px-2 rounded-3 w-100 w-lg-auto"
                                style="max-width: 150px; overflow: hidden; text-overflow: ellipsis;">
                                {{ $single_attendance ? $single_attendance->status->label() : 'Belum Absen' }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row mb-4">
                <div>
                    <div class="card border">
                        <div class="card-body">
                            <h4 class="mb-4"><b>Jadwal Pelajaran Hari Ini</b></h4>
                            <!-- Menambahkan batas tinggi untuk mengaktifkan scroll -->
                            <div class="table-responsive rounded-2 mt-3" style="max-height: 400px; overflow-y: auto;">
                                <table class="table border text-nowrap customize-table mb-0 align-middle">
                                    <thead>
                                        <tr>
                                            <th class="text-white" style="background-color: #0896D1;">Mata Pelajaran</th>
                                            <th class="text-white" style="background-color: #0896D1;">Guru</th>
                                            <th class="text-white" style="background-color: #0896D1;">Jam</th>
                                            <th class="text-white" style="background-color: #0896D1;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($todaySchedules as $schedule)
                                            @php
                                                $now = \Carbon\Carbon::now();
                                                $startTime = \Carbon\Carbon::parse($schedule->start->start);
                                                $endTime = \Carbon\Carbon::parse($schedule->end->end);

                                                if ($now->lt($startTime)) {
                                                    $status = 'upcoming';
                                                    $statusLabel = 'Akan Mulai';
                                                    $statusClass = 'bg-light-warning text-warning';
                                                } elseif ($now->between($startTime, $endTime)) {
                                                    $status = 'ongoing';
                                                    $statusLabel = 'Sedang Berlangsung';
                                                    $statusClass = 'bg-light-secondary text-secondary';
                                                } else {
                                                    $status = 'finished';
                                                    $statusLabel = 'Selesai';
                                                    $statusClass = 'bg-light-success text-success';
                                                }
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-light-primary text-primary d-inline-flex align-items-center justify-content-center rounded"
                                                            style="width: 35px; height: 35px;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" viewBox="0 0 24 24">
                                                                <path fill="currentColor"
                                                                    d="M20 22H6.5A3.5 3.5 0 0 1 3 18.5V5a3 3 0 0 1 3-3h14a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1m-1-2v-3H6.5a1.5 1.5 0 0 0 0 3z" />
                                                            </svg>
                                                        </div>
                                                        <span
                                                            class="ms-3">{{ $schedule->teacherSubject->subject->name ?? '-' }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $schedule->teacherSubject->employee->user->name ?? '-' }}</td>
                                                <td>Jam ke {{ $schedule->start->name ?? '-' }} -
                                                    {{ $schedule->end->name ?? '-' }}</td>
                                                <td>
                                                    <span class="mb-1 badge font-medium {{ $statusClass }}">
                                                        {{ $statusLabel }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">
                                                    <div
                                                        class="d-flex flex-column justify-content-center align-items-center">
                                                        <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}"
                                                            alt="" width="300px">
                                                        <p class="fs-5 text-dark text-center mt-2">
                                                            Tidak ada jadwal pelajaran hari ini
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="row mb-4">
                <div class="col-lg-8">
                    <div class="card border">
                        <div class="card-body">
                            <h4 class="mb-4"><b>Riwayat Absensi</b></h4>
                            <!-- Menambahkan batas tinggi untuk mengaktifkan scroll -->
                            <div class="table-responsive rounded-2 mt-3" style="max-height: 400px; overflow-y: auto;">
                                <table class="table border text-nowrap customize-table mb-0 align-middle">
                                    <thead>
                                        <tr>
                                            <th class="text-white"
                                                style="background-color: #5D87FF; border-top-left-radius: 12px; border-bottom-left-radius: 12px;">
                                                Hari</th>
                                            <th class="text-white" style="background-color: #5D87FF;">Tanggal</th>
                                            <th class="text-white" style="background-color: #5D87FF;">Masuk</th>
                                            <th class="text-white" style="background-color: #5D87FF;">Pulang</th>
                                            <th class="text-white"
                                                style="background-color: #5D87FF; border-top-right-radius: 12px; border-bottom-right-radius: 12px">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($history_attendance as $data)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('l') }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y') }}
                                                </td>
                                                <td>{{ $data->checkin == null ? '-' : \Carbon\Carbon::parse($data->checkin)->format('H:i') }}
                                                </td>
                                                <td>{{ $data->checkout == null ? '-' : \Carbon\Carbon::parse($data->checkout)->format('H:i') }}
                                                </td>
                                                <td>
                                                    <span class="mb-1 badge font-medium {{ $data->status->color() }}">
                                                        {{ $data->status->label() }}
                                                    </span>
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">
                                                    <div
                                                        class="d-flex flex-column justify-content-center align-items-center">
                                                        <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}"
                                                            alt="" width="300px">
                                                        <p class="fs-5 text-dark text-center mt-2">
                                                            Tidak ada riwayat absen
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 d-flex">
                    <div class="card w-100 h-100 overflow-hidden border">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <h5 class="card-title fw-semibold">Statistik Absensi</h5>
                                <h6 class="mb-3">Tahun ini</h6>
                                <div id="chart-attendance" class="d-flex justify-content-center"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="row">
                <div class="col-lg-4">
                    <div class="col-lg-12">
                        <div class="card border">
                            <div class="card-body">
                                <h5><b>Kelasmu</b></h5>

                                <div class="text-center">
                                    <img src="{{ asset('assets/images/Topi.png') }}" alt=""
                                        style="width: 100px; height: auto;">
                                    <h3 class="pt-2 mb-3"><b>{{ $studentClasses->classroom->name }}</b></h3>
                                    <span class="mb-1 badge font-medium bg-light-primary text-primary py-2 px-3"
                                        style="font-size: 18px;">{{ $studentClasses->classroom->classroomStudents->count() }}
                                        Total
                                        Siswa</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card border">
                            <div class="card-body">
                                <h5 class="mb-4"><b>Wali Kelasmu</b></h5>
                                <div class="d-flex flex-column flex-sm-row align-items-center mb-3">
                                    <img src="{{ asset('admin_assets/dist/images/profile/user-4.jpg') }}" alt=""
                                        class="rounded-circle img-fluid mb-2" style="max-width: 100px; height: auto;">

                                    <div class="ms-3 text-center text-sm-start">
                                        <h4><b>{{ $studentClasses->classroom->employee?->user->name ?? 'Belum ada Wali Kelas' }}</b></h4>
                                        <h6>Tahun Ajaran {{ $studentClasses->classroom->schoolYear->school_year }}</h6>

                                    </div>
                                </div>
                                <div class="d-flex flex-wrap justify-content-center justify-content-sm-start gap-2"
                                    id="subject-container">
                                    @php
                                        $subjects = $studentClasses->classroom->employee?->teacherSubjects ?? collect();
                                        $displayedSubjects = $subjects->take(2);
                                        $remainingSubjects = $subjects->count() - $displayedSubjects->count();
                                    @endphp

                                    @forelse ($displayedSubjects as $data)
                                        <span class="mb-1 badge font-medium bg-light-primary text-primary subject-item"
                                            style="font-size: 14px;">
                                            {{ $data->subject->name }}
                                        </span>
                                    @empty
                                        <span class="mb-1 badge font-medium bg-light-warning text-warning"
                                            style="font-size: 14px;">
                                            Belum memiliki mapel
                                        </span>
                                    @endforelse

                                    @if ($remainingSubjects > 0)
                                        <span class="mb-1 badge font-medium bg-light-secondary text-secondary"
                                            style="font-size: 14px; cursor: pointer;" id="toggle-subjects">
                                            +{{ $remainingSubjects }} mapel lainnya
                                        </span>

                                        <div id="additional-subjects" style="display: none;">
                                            @foreach ($subjects->skip(2) as $data)
                                                <span
                                                    class="mb-1 badge font-medium bg-light-primary text-primary subject-item"
                                                    style="font-size: 14px;">
                                                    {{ $data->subject->name }}
                                                </span>
                                            @endforeach
                                            <span class="mb-1 badge font-medium bg-light-danger text-danger"
                                                style="font-size: 14px; cursor: pointer;" id="close-subjects">
                                                Lebih sedikit...
                                            </span>
                                        </div>
                                    @endif
                                </div>


                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-8">
                    <div class="card border">
                        <div class="card-body">
                            <h5 class="mb-4"><b>Daftar Tugas</b></h5>
                            <div class="table-responsive rounded-2 mt-3">
                                <table class="table border text-nowrap customize-table mb-0 align-middle">
                                    <thead style="border-radius: 12px 12px 0 0;">
                                        <tr>
                                            <th class="text-white"
                                                style="background-color: #5D87FF; border-top-left-radius: 12px; border-bottom-left-radius: 12px;">
                                                Tugas</th>
                                            <th class="text-white" style="background-color: #5D87FF;">Status</th>
                                            <th class="text-white"
                                                style="background-color: #5D87FF; border-top-right-radius: 12px; border-bottom-right-radius: 12px">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ([] as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div
                                                            class="bg-light-primary text-primary d-inline-block px-2 py-2 rounded">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="25"
                                                                height="25" class="" viewBox="0 0 24 24">
                                                                <path fill="currentColor"
                                                                    d="M20 22H6.5A3.5 3.5 0 0 1 3 18.5V5a3 3 0 0 1 3-3h14a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1m-1-2v-3H6.5a1.5 1.5 0 0 0 0 3z" />
                                                            </svg>
                                                        </div>
                                                        <div class="ms-3">
                                                            <h6 class="fs-4 fw-semibold mb-0">Pemograman dasar I X RPL 1
                                                            </h6>
                                                            <span class="fw-normal">Membuat website file</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="mb-1 badge font-medium bg-light-danger text-danger">Belum
                                                        Dikerjakan</span>
                                                </td>
                                                <td>
                                                    <button class="btn mb-1 waves-effect waves-light btn-primary"
                                                        type="button">Detail</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">
                                                    <div
                                                        class="d-flex flex-column justify-content-center align-items-center">
                                                        <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}"
                                                            alt="" width="300px">
                                                        <p class="fs-5 text-dark text-center mt-2">
                                                            Tidak ada tugas
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="col-lg-3 col-md-4">
            <div class="card overflow-hidden rounded-3 border">
                <div class="py-3 position-relative" style="background-color: #63BCE2; min-height: 150px;">
                    <img src="{{ asset('assets/images/background/profile-right-student.png') }}"
                        class="position-absolute top-0 end-0 h-100">
                    <img src="{{ asset('assets/images/background/profile-left-student.png') }}"
                        class="position-absolute top-0 start-0 h-100">
                    <div class="text-white ps-4 py-2 position-relative" style="z-index: 1;">
                        <h5 class="text-white mb-0">My Profile</h5>
                    </div>
                </div>
                <div class="card-body text-center pt-0 mt-n5 position-relative">
                    <img src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : asset('assets/images/default-user.jpeg') }}"
                        alt="user" class="rounded-circle border border-3 border-white mb-3" width="100"
                        height="100">
                    <h5 class="fw-semibold">{{ auth()->user()->name }}</h5>
                    <span class="badge bg-light-primary text-primary rounded-pill px-3 py-1">Student</span>

                    <div class="mt-4 text-start">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold mb-0 text-dark">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</h4>
                            <div>
                                <i class="ti ti-chevron-left fs-5" style="cursor: pointer;"></i>
                                <i class="ti ti-chevron-right fs-5 ms-3" style="cursor: pointer;"></i>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between text-center align-items-stretch pb-2">
                            @php
                                $startOfWeek = \Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::SUNDAY);
                            @endphp
                            @for ($i = 0; $i < 7; $i++)
                                @php
                                    $date = $startOfWeek->copy()->addDays($i);
                                    $isToday = $date->isToday();
                                @endphp
                                <div class="d-flex flex-column align-items-center justify-content-center {{ $isToday ? 'bg-primary text-white rounded-3 shadow-md position-relative' : '' }}"
                                    style="width: 40px; {{ $isToday ? 'padding: 10px 0;' : '' }}">
                                    @if ($isToday)
                                        <span class="position-absolute bg-danger rounded-circle border border-white"
                                            style="width: 10px; height: 10px; top: 6px; right: 6px;"></span>
                                    @endif
                                    <span
                                        class="d-block fs-2 mb-2 {{ $isToday ? 'text-white opacity-75' : 'text-muted' }}">{{ $date->format('D') }}</span>
                                    <span
                                        class="d-block fw-bold fs-4 {{ $isToday ? 'text-white' : 'text-dark' }}">{{ $date->format('d') }}</span>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="card border overflow-hidden position-relative mx-4">
                    <img src="{{ asset('assets/images/background/class-right-student.png.png') }}"
                        class="position-absolute top-0 end-0 h-100">
                    <img src="{{ asset('assets/images/background/class-left-student.png') }}"
                        class="position-absolute top-0 start-0 h-100">
                    <div class="card-body p-3">
                        <h5 class="fw-semibold mb-3">Kelasmu</h5>
                        <div class="text-center">
                            <img src="{{ asset('assets/images/Topi.png') }}" alt="" class="img-fluid    "
                                style="width: 80px;">
                            <h3 class="fw-bold mb-2">{{ $studentClasses->classroom->name }}</h3>
                            <span class="badge bg-light-primary text-primary rounded-pill px-3">
                                {{ $studentClasses->classroom->classroomStudents->count() }} Total Siswa
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card border overflow-hidden position-relative mx-4">
                    <div class="card-body p-3">
                        <h5 class="fw-semibold mb-3">Wali Kelasmu</h5>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('admin_assets/dist/images/profile/user-4.jpg') }}" class="rounded-circle"
                                width="45" height="45" alt="">
                            <div class="ms-3">
                                <h6 class="mb-0 fw-semibold">{{ $studentClasses->classroom->employee?->user->name ?? 'Belum ada Wali Kelas' }}</h6>
                                <span class="fs-2 text-muted">Tahun Ajaran
                                    {{ $studentClasses->classroom->schoolYear->school_year }}</span>
                            </div>
                        </div>
                        <img src="{{ asset('assets/images/background/teacher-right-student.png') }}"
                            class="position-absolute top-0 end-0 h-100">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        const toggleButton = document.getElementById('toggle-subjects');
        const additionalSubjects = document.getElementById('additional-subjects');
        const closeButton = document.getElementById('close-subjects');

        toggleButton?.addEventListener('click', function() {
            additionalSubjects.style.display = 'block';
            toggleButton.style.display = 'none';
        });

        closeButton?.addEventListener('click', function() {
            additionalSubjects.style.display = 'none';
            toggleButton.style.display = 'inline-block';
        });
    </script>



    @include('student.pages.dashboard.scripts.chart-attendance')
@endsection
