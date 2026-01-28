@extends('extracurricular.layouts.app')

@section('style')
    <style>
        .bg-ekstra {
            background-image: url('{{ asset('assets/images/bg-ekstra.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            width: 100%;
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
    </style>
@endsection

@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Daftar Ekstrakurikuler</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    {{ auth()->user()->name }}
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="120" height="100" viewBox="0 0 24 24">
                            <path fill="#ffffff"
                                d="M5 13.18v2.81c0 .73.4 1.41 1.04 1.76l5 2.73c.6.33 1.32.33 1.92 0l5-2.73c.64-.35 1.04-1.03 1.04-1.76v-2.81l-6.04 3.3c-.6.33-1.32.33-1.92 0zm6.04-9.66l-8.43 4.6c-.69.38-.69 1.38 0 1.76l8.43 4.6c.6.33 1.32.33 1.92 0L21 10.09V16c0 .55.45 1 1 1s1-.45 1-1V9.59c0-.37-.2-.7-.52-.88l-9.52-5.19a2.04 2.04 0 0 0-1.92 0" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h4 class="fw-semibold mt-4">Daftar Ekstrakurikuler yang Diampu</h4>
    <p class="text-muted mb-4">Kelola kegiatan ekstrakurikuler yang Anda bina</p>

    <form action="{{ route('extracurricular.list') }}" method="GET" class="d-flex gap-2 mb-4">
        <div class="position-relative">
            <div class="">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-control search-chat py-2 px-5 ps-5" id="search-name" placeholder="Cari ekstrakurikuler">
                <i class="ti ti-search position-absolute top-50 translate-middle-y fs-6 text-dark ms-3"></i>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Cari</button>
    </form>

    <div class="row mt-4">
        @forelse ($extracurriculars as $extracurricular)
            <div class="col-lg-6 col-md-12 mb-3">
                <div class="card bg-ekstra border shadow-none">
                    <div class="p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="text-primary fw-bold mb-2">{{ $extracurricular->name }}</h5>
                                <p class="text-primary mb-0">
                                    <i class="ti ti-users fs-5 me-1"></i>
                                    {{ $extracurricular->extracurricularStudents->count() }} Siswa
                                </p>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('extracurricular.students.index', ['extracurricular' => $extracurricular->id]) }}"
                                    class="btn btn-sm btn-primary" title="Daftar Siswa">
                                    <i class="ti ti-users"></i>
                                </a>
                                <a href="{{ route('extracurricular.schedule.index', ['extracurricular' => $extracurricular->id]) }}"
                                    class="btn btn-sm btn-success" title="Jadwal">
                                    <i class="ti ti-calendar"></i>
                                </a>
                                <a href="{{ route('extracurricular.journal.index', ['extracurricular' => $extracurricular->id]) }}"
                                    class="btn btn-sm btn-info" title="Jurnal">
                                    <i class="ti ti-notebook"></i>
                                </a>
                                <a href="{{ route('extracurricular.permission.index', ['extracurricular' => $extracurricular->id]) }}"
                                    class="btn btn-sm btn-warning" title="Izin">
                                    <i class="ti ti-file-text"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt="" width="300px">
                    <p class="fs-5 text-dark text-center mt-2">
                        Belum ada ekstrakurikuler yang ditugaskan
                    </p>
                </div>
            </div>
        @endforelse
    </div>
@endsection
