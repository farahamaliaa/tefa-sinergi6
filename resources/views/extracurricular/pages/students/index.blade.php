@extends('extracurricular.layouts.app')
@section('style')
    <style>
        .card {
            border: 1px solid #E0E6ED !important;
            box-shadow: none !important;
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
                    <h4 class="fw-semibold text-white mb-2">Ekstrakurikuler {{ $extracurricular->name }}</h4>
                    <h6 class="fw-semibold text-white mb-2">Daftar Siswa Eskul {{ $extracurricular->name }}</h6>
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

    <div class="row mb-3 mt-3">
        <div class="col-lg-6 col-md-12 mb-3">
            <form class="d-flex flex-column flex-md-row gap-2" action="{{ route('extracurricular.students.index') }}">
                <input type="hidden" name="extracurricular" value="{{ $extracurricular->id }}">
                <div class="position-relative flex-grow-1">
                    <input type="text" name="search" class="form-control product-search ps-5" id="input-search"
                        placeholder="Cari..." value="{{ old('search', request('search')) }}">
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                </div>
                <button type="submit" class="btn btn-primary btn-md" style="background-color: #098CC3">Cari</button>
            </form>
        </div>

        <div class="">
            <div class="table-responsive rounded-3 mb-4">
                <table class="table border text-nowrap customize-table mb-0 align-middle">
                    <thead class="fs-4 table-header-custom">
                        <tr>
                            <th class="text-white">No</th>
                            <th class="text-white">Nama</th>
                            <th class="text-white">Jenis Kelamin</th>
                            <th class="text-white">Kelas</th>
                            <th class="text-white">NISN</th>
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
                                            <h6 class="fs-4 fw-semibold mb-0">
                                                {{ $extracurricularStudent->student->user->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $extracurricularStudent->student->gender->label() }}</td>
                                <td>{{ $extracurricularStudent->student->classroomStudents->first()->classroom->name ?? 'N/A' }}
                                </td>
                                <td>{{ $extracurricularStudent->student->nisn }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center align-middle">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt=""
                                            width="300px">
                                        <p class="fs-5 text-dark text-center mt-2">
                                            Belum ada siswa
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
