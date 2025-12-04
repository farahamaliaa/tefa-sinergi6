@extends('school.layouts.app')

@section('style')
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

    .apexcharts-toolbar {
        display: none !important;
    }

    #custom-legend {
        display: flex;
        flex-direction: row;
        align-items: center;
        padding: 10px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        margin-right: 15px;
        border-color: #8695c2 !important;
        padding: 5px 10px;
        border-radius: 7px;
        background: #F3F6FF;
    }

    .legend-marker {
        width: 12px;
        height: 12px;
        border-radius: 20%;
        margin-right: 5px;
    }

    .legend-text {
        font-size: 12px;
        color: #373d3f;
        font-family: Helvetica, Arial, sans-serif;
    }

</style>
@endsection

@section('content')
<div class="card header-wave shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold text-white mb-8">Statistik Absensi</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-white text-decoration-none" href="javascript:void(0)">
                                Statistik Absensi Siswa
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

<ul class="nav nav-pills d-flex gap-4 p-3 mb-3 rounded align-items-center card flex-row" id="pills-tab" role="tablist">
    <li class="nav-item ">
        <a class="nav-link active" id="pills-keseluruhan-tab" data-bs-toggle="pill" href="#pills-keseluruhan" role="tab" aria-controls="pills-keseluruhan" aria-selected="true">
            Keseluruhan
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pills-detail-tab" data-bs-toggle="pill" href="#pills-detail" role="tab" aria-controls="pills-detail" aria-selected="false">
            Kelas
        </a>
    </li>
</ul>

<div class="tab-content mt-4" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-keseluruhan" role="tabpanel" aria-labelledby="pills-keseluruhan-tab">
        @include('school.pages.statistic-presence.panes.tab-all')
    </div>
    <div class="tab-pane fade" id="pills-detail" role="tabpanel" aria-labelledby="pills-detail-tab">
        @include('school.pages.statistic-presence.panes.tab-detail')
    </div>
</div>


<x-delete-modal-component />
@endsection

@section('script')
@include('school.pages.statistic-presence.script.chart')
@include('school.pages.statistic-presence.script.tab')
@endsection
