@php
    use App\Enums\DayEnum;
    use Carbon\Carbon;
@endphp
@extends('student.layouts.app')

@section('style')
    <style>
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

        .section-title-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            margin-top: 30px;
        }

        .section-icon-box {
            background-color: #E6F6FD;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0896D1;
            font-size: 24px;
        }

        .schedule-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            border: 1px solid #f0f0f0;
            height: 100%;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .schedule-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        }

        .day-initial-box {
            background-color: #EEF7FF;
            color: #0896D1;
            width: 80px;
            height: 80px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            font-weight: 500;
            flex-shrink: 0;
        }

        .schedule-info {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #333;
            font-size: 14px;
            font-weight: 500;
        }

        .info-item i {
            color: #555;
            width: 18px;
            text-align: center;
        }

        .radius-badge {
            background-color: #E6F6FD;
            color: #0896D1;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 5px;
            align-self: flex-start;
            width: 100%;
        }

        .card-border {
            border: 1px solid #E0E6ED !important;
            box-shadow: none !important;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .header-wave::after {
                opacity: 0.3;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Header Banner -->
    {{-- <div class="header-wave mb-4">
        <h3 class="fw-bold text-white mb-2">Jadwal Ekstrakulikuler</h3>
        <p class="mb-0 text-white-50">Lihat jadwal Ekstrakulikuler yang kamu ikuti.</p>
    </div> --}}

    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Jadwal Ekstrakulikuler</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item text-white" aria-current="page">Lihat jadwal Ekstrakulikuler yang
                                kamu ikuti</li>
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

    <!-- Section Title -->
    <div class="section-title-wrapper">
        <div class="section-icon-box">
            <svg width="70" height="70" viewBox="0 0 70 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="70" height="70" rx="10" fill="#ECF2FF" />
                <path
                    d="M50.8776 43.0413V27.6663H26.9609V43.0413H50.8776ZM50.8776 19.1247C51.7838 19.1247 52.6528 19.4846 53.2935 20.1254C53.9343 20.7661 54.2943 21.6352 54.2943 22.5413V43.0413C54.2943 43.9475 53.9343 44.8165 53.2935 45.4573C52.6528 46.098 51.7838 46.458 50.8776 46.458H26.9609C26.0548 46.458 25.1857 46.098 24.545 45.4573C23.9042 44.8165 23.5443 43.9475 23.5443 43.0413V22.5413C23.5443 21.6352 23.9042 20.7661 24.545 20.1254C25.1857 19.4846 26.0548 19.1247 26.9609 19.1247H28.6693V15.708H32.0859V19.1247H45.7526V15.708H49.1693V19.1247H50.8776ZM44.9497 32.8938L37.3647 40.4788L32.7864 35.9005L34.5972 34.0897L37.3647 36.8572L43.1388 31.083L44.9497 32.8938ZM20.1276 49.8747H44.0443V53.2913H20.1276C19.2214 53.2913 18.3524 52.9314 17.7117 52.2906C17.0709 51.6499 16.7109 50.7808 16.7109 49.8747V29.3747H20.1276V49.8747Z"
                    fill="#0896D1" />
            </svg>

        </div>
        <h4 class="fw-bold mb-0 text-dark">Jadwal Ekstrakulikuler</h4>
    </div>

    <!-- Schedule Cards Grid -->
    <div class="row g-4">
        @if ($schedules->count() > 0)
            @foreach ($schedules as $schedule)
                @php
                    $dayLabel = DayEnum::tryFrom($schedule->day)?->label() ?? ucfirst($schedule->day);
                    $initial = substr($dayLabel, 0, 1);
                    $startTime = Carbon::parse($schedule->start_time)->format('H:i');
                    $endTime = Carbon::parse($schedule->end_time)->format('H:i');
                    $nextDate = Carbon::parse('next ' . $schedule->day)->locale('id');
                    if (strtolower(Carbon::now()->format('l')) == $schedule->day) {
                        $nextDate = Carbon::now()->locale('id');
                    }
                    $formattedDate = $nextDate->isoFormat('DD MMMM YYYY');
                @endphp
                <div class="col-md-6 col-lg-3">
                    <div class="schedule-card card-border">
                        <div class="d-flex gap-4">
                            <!-- Left: Initial Box -->
                            <div class="day-initial-box">
                                <p>
                                    {{ $initial }}
                                </p>
                            </div>

                            <!-- Right: Details -->
                            <div class="schedule-info w-100">
                                <!-- Date -->
                                <div class="info-item">
                                    <i class="ti ti-calendar"></i>
                                    <span class="fw-semibold">{{ $dayLabel }}, {{ $formattedDate }}</span>
                                </div>

                                <!-- Time -->
                                <div class="info-item">
                                    <i class="ti ti-clock"></i>
                                    <span>{{ $startTime }} WIB - {{ $endTime }} WIB</span>
                                </div>

                                <!-- Location -->
                                <div class="info-item">
                                    <i class="ti ti-map-pin"></i>
                                    <span>{{ $schedule->location_name ?? 'Lokasi belum ditentukan' }}</span>
                                </div>

                                <!-- Radius Badge -->
                                <div class="radius-badge bg-light-primary">
                                    <i class="ti ti-crosshair"></i>
                                    Radius Absensi: {{ $schedule->radius ?? 100 }} meter
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div
                    class="d-flex flex-column align-items-center justify-content-center py-5 bg-white rounded-4 card-border">
                    <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt="No Data" width="200"
                        class="mb-3 opacity-75">
                    <p class="text-muted fs-5 fw-medium">Belum ada jadwal ekstrakurikuler</p>
                </div>
            </div>
        @endif
    </div>
@endsection
