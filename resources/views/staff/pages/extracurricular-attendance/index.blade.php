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

    <div class="row mt-4">
        <div class="col-md-3 mb-3">
            <div class="card summary-card" style="background-color: #D1FAE5;">
                <h3 class="fw-bold mb-0" style="color: #059669;">{{ $summary['hadir'] ?? 0 }}</h3>
                <small class="fw-semibold" style="color: #059669;">Hadir</small>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card summary-card" style="background-color: #FEF3C7;">
                <h3 class="fw-bold mb-0" style="color: #D97706;">{{ $summary['sakit'] ?? 0 }}</h3>
                <small class="fw-semibold" style="color: #D97706;">Sakit</small>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card summary-card" style="background-color: #DBEAFE;">
                <h3 class="fw-bold mb-0" style="color: #2563EB;">{{ $summary['izin'] ?? 0 }}</h3>
                <small class="fw-semibold" style="color: #2563EB;">Izin</small>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card summary-card" style="background-color: #FEE2E2;">
                <h3 class="fw-bold mb-0" style="color: #DC2626;">{{ $summary['alpha'] ?? 0 }}</h3>
                <small class="fw-semibold" style="color: #DC2626;">Alpha</small>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="card mt-3">
        <div class="card-body">
            <form method="GET" class="d-flex flex-wrap gap-3 align-items-end">
                <input type="hidden" name="extracurricular" value="{{ $extracurricular->id }}">
                <div>
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="date" class="form-control"
                        value="{{ request('date', now()->format('Y-m-d')) }}">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-filter me-1"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-body mt-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Daftar Absensi - {{ Carbon::parse(request('date', now()))->translatedFormat('d F Y') }}</h4>
        </div>

        <div class="table-responsive rounded-3 mb-4">
            <table class="table border text-nowrap customize-table mb-0 align-middle">
                <thead class="fs-4 table-header-custom">
                    <tr>
                        <th class="text-white">No</th>
                        <th class="text-white">Nama</th>
                        <th class="text-white">Kelas</th>
                        <th class="text-white">Status</th>
                        <th class="text-white">Waktu Absen</th>
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
                                <span class="badge badge-{{ $status }} px-3 py-2">
                                    {{ ucfirst($status == 'belum' ? 'Belum Absen' : $status) }}
                                </span>
                            </td>
                            <td>
                                @if($attendance)
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
                                    <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt="" width="200px">
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
