@extends('teacher.layouts.app')
@section('content')
    <div class="card bg-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h5 class="fw-semibold text-white mb-2">Absensi Siswa</h5>
                    <h4 class="fw-semibold text-white mb-2">{{ $classroom->name }}</h4>
                    <h6 class="fw-semibold text-white mb-2">Daftar absensi siswa di kelas ini</h6>
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
            <input type="hidden" name="classroom" value="{{ $classroom->id }}">
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
                        <th class="text-black">Hadir</th>
                        <th class="text-black">Izin</th>
                        <th class="text-black">Sakit</th>
                        <th class="text-black">Alpha</th>
                        <th class="text-black">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($classroomStudents as $classroomStudent)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $classroomStudent->student->user->avatar ?? asset('assets/images/default-user.jpeg') }}"
                                        class="rounded-circle" width="40" height="40">
                                    <div class="ms-3">
                                        <h6 class="fs-4 fw-semibold mb-0">{{$classroomStudent->student->user->name}}</h6>
                                        <span class="fw-normal">{{ $classroomStudent->classroom->name }}</span>
                                    </div>
                                </div>

                            </td>
                            <td>{{ $classroomStudent->student->nisn }}</td>
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
                                    <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}"
                                        alt="" width="300px">
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
