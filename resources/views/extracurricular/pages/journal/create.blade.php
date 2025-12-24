@extends('extracurricular.layouts.app')
@section('style')
    <style>
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
                    <h4 class="fw-semibold text-white mb-2">Buat Jurnal Ekstrakurikuler</h4>
                    <h6 class="fw-semibold text-white mb-2">{{ $extracurricular->name ?? 'Ekstrakurikuler' }}</h6>
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

    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">Form Jurnal Kegiatan</h4>
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Judul Kegiatan</label>
                    <input type="text" class="form-control" name="title" placeholder="Masukkan judul kegiatan" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="description" rows="5" placeholder="Masukkan deskripsi kegiatan..." required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Foto Kegiatan</label>
                    <input type="file" class="form-control" name="image" accept="image/*">
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('extracurricular.journal.index', ['extracurricular' => request('extracurricular')]) }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary" style="background-color: #0896D1;">Simpan Jurnal</button>
                </div>
            </form>
        </div>
    </div>
@endsection
