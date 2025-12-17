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
                                {{ $lessonSchedule->teacherSubject->subject->name }} -
                                {{ $lessonSchedule->classroom->name }}</li>
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

    {{-- <div class="d-flex row me-0 mb-2 align-items-center">
        <div class="col-lg-6 col-md-12 mb-3">
            <div class="d-flex align-items-center">
                <span class="mb-1 badge bg-primary p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M12 7q-.825 0-1.412-.587T10 5t.588-1.412T12 3t1.413.588T14 5t-.587 1.413T12 7m0 14q-.625 0-1.062-.437T10.5 19.5v-9q0-.625.438-1.062T12 9t1.063.438t.437 1.062v9q0 .625-.437 1.063T12 21" />
                    </svg>
                </span>
                <h4 class="ms-3 mb-0">Tambah Jurnal</h4>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 mb-3 p-0">
            <div class="d-flex align-items-center justify-content-end">
                <h4 class="ms-3 mb-0">Tanggal saat ini : </h4>
                <div class="badge bg-light-primary ms-3">
                    <div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"
                            class="text-primary">
                            <path fill="currentColor"
                                d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2m0 16H5V10h14zm0-12H5V6h14zm-7 5h5v5h-5z" />
                        </svg>
                        <h6 class="mt-2 ms-3 me-2 text-primary">{{ Carbon::now()->isoFormat('DD MMM YYYY') }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <form action="{{ route('teacher.journals.store', $lessonSchedule->id) }}" method="POST">
        @csrf

        {{-- attendance --}}
        <div class="card shadow">
            <div class="card-body pt-3">
                <h4>Presensi Siswa</h4>
                <div class="d-flex flex-wrap mb-3 mt-3 mb-2 w-64">
                    <div class="d-flex gap-2" id="form-search">
                        <div class="position-relative" style="padding-right: 10px">
                            <input type="text" name="search" class="form-control product-search ps-5 text-dark"
                                id="input-search" placeholder="Cari" value="{{ request('search') }}"
                                style="border-radius: 10px; width: 250px;">
                            <i
                                class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        </div>
                        <button type="button" class="btn btn-primary w-lg-auto" onclick="locationSearch()"
                            style="background-color: #0D93CA;">Filter</button>
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
                                        <input class="form-check-input attendance-radio" type="checkbox">
                                        {{-- <label class="form-check-label ms-2">
                                            Hadir Semua
                                        </label> --}}
                                    </div>
                                    {{-- Status Kehadiran --}}
                                    Hadir Semua
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classroomStudents as $classroomStudent)
                                <tr>
                                    <td>{{ ($studentsPaginator->currentPage() - 1) * $studentsPaginator->perPage() + $loop->iteration }}
                                    </td>
                                    <td> <img
                                            src="{{ $classroomStudent->student->image ? asset('storage/' . $classroomStudent->student->image) : asset('assets/images/default-user.jpeg') }}"
                                            alt="" class="img-fluid rounded-circle" style="padding-right: 10px"
                                            width="32" height="32">
                                        {{ $classroomStudent->student->user->name }} </td>
                                    <td>{{ $lessonSchedule->classroom->name }}</td>
                                    <td>
                                        <div class="d-flex gap-5 align-items-center">
                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input attendance-radio" type="radio"
                                                    name="attendance[{{ $classroomStudent->id }}]"
                                                    id="attendance-{{ $classroomStudent->id . '-' . AttendanceEnum::PRESENT->value }}"
                                                    value="{{ AttendanceEnum::PRESENT->value }}" checked>
                                                <label class="form-check-label ms-2"
                                                    for="attendance-{{ $classroomStudent->id . '-' . AttendanceEnum::PRESENT->value }}">
                                                    Hadir
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input attendance-radio" type="radio"
                                                    name="attendance[{{ $classroomStudent->id }}]"
                                                    id="attendance-{{ $classroomStudent->id . '-' . AttendanceEnum::PERMIT->value }}"
                                                    value="{{ AttendanceEnum::PERMIT->value }}">
                                                <label class="form-check-label ms-2"
                                                    for="attendance-{{ $classroomStudent->id . '-' . AttendanceEnum::PERMIT->value }}">
                                                    Izin
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input attendance-radio" type="radio"
                                                    name="attendance[{{ $classroomStudent->id }}]"
                                                    id="attendance-{{ $classroomStudent->id . '-' . AttendanceEnum::SICK->value }}"
                                                    value="{{ AttendanceEnum::SICK->value }}">
                                                <label class="form-check-label ms-2"
                                                    for="attendance-{{ $classroomStudent->id . '-' . AttendanceEnum::SICK->value }}">
                                                    Sakit
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input attendance-radio" type="radio"
                                                    name="attendance[{{ $classroomStudent->id }}]"
                                                    id="attendance-{{ $classroomStudent->id . '-' . AttendanceEnum::ALPHA->value }}"
                                                    value="{{ AttendanceEnum::ALPHA->value }}">
                                                <label class="form-check-label ms-2"
                                                    for="attendance-{{ $classroomStudent->id . '-' . AttendanceEnum::ALPHA->value }}">
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
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Menampilkan {{ $studentsPaginator->currentPage() }} dari {{ $studentsPaginator->lastPage() }}
                        halaman
                    </div>
                    <div>
                        <x-paginate-component :paginator="$studentsPaginator" />
                    </div>
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
                        placeholder="Masukkan Judul" value="{{ old('title') }}">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi</label>
                    <p>Isi laporan sesuai dengan kegiatan dan aktivitas yang berlaku pada jam pelajaran tersebut.</p>
                    <textarea class="form-control" id="description" name="description" rows="5" placeholder="Masukkan Deskripsi">{{ old('description') }}</textarea>
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
                Tambah Jurnal
            </button>
        </div>
    </form>
    <script>
        function locationSearch() {
            var q = document.getElementById('input-search') ? document.getElementById('input-search').value : '';
            var base = "{{ url()->current() }}";
            var separator = base.indexOf('?') === -1 ? '?' : '&';
            window.location.href = base + (q ? (separator + 'search=' + encodeURIComponent(q)) : '');
        }
    </script>
@endsection
