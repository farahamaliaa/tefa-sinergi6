@php
    use App\Enums\DayEnum;
    use Carbon\Carbon;
@endphp
@extends('teacher.layouts.app')
@section('style')
    <style>
        .card {
            border: 1px solid #E0E6ED !important;
            box-shadow: none !important;
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

        .badge-hadir {
            background-color: #D1FAE5;
            color: #059669;
        }

        .badge-sakit {
            background-color: #FEF3C7;
            color: #D97706;
        }

        .badge-izin {
            background-color: #DBEAFE;
            color: #2563EB;
        }

        .badge-alpha {
            background-color: #FEE2E2;
            color: #DC2626;
        }

        .badge-belum {
            background-color: #F3F4F6;
            color: #6B7280;
        }

        .summary-card {
            border-radius: 12px;
            padding: 15px;
            text-align: center;
        }
    </style>
@endsection
@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-2">Absensi {{ $extracurricular->name }}</h4>
                    <h6 class="fw-semibold text-white mb-2">Rekap kehadiran siswa eskul {{ $extracurricular->name }}</h6>
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

    <div class="d-flex align-items-center mb-4 mt-4">
        <h4 class="fw-semibold mb-0">Absensi Hari Ini / </h4>
        <span class="ms-2 px-3 py-1 rounded-2 fw-semibold bg-light-primary" style="color: #098FC6;">
            <i class="ti ti-calendar me-1"></i> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </span>
    </div>

    <div class="row g-2 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm h-100 mb-0">
                <div class="card-body py-3">
                    <div class="d-flex">
                        <div class="border border-success"></div>
                        <div class="ms-3">
                            <h4>Hadir</h4>
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
                            <h4>Izin</h4>
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
                            <h4>Sakit</h4>
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
                            <h4>Alpha</h4>
                            <h4 class="text-danger">
                                <b>{{ $summary['alpha'] ?? 0 }}</b>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="card card-body mt-3">
        <h4><b>Daftar Absensi</b></h4>
        <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 mb-4 gap-3">
            <form class="d-flex gap-2 align-items-center" method="GET" action="{{ url()->current() }}">
                <input type="hidden" name="extracurricular" value="{{ $extracurricular->id }}">
                <input type="hidden" name="date" value="{{ request('date', now()->format('Y-m-d')) }}">
                <div class="position-relative">
                    <input type="text" name="search" class="form-control search-chat py-2 px-4 ps-5" id="search-name"
                        placeholder="Cari Siswa" value="{{ old('search', request('search')) }}">
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                </div>
                <div>
                    <select name="status" class="form-select py-2" id="search-status" style="min-width: 120px;">
                        <option value="" {{ request('status') == '' ? 'selected' : '' }}>Semua Status</option>
                        <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="alpha" {{ request('status') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                    </select>
                </div>
                <button type="submit" class="btn text-white px-4" style="background-color: #098FC6;">Filter</button>
            </form>

            <form class="d-flex gap-2 align-items-center" method="GET" action="{{ url()->current() }}">
                <input type="hidden" name="extracurricular" value="{{ $extracurricular->id }}">
                @if (request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                @if (request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <div class="position-relative">
                    <input type="date" name="date" class="form-control search-chat py-2 px-2 ps-3" id="search-date"
                        value="{{ request('date', now()->format('Y-m-d')) }}">
                </div>
                <button type="submit" class="btn text-white px-4" style="background-color: #098FC6;">Cari</button>
            </form>
        </div>

        <div class="table-responsive rounded-3 mb-4">
            <table class="table border text-nowrap customize-table mb-0 align-middle">
                <thead class="fs-4">
                    <tr>
                        <th class="text-white" style="background-color: #098FC6;">No</th>
                        <th class="text-white" style="background-color: #098FC6;">Nama</th>
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
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $esStudent->student->user->avatar ?? asset('assets/images/default-user.jpeg') }}"
                                        class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                    <div class="ms-3">
                                        <h6 class="fs-4 fw-semibold mb-0">{{ $esStudent->student->user->name }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $esStudent->student->classroomStudents->first()?->classroom?->name ?? 'N/A' }}</td>
                            <td>
                                <span
                                    class="badge {{ $status == 'hadir' ? 'bg-success' : ($status == 'sakit' ? 'bg-warning' : ($status == 'izin' ? 'bg-info' : ($status == 'alpha' ? 'bg-danger' : 'bg-light text-dark'))) }} px-3 py-2">
                                    {{ ucfirst($status == 'belum' ? 'Belum Absen' : $status) }}
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
