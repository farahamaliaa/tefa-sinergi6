@extends('student.layouts.app')
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
            background-color: #0896D1;
            color: #fff;
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

        .badge-hadir {
            background-color: #E8FFF3 !important;
            color: #13DEB9 !important;
        }

        .badge-sakit {
            background-color: #FFF4E5 !important;
            color: #FA896B !important;
        }

        .badge-izin {
            background-color: #ECF2FF !important;
            color: #5D87FF !important;
        }

        .badge-alpha {
            background-color: #FFE1E1 !important;
            color: #DC3545 !important;
        }

        .badge-belum {
            background-color: #F3F4F6 !important;
            color: #6B7280 !important;
        }
    </style>
@endsection
@section('content')
    {{-- <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="text-white mt-2">{{ $extracurricular->name }}</h4>
                    <p class="text-white mt-2">Riwayat absensi harian Siswa</p>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n3">
                        <img src="{{ asset('assets/images/background/book.png') }}" alt=""
                            class="img-fluid img-header-floating">
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Absensi Ekstrakurikuler</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    {{ $extracurricular->name }}
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n3">
                        <img src="{{ asset('assets/images/background/laptops.png') }}" alt=""
                            class="img-fluid img-header-floating">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-semibold mb-3">Absensi Hari Ini :</h5>
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-semibold text-dark mb-0">
                    @if (isset($todaySchedule))
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    @else
                        -
                    @endif
                </h5>
                @if (isset($todaySchedule))
                    @if ($hasAttendedToday)
                        <button class="btn btn-success" style="background-color: #34D399; border-color: #34D399;" disabled>
                            <i class="ti ti-check me-2"></i>Sudah Absen
                        </button>
                    @else
                        <a href="{{ route('student.extracurricular.attendance.create', $extracurricular->id) }}"
                            class="btn btn-primary" style="background-color: #0896D1; border-color: #0896D1;">
                            <i class="ti ti-check me-2"></i>Absen Sekarang
                        </a>
                    @endif
                @else
                    <button class="btn btn-secondary" disabled>
                        Belum Ada Jadwal
                    </button>
                @endif
            </div>
            @if (isset($todaySchedule))
                <div class="mt-2">
                    @if ($hasAttendedToday)
                        <span class="badge bg-light-success text-success">Sudah Absen</span>
                    @else
                        <span class="badge bg-light-secondary text-secondary">Belum Absen</span>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <div class="card card-body">
        <h4><b>Riwayat Absensi</b></h4>
        <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 mb-4 gap-3">
            <form class="d-flex gap-2 align-items-center" method="GET" action="{{ url()->current() }}">
                <div class="position-relative">
                    <input type="date" name="date" class="form-control search-chat py-2 px-2 ps-3" id="search-date"
                        value="{{ request('date') }}">
                </div>

                <div>
                    <select name="status" class="form-select py-2" id="search-status" style="min-width: 120px;">
                        <option value="" {{ request('status') == '' ? 'selected' : '' }}>Semua Status</option>
                        <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="alpha" {{ request('status') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                    </select>
                </div>

                <button type="submit" class="btn text-white px-4" style="background-color: #098FC6;">Filter</button>
            </form>
        </div>
        <div class="">
            <div class="table-responsive rounded-2 mb-4">
                <table class="table border text-nowrap customize-table mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th class="text-white" style="background-color: #098FC6;">No</th>
                            <th class="text-white" style="background-color: #098FC6;">Hari</th>
                            <th class="text-white" style="background-color: #098FC6;">Tanggal</th>
                            <th class="text-white" style="background-color: #098FC6;">Masuk</th>
                            <th class="text-white" style="background-color: #098FC6;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attendances as $attendance)
                            <tr>
                                <td>{{ $loop->iteration + ($attendances->currentPage() - 1) * $attendances->perPage() }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('l') }}</td>
                                <td>{{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('d/m/Y') }}
                                </td>
                                <td>{{ ($attendance->status == 'hadir' && $attendance->created_at && $attendance->created_at->format('H:i') != '00:00') ? \Carbon\Carbon::parse($attendance->created_at)->format('H:i') : '-' }}
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match (strtolower($attendance->status)) {
                                            'hadir' => 'badge-hadir',
                                            'sakit' => 'badge-sakit',
                                            'izin' => 'badge-izin',
                                            'alpha' => 'badge-alpha',
                                            default => 'badge-belum',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt=""
                                            width="150px">
                                        <p class="fs-5 text-dark text-center mt-2">
                                            Belum ada riwayat absensi
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination justify-content-end mt-2 mb-0">
                {{ $attendances->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection