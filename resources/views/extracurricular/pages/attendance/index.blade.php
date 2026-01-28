@php
    use App\Enums\DayEnum;
    use Carbon\Carbon;
@endphp
@extends('extracurricular.layouts.app')
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

        .custom-badge-hadir {
            background-color: #E8FFF3 !important;
            color: #13DEB9 !important;
        }

        .custom-badge-sakit {
            background-color: #FFF4E5 !important;
            color: #FA896B !important;
        }

        .custom-badge-izin {
            background-color: #ECF2FF !important;
            color: #5D87FF !important;
        }

        .custom-badge-alpha {
            background-color: #FFE1E1 !important;
            color: #DC3545 !important;
        }

        .custom-badge-belum {
            background-color: #F3F4F6 !important;
            color: #6B7280 !important;
        }
    </style>
@endsection
@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Absensi Siswa</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    Daftar Absensi Siswa - {{ $extracurricular->name }}
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

    <div class="d-flex align-items-center mb-4">
        <h4 class="fw-semibold mb-0">Absensi Tanggal / </h4>
        <span class="ms-2 px-3 py-1 rounded-2 fw-semibold bg-light-primary" style="color: #098FC6;">
            <i class="ti ti-calendar me-1"></i>
            {{ \Carbon\Carbon::parse(request('date', now()))->translatedFormat('d F Y') }}
        </span>
    </div>

    <div class="row g-2 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm h-100 mb-0">
                <div class="card-body py-3">
                    <div class="d-flex">
                        <div class="border border-success"></div>
                        <div class="ms-3">
                            <h4>Jumlah Siswa Hadir</h4>
                            <h4 class="text-success">
                                <b>{{ $summary['hadir'] ?? 0 }}</b>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm h-100 mb-0">
                <div class="card-body py-3">
                    <div class="d-flex">
                        <div class="border" style="border-color: #0D93CA !important;"></div>
                        <div class="ms-3">
                            <h4>Jumlah Siswa Izin</h4>
                            <h4 style="color: #0D93CA;">
                                <b>{{ $summary['izin'] ?? 0 }}</b>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm h-100 mb-0">
                <div class="card-body py-3">
                    <div class="d-flex">
                        <div class="border border-warning"></div>
                        <div class="ms-3">
                            <h4>Jumlah Siswa Sakit</h4>
                            <h4 class="text-warning">
                                <b>{{ $summary['sakit'] ?? 0 }}</b>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm h-100 mb-0">
                <div class="card-body py-3">
                    <div class="d-flex">
                        <div class="border border-danger"></div>
                        <div class="ms-3">
                            <h4>Jumlah Siswa Alpha</h4>
                            <h4 class="text-danger">
                                <b>{{ $summary['alpha'] ?? 0 }}</b>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-body">
        <h4><b>Daftar Kehadiran</b></h4>
        <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 mb-4 gap-3">
            <form class="d-flex gap-2 align-items-center" method="GET" action="{{ url()->current() }}">
                <input type="hidden" name="extracurricular" value="{{ $extracurricular->id }}">
                <input type="hidden" name="date" value="{{ request('date', now()->format('Y-m-d')) }}">
                <div class="position-relative">
                    <input type="text" name="search" class="form-control search-chat py-2 px-4 ps-5" id="search-name"
                        placeholder="Cari Nama Siswa" value="{{ old('search', request('search')) }}">
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                </div>
                <button type="submit" class="btn text-white px-4" style="background-color: #098FC6;">Cari</button>
            </form>

            <form class="d-flex gap-2 align-items-center" method="GET" action="{{ url()->current() }}">
                <input type="hidden" name="extracurricular" value="{{ $extracurricular->id }}">
                <div class="position-relative">
                    <input type="date" name="date" class="form-control search-chat py-2 px-2 ps-3" id="search-date"
                        value="{{ request('date', now()->format('Y-m-d')) }}">
                </div>
                <button type="submit" class="btn text-white px-4" style="background-color: #098FC6;">Filter
                    Tanggal</button>
            </form>
        </div>

        <div class="table-responsive rounded-2 mb-4">
            <table class="table border text-nowrap customize-table mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th class="text-white" style="background-color: #098FC6;">No</th>
                        <th class="text-white" style="background-color: #098FC6;">Nama Siswa</th>
                        <th class="text-white" style="background-color: #098FC6;">Kelas</th>
                        <th class="text-white" style="background-color: #098FC6;">Status</th>
                        <th class="text-white" style="background-color: #098FC6;">Waktu Absen</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($extracurricularStudents as $esStudent)
                        @php
                            $attendance = $attendanceMap->get($esStudent->id);
                            $status = $attendance?->status ?? 'belum';

                            $badgeClass = match ($status) {
                                'hadir' => 'custom-badge-hadir',
                                'sakit' => 'custom-badge-sakit',
                                'izin' => 'custom-badge-izin',
                                'alpha' => 'custom-badge-alpha',
                                default => 'custom-badge-belum',
                            };

                            $statusLabel = match ($status) {
                                'hadir' => 'Hadir',
                                'sakit' => 'Sakit',
                                'izin' => 'Izin',
                                'alpha' => 'Alpha',
                                'belum' => 'Belum Absen',
                                default => $status,
                            };
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $esStudent->student->user->avatar ?? asset('assets/images/default-user.jpeg') }}"
                                        class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                    <div class="ms-3">
                                        <h6 class="fs-4 fw-semibold mb-0">{{ $esStudent->student->user->name }}</h6>
                                        <span
                                            class="fw-normal fs-2">{{ $esStudent->student->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $esStudent->student->classroomStudents->first()?->classroom?->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge px-3 py-2 rounded-2 fw-semibold {{ $badgeClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td>
                                @if ($attendance)
                                    {{ $attendance->created_at->format('H:i') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center align-middle">
                                <div class="d-flex flex-column justify-content-center align-items-center py-4">
                                    <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt=""
                                        width="200px">
                                    <p class="fs-5 text-dark text-center mt-2">Belum ada siswa terdaftar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
