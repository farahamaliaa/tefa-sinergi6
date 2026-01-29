<div class="row">
    <div class="col-lg-6 mb-3">
        <div class="card h-100 border-1 shadow-sm overflow-hidden">
            <div class="position-relative rounded-2"
                style="height: 130px; background: linear-gradient(45deg, #0169C2 0%, #7ED4EF 100%);">\
                <img src="{{ asset('assets/images/background/doble-bubble-1.png') }}"
                    class="position-absolute top-0 end-0" style="width: 200px; z-index: 0; opacity: 1;"
                    alt="Background">
                <img src="{{ asset('assets/images/background/some-square.png') }}"
                    class="position-absolute bottom-0 start-0" style="width: 100px; z-index: 0; opacity: 1;"
                    alt="Background">
                <h4 class="text-white fw-bold position-absolute top-0 start-0 p-4">Profile Staff</h4>
            </div>

            <div class="card-body text-center pt-0 position-relative">
                <div class="d-flex justify-content-center position-relative" style="margin-top: -60px; z-index: 2;">
                    <img src="{{ auth()->user()->employee && auth()->user()->employee->image ? asset('storage/' . auth()->user()->employee->image) : asset('assets/images/default-user.jpeg') }}"
                        alt="Profile" class="rounded-circle border border-2 border-white shadow-sm object-fit-cover"
                        style="width: 110px; height: 110px;">
                </div>

                <div class="mt-3">
                    <h3 class="fw-bold text-dark mb-1">{{ auth()->user()->name }}</h3>
                    <p class="text-muted fs-4 mb-2">
                        @if(auth()->user()->employee && auth()->user()->employee->position == 'ketua_tu')
                            Kepala Tata Usaha
                        @else
                            Staff Tata Usaha
                        @endif
                    </p>
                    <p class="text-dark fw-bold mb-0" style="letter-spacing: 0.5px;">NIP :
                        {{ auth()->user()->employee ? auth()->user()->employee->nip : '-' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-3">
        <div class="card h-100 border-1 shadow-sm position-relative overflow-hidden">
            <img src="{{ asset('assets/images/background/calender2.png') }}" class="position-absolute bottom-0 end-0"
                style="width: 200px; z-index: 0; opacity: 1;" alt="Background">

            <img src="{{ asset('assets/images/background/bub-kebalik.png') }}" class="position-absolute top-0 end-0"
                style="width: 125px; z-index: 0; opacity: 0.5;" alt="Background">

            <div class="card-body p-4 position-relative" style="z-index: 1;">
                <div class="mb-3 d-flex align-items-center gap-3">
                    <h4 class="fw-bold text-dark">Status Absensi Hari Ini</h4>
                    @if($todayAttendance)
                        @php
                            $isNormalPresence = in_array($todayAttendance->status->value, ['present', 'late']);
                        @endphp
                        @if($todayAttendance->checkout)
                            <span class="border-0 fw-bold px-4 py-2 rounded-2" style="background-color: #1EBB9E; color: white;">
                                Sudah Lengkap
                            </span>
                        @elseif($isNormalPresence)
                            <span class="border-0 fw-bold px-4 py-2 rounded-2" style="background-color: #0896D1; color: white;">
                                Sudah Masuk
                            </span>
                        @else
                            <span class="border-0 fw-bold px-4 py-2 rounded-2 {{ $todayAttendance->status->color() }}">
                                {{ ucfirst($todayAttendance->status->label()) }}
                            </span>
                        @endif
                    @else
                        @php
                            $currentTime = now()->format('H:i');
                            $isLate = isset($timeConfig['late_limit']) ? $currentTime > $timeConfig['late_limit'] : false;
                        @endphp

                        @if($todayPermission)
                            <span class="border-0 fw-bold px-4 py-2 rounded-2" style="background-color: #00CFE8; color: white;">
                                {{ ucfirst($todayPermission->permission_type->label()) }}
                            </span>
                        @elseif($isLate)
                            <span class="border-0 fw-bold px-4 py-2 rounded-2" style="background-color: #EA5455; color: white;">
                                Alpha
                            </span>
                        @else
                            <span class="border-0 fw-bold px-4 py-2 rounded-2" style="background-color: #E6E6E6; color: #555;">
                                Belum Absen
                            </span>
                        @endif
                    @endif
                </div>

                @if($todayAttendance)
                    @php
                        $isNormalPresence = in_array($todayAttendance->status->value, ['present', 'late']);
                    @endphp
                    <p class="text-muted mb-4" style="max-width: 65%; font-size: 0.9rem; line-height: 1.6;">
                        @if($todayAttendance->checkout)
                            Absensi hari ini sudah lengkap. Masuk:
                            {{ $todayAttendance->checkin ? \Carbon\Carbon::parse($todayAttendance->checkin)->format('H:i') : '-' }}
                            - Pulang:
                            {{ $todayAttendance->checkout ? \Carbon\Carbon::parse($todayAttendance->checkout)->format('H:i') : '-' }}
                        @elseif($isNormalPresence)
                            Anda sudah absen masuk pada
                            {{ $todayAttendance->checkin ? \Carbon\Carbon::parse($todayAttendance->checkin)->format('H:i') : '-' }}
                            WIB. Jangan lupa absen pulang.
                        @else
                            Status absensi hari ini: <strong>{{ ucfirst($todayAttendance->status->label()) }}</strong>.
                        @endif
                    </p>
                @else
                    <p class="text-muted mb-4" style="max-width: 65%; font-size: 0.9rem; line-height: 1.6;">
                        @if($todayPermission)
                            Anda memiliki izin yang telah disetujui:
                            <strong>{{ ucfirst($todayPermission->permission_type->label()) }}</strong>.
                        @elseif($isLate)
                            Batas waktu absensi telah berakhir. Status Anda hari ini: <strong>Alpha</strong>.
                        @else
                            Anda belum melakukan absensi hari ini. Silakan untuk melakukan absensi di wilayah sekolah.
                        @endif
                    </p>
                @endif

                <div class="mb-4">
                    <div class="d-flex align-items-center mb-2 text-dark">
                        <span class="me-2 text-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </span>
                        <span class="fw-medium">Jam Kerja: {{ config('attendance.time.check_in_start', '07:00') }} -
                            {{ config('attendance.time.check_out_start', '16:00') }} WIB</span>
                    </div>
                    <div class="d-flex align-items-center text-dark">
                        <!-- Map Pin Icon -->
                        <span class="me-2 text-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </span>
                        <span class="fw-medium">Lokasi : Area Sekolah</span>
                    </div>
                </div>

                @if($todayAttendance && $todayAttendance->checkout)
                    <button class="btn border-0 fw-bold d-flex align-items-center gap-2 py-2 rounded-2"
                        style="background-color: #1EBB9E; color: white; pointer-events: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        Sudah Absen Lengkap
                    </button>
                @elseif($todayAttendance)
                    @php
                        $isNormalPresence = in_array($todayAttendance->status->value, ['present', 'late']);
                    @endphp
                    @if($isNormalPresence)
                        <button class="btn border-0 fw-bold d-flex align-items-center gap-2 py-2 rounded-2"
                            style="background-color: #F59E0B; color: white; pointer-events: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            Menunggu Absen Pulang
                        </button>
                    @else
                        <button class="btn border-0 fw-bold d-flex align-items-center gap-2 py-2 rounded-2"
                            style="background-color: #E6E6E6; color: #555; pointer-events: none;">
                            <i class="ti ti-info-circle fs-5"></i>
                            Status: {{ ucfirst($todayAttendance->status->label()) }}
                        </button>
                    @endif
                @else
                    @if($todayPermission || $isLate)
                        <button class="btn border-0 fw-bold d-flex align-items-center gap-2 py-2 rounded-2"
                            style="background-color: #E6E6E6; color: #555; pointer-events: none;">
                            <i class="ti ti-info-circle fs-5"></i>
                            Status: {{ $todayPermission ? ucfirst($todayPermission->permission_type->label()) : 'Alpha' }}
                        </button>
                    @else
                        <a href="{{ route('employee.attendance.index') }}"
                            class="btn border-0 fw-bold d-flex align-items-center gap-2 py-2 rounded-2"
                            style="background-color: #0896D1; color: white; width: fit-content;">
                            <svg width="19" height="13" viewBox="0 0 19 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6.49795 10.1626L16.9112 0.347439C17.1569 0.115813 17.4436 0 17.7713 0C18.099 0 18.3856 0.115813 18.6314 0.347439C18.8771 0.579065 19 0.854313 19 1.17318C19 1.49206 18.8771 1.76692 18.6314 1.99777L7.35804 12.6526C7.1123 12.8842 6.8256 13 6.49795 13C6.17029 13 5.8836 12.8842 5.63786 12.6526L0.354434 7.67261C0.108693 7.44098 -0.00926253 7.16612 0.000567093 6.84802C0.0103967 6.52992 0.138591 6.25467 0.385151 6.02227C0.63171 5.78987 0.923733 5.67406 1.26122 5.67483C1.5987 5.6756 1.89031 5.79142 2.13605 6.02227L6.49795 10.1626Z"
                                    fill="white" />
                            </svg>
                            Absen Sekarang
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>