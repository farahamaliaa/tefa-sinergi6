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
                <h6 class="mb-4 fw-bolder text-dark" style="font-size: 20px;">Profile Pembina</h6>
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ auth()->user()->employee && auth()->user()->employee->image && Storage::disk('public')->exists(auth()->user()->employee->image) ? asset('storage/' . auth()->user()->employee->image) : asset('assets/images/default-user.jpeg') }}"
                        width="90" height="90" alt="Profile"
                        class="rounded-circle object-fit-cover me-4 border border-3 border-white shadow-sm">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">{{ auth()->user()->name }}</h4>
                        <p class="text-muted mb-0 fs-6">Pembina Ekstrakurikuler</p>
                    </div>
                </div>
                <div class="pt-2">
                    @forelse ($extracurriculars as $eskul)
                        <div class="badge bg-light-primary text-primary me-1 mb-1">
                            {{ $eskul->name }}
                        </div>
                    @empty
                        <div class="badge bg-light-warning text-warning">Anda tidak membina ekstrakurikuler apapun</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-3">
        <div class="card h-100 border shadow-none position-relative overflow-hidden">

            <img src="{{ asset('assets/images/asset.png') }}" alt="" class="position-absolute"
                style="top: 0; right: 0; width: 100px; z-index: 5;">
            <!-- Whistle Icon (custom SVG to match the blue whistle in the image) -->
            <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%); z-index: 5;">
                <svg width="150" height="150" viewBox="0 0 137 137" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M25.0888 21.792C23.6492 21.792 21.7794 22.4583 19.1063 24.1914C20.1675 25.4442 21.2916 26.7834 23.5133 29.3438C25.0604 31.1267 26.622 32.9 27.8015 34.1838C27.8116 34.195 27.8162 34.1985 27.8261 34.2095L36.0927 29.4113L32.1721 25.6256C29.1506 23.1093 27.1834 21.9153 25.3708 21.8011C25.2768 21.7951 25.1829 21.7921 25.0888 21.792ZM57.2196 25.8276C56.9838 25.825 56.7481 25.8259 56.5123 25.8303C53.7135 25.8819 51.1073 26.427 49.3568 27.2816L31.3589 37.7273C32.0145 37.8729 32.666 38.0474 33.3088 38.2678C37.9312 39.8527 42.1637 43.1439 46.5721 47.5528L104.487 104.681L126.155 92.7914L69.183 29.8025C66.8668 27.7047 63.1651 26.3486 59.3647 25.951C58.6519 25.8769 57.9359 25.8359 57.2193 25.8279L57.2196 25.8276ZM15.5742 27.4906C10.8801 33.0356 10.0701 37.4408 11.4733 42.7436C11.6585 43.4441 12.2913 44.4446 13.1786 45.5452C13.7831 44.6796 14.4155 43.8338 15.0747 43.0091C16.1423 41.6725 17.3183 40.5519 18.5759 39.6488L18.5476 39.5953L19.2882 39.1645C19.6473 38.9355 20.016 38.7218 20.3933 38.5242L23.5689 36.6806C22.324 35.2995 21.0928 33.906 19.8755 32.5005C18.434 30.8373 17 29.1673 15.5742 27.4906ZM64.8335 31.0863L80.4641 47.5879C68.1325 46.2401 65.2683 51.1199 61.994 56.739L46.6526 40.8706L64.8335 31.0863ZM27.7517 42.0709C27.56 42.0665 27.3681 42.0667 27.1764 42.0715C25.3098 42.1196 23.3749 42.6221 21.2223 43.6462C20.4102 44.2589 19.6195 45.0365 18.8381 46.0148C11.9427 54.6479 10.6904 61.838 12.0192 68.3514C13.348 74.8648 17.5142 80.8355 22.1647 86.1333C25.7272 90.1919 29.887 92.553 35.1347 93.6068C40.383 94.661 46.7578 94.3314 54.395 92.6769C63.2909 90.7504 72.0578 94.9299 80.0317 100.079C87.0203 104.593 93.5914 110.004 99.0244 113.445L101.376 108.378L43.1728 50.9642L43.1669 50.9583C39.013 46.8044 35.2559 44.0267 31.7461 42.8234C30.4029 42.3626 29.0904 42.1025 27.7517 42.0709ZM125.974 98.3844L106.321 109.169L103.516 115.207L122.47 104.93L125.974 98.3846L125.974 98.3844Z"
                        fill="#0896D1" />
                </svg>
            </div>


            <div class="card-body p-4 position-relative" style="z-index: 1;">
                <div class="d-flex justify-content-between align-items-start h-100 text-start">
                    @if ($extracurriculars->count() > 0)
                        <div class="pt-1 ps-1">
                            <h6 class="mb-4 fw-bolder text-dark" style="font-size: 20px;">Mengajar Ekskul :</h6>
                            <h2 class="fw-bold mb-3 text-dark" style="font-size: 42px;">
                                {{ $extracurriculars->pluck('name')->join(', ') }}
                            </h2>

                            <div class="badge px-3 py-2 rounded-2 fw-medium fs-6 d-inline-flex align-items-center"
                                style="background: #EAF0FD; color: #098FC6;">
                                {{ $extracurriculars->sum(function ($e) {return $e->extracurricularStudents->count();}) }}
                                Total Siswa
                            </div>
                        </div>
                    @else
                        <div class="pt-1 ps-1">
                            <h6 class="mb-4 fw-bolder text-dark" style="font-size: 20px;">Mengajar Ekskul :</h6>
                            <h2 class="fw-bold mb-3 text-muted" style="font-size: 24px;">
                                Belum ada ekstrakurikuler yang dibina
                            </h2>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>
