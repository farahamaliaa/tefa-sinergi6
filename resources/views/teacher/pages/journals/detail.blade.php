@php
    use Carbon\Carbon;
    use App\Enums\AttendanceEnum;
@endphp
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

        .text-primary {
            color: #0896D1 !important;
        }

        .bg-primary {
            background-color: #0896D1 !important;
        }

        .btn-primary {
            background-color: #0896D1 !important;
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
    </style>
    @extends('teacher.layouts.app')
@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Detail Jurnal</h4>
                    <h3 class="fw-semibold text-white mb-8">{{ Carbon::now()->isoFormat('DD MMM YYYY') }}</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item text-white fs-3" aria-current="page">
                                {{ $journal->lessonSchedule->teacherSubject->subject->name }} -
                                {{ $journal->lessonSchedule->classroom->name }}</li>
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
                <h4 class="ms-3 mb-0">Detail Jurnal</h4>
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

    {{-- <div class="card bg-light-primary shadow-none position-relative overflow-hidden rounded-top-0">
        <div class="card-body px-1 py-0">
            <div class="card-body py-3">
                <div class="d-flex gap-4">
                    <div>
                        <h4><b>Siswa Masuk</b></h4>
                        <h5>89 Masuk</h5>
                    </div>
                    <div class="border-end border-dark"></div>
                    <div>
                        <h4><b>Siswa Izin</b></h4>
                        <h5>89 Masuk</h5>
                    </div>
                    <div class="border-end border-dark"></div>
                    <div>
                        <h4><b>Siswa Sakit</b></h4>
                        <h5>89 Masuk</h5>
                    </div>
                    <div class="border-end border-dark"></div>
                    <div>
                        <h4><b>Siswa Alpha</b></h4>
                        <h5>89 Masuk</h5>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="card shadow">
        <div class="card-body pt-3">
            <h4 class="pb-3 mt-3"><b>Presensi Siswa</b></h4>
            <div class="row g-2">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body py-3">
                            <div class="d-flex">
                                <div class="border border-success"></div>
                                <div class="ms-3">
                                    <h4>Jumlah Siswa Masuk</h4>
                                    <h4 class="text-success">
                                        <b>{{ $attendanceJournals->where('status', AttendanceEnum::PRESENT)->count() }}</b>
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
                                <div class="border" style="border-color: #0D93CA !important;"></div>
                                <div class="ms-3">
                                    <h4>Jumlah Siswa Izin</h4>
                                    <h4 style="color: #0D93CA;">
                                        <b>{{ $attendanceJournals->where('status', AttendanceEnum::PERMIT)->count() }}</b>
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
                                        <b>{{ $attendanceJournals->where('status', AttendanceEnum::SICK)->count() }}</b>
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
                                        <b>{{ $attendanceJournals->where('status', AttendanceEnum::ALPHA)->count() }}</b>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive rounded-2 mb-4 mt-4">
                <table class="table text-nowrap customize-table mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th class="text-white" style="background-color: #0D93CA;">No</th>
                            <th class="text-white" style="background-color: #0D93CA;">Nama Siswa</th>
                            <th class="text-white" style="background-color: #0D93CA;">Kelas</th>
                            <th class="text-white text-center" style="background-color: #0D93CA;">Status Kehadiran</th>
                            <th class="text-white text-center" style="background-color: #0D93CA;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attendanceJournals as $attendance)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                {{-- <td>{{ $attendance->classroomStudent->student->user->name }}</td> --}}
                                <td> <img
                                        src="{{ $attendance->classroomStudent->student->image ? asset('storage/' . $attendance->classroomStudent->student->image) : asset('assets/images/default-user.jpeg') }}"
                                        alt="" class="img-fluid rounded-circle" style="padding-right: 10px"
                                        width="32" height="32">
                                    {{ $attendance->classroomStudent->student->user->name }} </td>
                                <td>{{ $attendance->classroomStudent->classroom->name }}</td>
                                <td class="text-center">
                                    @switch($attendance->status)
                                        @case(AttendanceEnum::SICK)
                                            <span class="mb-1 badge font-medium bg-light-warning text-warning w-25">Sakit</span>
                                        @break

                                        @case(AttendanceEnum::PERMIT)
                                            <span class="mb-1 badge font-medium bg-light-primary text-primary w-25">Izin</span>
                                        @break

                                        @case(AttendanceEnum::ALPHA)
                                            <span class="mb-1 badge font-medium bg-light-danger text-danger w-25">Alfa</span>
                                        @break

                                        @default
                                            <span class="mb-1 badge font-medium bg-light-success text-success w-25">Masuk</span>
                                    @endswitch
                                </td>

                                <td class="text-center">
                                    <button type="button" class="btn bg-white" style="color: #0D93CA;"
                                        data-bs-toggle="modal" data-bs-target="#modal-detail"
                                        data-attendance="{{ $attendance->id }}">Lihat
                                        Detail</button>
                                </td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Menampilkan {{ $attendanceJournals->currentPage() }} dari {{ $attendanceJournals->lastPage() }}
                        halaman
                    </div>
                    <div>
                        <x-paginate-component :paginator="$attendanceJournals" />
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow">
            <div class="card-body pt-3">
                <h4 class="pb-3"><b>Laporan Kegiatan</b></h4>
                <div class="form-group">
                    <h6 class="mt-4">Judul</h6>
                    <input type="text" class="form-control" id="nametext" aria-describedby="name"
                        placeholder="Maling Rambutan" value="{{ $journal->title }}">
                </div>
                <div class="form-group">
                    <h6 class="mt-4">Isi Laporan</h6>
                    <textarea class="form-control" rows="8"
                        placeholder="Pada pertemuan kali ini, ekstrakurikuler band berjalan dengan lancar. Latihan rutin diadakan setiap Selasa dan Kamis sore, dengan fokus pada teknik bermain musik dan kerjasama tim.
Kegiatan ini memberikan banyak manfaat, termasuk peningkatan bakat musik, rasa percaya diri, disiplin, dan kerjasama. Kami optimis ekstrakurikuler band akan terus berkembang dan meraih prestasi di masa depan.">{{ $journal->description }}</textarea>

                </div>
            </div>
        </div>

        <div class="justify-content-start mb-5">
            <a href="/teacher/journals" type="button" class="btn mb-1 btn-white border-1"
                style="border-color: #0896D1 !important; color: #0896D1 !important;">
                {{-- <i class="ti ti-plus" style="color: #0896D1 !important;"></i> --}}
                <svg width="24" height="24" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M22.9564 13.2916H9.45931L15.356 7.39489C15.8272 6.92364 15.8272 6.1503 15.356 5.67905C15.2442 5.56704 15.1114 5.47817 14.9652 5.41753C14.8191 5.35689 14.6624 5.32568 14.5041 5.32568C14.3458 5.32568 14.1891 5.35689 14.043 5.41753C13.8968 5.47817 13.764 5.56704 13.6522 5.67905L5.68931 13.642C5.57729 13.7538 5.48842 13.8865 5.42778 14.0327C5.36715 14.1789 5.33594 14.3356 5.33594 14.4938C5.33594 14.6521 5.36715 14.8088 5.42778 14.955C5.48842 15.1012 5.57729 15.2339 5.68931 15.3457L13.6522 23.3086C13.7641 23.4205 13.8969 23.5092 14.0431 23.5698C14.1892 23.6303 14.3459 23.6615 14.5041 23.6615C14.6623 23.6615 14.819 23.6303 14.9651 23.5698C15.1113 23.5092 15.2441 23.4205 15.356 23.3086C15.4678 23.1968 15.5566 23.064 15.6171 22.9178C15.6777 22.7716 15.7088 22.615 15.7088 22.4568C15.7088 22.2986 15.6777 22.1419 15.6171 21.9957C15.5566 21.8496 15.4678 21.7168 15.356 21.6049L9.45931 15.7082H22.9564C23.621 15.7082 24.1647 15.1645 24.1647 14.4999C24.1647 13.8353 23.621 13.2916 22.9564 13.2916Z"
                        fill="#0896D1" />
                </svg>
                Kembali
            </a>
        </div>


        @include('teacher.pages.journals.wigets.detail')
    @endsection

    @section('script')
        <script>
            const attendanceStudents = @json($attendanceJournals->items());

            $('.btn-detail').click(function() {
                let attendance = attendanceStudents.find(item => item.id == $(this).data('attendance'));
                let classroomStudent = attendance.classroom_student;
                let student = classroomStudent.student;

                $('#name-detail').text(student.user.name);
                $('#email-detail').text(student.user.email);
                $('#gender-detail').text(student.gender);
                $('#nik-detail').text(student.nik);
                $('#nisn-detail').text(student.nisn);
                $('#classroom-detail').text(classroomStudent.classroom.name);
                $('#religion-detail').text(student
                    .religion_id); // Assuming religion_id returns name or handled elsewhere
                $('#address-detail').text(student.address);
                $('#rfid-detail').text(student.rfid || '-');

                // Status Logic
                let statusText = 'Masuk';
                let statusClass = 'bg-light-success text-success';

                switch (attendance.status) {
                    case 'sick':
                    case 'sakit': // Handle potential variations
                        statusText = 'Sakit';
                        statusClass = 'bg-light-warning text-warning';
                        break;
                    case 'permit':
                    case 'izin':
                        statusText = 'Izin';
                        statusClass = 'bg-light-primary text-primary';
                        break;
                    case 'alpha':
                        statusText = 'Alfa';
                        statusClass = 'bg-light-danger text-danger';
                        break;
                    default:
                        statusText = 'Masuk';
                        statusClass = 'bg-light-success text-success';
                }

                let statusBadge = $('#status-detail');
                statusBadge.text(statusText);
                statusBadge.attr('class', 'badge px-3 py-2 rounded-2 ' + statusClass);

                // Image
                let imageUrl = student.image ? "{{ asset('storage') }}/" + student.image :
                    "{{ asset('admin_assets/dist/images/profile/user-7.jpg') }}";
                $('#image-detail').attr('src', imageUrl);

                $('#modal-detail').modal('show');
            });
        </script>
    @endsection
