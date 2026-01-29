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
@endsection
@section('content')
    {{-- <div class="card bg-info shadow-none position-relative overflow-hidden">
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
    </div> --}}
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Absensi Siswa</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    Daftar - daftar Absensi Siswa
                                </a>
                            </li>
                        </ol>
                    </nav>
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
    @php
        use App\Enums\AttendanceEnum;
    @endphp

    <div class="d-flex align-items-center mb-4">
        <h4 class="fw-semibold mb-0">Absensi Hari Ini / </h4>
        <span class="ms-2 px-3 py-1 rounded-2 fw-semibold bg-light-primary" style="color: #098FC6;">
            <i class="ti ti-calendar me-1"></i> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </span>
    </div>

    <div class="row g-2 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm h-100 mb-0">
                <div class="card-body py-3">
                    <div class="d-flex">
                        <div class="border border-success"></div>
                        <div class="ms-3">
                            <h4>Jumlah Siswa Masuk</h4>
                            <h4 class="text-success">
                                <b>{{ $attendances->where('status', AttendanceEnum::PRESENT)->count() }}</b>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm h-100 mb-0">
                <div class="card-body py-3">
                    <div class="d-flex">
                        <div class="border" style="border-color: #0D93CA !important;"></div>
                        <div class="ms-3">
                            <h4>Jumlah Siswa Izin</h4>
                            <h4 style="color: #0D93CA;">
                                <b>{{ $attendances->where('status', AttendanceEnum::PERMIT)->count() }}</b>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm h-100 mb-0">
                <div class="card-body py-3">
                    <div class="d-flex">
                        <div class="border border-warning"></div>
                        <div class="ms-3">
                            <h4>Jumlah Siswa Sakit</h4>
                            <h4 class="text-warning">
                                <b>{{ $attendances->where('status', AttendanceEnum::SICK)->count() }}</b>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm h-100 mb-0">
                <div class="card-body py-3">
                    <div class="d-flex">
                        <div class="border border-danger"></div>
                        <div class="ms-3">
                            <h4>Jumlah Siswa Alpha</h4>
                            <h4 class="text-danger">
                                <b>{{ $attendances->where('status', AttendanceEnum::ALPHA)->count() }}</b>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-body">
        <h4><b>Riwayat Absensi</b></h4>
        <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 mb-4 gap-3">
            <form class="d-flex gap-2 align-items-center" method="GET" action="{{ url()->current() }}">
                <input type="hidden" name="classroom" value="{{ request('classroom') }}">
                <div class="position-relative">
                    <input type="text" name="search" class="form-control search-chat py-2 px-4 ps-5" id="search-name"
                        placeholder="Cari" value="{{ old('search', request('search')) }}">
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                </div>
                <div>
                    <select name="status" class="form-select py-2" id="search-status" style="min-width: 120px;">
                        <option value="" {{ old('status', request('status')) == '' ? 'selected' : '' }}>Semua
                        </option>
                        <option value="present" {{ old('status', request('status')) == 'present' ? 'selected' : '' }}>Masuk
                        </option>
                        <option value="permit" {{ old('status', request('status')) == 'permit' ? 'selected' : '' }}>Izin
                        </option>
                        <option value="sick" {{ old('status', request('status')) == 'sick' ? 'selected' : '' }}>Sakit
                        </option>
                        <option value="alpha" {{ old('status', request('status')) == 'alpha' ? 'selected' : '' }}>Alfa
                        </option>
                    </select>
                </div>
                <button type="submit" class="btn text-white px-4" style="background-color: #098FC6;">Filter</button>
            </form>

            <form class="d-flex gap-2 align-items-center" method="GET" action="{{ url()->current() }}">
                <input type="hidden" name="classroom" value="{{ request('classroom') }}">
                <div class="position-relative">
                    <input type="date" name="date" class="form-control search-chat py-2 px-2 ps-3" id="search-date"
                        value="{{ old('date', request('date')) }}">
                </div>
                <button type="submit" class="btn text-white px-4" style="background-color: #098FC6;">Cari</button>
            </form>
        </div>

        <div class="">
            <div class="table-responsive rounded-2 mb-4">
                <table class="table border text-nowrap customize-table mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th class="text-white" style="background-color: #098FC6;">No</th>
                            <th class="text-white" style="background-color: #098FC6;">Nama Siswa</th>
                            <th class="text-white" style="background-color: #098FC6;">Tanggal</th>
                            <th class="text-white" style="background-color: #098FC6;">Masuk</th>
                            <th class="text-white" style="background-color: #098FC6;">Pulang</th>
                            <th class="text-white" style="background-color: #098FC6;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attendances as $attendance)
                            @php
                                $student = $attendance->model->student ?? null;
                                $user = $student->user ?? null;
                                $genderLabel = 'Laki-laki';
                                if ($student) {
                                    try {
                                        $genderLabel = $student->gender->label();
                                    } catch (\Throwable $th) {
                                        $genderLabel = $student->gender == 'male' ? 'Laki-laki' : 'Perempuan';
                                    }
                                }

                                // Status badge colors
                                $statusColors = [
                                    'present' => ['bg' => '#E8FFF3', 'text' => '#13DEB9'],
                                    'late' => ['bg' => '#FFF8E1', 'text' => '#FFAE1F'],
                                    'sick' => ['bg' => '#FFF4E5', 'text' => '#FA896B'],
                                    'alpha' => ['bg' => '#FFE1E1', 'text' => '#DC3545'],
                                    'permit' => ['bg' => '#ECF2FF', 'text' => '#5D87FF'],
                                ];
                                $statusKey = $attendance->status->value ?? 'present';
                                $statusLabel = $attendance->status->label() ?? 'Masuk';
                                $statusColor = $statusColors[$statusKey] ?? $statusColors['present'];
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration + ($attendances->currentPage() - 1) * $attendances->perPage() }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $student && $student->image ? asset('storage/' . $student->image) : asset('assets/images/default-user.jpeg') }}"
                                            class="rounded-circle" width="40" height="40"
                                            style="object-fit: cover">
                                        <div class="ms-3">
                                            <h6 class="fs-4 fw-semibold mb-0">{{ $user->name ?? 'N/A' }}</h6>
                                            <span class="fw-normal fs-2">{{ $genderLabel }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($attendance->created_at)->translatedFormat('d F Y') }}</td>
                                <td>{{ $attendance->checkin ? \Carbon\Carbon::parse($attendance->checkin)->format('H.i') : '-' }}
                                </td>
                                <td>{{ $attendance->checkout ? \Carbon\Carbon::parse($attendance->checkout)->format('H.i') : '-' }}
                                </td>
                                <td>
                                    <span class="badge px-3 py-2 rounded-2 fw-semibold"
                                        style="background-color: {{ $statusColor['bg'] }}; color: {{ $statusColor['text'] }};">
                                        {{ ucfirst($statusLabel) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center align-middle">
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
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Menampilkan {{ $attendances->currentPage() }} dari {{ $attendances->lastPage() }} halaman
                </div>
                <div>
                    {{ $attendances->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
