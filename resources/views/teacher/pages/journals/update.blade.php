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

        /* Custom Pagination Style - Kept for consistency even if unused */
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
                    <h4 class="fw-semibold text-white mb-8">Edit Jurnal</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item text-white fs-3" aria-current="page">
                                {{ $teacherJournal->lessonSchedule->teacherSubject->subject->name }} -
                                {{ $teacherJournal->lessonSchedule->classroom->name }}
                            </li>
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

    <form action="{{ route('teacher.journals.update', $teacherJournal->id) }}" method="POST">
        @method('put')
        @csrf

        {{-- attendance --}}
        <div class="card shadow">
            <div class="card-body pt-3">
                <h4>Presensi Siswa</h4>

                {{-- Summary Statistics (Preserved from Update page) --}}
                <div class="row g-2 mb-3 mt-2">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body py-3">
                                <div class="d-flex">
                                    <div class="border border-success"></div>
                                    <div class="ms-3">
                                        <h4>Jumlah Siswa Masuk</h4>
                                        <h4 class="text-success">
                                            <b>{{ $teacherJournal->attendanceJournals->where('status', AttendanceEnum::PRESENT)->count() }}</b>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body py-3">
                                <div class="d-flex">
                                    <div class="border border-primary"></div>
                                    <div class="ms-3">
                                        <h4>Jumlah Siswa Izin</h4>
                                        <h4 class="text-primary">
                                            <b>{{ $teacherJournal->attendanceJournals->where('status', AttendanceEnum::PERMIT)->count() }}</b>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body py-3">
                                <div class="d-flex">
                                    <div class="border border-warning"></div>
                                    <div class="ms-3">
                                        <h4>Jumlah Siswa Sakit</h4>
                                        <h4 class="text-warning">
                                            <b>{{ $teacherJournal->attendanceJournals->where('status', AttendanceEnum::SICK)->count() }}</b>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body py-3">
                                <div class="d-flex">
                                    <div class="border border-danger"></div>
                                    <div class="ms-3">
                                        <h4>Jumlah Siswa Alpha</h4>
                                        <h4 class="text-danger">
                                            <b>{{ $teacherJournal->attendanceJournals->where('status', AttendanceEnum::ALPHA)->count() }}</b>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive rounded-2 mb-4">
                    <table class="table text-nowrap customize-table mb-0 align-middle" id="student-table">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="text-white" style="background-color: #0D93CA; border-top-left-radius: 10px;">No
                                </th>
                                <th class="text-white" style="background-color: #0D93CA;">Nama Siswa</th>
                                <th class="text-white" style="background-color: #0D93CA;">Kelas</th>
                                <th class="text-white d-flex" style="background-color: #0D93CA;">
                                    <div class="form-check d-flex align-items-center">
                                        {{-- <input class="form-check-input attendance-radio" type="checkbox"> --}}
                                        {{-- <label class="form-check-label ms-2"> --}}
                                        {{-- Hadir Semua --}}
                                        {{-- </label> --}}
                                    </div>
                                    Status Kehadiran
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classroomStudents as $classroomStudent)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ $classroomStudent->classroomStudent->student->image ? asset('storage/' . $classroomStudent->classroomStudent->student->image) : asset('assets/images/default-user.jpeg') }}"
                                            alt="" class="img-fluid rounded-circle" style="padding-right: 10px"
                                            width="32" height="32">
                                        {{ $classroomStudent->classroomStudent->student->user->name }}
                                    </td>
                                    <td>{{ $teacherJournal->lessonSchedule->classroom->name }}</td>
                                    <td>
                                        <div class="d-flex gap-5 align-items-center">
                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input attendance-radio" type="radio"
                                                    name="attendance[{{ $classroomStudent->classroom_student_id }}]"
                                                    id="attendance-{{ $classroomStudent->classroom_student_id . '-' . AttendanceEnum::PRESENT->value }}"
                                                    value="{{ AttendanceEnum::PRESENT->value }}"
                                                    {{ $classroomStudent->status == AttendanceEnum::PRESENT ? 'checked' : '' }}>
                                                <label class="form-check-label ms-2"
                                                    for="attendance-{{ $classroomStudent->classroom_student_id . '-' . AttendanceEnum::PRESENT->value }}">
                                                    Hadir
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input attendance-radio" type="radio"
                                                    name="attendance[{{ $classroomStudent->classroom_student_id }}]"
                                                    id="attendance-{{ $classroomStudent->classroom_student_id . '-' . AttendanceEnum::PERMIT->value }}"
                                                    value="{{ AttendanceEnum::PERMIT->value }}"
                                                    {{ $classroomStudent->status == AttendanceEnum::PERMIT ? 'checked' : '' }}>
                                                <label class="form-check-label ms-2"
                                                    for="attendance-{{ $classroomStudent->classroom_student_id . '-' . AttendanceEnum::PERMIT->value }}">
                                                    Izin
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input attendance-radio" type="radio"
                                                    name="attendance[{{ $classroomStudent->classroom_student_id }}]"
                                                    id="attendance-{{ $classroomStudent->classroom_student_id . '-' . AttendanceEnum::SICK->value }}"
                                                    value="{{ AttendanceEnum::SICK->value }}"
                                                    {{ $classroomStudent->status == AttendanceEnum::SICK ? 'checked' : '' }}>
                                                <label class="form-check-label ms-2"
                                                    for="attendance-{{ $classroomStudent->classroom_student_id . '-' . AttendanceEnum::SICK->value }}">
                                                    Sakit
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input attendance-radio" type="radio"
                                                    name="attendance[{{ $classroomStudent->classroom_student_id }}]"
                                                    id="attendance-{{ $classroomStudent->classroom_student_id . '-' . AttendanceEnum::ALPHA->value }}"
                                                    value="{{ AttendanceEnum::ALPHA->value }}"
                                                    {{ $classroomStudent->status == AttendanceEnum::ALPHA ? 'checked' : '' }}>
                                                <label class="form-check-label ms-2"
                                                    for="attendance-{{ $classroomStudent->classroom_student_id . '-' . AttendanceEnum::ALPHA->value }}">
                                                    Alfa
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex flex-direction-row justify-content-between">
            <h4 class="pb-3"><b>Isi Jurnal</b></h4>
        </div>

        {{-- description --}}
        <div class="card shadow">
            <div class="card-body">
                <h5 class="fw-bold pb-3"><b>Laporan Kegiatan</b></h5>
                <div class="form-group mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" class="form-control" name="title" id="title"
                        placeholder="Masukkan Judul" value="{{ $teacherJournal->title ?? '' }}">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi</label>
                    <p>Isi laporan sesuai dengan kegiatan dan aktivitas yang berlaku pada jam pelajaran tersebut.</p>
                    <textarea class="form-control" id="description" name="description" rows="5" placeholder="Masukkan Deskripsi">{{ $teacherJournal->description ?? '' }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
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
                Simpan Jurnal
            </button>
        </div>
    </form>
@endsection
