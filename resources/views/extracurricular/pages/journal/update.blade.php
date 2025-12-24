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
                    <h4 class="fw-semibold text-white mb-2">Edit Jurnal Ekstrakurikuler</h4>
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
            <h4 class="mb-4">Edit Jurnal Kegiatan</h4>
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Judul Kegiatan</label>
                    <input type="text" class="form-control" name="title" 
                           value="{{ $journal->title ?? 'Kegiatan Ekstrakurikuler' }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="description" rows="5" required>{{ $journal->description ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Foto Kegiatan</label>
                    <input type="file" class="form-control" name="image" accept="image/*">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="javascript:history.back()" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary" style="background-color: #0896D1;">Update Jurnal</button>
                </div>
            </form>
        </div>
    </div>
@endsection
