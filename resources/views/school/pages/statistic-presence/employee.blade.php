@extends('school.layouts.app')

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

        .apexcharts-legend {
            display: none;
        }

        .apexcharts-legend-series {
            display: none;
        }

        .apexcharts-toolbar {
            display: none !important;
        }

        #custom-legend {
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 10px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-right: 15px;
        }

        .legend-marker {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .legend-text {
            font-size: 12px;
            color: #373d3f;
            font-family: Helvetica, Arial, sans-serif;
        }
    </style>
@endsection

@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Statistik Absensi</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    Statistik Absensi Guru
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

    <div class="row align-items-center">
        <!-- Bagian Statistik -->
        <div class="col-12 col-lg-4 mb-3 mb-lg-0">
            <div class="d-flex align-items-center">
                <span class="badge p-1 d-flex align-items-center justify-content-center">
                    <svg width="72" height="72" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="72" height="72" rx="8" fill="#ECF2FF"/>
                        <path d="M21.3346 41.5V48.8333M36.0013 30.5V48.8333M54.3346 54.3333H17.668M50.668 37.8333V48.8333" stroke="#0896D1" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M24.268 30.1334C23.9791 29.7482 23.6171 29.4236 23.2028 29.1783C22.7885 28.933 22.3299 28.7717 21.8532 28.7036C21.3765 28.6355 20.8911 28.6619 20.4247 28.7814C19.9582 28.9009 19.5199 29.1111 19.1347 29.4001C18.7494 29.689 18.4249 30.0509 18.1796 30.4652C17.9342 30.8796 17.7729 31.3382 17.7048 31.8148C17.5673 32.7775 17.8178 33.7554 18.4013 34.5334C18.9848 35.3114 19.8534 35.8257 20.8161 35.9632C21.7788 36.1007 22.7567 35.8502 23.5347 35.2667C24.3126 34.6832 24.8269 33.8146 24.9645 32.8519C25.102 31.8892 24.8515 30.9114 24.268 30.1334ZM24.268 30.1334L33.068 23.5334M33.068 23.5334C33.4428 24.0339 33.9394 24.4303 34.5106 24.6848C35.0818 24.9393 35.7086 25.0434 36.3315 24.9874C36.9543 24.9314 37.5524 24.717 38.069 24.3646C38.5856 24.0123 39.0035 23.5336 39.283 22.9742M33.068 23.5334C32.6767 23.0109 32.432 22.3934 32.3591 21.7447C32.2863 21.0959 32.3879 20.4395 32.6536 19.8432C32.9193 19.247 33.3393 18.7324 33.8704 18.3527C34.4014 17.9731 35.0242 17.7421 35.6743 17.6836C36.3245 17.6251 36.9785 17.7412 37.5688 18.02C38.159 18.2988 38.6642 18.7301 39.032 19.2694C39.3999 19.8087 39.6171 20.4364 39.6612 21.0877C39.7053 21.739 39.5747 22.3903 39.283 22.9742M39.283 22.9742L47.3863 27.0259M47.3863 27.0259C47.1708 27.4566 47.0423 27.9255 47.0081 28.4059C46.9738 28.8863 47.0345 29.3687 47.1867 29.8257C47.4941 30.7485 48.1555 31.5114 49.0253 31.9466C49.8952 32.3817 50.9023 32.4535 51.8251 32.1462C52.7479 31.8388 53.5108 31.1774 53.946 30.3076C54.3722 29.439 54.4379 28.4372 54.1286 27.5204C53.8194 26.6036 53.1604 25.8462 52.2952 25.4133C51.4299 24.9803 50.4287 24.9068 49.5095 25.2089C48.5904 25.511 47.8279 26.1641 47.3882 27.0259H47.3863Z" stroke="#0896D1" stroke-width="3"/>
                    </svg>
                </span>
                <h3 class="ms-2 mb-0 fw-bold">Statistik Absensi Guru</h3>
            </div>
        </div>

        <!-- Form Filter -->
        <div class="col-12 col-lg-6">
            <form action="">
                <div class="row g-2 align-items-center">
                    <div class="col-12 col-md-6 col-lg-4">
                        <input type="date" name="start_date" class="form-control"
                            value="{{ old('start_date', request()->start_date ?? date('Y-m-d')) }}">
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <input type="date" name="end_date" class="form-control"
                            value="{{ old('end_date', request()->end_date ?? date('Y-m-d')) }}">
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <button type="submit" class="btn btn-primary w-100">Cari</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tombol Cetak -->
        <div class="col-12 col-lg-2 mt-3 mt-lg-0">
            <form action="{{ route('school.teacher-attendance.export') }}" >
                
                <button class="btn btn-success d-flex align-items-center justify-content-center w-100" type="submit">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 10C18 10.2652 17.8946 10.5196 17.7071 10.7071C17.5196 10.8946 17.2652 11 17 11C16.7348 11 16.4804 10.8946 16.2929 10.7071C16.1054 10.5196 16 10.2652 16 10C16 9.73478 16.1054 9.48043 16.2929 9.29289C16.4804 9.10536 16.7348 9 17 9C17.2652 9 17.5196 9.10536 17.7071 9.29289C17.8946 9.48043 18 9.73478 18 10Z" fill="white"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.945 1.25H12.055C13.422 1.25 14.525 1.25 15.392 1.367C16.292 1.487 17.05 1.747 17.652 2.348C18.392 3.088 18.62 4.075 18.702 5.299C18.946 5.31567 19.176 5.33833 19.392 5.367C20.292 5.487 21.05 5.747 21.652 6.348C22.254 6.95 22.512 7.708 22.634 8.608C22.75 9.475 22.75 10.578 22.75 11.945V12.055C22.75 13.422 22.75 14.525 22.634 15.392C22.512 16.292 22.254 17.05 21.652 17.652C20.912 18.392 19.925 18.62 18.701 18.702C18.685 18.946 18.6627 19.176 18.634 19.392C18.512 20.292 18.254 21.05 17.652 21.652C17.05 22.254 16.292 22.512 15.392 22.634C14.525 22.75 13.422 22.75 12.055 22.75H11.945C10.578 22.75 9.475 22.75 8.608 22.634C7.708 22.512 6.95 22.254 6.348 21.652C5.746 21.05 5.488 20.292 5.367 19.392C5.33767 19.176 5.315 18.946 5.299 18.702C4.075 18.62 3.089 18.392 2.349 17.652C1.746 17.05 1.488 16.292 1.367 15.392C1.25 14.525 1.25 13.422 1.25 12.055V11.945C1.25 10.578 1.25 9.475 1.367 8.608C1.487 7.708 1.747 6.95 2.348 6.348C2.95 5.746 3.708 5.488 4.608 5.367C4.83714 5.33636 5.06728 5.31368 5.298 5.299C5.38 4.075 5.608 3.089 6.348 2.349C6.95 1.746 7.708 1.488 8.608 1.367C9.475 1.25 10.578 1.25 11.945 1.25ZM6.807 5.253C7.16367 5.25033 7.543 5.24933 7.945 5.25H16.055C16.4563 5.25 16.8357 5.251 17.193 5.253C17.111 4.233 16.926 3.745 16.591 3.409C16.314 3.132 15.926 2.952 15.191 2.853C14.436 2.752 13.435 2.75 12 2.75C10.565 2.75 9.563 2.752 8.808 2.853C8.074 2.952 7.686 3.133 7.409 3.409C7.074 3.745 6.889 4.232 6.807 5.253ZM5.253 17.193C5.25033 16.8363 5.24933 16.457 5.25 16.055V14.75H5C4.80109 14.75 4.61032 14.671 4.46967 14.5303C4.32902 14.3897 4.25 14.1989 4.25 14C4.25 13.8011 4.32902 13.6103 4.46967 13.4697C4.61032 13.329 4.80109 13.25 5 13.25H19C19.1989 13.25 19.3897 13.329 19.5303 13.4697C19.671 13.6103 19.75 13.8011 19.75 14C19.75 14.1989 19.671 14.3897 19.5303 14.5303C19.3897 14.671 19.1989 14.75 19 14.75H18.75V16.055C18.75 16.4563 18.749 16.8357 18.747 17.193C19.767 17.111 20.256 16.926 20.591 16.591C20.868 16.314 21.048 15.926 21.147 15.191C21.248 14.436 21.25 13.435 21.25 12C21.25 10.565 21.248 9.563 21.147 8.808C21.048 8.074 20.867 7.686 20.591 7.409C20.314 7.132 19.926 6.952 19.191 6.853C18.436 6.752 17.435 6.75 16 6.75H8C6.565 6.75 5.563 6.752 4.808 6.853C4.074 6.952 3.686 7.133 3.409 7.409C3.132 7.686 2.952 8.074 2.853 8.809C2.752 9.563 2.75 10.565 2.75 12C2.75 13.435 2.752 14.437 2.853 15.192C2.952 15.926 3.133 16.314 3.409 16.591C3.745 16.926 4.232 17.111 5.253 17.193ZM17.25 14.75H6.75V16C6.75 17.435 6.752 18.436 6.853 19.192C6.952 19.926 7.133 20.314 7.409 20.591C7.686 20.868 8.074 21.048 8.809 21.147C9.563 21.248 10.565 21.25 12 21.25C13.435 21.25 14.437 21.248 15.192 21.147C15.926 21.048 16.314 20.867 16.591 20.591C16.868 20.314 17.048 19.926 17.147 19.191C17.248 18.436 17.25 17.435 17.25 16V14.75ZM5.25 10C5.25 9.80109 5.32902 9.61032 5.46967 9.46967C5.61032 9.32902 5.80109 9.25 6 9.25H9C9.19891 9.25 9.38968 9.32902 9.53033 9.46967C9.67098 9.61032 9.75 9.80109 9.75 10C9.75 10.1989 9.67098 10.3897 9.53033 10.5303C9.38968 10.671 9.19891 10.75 9 10.75H6C5.80109 10.75 5.61032 10.671 5.46967 10.5303C5.32902 10.3897 5.25 10.1989 5.25 10ZM8.25 16.805C8.25 16.6061 8.32902 16.4153 8.46967 16.2747C8.61032 16.134 8.80109 16.055 9 16.055H15C15.1989 16.055 15.3897 16.134 15.5303 16.2747C15.671 16.4153 15.75 16.6061 15.75 16.805C15.75 17.0039 15.671 17.1947 15.5303 17.3353C15.3897 17.476 15.1989 17.555 15 17.555H9C8.80109 17.555 8.61032 17.476 8.46967 17.3353C8.32902 17.1947 8.25 17.0039 8.25 16.805ZM8.25 19.305C8.25 19.1061 8.32902 18.9153 8.46967 18.7747C8.61032 18.634 8.80109 18.555 9 18.555H13C13.1989 18.555 13.3897 18.634 13.5303 18.7747C13.671 18.9153 13.75 19.1061 13.75 19.305C13.75 19.5039 13.671 19.6947 13.5303 19.8353C13.3897 19.976 13.1989 20.055 13 20.055H9C8.80109 20.055 8.61032 19.976 8.46967 19.8353C8.32902 19.6947 8.25 19.5039 8.25 19.305Z" fill="white"/>
                    </svg>
                    <span class="ms-2">Cetak Absensi</span>
                </button>
            </form>
        </div>
    </div>



    <div class="row mt-3">
        <div class="col-lg-8">
            <div class="card card-body">
                <h5 class="mb-4">Data Absensi Guru</h5>

                <div class="table-responsive rounded-2 mb-4">
                    <table class="table border text-nowrap customize-table mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr class="">
                                <th class="text-white" style="background-color: #5D87FF;">No</th>
                                <th class="text-white" style="background-color: #5D87FF;">Nama Guru</th>
                                <th class="text-white" style="background-color: #5D87FF;">Masuk</th>
                                <th class="text-white" style="background-color: #5D87FF;">Pulang</th>
                                <th class="text-white" style="background-color: #5D87FF;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attendances as $employee)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $employee->model->user->name }}</td>
                                    <td>{{ $employee->checkin ? $employee->checkin : '-' }}</td>
                                    <td>{{ $employee->checkout ? $employee->checkout : '-' }}</td>
                                    <td><span
                                            class="badge {{ $employee->status->color() }}">
                                            {{ $employee->status->label() }}
                                        </span></td>

                                    {{-- <td>
                                        <span class="badge {{ $employee->attendances->first()->status->color() }}">
                                            {{ $employee->attendances->first()->status->label() }}
                                        </span>
                                    </td> --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center align-middle">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}"
                                                alt="" width="300px">
                                            <p class="fs-5 text-dark text-center mt-2">
                                                Belum ada guru yang absen
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
        <div class="col-lg-4">
            <div class="card card-body">
                <h5>Statistik Absensi Guru</h5>
                <div>
                    <p>20 Januari 2024</p>
                </div>
                <div id="chart-employee"></div>

                <div class="d-flex">
                    <div class="d-flex">
                        <div id="custom-legend">
                            <div class="legend-item">
                                <span class="legend-marker" style="background-color: rgb(19, 222, 185);"></span>
                                <span class="legend-text">Masuk</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-marker" style="background-color: rgb(93, 135, 255);"></span>
                                <span class="legend-text">Izin</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-marker" style="background-color: rgb(255, 174, 31);"></span>
                                <span class="legend-text">Sakit</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-marker" style="background-color: rgb(250, 137, 107);"></span>
                                <span class="legend-text">Alfa</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('school.pages.statistic-presence.script.donut-chart')
@endsection
