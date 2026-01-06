@extends('staff.layouts.app')
@section('style')
    <style>
        .table-wrapper {
            max-height: 400px;
            overflow-y: auto;
        }

        .table-wrapper::-webkit-scrollbar {
            width: 8px;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

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

        .btn-primary {
            background-color: #0896D1 !important;
            border-color: #0896D1 !important;
        }

        .btn-primary:hover {
            background-color: #067aa7 !important;
            border-color: #067aa7 !important;
        }
    </style>
@endsection
@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Absensi</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item text-white" aria-current="page">Riwayat absensi harian Staff</li>
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
    {{-- 
    <div class="card">
        <div class="d-flex card-body justify-content-between align-items-center">
            <div>
                <h5 class="fs-4 mb-2 fw-normal">Absensi Hari Ini :</h5>
                <h3 class="fw-semibold mb-0">{{ \Carbon\Carbon::now()->translatedFormat('d F Y - H.i') }}</h3>
            </div>
            <div>
                <span class="badge px-4 py-2 rounded-2 fs-6 fw-semibold" style="background-color: #E5F9F6; color: #1EB196;">
                    Masuk
                </span>
            </div>
        </div>
    </div> --}}

    <div class="card">
        <div class="d-flex card-body justify-content-between align-items-center">
            <div>
                <h5 class="fs-4 mb-3 fw-normal">Absensi Hari Ini :</h5>
                <span class="border-0 px-4 py-2 mt-2 rounded-2 fs-4 fw-semibold"
                    style="background-color: #E6E6E6; color: #555; pointer-events: none;">
                    Belum Absen
                </span>
            </div>
            <button class="btn border-0 fw-bold d-flex align-items-center gap-2 py-2 rounded-2"
                style="background-color: #0896D1; color: white;">
                <svg width="19" height="13" viewBox="0 0 19 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M6.49795 10.1626L16.9112 0.347439C17.1569 0.115813 17.4436 0 17.7713 0C18.099 0 18.3856 0.115813 18.6314 0.347439C18.8771 0.579065 19 0.854313 19 1.17318C19 1.49206 18.8771 1.76692 18.6314 1.99777L7.35804 12.6526C7.1123 12.8842 6.8256 13 6.49795 13C6.17029 13 5.8836 12.8842 5.63786 12.6526L0.354434 7.67261C0.108693 7.44098 -0.00926253 7.16612 0.000567093 6.84802C0.0103967 6.52992 0.138591 6.25467 0.385151 6.02227C0.63171 5.78987 0.923733 5.67406 1.26122 5.67483C1.5987 5.6756 1.89031 5.79142 2.13605 6.02227L6.49795 10.1626Z"
                        fill="white" />
                </svg>
                Absen Sekarang
            </button>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card border">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Riwayat Absensi</h4>
                    <form class="d-flex gap-2" method="GET" action="{{ url()->current() }}">
                        <div class="position-relative">
                            <input type="date" name="date" class="form-control search-chat"
                                value="{{ request('date') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </form>
                </div>
                <div class="table-responsive rounded-2 ">
                    <table class="table border text-nowrap customize-table mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="text-white" style="background-color: #0896D1;">No</th>
                                <th class="text-white" style="background-color: #0896D1;">Hari</th>
                                <th class="text-white" style="background-color: #0896D1;">Tanggal</th>
                                <th class="text-white" style="background-color: #0896D1;">Masuk</th>
                                <th class="text-white" style="background-color: #0896D1;">Pulang</th>
                                <th class="text-white" style="background-color: #0896D1;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attendances as $attendance)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($attendance->created_at)->translatedFormat('l') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($attendance->created_at)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ $attendance->checkin == null ? '-' : \Carbon\Carbon::parse($attendance->checkin)->format('H:i') }}
                                    </td>
                                    <td>{{ $attendance->checkout == null ? '-' : \Carbon\Carbon::parse($attendance->checkout)->format('H:i') }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $attendance->status->color() }}">
                                            {{ $attendance->status->label() }}
                                        </span>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center align-middle">
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
                    <div class="pagination justify-content-end mt-2 mb-0">
                        {{-- <x-paginate-component :paginator="$attendances" /> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
