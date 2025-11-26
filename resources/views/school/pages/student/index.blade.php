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
        height: 90px;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 80'%3E%3Cpath fill='%23FFFFFF55' d='M0 32l48 10.7C96 53 192 75 288 69.3c96-5.3 192-42.7 288-48C672 16 768 48 864 58.7 960 69 1056 59 1152 53.3 1248 48 1344 48 1392 48h48v32H0z'/%3E%3C/svg%3E");
        background-size: cover;
        opacity: 0.6;
    }
</style>

@extends('school.layouts.app')

@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Siswa</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    Daftar - daftar siswa dan alumni di Sekolah
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

    <div class="row">
        <div class="col-md-6 col-lg-6">
            <div class="card rounded-3 card-hover position-relative">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-light-success text-success d-inline-block px-3 py-3 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 me-1" width="40" height="40"
                                viewBox="0 0 16 16">
                                <path fill="currentColor"
                                    d="M15 14s1 0 1-1s-1-4-5-4s-5 3-5 4s1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276c.593.69.758 1.457.76 1.72l-.008.002l-.014.002zM11 7a2 2 0 1 0 0-4a2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0a3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904c.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724c.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0a3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4a2 2 0 0 0 0-4" />
                            </svg>
                        </div>
                        <div class="ms-4">
                            <h4 class="card-title text-dark"><b>Jumlah Siswa</b></h4>
                            <h6 style="font-size: 25px; color: #2AB89D"><b>{{ $studentCount }}</b></h6>
                        </div>
                    </div>
                </div>
                <img src="{{ asset('assets/images/background/bub1.png') }}" alt="Image"
                    style="position: absolute; bottom: 0; right: 0; width: auto; height: 90px; border-bottom-right-radius: 13px;">
            </div>
        </div>

        <div class="col-md-6 col-lg-6">
            <div class="card rounded-3 card-hover position-relative">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-light-warning text-warning d-inline-block px-3 py-3 rounded">
                        <svg width="45" height="45" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.638 4.47806C25.1688 3.95393 26.8305 3.95393 28.3613 4.47806C30.5085 5.21147 34.48 6.64797 40.2747 9.06164C44.4455 10.8004 47.4041 12.1459 49.3964 13.1003C50.6953 13.7221 51.4406 14.9474 51.4406 16.2496C51.4406 17.5517 50.6953 18.777 49.3953 19.3988C47.4041 20.3521 44.4455 21.6987 40.2747 23.4375C34.48 25.8511 30.5085 27.2876 28.3613 28.02C26.8305 28.5441 25.1688 28.5441 23.638 28.02C21.4908 27.2876 17.5193 25.8511 11.7245 23.4375C10.1566 22.7852 8.59544 22.1167 7.0413 21.4322V38.7352C8.12401 39.1201 9.03608 39.8748 9.61668 40.8664C10.1973 41.858 10.4091 43.0228 10.2148 44.1553C10.0205 45.2879 9.43262 46.3154 8.55473 47.0569C7.67685 47.7983 6.56537 48.2059 5.4163 48.2079C4.26556 48.2089 3.15158 47.8028 2.27147 47.0614C1.39136 46.3201 0.801867 45.2913 0.607305 44.1571C0.412744 43.023 0.625658 41.8565 1.20837 40.8643C1.79108 39.872 2.70603 39.1178 3.7913 38.7352V19.9611C3.3623 19.761 2.96652 19.5736 2.60396 19.3988C1.30396 18.777 0.558629 17.5517 0.558629 16.2496C0.558629 14.9474 1.30396 13.7221 2.60396 13.1003C4.59513 12.1459 7.55371 10.8004 11.7256 9.06164C17.5193 6.64797 21.4908 5.21147 23.639 4.47914" fill="#FFAE1F"/>
                            <path d="M22.589 30.5483C18.4373 29.1294 14.3356 27.5685 10.291 25.8683V26.1814C10.291 29.5852 10.4654 31.7649 10.6474 33.1147C10.863 34.7137 11.7947 36.1188 13.2658 36.889C15.3968 38.0038 19.5178 39.5421 25.9993 39.5421C32.4809 39.5421 36.6019 38.0038 38.7328 36.8879C40.204 36.1188 41.1368 34.7137 41.3513 33.1147C41.5333 31.7649 41.7077 29.5852 41.7077 26.1814V25.8672C37.6631 27.5674 33.5613 29.1283 29.4097 30.5472C27.199 31.3031 24.7997 31.3042 22.589 30.5483Z" fill="#FFAE1F"/>
                        </svg>
                        </div>
                        <div class="ms-4">
                            <h4 class="card-title text-dark"><b>Jumlah Alumni</b></h4>
                            <h6 style="font-size: 25px; color: #FFAE1F"><b>{{ $alumnus->count() }}</b></h6>
                        </div>
                    </div>
                </div>
                <img src="{{ asset('assets/images/background/bub2.png') }}" alt="Image"
                    style="position: absolute; bottom: 0; right: 0; width: auto; height: 90px; border-bottom-right-radius: 13px;">
            </div>
        </div>
    </div>

    <ul class="nav nav-pills p-3 mb-3 rounded align-items-center card flex-row" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pills-student-tab" data-bs-toggle="pill" href="#pills-student" role="tab"
                aria-controls="pills-student" aria-selected="true">
                <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 me-1" width="17" height="17" viewBox="0 0 16 16">
                    <path fill="currentColor"
                        d="M15 14s1 0 1-1s-1-4-5-4s-5 3-5 4s1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276c.593.69.758 1.457.76 1.72l-.008.002l-.014.002zM11 7a2 2 0 1 0 0-4a2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0a3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904c.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724c.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0a3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4a2 2 0 0 0 0-4" />
                </svg>
                Siswa
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-alumni-tab" data-bs-toggle="pill" href="#pills-alumni" role="tab"
                aria-controls="pills-alumni" aria-selected="false">
                <svg xmlns="http://www.w3.org/2000/svg" class="me-1 mb-1" width="18" height="18"
                    viewBox="0 0 1024 1024">
                    <path fill="currentColor"
                        d="M990.848 696.304V438.16l16.096-8.496c10.464-5.44 17.055-16.225 17.183-28.032c.128-11.777-6.256-22.689-16.592-28.368l-481.44-257.6c-9.631-5.28-21.28-5.249-30.976.095l-478.8 257.92C6.126 379.36-.177 390.143-.113 401.84s6.496 22.4 16.817 27.97l210.384 111.983c-2.64 4.656-4.272 9.968-4.272 15.696v270.784a32.03 32.03 0 0 0 10.72 23.904c6.945 6.16 73.441 60.096 276.753 60.096c202.592 0 270.88-50.976 278-56.784c7.44-6.064 11.744-15.152 11.744-24.784V552.976c0-4.496-.944-8.768-2.608-12.64l129.424-68.369V696.48c-18.976 11.104-31.84 31.472-31.84 55.024c0 35.344 28.656 64 64 64s64-28.656 64-64c0-23.697-13.04-44.145-32.16-55.2zM736.031 812.368c-25.152 12.096-91.712 35.904-225.744 35.904c-134.88 0-199.936-25.344-223.472-37.536V573.6l207.808 110.624a31.896 31.896 0 0 0 15.184 3.84a31.675 31.675 0 0 0 14.816-3.664l211.408-111.664zM510.063 619.81l-411.6-218.561l412.32-220.976l413.6 220.336z" />
                </svg>
                Alumni
            </a>
        </li>
    </ul>

    <div class="tab-content mt-4" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-student" role="tabpanel" aria-labelledby="pills-student-tab">
            @include('school.pages.student.panes.tab-student')
        </div>
        <div class="tab-pane fade" id="pills-alumni" role="tabpanel" aria-labelledby="pills-alumni-tab">
            @include('school.pages.student.panes.tab-alumni')
        </div>
    </div>

    {{-- modal siswa --}}
    @include('school.pages.student.widgets.student.modal-create-rfid')
    @include('school.pages.student.widgets.student.modal-detail-student')
    @include('school.pages.student.widgets.student.modal-update-student')
    @include('school.pages.student.widgets.student.import')

    {{-- modal alumni --}}
    @include('school.pages.student.widgets.alumni.modal-detail-alumni')
    @include('school.pages.student.widgets.alumni.modal-update-alumni')
    @include('school.pages.student.widgets.alumni.modal-confirm-alumnus')

    <x-delete-modal-component />
@endsection

@section('script')
    @include('school.pages.student.scripts.rfid')
    @include('school.pages.student.scripts.delete')
    @include('school.pages.student.scripts.detail')
    @include('school.pages.student.scripts.preview')
    @include('school.pages.student.scripts.tab')
    @include('school.pages.student.scripts.update')
    @include('school.pages.student.scripts.confirm-alumnus')
@endsection
