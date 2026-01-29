@extends('school.layouts.app')

<style>
    .btn-primary {
        background-color: #0896D1 !important;
        border-color: #0896D1 !important;
    }

    .clr {
        color: #0896D1;
    }
</style>

@section('content')
    <div class="card border-1">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h4>Detail Sekolah</h4>

                <div class="">
                    <a href="{{ route('school.settings-information.edit') }}"
                        class="btn btn-primary d-inline-flex align-items-center gap-2">
                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_6668_3785)">
                                <path
                                    d="M14.6426 1.95571L15.0443 2.35747C15.3564 2.66958 15.3564 3.17427 15.0443 3.48306L14.0781 4.45259L12.5475 2.92192L13.5137 1.95571C13.8258 1.6436 14.3305 1.6436 14.6393 1.95571H14.6426ZM6.96602 8.50669L11.4219 4.04751L12.9525 5.57817L8.49336 10.034C8.39707 10.1303 8.27754 10.2 8.14805 10.2366L6.20566 10.7911L6.76016 8.84868C6.79668 8.71919 6.86641 8.59966 6.9627 8.50337L6.96602 8.50669ZM12.3881 0.830127L5.83711 7.37778C5.54824 7.66665 5.33906 8.02192 5.22949 8.4104L4.27988 11.7307C4.2002 12.0096 4.27656 12.3084 4.48242 12.5143C4.68828 12.7202 4.98711 12.7965 5.26602 12.7168L8.58633 11.7672C8.97813 11.6543 9.3334 11.4452 9.61895 11.1596L16.1699 4.61196C17.1029 3.67895 17.1029 2.16489 16.1699 1.23188L15.7682 0.830127C14.8352 -0.102881 13.3211 -0.102881 12.3881 0.830127ZM2.92188 2.12505C1.3082 2.12505 0 3.43325 0 5.04692V14.0782C0 15.6918 1.3082 17 2.92188 17H11.9531C13.5668 17 14.875 15.6918 14.875 14.0782V10.3594C14.875 9.91782 14.5197 9.56255 14.0781 9.56255C13.6365 9.56255 13.2812 9.91782 13.2812 10.3594V14.0782C13.2812 14.812 12.6869 15.4063 11.9531 15.4063H2.92188C2.18809 15.4063 1.59375 14.812 1.59375 14.0782V5.04692C1.59375 4.31313 2.18809 3.7188 2.92188 3.7188H6.64062C7.08223 3.7188 7.4375 3.36353 7.4375 2.92192C7.4375 2.48032 7.08223 2.12505 6.64062 2.12505H2.92188Z"
                                    fill="white" />
                            </g>
                            <defs>
                                <clipPath id="clip0_6668_3785">
                                    <rect width="17" height="17" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>

                        Edit Informasi
                    </a>
                </div>
            </div>
            <div class="row pb-4 mt-3 mx-2">
                <div class="row mb-4 d-flex align-items-center">
                    <div class="col-12 col-lg-1 mb-2">
                        <img class="img-fluid me-3 rounded-circle" style="width: 80px; height: 80px; object-fit: cover;"
                            src="{{ $school->image && Storage::disk('public')->exists($school->image) ? asset('storage/' . $school->image) : asset('assets/images/default-user.jpeg') }}"
                            alt="{{ $school->user->name }}">
                    </div>
                    <div class="col-12 col-lg-7">
                        <div class="mb-2 d-flex">
                            <h3 class="mb-1">{{ $school->user->name }}</h3>
                            <span
                                class="badge font-medium bg-light-primary text-secondary align-self-center ms-2">{{ $school->type }}</span>
                        </div>
                        <p>{{ $school->description != null ? Str::limit($school->description, 100) : '' }}</p>
                    </div>
                    <div class="col-12 col-lg-4 text-lg-end">
                        <h5 class="mb-1">Tahun Ajaran</h5>
                        <h5 class="clr">{{ $schoolYear->school_year }}</h5>
                    </div>
                </div>


                <hr>

                <div class="d-flex flex-column flex-md-row justify-content-between">
                    <div class="col-md-5 mb-3 mb-md-0 mt-3">
                        <div class="d-flex mb-4">
                            <h6 class="mb-0" style="width: 140px;">Kepala Sekolah</h6>
                            <span class="me-4">:</span>
                            <p class="mb-0">{{ $school->head_school }}</p>
                        </div>
                        <div class="d-flex mb-4">
                            <h6 class="mb-0" style="width: 140px;">NPSN</h6>
                            <span class="me-4">:</span>
                            <p class="mb-0">{{ $school->npsn }}</p>
                        </div>
                        <div class="d-flex mb-4">
                            <h6 class="mb-0" style="width: 140px;">Nomor Telepon</h6>
                            <span class="me-4">:</span>
                            <p class="mb-0">{{ $school->phone_number }}</p>
                        </div>
                        <div class="d-flex mb-4">
                            <h6 class="mb-0" style="width: 140px;">Email</h6>
                            <span class="me-4">:</span>
                            <p class="mb-0">{{ $school->user->email }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="d-flex mb-4">
                            <h6 class="mb-0" style="width: 160px;">Jenjang Pendidikan</h6>
                            <span class="me-4">:</span>
                            <p class="mb-0">{{ $school->level }}</p>
                        </div>
                        <div class="d-flex mb-4">
                            <h6 class="mb-0" style="width: 160px;">Akreditasi</h6>
                            <span class="me-4">:</span>
                            <p class="mb-0">{{ $school->accreditation }}</p>
                        </div>
                        <div class="d-flex mb-4">
                            <h6 class="mb-0" style="width: 160px; flex-shrink: 0;">Alamat</h6>
                            <span class="me-4" style="flex-shrink: 0;">:</span>
                            <p class="mb-0">{{ $school->address }}</p>
                        </div>
                        <div class="d-flex mb-4">
                            <h6 class="mb-0" style="width: 160px;">Website</h6>
                            <span class="me-4">:</span>
                            <p class="mb-0">{{ $school->website_school }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-1">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                <h4 class="fw-semibold m-0 mb-2 mb-md-0">Daftar RFID Sekolah</h4>
                {{-- <div class="row align-items-center pt-3"> --}}
                {{-- <div class="col-12 col-md-8 col-lg-3">
                        <form action="" class="d-flex">
                            <div class="position-relative flex-grow-1">
                                <input type="text" name="search" class="form-control search-chat py-2 px-5 ps-5"
                                    id="search-name" placeholder="Cari..." value="{{ request()->search }}">
                                <i class="ti ti-search position-absolute top-50 translate-middle-y fs-6 text-dark ms-3"></i>
                            </div>
                        </form>
                    </div> --}}

                <button class="btn btn-primary d-flex gap-2 btn-rfid w-md-auto">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M21 11C21 16.55 17.16 21.74 12 23C6.84 21.74 3 16.55 3 11V5L12 1L21 5V11ZM12 21C15.75 20 19 15.54 19 11.22V6.3L12 3.18L5 6.3V11.22C5 15.54 8.25 20 12 21ZM12 6C12.7956 6 13.5587 6.31607 14.1213 6.87868C14.6839 7.44129 15 8.20435 15 9C15 10.31 14.17 11.42 13 11.83V14H15V16H13V18H11V11.83C10.414 11.6244 9.90661 11.2414 9.54821 10.7343C9.18981 10.2271 8.9982 9.621 9 9C9 8.20435 9.31607 7.44129 9.87868 6.87868C10.4413 6.31607 11.2044 6 12 6ZM12 8C11.7348 8 11.4804 8.10536 11.2929 8.29289C11.1054 8.48043 11 8.73478 11 9C11 9.26522 11.1054 9.51957 11.2929 9.70711C11.4804 9.89464 11.7348 10 12 10C12.2652 10 12.5196 9.89464 12.7071 9.70711C12.8946 9.51957 13 9.26522 13 9C13 8.73478 12.8946 8.48043 12.7071 8.29289C12.5196 8.10536 12.2652 8 12 8Z"
                            fill="white" />
                    </svg>
                    Tambah Master Key
                </button>
            </div>
            {{-- </div> --}}

            <div class="mt-3">
                <div class="table-responsive rounded-2 mb-3">
                    <table class="table border text-nowrap customize-table mb-0 align-middle text-center">
                        <thead>
                            <tr>
                                <th style="background-color: #0896D1;" class="text-white">No</th>
                                <th style="background-color: #0896D1;" class="text-white">Nama Pengguna</th>
                                <th style="background-color: #0896D1;" class="text-white">Email</th>
                                <th style="background-color: #0896D1;" class="text-white">RFID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rfids as $rfid)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $rfid->rfid }}</td>
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
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Menampilkan {{ $rfids->currentPage() }} dari {{ $rfids->lastPage() }} halaman
                    </div>
                    <div>
                        <x-paginate-component :paginator="$rfids" />
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- modal create masterkey --}}
    @include('school.pages.settings.widgets.modal-create-masterkey')
@endsection

@section('script')
    @include('school.pages.settings.scripts.script-index')
@endsection
