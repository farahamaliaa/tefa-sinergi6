<div class="row">
    <div class="col-lg-12 col-md-12">
        @forelse ($employeeJournals as $employeeJournal)
            <div class="col-md-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-header" style="border-radius: 0.50rem; background-color: #0896D1;">
                        <h4 class="mb-0 text-white card-title">
                            {{ $employeeJournal->title }}
                        </h4>
                        <div class="position-absolute top-0 end-0" style="padding: 0px; position: relative;">
                            <img src="{{ asset('assets/images/background/arrow-leftwarning.png') }}" alt="Description"
                                class="img-fluid" style="max-width: 210px; height: auto; position: relative;">
                            <span class="d-flex align-items-center ms-5 fs-2"
                                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-weight: bold;width: 100%;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="20" height="20"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M12 12h5v5h-5zm7-9h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2m0 2v2H5V5zM5 19V9h14v10z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($employeeJournal->created_at)->translatedFormat('d F Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-lg-9 col-md-8 position-relative">
                                <h5 class="fw-bold mb-3 text-dark">Deskripsi</h5>
                                <p class="text-muted mb-0" style="color: #6c757d; line-height: 1.6;">
                                    {{ \Illuminate\Support\Str::limit($employeeJournal->description, 200) }}
                                </p>
                                <!-- Vertical Divider for Desktop -->
                                <div class="d-none d-md-block position-absolute opacity-25"
                                    style="top: 0; right: 0; bottom: 0; border-right: 2px solid #ccc;"></div>
                            </div>
                            <div
                                class="col-lg-3 col-md-4 mt-3 mt-md-0 d-flex justify-content-center justify-content-md-end">
                                <a href="{{ route('employee.journal.detail', ['employeeJournal' => $employeeJournal->id]) }}"
                                    class="btn text-white fw-bold d-inline-flex align-items-center py-2 px-3"
                                    style="background-color: #0896d1; border-radius: 6px;">
                                    Lihat Detail Jurnal
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="ms-2"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </a>
                            </div>
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

        @if ($employeeJournals->count() < 0)
            <a href="{{ route('employee.journal.index') }}"
                class="btn mb-1 waves-effect waves-light btn-outline-primary w-100">Lihat Selengkapnya
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="mb-1"
                    viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M17.92 11.62a1 1 0 0 0-.21-.33l-5-5a1 1 0 0 0-1.42 1.42l3.3 3.29H7a1 1 0 0 0 0 2h7.59l-3.3 3.29a1 1 0 0 0 0 1.42a1 1 0 0 0 1.42 0l5-5a1 1 0 0 0 .21-.33a1 1 0 0 0 0-.76" />
                </svg>
            </a>
        @endif

    </div>
</div>
