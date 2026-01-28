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
<div class="row me-3">
    <div class="col-lg-12 col-md-12">
        @forelse ($teacherJournals->take(3) as $teacherJournal)
            <div class="col-md-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-header" style="color: #0896D1 !important; background-color: #0896D1 !important;">
                        <h4 class="mb-0 text-white card-title">
                            {{ $teacherJournal->lessonSchedule->classroom->name }} -
                            {{ $teacherJournal->lessonSchedule->teacherSubject->subject->name }}
                        </h4>
                        <div class="position-absolute top-0 end-0" style="padding: 0px; position: relative;">
                            <img src="{{ asset('assets/images/background/arrow-leftwarning1.png') }}" alt="Description"
                                class="img-fluid" style="max-width: 268px; height: auto; position: relative;">
                            <span class="d-flex align-items-center justify-content-end pe-4"
                                style="position: absolute; top: 0; bottom: 0; left: 0; right: 0; color: white; font-weight: bold; font-size: 13px">

                                <svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="18" height="18"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M12 12h5v5h-5zm7-9h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2m0 2v2H5V5zM5 19V9h14v10z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($teacherJournal->date)->isoFormat('DD MMMM YYYY') }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row pb-2" style="border-bottom: 1px solid #c0c0c0">
                            <div class="col-lg-8" style="border-right: 1px solid #c0c0c0;">
                                <div class="pe-3">
                                    <h5 class="card-title mb-4">Deskripsi:</h5>
                                    @if(isset($teacherJournal->is_filled) && $teacherJournal->is_filled)
                                        <p>{{ \Illuminate\Support\Str::limit($teacherJournal->description, 100) }}</p>
                                    @else
                                        <p class="text-muted">-</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="ps-3">
                                    <h5 class="card-title mb-4 ms-5 ps-3">Rekap Absensi:</h5>
                                    <div class="row px-3">
                                        <div class="col-lg-3">
                                            <div class="text-center">
                                                @if(isset($teacherJournal->is_filled) && $teacherJournal->is_filled)
                                                    <span
                                                        class="badge bg-light-success text-success fs-7 fw-semibold mb-1 d-inline-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px;">{{ $teacherJournal->attendanceJournals->where('status', App\Enums\AttendanceEnum::PRESENT)->count() }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-light-success text-success fs-7 fw-semibold mb-1 d-inline-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px;">-</span>
                                                @endif
                                                <p>Masuk</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="text-center">
                                                @if(isset($teacherJournal->is_filled) && $teacherJournal->is_filled)
                                                    <span
                                                        class="badge bg-light-primary fs-7 fw-semibold mb-1 d-inline-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px; color: #0896D1 !important;">{{ $teacherJournal->attendanceJournals->where('status', App\Enums\AttendanceEnum::PERMIT)->count() }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-light-primary text-primary fs-7 fw-semibold mb-1 d-inline-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px; color: #0896D1 !important;">-</span>
                                                @endif
                                                <p>Izin</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="text-center">
                                                @if(isset($teacherJournal->is_filled) && $teacherJournal->is_filled)
                                                    <span
                                                        class="badge bg-light-primary fs-7 fw-semibold mb-1 d-inline-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px; color: #0896D1 !important;">{{ $teacherJournal->attendanceJournals->where('status', App\Enums\AttendanceEnum::SICK)->count() }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-light-primary text-primary fs-7 fw-semibold mb-1 d-inline-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px; color: #0896D1 !important;">-</span>
                                                @endif
                                                <p>Sakit</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="text-center">
                                                @if(isset($teacherJournal->is_filled) && $teacherJournal->is_filled)
                                                    <span
                                                        class="badge bg-light-danger text-danger fs-7 fw-semibold mb-1 d-inline-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px;">{{ $teacherJournal->attendanceJournals->where('status', App\Enums\AttendanceEnum::ALPHA)->count() }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-light-danger text-danger fs-7 fw-semibold mb-1 d-inline-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px;">-</span>
                                                @endif
                                                <p>Alfa</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div>
                            @if(isset($teacherJournal->is_filled) && $teacherJournal->is_filled)
                                <a href="{{ route('teacher.journals.show', $teacherJournal->id) }}"
                                    class="btn btn-primary mt-3">
                                    Lihat Detail Jurnal
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="mb-1"
                                        viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M17.92 11.62a1 1 0 0 0-.21-.33l-5-5a1 1 0 0 0-1.42 1.42l3.3 3.29H7a1 1 0 0 0 0 2h7.59l-3.3 3.29a1 1 0 0 0 0 1.42a1 1 0 0 0 1.42 0l5-5a1 1 0 0 0 .21-.33a1 1 0 0 0 0-.76" />
                                    </svg>
                                </a>
                            @else
                                <span class="badge bg-light-danger text-danger mt-3 px-3 py-2">Jurnal tidak diisi</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center align-middle">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt="" width="300px">
                    <p class="fs-5 text-dark text-center mt-2">
                        Belum ada data
                    </p>
                </div>
            </div>
        @endforelse
    </div>
</div>