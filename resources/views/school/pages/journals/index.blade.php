@extends('school.layouts.app')

<style>
    .card {
        border: 1px solid #E0E6ED !important; 
        box-shadow: none !important;
    }

    .card-hover:hover {
        border-color: #00A9D9 !important;
        transition: .2s ease-in-out;
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
</style>

@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Jurnal Mengajar</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    Daftar jurnal guru setelah kegiatan  mengajar
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

    <div class="container-fluid note-has-grid">
        <ul class="nav nav-pills p-3 mb-3 rounded align-items-center card flex-row flex-wrap" id="nav-tab" role="tablist">
            <li class="nav-item col-12 col-md-auto mb-2 mb-md-0">
                <a class="nav-link note-link d-flex align-items-center justify-content-center px-3 text-body-color"
                    id="all-tab" data-bs-toggle="pill" href="#all-content" role="tab" aria-controls="teacher-content">
                    <span>Semua</span>
                </a>
            </li>
            <li class="nav-item col-12 col-md-auto mb-2 mb-md-0">
                <a class="nav-link note-link d-flex align-items-center justify-content-center px-3 text-body-color"
                    id="fill-tab" data-bs-toggle="pill" href="#fill-content" role="tab" aria-controls="employee-content">
                    <span>Mengisi</span>
                </a>
            </li>
            <li class="nav-item col-12 col-md-auto mb-2 mb-md-0">
                <a class="nav-link note-link d-flex align-items-center justify-content-center px-3 text-body-color"
                    id="notfill-tab" data-bs-toggle="pill" href="#notfill-content" role="tab" aria-controls="employee-content">
                    <span>Tidak Mengisi</span>
                </a>
            </li>
            <li class="nav-item ms-md-auto col-12 col-md-auto d-flex justify-content-center justify-content-md-end align-items-center">
                <a href="{{ route('school.export-journal.index') }}" type="button" class="btn btn-warning w-100 w-md-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M16 8V5H8v3H6V3h12v5zM4 10h16zm14 2.5q.425 0 .713-.288T19 11.5t-.288-.712T18 10.5t-.712.288T17 11.5t.288.713t.712.287M16 19v-4H8v4zm2 2H6v-4H2v-6q0-1.275.875-2.137T5 8h14q1.275 0 2.138.863T22 11v6h-4zm2-6v-4q0-.425-.288-.712T19 10H5q-.425 0-.712.288T4 11v4h2v-2h12v2z" />
                    </svg>
                    Download Jurnal
                </a>
            </li>
        </ul>



        <!-- Tab Content -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade" id="all-content" role="tabpanel" aria-labelledby="all-tab">
                @include('school.pages.journals.panes.journal-all')
            </div>
            <div class="tab-pane fade" id="fill-content" role="tabpanel" aria-labelledby="fill-tab">
                @include('school.pages.journals.panes.journal-fill')
            </div>
            <div class="tab-pane fade" id="notfill-content" role="tabpanel" aria-labelledby="notfill-tab">
                @include('school.pages.journals.panes.journal-notfill')
            </div>
        </div>
    </div>

    @include('school.pages.journals.widgets.modal-detail')
@endsection

@section('script')
    @include('school.pages.journals.scripts.tab-script')
    @include('school.pages.journals.scripts.detail')
@endsection
