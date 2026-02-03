@php
    use App\Enums\DayEnum;
    use Carbon\Carbon;
@endphp
@extends('staff.layouts.app')
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
        <h4 class="fw-semibold mb-0">{{ isset($isHistory) && $isHistory ? 'Riwayat Absensi' : 'Absensi Tanggal' }} / </h4>
        <span class="ms-2 px-3 py-1 rounded-2 fw-semibold bg-light-primary" style="color: #098FC6;">
            <i class="ti ti-calendar me-1"></i>
            @if(isset($isHistory) && $isHistory)
                Semua Riwayat
            @else
                {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}
            @endif
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
        <div class="d-flex flex-wrap align-items-center mt-3 mb-4 gap-3">
            <form class="d-flex flex-wrap gap-2 align-items-center w-100" method="GET" action="{{ url()->current() }}">
                <input type="hidden" name="extracurricular" value="{{ $extracurricular->id }}">
                <div class="position-relative">
                    <input type="text" name="search" class="form-control search-chat py-2 px-4 ps-5" id="search-name"
                        placeholder="Cari Siswa" value="{{ old('search', request('search')) }}">
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                </div>
                <div>
                    <select name="status" class="form-select py-2" id="search-status" style="min-width: 150px;">
                        <option value="" {{ request('status') == '' ? 'selected' : '' }}>Semua Status</option>
                        <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="alpha" {{ request('status') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                    </select>
                </div>
                <div class="position-relative">
                    <input type="date" name="date" class="form-control search-chat py-2 px-2 ps-3" id="search-date"
                        value="{{ request('date') }}">
                </div>
                <button type="submit" class="btn text-white px-4" style="background-color: #098FC6;">Filter</button>
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
                        <th class="text-white" style="background-color: #098FC6;">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($isHistory) && $isHistory)
                        @forelse ($attendancesPaginator as $attendance)
                            <tr>
                                <td>{{ $loop->iteration + ($attendancesPaginator->currentPage() - 1) * $attendancesPaginator->perPage() }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $attendance->extracurricularStudent->student->image ? asset('storage/' . $attendance->extracurricularStudent->student->image) : asset('assets/images/default-user.jpeg') }}"
                                            class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                        <div class="ms-3">
                                            <h6 class="fs-4 fw-semibold mb-0">
                                                {{ $attendance->extracurricularStudent->student->user->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $attendance->extracurricularStudent->student->classroomStudents->first()?->classroom?->name ?? 'N/A' }}
                                </td>
                                <td>
                                    @php
                                        $status = $attendance->status;
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
                                            default => ucfirst($status),
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }} px-3 py-2">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td>
                                    @if ($status == 'hadir' && $attendance->created_at->format('H:i') != '00:00')
                                        {{ $attendance->created_at->format('H:i') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center align-middle">
                                    <div class="d-flex flex-column justify-content-center align-items-center py-4">
                                        <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt="" width="200px">
                                        <p class="fs-5 text-dark text-center mt-2">Belum ada riwayat absensi</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    @else
                        @forelse ($extracurricularStudents as $esStudent)
                            @php
                                $attendance = $attendanceMap->get($esStudent->id);
                                $status = $attendance?->status ?? 'belum';
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $esStudent->student->image ? asset('storage/' . $esStudent->student->image) : asset('assets/images/default-user.jpeg') }}"
                                            class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                        <div class="ms-3">
                                            <h6 class="fs-4 fw-semibold mb-0">{{ $esStudent->student->user->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $esStudent->student->classroomStudents->first()?->classroom?->name ?? 'N/A' }}</td>
                                <td>
                                    @php
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
                                            default => ucfirst($status),
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }} px-3 py-2">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td>
                                    @if ($attendance && $status == 'hadir' && $attendance->created_at->format('H:i') != '00:00')
                                        {{ $attendance->created_at->format('H:i') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($attendance ? $attendance->date : $date)->format('d/m/Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center align-middle">
                                    <div class="d-flex flex-column justify-content-center align-items-center py-4">
                                        <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt="" width="200px">
                                        <p class="fs-5 text-dark text-center mt-2">Belum ada siswa terdaftar</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>
        @if(isset($isHistory) && $isHistory)
            <div class="d-flex justify-content-end mt-3">
                {{ $attendancesPaginator->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection