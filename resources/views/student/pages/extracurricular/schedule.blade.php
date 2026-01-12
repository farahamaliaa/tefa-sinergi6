@php
    use App\Enums\DayEnum;
    use Carbon\Carbon;
@endphp
@extends('student.layouts.app')

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

        .table thead th {
            background-color: #0896D1 !important;
            color: white !important;
        }

        .schedule-card {
            border-left: 4px solid #0896D1;
            transition: transform 0.2s;
        }

        .schedule-card:hover {
            transform: translateX(5px);
        }

        .day-badge {
            background-color: #0896D1;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.875rem;
        }

        .time-badge {
            background-color: #F0F9FF;
            color: #0896D1;
            padding: 5px 12px;
            border-radius: 8px;
            font-weight: 600;
        }

        .location-info {
            background-color: #F8F9FA;
            border-radius: 8px;
            padding: 10px 15px;
            margin-top: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Jadwal Ekstrakurikuler</h4>
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

    <div class="card mt-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="ti ti-calendar me-2"></i>Daftar Jadwal Kegiatan</h5>
            <span class="badge bg-primary">{{ $schedules->count() }} Jadwal</span>
        </div>
        <div class="card-body">
            @if ($schedules->count() > 0)
                <div class="row">
                    @foreach ($schedules as $schedule)
                        <div class="col-md-6 mb-3">
                            <div class="card schedule-card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <span class="day-badge">
                                            <i class="ti ti-calendar-event me-1"></i>
                                            {{ DayEnum::tryFrom($schedule->day)?->label() ?? ucfirst($schedule->day) }}
                                        </span>
                                        <div class="time-badge">
                                            <i class="ti ti-clock me-1"></i>
                                            {{ Carbon::parse($schedule->start_time)->format('H:i') }} -
                                            {{ Carbon::parse($schedule->end_time)->format('H:i') }}
                                        </div>
                                    </div>

                                    @if ($schedule->location_name)
                                        <div class="location-info">
                                            <div class="d-flex align-items-center">
                                                <i class="ti ti-map-pin text-primary me-2 fs-5"></i>
                                                <div>
                                                    <small class="text-muted d-block">Lokasi</small>
                                                    <span class="fw-medium">{{ $schedule->location_name }}</span>
                                                </div>
                                            </div>
                                            @if ($schedule->radius)
                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        <i class="ti ti-circle-dot me-1"></i>
                                                        Radius absensi: {{ $schedule->radius }} meter
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="location-info">
                                            <div class="text-muted">
                                                <i class="ti ti-map-pin-off me-1"></i>
                                                Lokasi belum ditentukan
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt="" width="150px">
                    <p class="text-muted mt-3">Belum ada jadwal untuk ekstrakurikuler ini</p>
                </div>
            @endif
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="ti ti-info-circle me-2"></i>Informasi Pembina</h5>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                    style="width: 50px; height: 50px;">
                    <i class="ti ti-user fs-4"></i>
                </div>
                <div>
                    <h6 class="mb-0">{{ $extracurricular->employee->user->name ?? 'Belum ditentukan' }}</h6>
                    <small class="text-muted">Pembina Ekstrakurikuler</small>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('student.extracurricular.index') }}" class="btn btn-outline-secondary">
            <i class="ti ti-arrow-left me-1"></i> Kembali ke Daftar Ekstrakurikuler
        </a>
    </div>
@endsection
