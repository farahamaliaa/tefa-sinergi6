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

        .btn-primary {
            background-color: #0896D1 !important;
            border-color: #0896D1 !important;
        }

        .eskul-card {
            transition: all 0.2s;
            border: 1px solid #E0E6ED;
        }

        .eskul-card:hover {
            border-color: #0896D1;
            transform: translateY(-2px);
        }

        .schedule-badge {
            background-color: #E0F2FE;
            color: #0284C7;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .schedule-badge.today {
            background-color: #D1FAE5;
            color: #059669;
            font-weight: 600;
        }
    </style>
@endsection

@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Ekstrakurikuler Saya</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    Daftar eskul yang kamu ikuti
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

    <div class="row mt-4">
        @forelse($enrollments as $enrollment)
            @php
                $extracurricular = $enrollment->extracurricular;
                $todaySchedule = $extracurricular->schedules->where('day', $today)->first();
                $now = now();
            @endphp
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card eskul-card h-100">
                    <div class="card-body">
                        <h5 class="fw-semibold mb-2">{{ $extracurricular->name }}</h5>
                        <p class="text-muted small mb-3">
                            <i class="ti ti-user me-1"></i>Pembina: {{ $extracurricular->employee->user->name ?? '-' }}
                        </p>

                        <h6 class="fw-semibold text-muted mb-2">Jadwal:</h6>
                        <div class="d-flex flex-wrap gap-1 mb-3">
                            @forelse($extracurricular->schedules as $schedule)
                                <span class="schedule-badge {{ $schedule->day === $today ? 'today' : '' }}">
                                    {{ ucfirst(\App\Enums\DayEnum::tryFrom($schedule->day)?->label() ?? $schedule->day) }}
                                    ({{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }})
                                </span>
                            @empty
                                <span class="text-muted">Belum ada jadwal</span>
                            @endforelse
                        </div>

                        @if($todaySchedule)
                            @php
                                $scheduleStart = \Carbon\Carbon::parse($todaySchedule->start_time);
                                $scheduleEnd = \Carbon\Carbon::parse($todaySchedule->end_time);
                                $isWithinSchedule = $now->between(
                                    $scheduleStart->copy()->subMinutes(30),
                                    $scheduleEnd
                                );
                            @endphp
                            @if($isWithinSchedule && $todaySchedule->latitude)
                                <a href="{{ route('student.extracurricular.attendance', $extracurricular->id) }}"
                                    class="btn btn-primary w-100 mb-2">
                                    <i class="ti ti-map-pin me-1"></i> Absen Sekarang
                                </a>
                            @elseif($todaySchedule->latitude)
                                <button class="btn btn-secondary w-100 mb-2" disabled>
                                    <i class="ti ti-clock me-1"></i> Jadwal: {{ $scheduleStart->format('H:i') }}
                                </button>
                            @else
                                <button class="btn btn-secondary w-100 mb-2" disabled>
                                    <i class="ti ti-map-pin-off me-1"></i> Lokasi belum diatur
                                </button>
                            @endif
                        @else
                            <button class="btn btn-outline-secondary w-100 mb-2" disabled>
                                Tidak ada jadwal hari ini
                            </button>
                        @endif

                        <a href="{{ route('student.extracurricular.permission', $extracurricular->id) }}"
                            class="btn btn-outline-warning w-100">
                            <i class="ti ti-file-text me-1"></i> Ajukan Izin
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt="" width="200px">
                        <h5 class="mt-3 text-muted">Kamu belum terdaftar di ekstrakurikuler manapun</h5>
                        <p class="text-muted">Hubungi pembina atau operator untuk mendaftar ekstrakurikuler</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
@endsection