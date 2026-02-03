@extends('school.layouts.app')

@section('content')
    <style>
        .card {
            border: 1px solid #E0E6ED !important;
            box-shadow: none !important;
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

        .table-custom-header th {
            background-color: #0896D1 !important;
            color: #fff !important;
        }

        .btn-primary {
            background-color: #0896D1 !important;
            border-color: #0896D1 !important;
        }

        .btn-primary:hover {
            background-color: #067aa7 !important;
            border-color: #067aa7 !important;
        }

        .card-body-custom {
            border-radius: 10px !important;
        }
    </style>

    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Cetak Jurnal Guru</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    Halaman untuk melakukan export data jurnal guru berdasarkan rentang tanggal, kelas, dan
                                    mapel.
                                </a>
                            </li>
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

    <div class="card card-body card-body-custom">
        <div class="card bg-light-warning shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ti ti-info-circle text-warning fs-7"></i>
                            <h4 class="fw-semibold mb-0 text-warning">Perhatian</h4>
                        </div>
                        <p class="mb-0 mt-2 text-dark">
                            Lengkapi form dibawah untuk melakukan export jurnal guru.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <form id="form-action" class="row align-items-end">
            <div class="col-12 col-md-3 mb-3">
                <label for="startDate" class="form-label fw-semibold">Tanggal Awal</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent"><i class="ti ti-calendar fs-5"></i></span>
                    <input type="date" class="form-control" id="startDate" name="start"
                        value="{{ request('start') ?? now()->format('Y-m-d') }}">
                </div>
            </div>
            <div class="col-12 col-md-3 mb-3">
                <label for="endDate" class="form-label fw-semibold">Tanggal Akhir</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent"><i class="ti ti-calendar fs-5"></i></span>
                    <input type="date" class="form-control" id="endDate" name="end"
                        value="{{ request('end') ?? now()->format('Y-m-d') }}">
                </div>
            </div>
            <div class="col-12 col-md-3 mb-3">
                <label for="kelas" class="form-label fw-semibold">Kelas</label>
                <select class="form-select" id="kelas" name="classroom">
                    <option value="" disabled selected>Pilih Kelas</option>
                    @forelse ($classrooms as $classroom)
                        <option value="{{ $classroom->id }}"
                            {{ old('classroom', request('classroom')) == $classroom->id ? 'selected' : '' }}>
                            {{ $classroom->name }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div class="col-12 col-md-3 mb-3">
                <label for="mapel" class="form-label fw-semibold">Mapel</label>
                <select class="form-select" id="mapel" name="subject">
                    <option value="" disabled selected>Pilih Mapel</option>
                    @forelse ($subjects as $subject)
                        <option value="{{ $subject->id }}"
                            {{ old('subject', request('subject')) == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div class="col-12 d-flex gap-2 justify-content-end mb-3">
                <button type="submit" class="btn-review btn btn-warning px-4 d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5A6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5S14 7.01 14 9.5S11.99 14 9.5 14" />
                    </svg>
                    Tampilkan
                </button>
                <button type="submit" class="btn-export btn btn-primary px-4 d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                        <g fill="none">
                            <path
                                d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                            <path fill="currentColor"
                                d="M16.9 3a1.1 1.1 0 0 1 1.094.98L18 4.1V7h1a3 3 0 0 1 2.995 2.824L22 10v7a2 2 0 0 1-1.85 1.995L20 19h-2v1.9a1.1 1.1 0 0 1-.98 1.094L16.9 22H7.1a1.1 1.1 0 0 1-1.094-.98L6 20.9V19H4a2 2 0 0 1-1.995-1.85L2 17v-7a3 3 0 0 1 2.824-2.995L5 7h1V4.1a1.1 1.1 0 0 1 .98-1.094L7.1 3zM16 16H8v4h8zm3-7H5a1 1 0 0 0-.993.883L4 10v7h2v-1.9a1.1 1.1 0 0 1 .98-1.094L7.1 14h9.8a1.1 1.1 0 0 1 1.094.98l.006.12V17h2v-7a1 1 0 0 0-1-1m-2 1a1 1 0 0 1 .117 1.993L17 12h-2a1 1 0 0 1-.117-1.993L15 10zm-1-5H8v2h8z" />
                        </g>
                    </svg>
                    Download
                </button>
            </div>
        </form>
    </div>

    <div class="card card-body card-body-custom">
        <h4 class="mb-4">Daftar Jurnal</h4>
        <div class="table-responsive rounded-3 mb-4">
            <table class="table border text-nowrap customize-table mb-0 align-middle">
                <thead class="fs-4 table-custom-header">
                    <tr>
                        <th class="text-white">No</th>
                        <th class="text-white">Nama Guru</th>
                        <th class="text-white">Tanggal</th>
                        <th class="text-white">Kelas / Mapel</th>
                        <th class="text-white">Deskripsi</th>
                        <th class="text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($journals as $journal)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-start">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('admin_assets/dist/images/profile/user-10.jpg') }}"
                                        class="rounded-circle me-2 user-profile" style="object-fit: cover" width="40"
                                        height="40" alt="" />
                                    <div class="ms-2">
                                        <h6 class="fs-4 fw-semibold mb-0 text-start">
                                            {{ $journal->teacherSubject->employee->user->name }}</h6>
                                        <span class="fw-normal">{{ $journal->teacherSubject->employee->nip }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($journal->created_at)->translatedFormat('d F Y') }}</td>
                            <td>{{ $journal->classroom->name }} - {{ $journal->teacherSubject->subject->name }}</td>
                            <td>{{ $journal->teacherJournals->first() ? \Illuminate\Support\Str::limit($journal->teacherJournals->first()->description, 50) : 'kosong...' }}
                            </td>
                            <td>
                                <a type="button" class="text-primary btn-detail-journal"
                                    data-author="{{ $journal->teacherSubject->employee->user->name }}"
                                    data-date="{{ \Carbon\Carbon::parse($journal->created_at)->translatedFormat('d F Y') }}"
                                    data-description="{{ $journal->teacherJournals->first() ? $journal->teacherJournals->first()->description : 'kosong...' }}"
                                    data-classroom="{{ $journal->classroom->name }} - {{ $journal->teacherSubject->subject->name }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24">
                                        <g fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1.5">
                                            <path d="M3 13c3.6-8 14.4-8 18 0" />
                                            <path d="M12 17a3 3 0 1 1 0-6a3 3 0 0 1 0 6" />
                                        </g>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center align-middle">
                                <div class="d-flex flex-column justify-content-center align-items-center p-4">
                                    <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt=""
                                        width="300px">
                                    <p class="fs-5 text-dark text-center mt-2">
                                        Belum ada data jurnal guru
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @include('school.pages.journals.widgets.modal-detail')
@endsection

@section('script')
    <script>
        $('.btn-review').on('click', function() {
            $('#form-action').attr('action', '{{ route('school.export-journal.index') }}');
        });

        $('.btn-export').on('click', function() {
            $('#form-action').attr('action', '{{ route('school.export-journal.export') }}');
        });
    </script>
    @include('school.pages.journals.scripts.detail')
@endsection
