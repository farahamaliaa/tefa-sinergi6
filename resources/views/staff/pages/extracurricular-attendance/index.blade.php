@extends('staff.layouts.app')
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

        .table-header-custom th {
            background-color: #0891CA !important;
            color: white !important;
        }
    </style>
@endsection
@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h5 class="fw-semibold text-white mb-2">Absensi Siswa Ekstrakurikuler</h5>
                    <h4 class="fw-semibold text-white mb-2">{{ $extracurricular->name }}</h4>
                    <h6 class="fw-semibold text-white mb-2">Daftar absensi siswa ekstrakurikuler</h6>
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
            <input type="text" name="search" class="form-control search-chat"
                value="{{ old('search', request('search')) }}" placeholder="Cari..">
            <button class="btn-primary btn" type="submit" style="background-color: #098CC3">Cari</button>
        </form>
    </div>

    <div class="">
        <div class="table-responsive rounded-3 mb-4">
            <table class="table border text-nowrap customize-table mb-0 align-middle">
                <thead class="fs-4 table-header-custom">
                    <tr>
                        <th class="text-black">No</th>
                        <th class="text-black">Nama</th>
                        <th class="text-black">NISN</th>
                        <th class="text-black">Hadir</th>
                        <th class="text-black">Izin</th>
                        <th class="text-black">Sakit</th>
                        <th class="text-black">Alpha</th>
                        <th class="text-black">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($extracurricularStudents as $extracurricularStudent)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $extracurricularStudent->student->user->avatar ?? asset('assets/images/default-user.jpeg') }}"
                                        class="rounded-circle" width="40" height="40">
                                    <div class="ms-3">
                                        <h6 class="fs-4 fw-semibold mb-0">{{ $extracurricularStudent->student->user->name }}
                                        </h6>
                                        <span
                                            class="fw-normal">{{ $extracurricularStudent->student->classroomStudents->first()->classroom->name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $extracurricularStudent->student->nisn }}</td>
                            <td><span class="badge bg-success">0</span></td>
                            <td><span class="badge bg-warning">0</span></td>
                            <td><span class="badge bg-info">0</span></td>
                            <td><span class="badge bg-danger">0</span></td>
                            <td>0</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center align-middle">
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt=""
                                        width="300px">
                                    <p class="fs-5 text-dark text-center mt-2">
                                        Belum ada data
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
