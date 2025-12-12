@extends('teacher.layouts.app')
@section('content')
    <div class="card bg-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h5 class="fw-semibold text-white mb-2">Perizinan Siswa Ekstrakurikuler</h5h5>
                    <h4 class="fw-semibold text-white mb-2">{{ $extracurricular->name }}</h4>
                    <h6 class="fw-semibold text-white mb-2">Daftar perizinan siswa ekstrakurikuler</h6>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('admin_assets/dist/images/breadcrumb/ChatBc.png') }}" alt=""
                            class="img-fluid mb-n4">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 mb-3 mt-4">
        <form class="d-flex gap-2">
            <input type="hidden" name="extracurricular" value="{{ $extracurricular->id }}">
            <input type="text" name="search" class="form-control search-chat" value="{{ old('search', request('search')) }}" placeholder="Cari..">
            <button class="btn-primary btn" type="submit">Cari</button>
        </form>
    </div>

    <div class="">
        <div class="table-responsive rounded-2 mb-4">
            <table class="table border text-nowrap customize-table mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th class="text-black">No</th>
                        <th class="text-black">Nama</th>
                        <th class="text-black">NISN</th>
                        <th class="text-black">Tanggal</th>
                        <th class="text-black">Keterangan</th>
                        <th class="text-black">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $hasPermissions = false; // TODO: Ganti dengan data permission yang sebenarnya
                    @endphp
                    @if($hasPermissions)
                        {{-- TODO: Loop data permission di sini --}}
                    @else
                        <tr>
                            <td colspan="6" class="text-center align-middle">
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}"
                                        alt="" width="300px">
                                    <p class="fs-5 text-dark text-center mt-2">
                                        Belum ada data perizinan
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
