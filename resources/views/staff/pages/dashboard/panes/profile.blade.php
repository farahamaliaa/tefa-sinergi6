<div class="row">
    <!-- Profile Staff Card -->
    <div class="col-lg-6 mb-3">
        <div class="card h-100 border-1 shadow-sm overflow-hidden">
            <!-- Header Background with Gradient -->
            <div class="position-relative rounded-2"
                style="height: 130px; background: linear-gradient(45deg, #0169C2 0%, #7ED4EF 100%);">\
                <img src="{{ asset('assets/images/background/doble-bubble-1.png') }}"
                    class="position-absolute top-0 end-0" style="width: 200px; z-index: 0; opacity: 1;" alt="Background">
                <img src="{{ asset('assets/images/background/some-square.png') }}"
                    class="position-absolute bottom-0 start-0" style="width: 100px; z-index: 0; opacity: 1;"
                    alt="Background">
                <h5 class="text-white fw-bold position-absolute top-0 start-0 p-4">Profile Staff</h5>
            </div>

            <div class="card-body text-center pt-0 position-relative">
                <!-- Profile Image -->
                <div class="d-flex justify-content-center position-relative" style="margin-top: -60px; z-index: 2;">
                    <img src="{{ asset('assets/images/default-user.jpeg') }}" alt="Profile"
                        class="rounded-circle border border-2 border-white shadow-sm object-fit-cover"
                        style="width: 110px; height: 110px;">
                </div>

                <div class="mt-3">
                    <h3 class="fw-bold text-dark mb-1">{{ auth()->user()->name }}</h3>
                    <p class="text-muted fs-4 mb-2">Staff Tata Usaha</p>
                    <p class="text-dark fw-bold mb-0" style="letter-spacing: 0.5px;">NIP : 1234567891011</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Status Card -->
    <div class="col-lg-6 mb-3">
        <div class="card h-100 border-1 shadow-sm position-relative overflow-hidden">
            <img src="{{ asset('assets/images/background/calender2.png') }}" class="position-absolute bottom-0 end-0"
                style="width: 200px; z-index: 0; opacity: 1;" alt="Background">

            <img src="{{ asset('assets/images/background/buble.png') }}" class="position-absolute top-0 end-0"
                style="width: 100px; z-index: 0; opacity: 0.5; rotate: -90deg;" alt="Background">

            <div class="card-body p-4 position-relative" style="z-index: 1;">
                <h5 class="fw-bold text-dark mb-3" style="font-size: 1.25rem;">Status Absensi Hari Ini</h5>

                <p class="text-muted mb-4" style="max-width: 65%; font-size: 0.9rem; line-height: 1.6;">
                    Anda belum melakukan absensi hari ini. Silakan login melalui aplikasi mobile SINERGI6 untuk
                    melakukan absensi di wilayah sekolah.
                </p>

                <div class="mb-4">
                    <div class="d-flex align-items-center mb-2 text-dark">
                        <!-- Clock Icon -->
                        <span class="me-2 text-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </span>
                        <span class="fw-medium">Jam Kerja: 07.00 - 16.00 WIB</span>
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

                <button class="btn border-0 fw-bold px-4 py-2 rounded-2"
                    style="background-color: #E6E6E6; color: #555; pointer-events: none;">
                    Belum Absen
                </button>
            </div>
        </div>
    </div>
</div>
