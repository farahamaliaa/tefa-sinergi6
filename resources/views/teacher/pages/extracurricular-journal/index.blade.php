@php
    use Carbon\Carbon;
    use App\Enums\DayEnum;
@endphp
@extends('teacher.layouts.app')
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
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Jurnal Pembina Eskul</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    {{ auth()->user()->name }} - {{ $extracurricular->name }}
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

    <div class="row me-3 mb-3">
        <div class="col-lg-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div class="d-flex align-items-start align-items-md-center mb-3 mb-md-0">
                    <span class="mb-1 badge p-1" style="color: #0896D1 !important; background-color: #0896D1 !important;">
                        <i class="ti ti-notebook fs-5 text-white"></i>
                    </span>
                    <h4 class="ms-3 mb-0">Pengisian Jurnal</h4>
                </div>
                <div class="d-flex align-items-start align-items-md-center">
                    <p class="mb-0">Tanggal saat ini:</p>
                    <span class="badge bg-light-primary text-secondary ms-2 fw-semibold d-flex align-items-center gap-2">
                        <i class="ti ti-calendar fs-5"></i>
                        {{ now()->format('d F Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Today's Schedules --}}
    <div class="card border shadow mt-3">
        <div class="card-body pt-3">
            <h4 class="pb-3">Jadwal Kegiatan Ekstrakurikuler Hari Ini
                ({{ ucfirst(DayEnum::tryFrom(strtolower(now()->format('l')))?->label() ?? now()->format('l')) }})</h4>
            <div class="table-responsive rounded-2 mb-4">
                <table class="table text-nowrap border customize-table mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th class="text-white" style="background-color: #0896D1 !important;">No</th>
                            <th class="text-white" style="background-color: #0896D1 !important;">Hari</th>
                            <th class="text-white" style="background-color: #0896D1 !important;">Jam</th>
                            <th class="text-white" style="background-color: #0896D1 !important;">Total Hadir</th>
                            <th class="text-white" style="background-color: #0896D1 !important;">Status</th>
                            <th class="text-center text-white" style="background-color: #0896D1 !important;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($todaySchedules as $index => $schedule)
                            @php
                                $existingJournal = $todaysJournals->firstWhere('schedule_id', $schedule->id);
                                $attendanceCount = $existingJournal ? $existingJournal->attendances->where('status', 'hadir')->count() : 0;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ ucfirst(DayEnum::tryFrom($schedule->day)?->label() ?? $schedule->day) }}</td>
                                <td>{{ Carbon::parse($schedule->start_time)->format('H:i') }} -
                                    {{ Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                                <td>{{ $attendanceCount }} Siswa Hadir</td>
                                <td>
                                    @if (!$existingJournal)
                                        <span class="badge px-3 py-2 rounded-2 fw-semibold"
                                            style="background-color: #FEF2F2; color: #DC2626;">Belum Mengisi</span>
                                    @else
                                        <span class="badge px-3 py-2 rounded-2 fw-semibold"
                                            style="background-color: #F0FDFA; color: #0D9488;">Sudah Mengisi</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if (!$existingJournal)
                                        <a href="{{ route('teacher.extracurricular-journal.create', ['extracurricular' => $extracurricular->id, 'schedule' => $schedule->id]) }}"
                                            class="btn btn-sm d-inline-flex align-items-center justify-content-center"
                                            style="background-color: #E0F2FE; color: #0284C7; width: 32px; height: 32px;">
                                            <i class="ti ti-plus fs-5"></i>
                                        </a>
                                    @else
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="{{ route('teacher.extracurricular-journal.show', ['id' => $existingJournal->id]) }}"
                                                class="btn btn-sm d-inline-flex align-items-center justify-content-center"
                                                style="background-color: #E0F2FE; color: #0284C7; width: 32px; height: 32px;">
                                                <i class="ti ti-eye fs-5"></i>
                                            </a>
                                            <a href="{{ route('teacher.extracurricular-journal.edit', ['id' => $existingJournal->id]) }}"
                                                class="btn btn-sm d-inline-flex align-items-center justify-content-center"
                                                style="background-color: #FEF3C7; color: #D97706; width: 32px; height: 32px;">
                                                <i class="ti ti-pencil fs-5"></i>
                                            </a>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt=""
                                            width="150px">
                                        <p class="fs-5 text-dark text-center mt-2">
                                            Tidak ada jadwal untuk hari ini
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

    {{-- Journal History --}}
    <div class="row me-3 mb-3">
        <div class="col-lg-6 col-md-12 mb-3">
            <div class="d-flex align-items-start align-items-md-center mb-3 mb-md-0">
                <span class="mb-1 badge p-1" style="color: #0896D1 !important; background-color: #0896D1 !important;">
                    <i class="ti ti-history fs-5 text-white"></i>
                </span>
                <h4 class="ms-3 mb-0">Riwayat Jurnal</h4>
            </div>
        </div>
    </div>

    <div class="row me-3 mb-3">
        @forelse ($journalHistory as $journal)
            <div class="col-md-12 d-flex align-items-stretch mb-4">
                <div class="card w-100 shadow-sm border" style="border-radius: 8px; overflow: hidden;">
                    <div class="card-header" style="color: #0896D1 !important; background-color: #0896D1 !important;">
                        <h4 class="mb-0 text-white card-title">
                            {{ $extracurricular->name }} -
                            {{ ucfirst(DayEnum::tryFrom($journal->schedule->day)?->label() ?? $journal->schedule->day) }}
                        </h4>
                        <div class="position-absolute top-0 end-0" style="padding: 0px; position: relative;">
                            <img src="{{ asset('assets/images/background/arrow-leftwarning1.png') }}" alt="" class="img-fluid"
                                style="max-width: 268px; height: auto; position: relative;">
                            <span class="d-flex align-items-right ms-5"
                                style="position: absolute; top: 50%; left: 65%; transform: translate(-50%, -50%); color: white; font-weight: bold;width: 100%; font-size: 13px">
                                <i class="ti ti-calendar me-2"></i>
                                {{ $journal->date->format('d M Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="d-flex flex-column flex-md-row gap-4">
                            <div style="min-width: 200px; max-width: 200px;">
                                <img src="{{ asset('storage/' . $journal->image) }}" class="img-fluid rounded-3 w-100"
                                    style="height: 140px; object-fit: cover;" alt="Dokumentasi">
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fw-semibold text-dark mb-2">Deskripsi</h5>
                                <p class="text-muted mb-0" style="line-height: 1.6; text-align: justify;">
                                    {{ Str::limit($journal->description, 200) }}
                                </p>
                                <div class="mt-2">
                                    <span class="badge bg-light-success text-success">
                                        {{ $journal->attendances->where('status', 'hadir')->count() }} Hadir
                                    </span>
                                    <span class="badge bg-light-warning text-warning">
                                        {{ $journal->attendances->where('status', 'izin')->count() }} Izin
                                    </span>
                                    <span class="badge bg-light-info text-info">
                                        {{ $journal->attendances->where('status', 'sakit')->count() }} Sakit
                                    </span>
                                    <span class="badge bg-light-danger text-danger">
                                        {{ $journal->attendances->where('status', 'alpha')->count() }} Alpha
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <a href="{{ route('teacher.extracurricular-journal.show', ['id' => $journal->id]) }}"
                                class="btn btn-primary d-inline-flex align-items-center px-4 py-2"
                                style="background-color: #0896D1; border: none;">
                                Lihat Detail Jurnal
                                <i class="ti ti-arrow-right ms-2 fs-5"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt="" width="200px">
                        <p class="fs-5 text-dark text-center mt-2">
                            Belum ada riwayat jurnal
                        </p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($journalHistory->hasPages())
        <div class="d-flex justify-content-center">
            {{ $journalHistory->appends(['extracurricular' => $extracurricular->id])->links() }}
        </div>
    @endif
@endsection
