@php
    use Carbon\Carbon;
    use App\Enums\AttendanceEnum;
@endphp
@extends('teacher.layouts.app')

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

        .select2-selection__rendered {
            width: 100% !important;
        }

        /* Custom Pagination Style */
        .pagination .page-item .page-link {
            border-radius: 8px;
            border: 1px solid #EAEFF4;
            color: #0896D1;
            margin: 0 4px;
            font-weight: 600;
            padding: 6px 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 35px;
            min-width: 35px;
        }

        .pagination .page-item.active .page-link {
            background-color: #0896D1;
            border-color: #0896D1;
            color: #fff;
        }

        .pagination .page-item.disabled .page-link {
            color: #A5A5A5;
            background-color: transparent;
            border-color: #EAEFF4;
        }

        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            border-radius: 8px;
        }

        .pagination .page-item .page-link:hover {
            background-color: #EAEFF4;
            color: #0896D1;
        }

        .pagination .page-item.active .page-link:hover {
            background-color: #0896D1;
            color: #fff;
        }

        .pagination .page-item .page-link.pagination-dots {
            border: none;
            padding-bottom: 12px;
            background-color: transparent;
            color: #000;
            font-weight: 900;
        }

        /* Attendance Radio Customization */
        .attendance-radio {
            width: 22px;
            height: 22px;
            border-radius: 4px !important;
            appearance: none;
            -webkit-appearance: none;
            border: 1px solid #dfe5ef;
            background-color: #fff;
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            cursor: pointer;
        }

        .attendance-radio:checked {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10l3 3l6-6'/%3e%3c/svg%3e");
            border-color: transparent;
        }

        /* Hadir - Green */
        .attendance-radio.present-radio:checked {
            background-color: #1EBB9E;
            border-color: #1EBB9E;
        }

        /* Others - Standard Blue (or customize as needed) */
        .attendance-radio:not(.present-radio):checked {
            background-color: #1EBB9E;
            border-color: #1EBB9E;
        }
    </style>
@endsection
@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Pengisian Jurnal</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item text-white fs-3" aria-current="page">
                                Extrakulikuler Basket
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n3">
                        <img src="{{ asset('assets/images/background/laptops.png') }}" alt=""
                            class="img-fluid img-header-floating">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('teacher.journals.store', $lessonSchedule->id) }}" method="POST">
        @csrf
        <h4 class="pb-3 fw-bold">Edit Jurnal</h4>
        <div class="row">
            {{-- Bukti Foto --}}
            <div class="col-md-4">
                <div class="card shadow overflow-hidden">
                    <div class="card-header text-white py-3" style="background-color: #0896D1;">
                        <h5 class="mb-0 text-white">Bukti Foto</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center p-4 border-2 border-dashed rounded-3"
                            style="border-color: #93c5fd; border-style: dashed; background-color: #f8fafc;">
                            <div class="mb-3">
                                <img src="{{ asset('assets/images/background/Image-upload-pana.png') }}" alt="Upload"
                                    class="img-fluid" style="max-height: 300px;">
                                {{-- Fallback if specific image missing, use a generic icon or keep empty if asset not available --}}
                                {{-- If you don't have the exact illustration, implies I should maybe use a generic one or just the area --}}
                            </div>
                            <p class="text-muted small mb-3">Format harus berupa jpg, png dan jpeg</p>
                            <button type="button" class="btn btn-primary px-4" style="background-color: #0896D1;">
                                Unggah Gambar
                            </button>
                            <input type="file" name="image" class="d-none">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Isi Laporan --}}
            <div class="col-md-8">
                <div class="card shadow overflow-hidden">
                    <div class="card-header text-white py-3" style="background-color: #0896D1;">
                        <h5 class="mb-0 text-white">Isi Laporan Kegiatan</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group mb-4">
                            <label for="title" class="form-label fw-semibold">Judul</label>
                            <input type="text" class="form-control py-2" name="title" id="title"
                                placeholder="Masukkan Judul" value="{{ old('title') }}">
                            @error('title')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-label fw-semibold">Deskripsi</label>
                            <p class="text-muted small mb-2">Isi laporan sesuai dengan kegiatan dan aktivitas yang berlaku
                                pada jam pelajaran tersebut.</p>
                            <textarea class="form-control" id="description" name="description" rows="6" placeholder="Masukkan Deskripsi"
                                style="resize: none;">{{ old('description') }}</textarea>
                            <div class="text-start mt-1">
                                <span class="text-black small">0 Karakter</span>
                            </div>
                            @error('description')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="d-flex gap-2 justify-content-end mb-5">
            <a href="{{ route('teacher.journals.index') }}" type="button" class="btn mb-1 btn-white border-1"
                style="border-color: #0896D1 !important; color: #0896D1 !important;">
                Kembali
            </a>
            <button type="submit" class="btn mb-1 text-white" style="background-color: #0896D1 !important;"
                id="submit-btn">
                Tambah Jurnal
            </button>
        </div>
    </form>
@endsection
