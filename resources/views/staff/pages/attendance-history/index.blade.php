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
