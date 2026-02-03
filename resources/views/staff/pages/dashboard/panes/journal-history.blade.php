<div class="row">
    <div class="col-lg-12 col-md-12">
        @forelse ($employeeJournals as $employeeJournal)
            <div class="col-md-12 d-flex align-items-stretch">
                <div class="card w-100 shadow-sm" style="border-radius: 12px; border: 1px solid #e0e0e0; overflow: hidden;">
                    <div class="card-header" style="color: #0896D1 !important; background-color: #0896D1 !important;">
                        <h4 class="mb-0 text-white card-title">
                            Jurnal - Staff
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
                                {{ \Carbon\Carbon::parse($employeeJournal->created_at)->translatedFormat('d F Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-lg-9 col-md-8">
                                <h5 class="fw-bold mb-3 text-dark">Deskripsi</h5>
                                <p class="text-muted mb-0" style="color: #6c757d; line-height: 1.6;">
                                    @if ($employeeJournal->status->value == 'completed')
                                        {{ \Illuminate\Support\Str::limit($employeeJournal->description, 200) }}
                                    @else
                                        @if (\Carbon\Carbon::parse($employeeJournal->created_at)->isToday())
                                            Belum mengisi jurnal.
                                        @else
                                            Tidak mengisi jurnal.
                                        @endif
                                    @endif
                                </p>
                            </div>
                            <div
                                class="col-lg-3 col-md-4 mt-3 mt-md-0 d-flex justify-content-center justify-content-md-end border-start">

                                @if ($employeeJournal->status->value == 'completed')
                                    <button type="button"
                                        class="btn text-white fw-bold d-inline-flex align-items-center py-2 px-3 w-100 justify-content-center btn-detail-journal"
                                        style="background-color: #0896d1; border-radius: 6px;"
                                        data-title="{{ $employeeJournal->title }}"
                                        data-description="{{ $employeeJournal->description }}">
                                        Lihat Detail Jurnal
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="ms-2"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </button>

                                    <!-- Helper Modal for Detail (Inline to avoid complexity or use existing JS) -->
                                    <!-- Using existing btn-detail-journal class trigger if preferred, but direct modal nicer -->
                                @else
                                    @if (\Carbon\Carbon::parse($employeeJournal->created_at)->isToday())
                                        <div class="w-100 text-center py-2 rounded"
                                            style="background-color: #FFF9E1; color: #F9A825; font-weight: bold;">
                                            Belum Mengisi
                                        </div>
                                    @else
                                        <div class="w-100 text-center py-2 rounded"
                                            style="background-color: #FDEDED; color: #D9534F; font-weight: bold;">
                                            Tidak Mengisi
                                        </div>
                                    @endif
                                @endif

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
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="mb-1" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M17.92 11.62a1 1 0 0 0-.21-.33l-5-5a1 1 0 0 0-1.42 1.42l3.3 3.29H7a1 1 0 0 0 0 2h7.59l-3.3 3.29a1 1 0 0 0 0 1.42a1 1 0 0 0 1.42 0l5-5a1 1 0 0 0 .21-.33a1 1 0 0 0 0-.76" />
                </svg>
            </a>
        @endif

    </div>
</div>

<!-- Include Modal Detail Jurnal -->
@include('staff.pages.journal.widget.modal-detail')