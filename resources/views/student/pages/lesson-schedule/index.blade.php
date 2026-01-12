@php
    use Carbon\Carbon;
@endphp
@extends('student.layouts.app')

@section('style')
    <style>
        body {
            background-color: #f4f6f9;
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

        /* Navigasi Hari & Tombol Kembali Container */
        .nav-container {
            background: white;
            border-radius: 12px;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            /* box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02); */
            flex-wrap: wrap;
            gap: 10px;
        }

        /* Tab Navigasi Hari */
        .nav-pills {
            display: flex;
            gap: 10px;
        }

        .nav-pills .nav-link {
            color: #333;
            font-weight: 500;
            padding: 8px 25px;
            border-radius: 20px;
            background: transparent;
            font-size: 1rem;
        }

        .nav-pills .nav-link.active {
            background-color: #0896D1 !important;
            color: white !important;
            /* box-shadow: 0 4px 6px rgba(8, 150, 209, 0.2); */
        }

        .nav-pills .nav-link:hover:not(.active) {
            background-color: #f0f0f0;
        }

        /* Tombol Kembali Orange */
        .btn-back {
            background-color: #FFAA00;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background-color: #ff9900;
            color: white;
            transform: translateY(-1px);
        }

        /* Kartu Jadwal */
        .schedule-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            background: white;
            /* box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); */
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .schedule-header {
            background-color: #0896D1;
            color: white;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .schedule-body {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            font-size: 0.85rem;
            color: #666;
        }

        .badge-category {
            background-color: #E6F7FF;
            color: #0896D1;
            padding: 4px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .badge-category.agama {
            background-color: #FFF7E6;
            color: #FFAA00;
        }

        .subject-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            line-height: 1.4;
        }

        .teacher-chip {
            background-color: #EEF8FC;
            color: #0896D1;
            padding: 8px 12px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            margin-top: auto;
            align-self: flex-start;
        }

        .card-border {
            border: 1px solid #E0E6ED !important;
            box-shadow: none !important;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .nav-container {
                justify-content: center;
            }

            .header-wave::after {
                opacity: 0.3;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Header Section -->
    {{-- <div class="header-wave mb-4">
        <h3 class="fw-bold text-white mb-1">Jadwal Pelajaran</h3>
        <p class="mb-0 text-white-50">Lihat jadwal mata pelajaran kamu</p>
    </div> --}}

    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Jadwal Pelajaran</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item text-white" aria-current="page">Lihat jadwal mata pelajaran kamu</li>
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

    <!-- Navigation & Action Bar -->
    <div class="nav-container card-border">
        <!-- Day Tabs -->
        <ul class="nav nav-pills" id="dayTabs" role="tablist">
            @foreach ($days as $day)
                @if ($day != 'saturday' && $day != 'sunday')
                    <!-- Filter hari sekolah Senin-Jumat sesuai gambar -->
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $day == $today ? 'active' : '' }}" id="{{ $day }}-tab"
                            data-bs-toggle="pill" data-bs-target="#{{ $day }}" type="button" role="tab"
                            aria-controls="{{ $day }}" aria-selected="{{ $day == $today ? 'true' : 'false' }}">
                            {{ $dayLabels[$day] }}
                        </button>
                    </li>
                @endif
            @endforeach
        </ul>

        <!-- Back Button -->
        <a href="{{ route('student.dashboard') }}" class="btn-back">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Schedule Content Grid -->
    <div class="tab-content" id="dayTabsContent">
        @foreach ($days as $day)
            @if ($day != 'saturday' && $day != 'sunday')
                <div class="tab-pane fade {{ $day == $today ? 'show active' : '' }}" id="{{ $day }}"
                    role="tabpanel" aria-labelledby="{{ $day }}-tab">

                    @if ($schedules[$day]->count() > 0)
                        <div class="row g-4">
                            @foreach ($schedules[$day] as $schedule)
                                <div class="col-md-6 col-lg-4">
                                    <div class="schedule-card card-border">
                                        <div class="schedule-header">
                                            <span>Jam ke {{ $schedule->lesson_hour_start }}
                                                @if ($schedule->lesson_hour_end != $schedule->lesson_hour_start)
                                                    – {{ $schedule->lesson_hour_end }}
                                                @endif
                                            </span>
                                            <span>
                                                {{ Carbon::parse($schedule->start->start ?? '00:00')->format('H:i') }} -
                                                {{ Carbon::parse($schedule->end->end ?? '00:00')->format('H:i') }}
                                            </span>
                                        </div>
                                        <div class="schedule-body">
                                            <div class="meta-row">
                                                <span>Mata Pelajaran :</span>
                                                @php
                                                    $subjectName = $schedule->teacherSubject->subject->name ?? '-';
                                                    $isReligion = stripos($subjectName, 'Agama') !== false;
                                                    $categoryLabel = $isReligion ? 'Agama' : 'Umum';
                                                    $categoryClass = $isReligion ? 'agama' : '';
                                                @endphp
                                                <span
                                                    class="badge-category {{ $categoryClass }}">{{ $categoryLabel }}</span>
                                            </div>
                                            <h5 class="subject-title">
                                                {{ $subjectName }}
                                            </h5>
                                            <div class="teacher-chip">
                                                {{-- <i class="ti ti-id-badge-2"></i> --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-id mb-0">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                                                    <path d="M9 10m-3 0a3 3 0 0 1 6 0a3 3 0 0 1 -6 0" />
                                                    <path d="M15 8l2 0" />
                                                    <path d="M15 12l2 0" />
                                                    <path d="M7 16l10 0" />
                                                </svg>
                                                {{ $schedule->teacherSubject->employee->user->name ?? 'Guru' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div
                            class="d-flex flex-column align-items-center justify-content-center py-5 bg-white rounded-3 card-border">
                            <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt="No Data"
                                width="200" class="mb-3 opacity-75">
                            <p class="text-muted fs-4">Tidak ada jadwal pelajaran hari ini</p>
                        </div>
                    @endif
                </div>
            @endif
        @endforeach
    </div>
@endsection
