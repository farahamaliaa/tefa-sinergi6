@extends('teacher.layouts.app')

@section('style')
<style>
    .bg-ekstra {
        background-image: url('{{ asset('assets/images/bg-ekstra.png') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        width: 100%;
    }

</style>
@endsection

@section('content')
<div class="card bg-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold text-white mb-8">Ekstrakurikuler</h4>
            </div>
            <div class="col-3">
                <div class="text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="120" height="100" viewBox="0 0 24 24">
                        <path fill="#ffffff" d="M5 13.18v2.81c0 .73.4 1.41 1.04 1.76l5 2.73c.6.33 1.32.33 1.92 0l5-2.73c.64-.35 1.04-1.03 1.04-1.76v-2.81l-6.04 3.3c-.6.33-1.32.33-1.92 0zm6.04-9.66l-8.43 4.6c-.69.38-.69 1.38 0 1.76l8.43 4.6c.6.33 1.32.33 1.92 0L21 10.09V16c0 .55.45 1 1 1s1-.45 1-1V9.59c0-.37-.2-.7-.52-.88l-9.52-5.19a2.04 2.04 0 0 0-1.92 0" /></svg>
                </div>
            </div>
        </div>
    </div>
</div>

<h4 class="fw-semibold">Daftar Ekstrakurikuler</h4>
<form action="{{ route('teacher.extracurricular.index') }}" method="GET" class="d-flex gap-2 mt-4">
    <div class="position-relative">
        <div class="">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control search-chat py-2 px-5 ps-5" id="search-name" placeholder="Cari ekstrakurikuler">
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
                        <div>
                            <a href="#" class="text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-primary" width="30" height="30" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M16.175 13H4v-2h12.175l-5.6-5.6L12 4l8 8l-8 8l-1.425-1.4z"/>
                                </svg>
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
