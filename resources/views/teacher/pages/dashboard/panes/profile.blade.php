<div class="row">
    <div class="col-lg-6 col-12 mb-3">
        <div class="card h-100 overflow-hidden position-relative border shadow-none">
            <div class="position-absolute end-0 top-0 h-100" style="z-index: 0; pointer-events: none;">
                <svg preserveAspectRatio="none" style="height: 100%; width: auto;" viewBox="0 0 115 209" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M60.7311 225.393L66.9488 215.899C73.1666 206.405 84.2537 187.306 81.9401 166.094C80.8924 145.988 66.3616 124.763 69.3588 104.993C72.4385 84.2281 94.3121 66.023 97.3093 46.2524C100.307 26.4819 85.7758 5.25764 78.5928 -6.34861L71.3274 -16.9607L147.683 -10.6282L146.858 -0.687043C145.952 10.2483 144.303 30.1306 142.654 50.013C141.005 69.8954 139.356 89.7778 137.624 110.654C135.976 130.537 134.327 150.419 132.678 170.302C130.946 191.178 129.297 211.06 128.473 221.002L127.648 230.943L60.7311 225.393Z"
                        fill="url(#paint0_linear_7601_7655)" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M8.99954 209.293L17.2489 201.5C25.4983 193.706 40.7114 177.697 43.3787 156.527C47.021 136.726 37.8067 112.711 45.3059 94.1738C53.1158 74.6888 78.6141 62.051 86.1134 43.514C93.6126 24.977 84.3983 0.962165 80.1019 -11.9932L75.4948 -24.0006L148.302 -0.138245L145.195 9.34095C141.777 19.7681 135.564 38.7264 129.35 57.6848C123.137 76.6432 116.923 95.6015 110.399 115.508C104.185 134.466 97.9719 153.425 91.7583 172.383C85.2341 192.289 79.0205 211.248 75.9137 220.727L72.8069 230.206L8.99954 209.293Z"
                        fill="url(#paint1_linear_7601_7655)" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M60.7311 225.393L66.9488 215.899C73.1666 206.405 84.2537 187.306 81.9401 166.094C80.8924 145.988 66.3616 124.763 69.3588 104.993C72.4385 84.2281 94.3121 66.023 97.3093 46.2524C100.307 26.4819 85.7758 5.25764 78.5928 -6.34861L71.3274 -16.9607L147.683 -10.6282L146.858 -0.687043C145.952 10.2483 144.303 30.1306 142.654 50.013C141.005 69.8954 139.356 89.7778 137.624 110.654C135.976 130.537 134.327 150.419 132.678 170.302C130.946 191.178 129.297 211.06 128.473 221.002L127.648 230.943L60.7311 225.393Z"
                        fill="url(#paint2_linear_7601_7655)" />
                    <defs>
                        <linearGradient id="paint0_linear_7601_7655" x1="89.4703" y1="227.775" x2="109.504"
                            y2="-13.7903" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#7ED4EF" />
                            <stop offset="0.2294" stop-color="#66BFE6" />
                            <stop offset="0.711" stop-color="#298BD0" />
                            <stop offset="1" stop-color="#0169C2" />
                        </linearGradient>
                        <linearGradient id="paint1_linear_7601_7655" x1="36.4033" y1="218.274" x2="111.896"
                            y2="-12.0656" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#7ED4EF" />
                            <stop offset="0.2294" stop-color="#66BFE6" />
                            <stop offset="0.711" stop-color="#298BD0" />
                            <stop offset="1" stop-color="#0169C2" />
                        </linearGradient>
                        <linearGradient id="paint2_linear_7601_7655" x1="89.4703" y1="227.775" x2="109.504"
                            y2="-13.7903" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#7ED4EF" />
                            <stop offset="0.2294" stop-color="#66BFE6" />
                            <stop offset="0.711" stop-color="#298BD0" />
                            <stop offset="1" stop-color="#0169C2" />
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <div class="card-body position-relative p-4" style="z-index: 1;">
                <h6 class="mb-4 fw-bolder text-dark" style="font-size: 20px;">Profile Guru</h6>
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('assets/images/default-user.jpeg') }}" width="90px" height="90px"
                        alt="Profile" class="img-fluid rounded-circle object-fit-cover me-4 border border-3 border-white shadow-sm">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">{{ auth()->user()->name }}</h4>
                        <p class="text-muted mb-0 fs-6">Tahun Ajaran {{ $schoolYear->school_year }}</p>
                    </div>
                </div>
                <div class="pt-2">
                    @forelse ($teacherSubjects as $teacherSubject)
                        <div class="badge bg-light-primary text-primary me-1 mb-1">
                            {{ $teacherSubject->subject->name }}
                        </div>
                    @empty
                        <div class="badge bg-light-warning text-warning">Anda tidak mengajar pelajaran apapun</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-3">
        <div class="card h-100 border shadow-none position-relative overflow-hidden">

            <img src="{{ asset('assets/images/asset.png') }}" alt=""
                class="position-absolute"
                style="top: 0; right: 0; width: 100px; z-index: 5;">

            <img src="{{ asset('assets/images/Topi.png') }}" alt="Graduation Cap"
                class="position-absolute"
                style="top: 50%; right: 10px; transform: translateY(-50%); width: 150px; z-index: 5;">


            <div class="card-body p-4 position-relative" style="z-index: 10;">
                <div class="d-flex justify-content-between align-items-start h-100 text-start">
                    @if ($classroom)
                        <div class="pt-1 ps-1">
                            <h6 class="mb-4 fw-bolder text-dark" style="font-size: 20px;">Wali Kelas Dari :</h6>
                            <h2 class="fw-bold mb-3 text-dark" style="font-size: 42px;">{{ $classroom->name }}</h2>

                            <div class="badge px-3 py-2 rounded-2 fw-medium fs-6 d-inline-flex align-items-center"
                                style="background: #EAF0FD; color: #047AAB;">
                                {{ $classroom->classroomStudents->count() }} Total Siswa
                            </div>
                        </div>
                    @else
                        <div class="w-100 text-center align-self-center">
                            <h6 class="mb-4 fw-bold text-dark text-start" style="font-size: 20px;">Wali Kelas Dari :</h6>
                            <div class="py-3">
                                <img src="{{ asset('assets/images/Topi.png') }}" width="100" alt="Graduation Cap"
                                    class="img-fluid mb-3 opacity-50">
                                <h4 class="text-muted">Anda Tidak Menjadi Wali Kelas Manapun</h4>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>
