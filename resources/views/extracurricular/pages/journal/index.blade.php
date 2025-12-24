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
    </style>
    @extends('extracurricular.layouts.app')
@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Jurnal Pembina Eskul</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    {{ auth()->user()->name }}
                                </a>
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

    <div class="row me-3 mb-3">
        <div class="col-lg-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div class="d-flex align-items-start align-items-md-center mb-3 mb-md-0">
                    <span class="mb-1 badge p-1" style="color: #0896D1 !important; background-color: #0896D1 !important;">
                        <svg width="29" height="29" viewBox="0 0 29 29" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9.0625 19.0312C9.0625 18.7909 9.15798 18.5604 9.32793 18.3904C9.49789 18.2205 9.7284 18.125 9.96875 18.125H13.5938C13.8341 18.125 14.0646 18.2205 14.2346 18.3904C14.4045 18.5604 14.5 18.7909 14.5 19.0312C14.5 19.2716 14.4045 19.5021 14.2346 19.6721C14.0646 19.842 13.8341 19.9375 13.5938 19.9375H9.96875C9.7284 19.9375 9.49789 19.842 9.32793 19.6721C9.15798 19.5021 9.0625 19.2716 9.0625 19.0312ZM9.0625 15.4062C9.0625 15.1659 9.15798 14.9354 9.32793 14.7654C9.49789 14.5955 9.7284 14.5 9.96875 14.5H19.0312C19.2716 14.5 19.5021 14.5955 19.6721 14.7654C19.842 14.9354 19.9375 15.1659 19.9375 15.4062C19.9375 15.6466 19.842 15.8771 19.6721 16.0471C19.5021 16.217 19.2716 16.3125 19.0312 16.3125H9.96875C9.7284 16.3125 9.49789 16.217 9.32793 16.0471C9.15798 15.8771 9.0625 15.6466 9.0625 15.4062ZM9.0625 11.7812C9.0625 11.5409 9.15798 11.3104 9.32793 11.1404C9.49789 10.9705 9.7284 10.875 9.96875 10.875H19.0312C19.2716 10.875 19.5021 10.9705 19.6721 11.1404C19.842 11.3104 19.9375 11.5409 19.9375 11.7812C19.9375 12.0216 19.842 12.2521 19.6721 12.4221C19.5021 12.592 19.2716 12.6875 19.0312 12.6875H9.96875C9.7284 12.6875 9.49789 12.592 9.32793 12.4221C9.15798 12.2521 9.0625 12.0216 9.0625 11.7812ZM9.0625 8.15625C9.0625 7.9159 9.15798 7.68539 9.32793 7.51543C9.49789 7.34548 9.7284 7.25 9.96875 7.25H19.0312C19.2716 7.25 19.5021 7.34548 19.6721 7.51543C19.842 7.68539 19.9375 7.9159 19.9375 8.15625C19.9375 8.3966 19.842 8.62711 19.6721 8.79707C19.5021 8.96702 19.2716 9.0625 19.0312 9.0625H9.96875C9.7284 9.0625 9.49789 8.96702 9.32793 8.79707C9.15798 8.62711 9.0625 8.3966 9.0625 8.15625Z"
                                fill="white" />
                            <path
                                d="M5.4375 0H23.5625C24.5239 0 25.4459 0.381919 26.1258 1.06174C26.8056 1.74156 27.1875 2.66359 27.1875 3.625V25.375C27.1875 26.3364 26.8056 27.2584 26.1258 27.9383C25.4459 28.6181 24.5239 29 23.5625 29H5.4375C4.47609 29 3.55406 28.6181 2.87424 27.9383C2.19442 27.2584 1.8125 26.3364 1.8125 25.375V23.5625H3.625V25.375C3.625 25.8557 3.81596 26.3167 4.15587 26.6566C4.49578 26.9965 4.95679 27.1875 5.4375 27.1875H23.5625C24.0432 27.1875 24.5042 26.9965 24.8441 26.6566C25.184 26.3167 25.375 25.8557 25.375 25.375V3.625C25.375 3.14429 25.184 2.68328 24.8441 2.34337C24.5042 2.00346 24.0432 1.8125 23.5625 1.8125H5.4375C4.95679 1.8125 4.49578 2.00346 4.15587 2.34337C3.81596 2.68328 3.625 3.14429 3.625 3.625V5.4375H1.8125V3.625C1.8125 2.66359 2.19442 1.74156 2.87424 1.06174C3.55406 0.381919 4.47609 0 5.4375 0Z"
                                fill="white" />
                            <path
                                d="M1.8125 9.0625V8.15625C1.8125 7.9159 1.90798 7.68539 2.07793 7.51543C2.24789 7.34548 2.4784 7.25 2.71875 7.25C2.9591 7.25 3.18961 7.34548 3.35957 7.51543C3.52952 7.68539 3.625 7.9159 3.625 8.15625V9.0625H4.53125C4.7716 9.0625 5.00211 9.15798 5.17207 9.32793C5.34202 9.49789 5.4375 9.7284 5.4375 9.96875C5.4375 10.2091 5.34202 10.4396 5.17207 10.6096C5.00211 10.7795 4.7716 10.875 4.53125 10.875H0.90625C0.665898 10.875 0.435389 10.7795 0.265435 10.6096C0.0954797 10.4396 0 10.2091 0 9.96875C0 9.7284 0.0954797 9.49789 0.265435 9.32793C0.435389 9.15798 0.665898 9.0625 0.90625 9.0625H1.8125ZM1.8125 14.5V13.5938C1.8125 13.3534 1.90798 13.1229 2.07793 12.9529C2.24789 12.783 2.4784 12.6875 2.71875 12.6875C2.9591 12.6875 3.18961 12.783 3.35957 12.9529C3.52952 13.1229 3.625 13.3534 3.625 13.5938V14.5H4.53125C4.7716 14.5 5.00211 14.5955 5.17207 14.7654C5.34202 14.9354 5.4375 15.1659 5.4375 15.4062C5.4375 15.6466 5.34202 15.8771 5.17207 16.0471C5.00211 16.217 4.7716 16.3125 4.53125 16.3125H0.90625C0.665898 16.3125 0.435389 16.217 0.265435 16.0471C0.0954797 15.8771 0 15.6466 0 15.4062C0 15.1659 0.0954797 14.9354 0.265435 14.7654C0.435389 14.5955 0.665898 14.5 0.90625 14.5H1.8125ZM1.8125 19.9375V19.0312C1.8125 18.7909 1.90798 18.5604 2.07793 18.3904C2.24789 18.2205 2.4784 18.125 2.71875 18.125C2.9591 18.125 3.18961 18.2205 3.35957 18.3904C3.52952 18.5604 3.625 18.7909 3.625 19.0312V19.9375H4.53125C4.7716 19.9375 5.00211 20.033 5.17207 20.2029C5.34202 20.3729 5.4375 20.6034 5.4375 20.8438C5.4375 21.0841 5.34202 21.3146 5.17207 21.4846C5.00211 21.6545 4.7716 21.75 4.53125 21.75H0.90625C0.665898 21.75 0.435389 21.6545 0.265435 21.4846C0.0954797 21.3146 0 21.0841 0 20.8438C0 20.6034 0.0954797 20.3729 0.265435 20.2029C0.435389 20.033 0.665898 19.9375 0.90625 19.9375H1.8125Z"
                                fill="white" />
                        </svg>
                    </span>
                    <h4 class="ms-3 mb-0">Pengisian Jurnal</h4>
                </div>
                <div class="d-flex align-items-start align-items-md-center">
                    <p class="mb-0">Tanggal saat ini:</p>
                    <span class="badge bg-light-primary text-secondary ms-2 fw-semibold d-flex align-items-center gap-2">
                        <svg width="23" height="26" viewBox="0 0 23 26" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.5 14.3H17.8889V20.8H11.5V14.3ZM20.4444 2.6H19.1667V0H16.6111V2.6H6.38889V0H3.83333V2.6H2.55556C1.15 2.6 0 3.77 0 5.2V23.4C0 24.83 1.15 26 2.55556 26H20.4444C21.85 26 23 24.83 23 23.4V5.2C23 3.77 21.85 2.6 20.4444 2.6ZM20.4444 5.2V7.8H2.55556V5.2H20.4444ZM2.55556 23.4V10.4H20.4444V23.4H2.55556Z"
                                fill="#0896D1" />
                        </svg>
                        <?php echo date('d F Y'); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>


    <div class="card border shadow mt-3">
        <div class="card-body pt-3">
            <h4 class="pb-3">Jurnal Kegiatan Esktrakulikuler Hari Ini</h4>
            <div class="table-responsive rounded-2 mb-4">
                <table class="table text-nowrap border customize-table mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th class="text-white" style="background-color: #0896D1 !important;">No</th>
                            <th class="text-white" style="background-color: #0896D1 !important;">Tanggal</th>
                            <th class="text-white" style="background-color: #0896D1 !important;">Jam</th>
                            <th class="text-white" style="background-color: #0896D1 !important;">Total Hadir</th>
                            <th class="text-white" style="background-color: #0896D1 !important;">Status</th>
                            <th class=" text-center text-white" style="background-color: #0896D1 !important;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $dummyData = [
                                [
                                    'date' => '20/12/2025',
                                    'time' => '15:00',
                                    'attendance' => 20,
                                    'status' => 'Belum Mengisi',
                                ],
                                [
                                    'date' => '20/12/2025',
                                    'time' => '15:00',
                                    'attendance' => 20,
                                    'status' => 'Mengisi',
                                ],
                            ];
                        @endphp
                        @foreach ($dummyData as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data['date'] }}</td>
                                <td>{{ $data['time'] }}</td>
                                <td>{{ $data['attendance'] }} Siswa Hadir</td>
                                <td>
                                    @if ($data['status'] == 'Belum Mengisi')
                                        <span class="badge px-3 py-2 rounded-2 fw-semibold"
                                            style="background-color: #FEF2F2; color: #DC2626;">{{ $data['status'] }}</span>
                                    @else
                                        <span class="badge px-3 py-2 rounded-2 fw-semibold"
                                            style="background-color: #F0FDFA; color: #0D9488;">{{ $data['status'] }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($data['status'] == 'Belum Mengisi')
                                        <a href="{{ route('extracurricular.journal.create', ['extracurricular' => request('extracurricular')]) }}"
                                            class="btn btn-sm d-inline-flex align-items-center justify-content-center"
                                            style="background-color: #E0F2FE; color: #0284C7; width: 32px; height: 32px;">
                                            <i class="ti ti-plus fs-5"></i>
                                        </a>
                                    @else
                                        <div class="d-flex gap-2 justify-content-center">
                                            <button type="button"
                                                class="btn btn-sm d-inline-flex align-items-center justify-content-center"
                                                style="background-color: #E0F2FE; color: #0284C7; width: 32px; height: 32px;"
                                                data-bs-toggle="modal" data-bs-target="#modal-detail">
                                                <i class="ti ti-eye fs-5"></i>
                                            </button>
                                            <a href="{{ route('extracurricular.journal.edit', ['id' => 1]) }}"
                                                class="btn btn-sm d-inline-flex align-items-center justify-content-center"
                                                style="background-color: #FEF3C7; color: #D97706; width: 32px; height: 32px;">
                                                <i class="ti ti-pencil fs-5"></i>
                                            </a>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row me-3 mb-3">
        <div class="col-lg-6 col-md-12 mb-3">
            <div class="d-flex align-items-start align-items-md-center mb-3 mb-md-0">
                <span class="mb-1 badge p-1" style="color: #0896D1 !important; background-color: #0896D1 !important;">
                    <svg width="29" height="29" viewBox="0 0 29 29" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.2487 2.41699C6.60776 2.41699 5.99307 2.6716 5.53986 3.12482C5.08664 3.57803 4.83203 4.19272 4.83203 4.83366V13.8937C5.41356 13.6517 6.0221 13.4805 6.64453 13.3838V4.83366C6.64453 4.67342 6.70818 4.51975 6.82149 4.40645C6.93479 4.29315 7.08846 4.22949 7.2487 4.22949H14.4987V9.66699C14.4987 10.3079 14.7533 10.9226 15.2065 11.3758C15.6597 11.829 16.2744 12.0837 16.9154 12.0837H22.3529V24.167C22.3529 24.3272 22.2892 24.4809 22.1759 24.5942C22.0626 24.7075 21.9089 24.7712 21.7487 24.7712H14.8225C14.4768 25.4343 14.0382 26.0446 13.5199 26.5837H21.7487C22.3896 26.5837 23.0043 26.329 23.4575 25.8758C23.9107 25.4226 24.1654 24.8079 24.1654 24.167V11.8758C24.1652 11.2349 23.9105 10.6203 23.4573 10.1672L16.4151 3.12508C15.962 2.67183 15.3474 2.41713 14.7065 2.41699H7.2487ZM20.9995 10.2712H16.9154C16.7551 10.2712 16.6015 10.2075 16.4882 10.0942C16.3748 9.9809 16.3112 9.82723 16.3112 9.66699V5.58283L20.9995 10.2712ZM13.5199 15.7087C12.7733 14.9294 11.8742 14.3124 10.8785 13.8962H18.4258C18.6661 13.8962 18.8966 13.9916 19.0666 14.1616C19.2365 14.3315 19.332 14.5621 19.332 14.8024C19.332 15.0428 19.2365 15.2733 19.0666 15.4432C18.8966 15.6132 18.6661 15.7087 18.4258 15.7087H13.5199ZM14.6558 17.2191C14.982 17.7822 15.2406 18.3912 15.4194 19.0316H18.4258C18.6661 19.0316 18.8966 18.9361 19.0666 18.7661C19.2365 18.5962 19.332 18.3657 19.332 18.1253C19.332 17.885 19.2365 17.6545 19.0666 17.4845C18.8966 17.3146 18.6661 17.2191 18.4258 17.2191H14.6558ZM15.707 21.1462C15.707 21.557 15.6764 21.9598 15.6152 22.3545H18.4258C18.6661 22.3545 18.8966 22.259 19.0666 22.0891C19.2365 21.9191 19.332 21.6886 19.332 21.4482C19.332 21.2079 19.2365 20.9774 19.0666 20.8074C18.8966 20.6375 18.6661 20.542 18.4258 20.542H15.6841C15.7002 20.7418 15.7078 20.9432 15.707 21.1462ZM7.85286 14.5003C9.61545 14.5003 11.3058 15.2005 12.5522 16.4468C13.7985 17.6932 14.4987 19.3836 14.4987 21.1462C14.4987 22.9087 13.7985 24.5991 12.5522 25.8455C11.3058 27.0918 9.61545 27.792 7.85286 27.792C6.09028 27.792 4.39989 27.0918 3.15355 25.8455C1.90722 24.5991 1.20703 22.9087 1.20703 21.1462C1.20703 19.3836 1.90722 17.6932 3.15355 16.4468C4.39989 15.2005 6.09028 14.5003 7.85286 14.5003ZM8.45703 17.5212C8.45703 17.3609 8.39338 17.2073 8.28007 17.0939C8.16677 16.9806 8.0131 16.917 7.85286 16.917C7.69263 16.917 7.53896 16.9806 7.42565 17.0939C7.31235 17.2073 7.2487 17.3609 7.2487 17.5212V21.1462C7.2487 21.3064 7.31235 21.4601 7.42565 21.5734C7.53896 21.6867 7.69263 21.7503 7.85286 21.7503H10.8737C11.0339 21.7503 11.1876 21.6867 11.3009 21.5734C11.4142 21.4601 11.4779 21.3064 11.4779 21.1462C11.4779 20.9859 11.4142 20.8323 11.3009 20.7189C11.1876 20.6056 11.0339 20.542 10.8737 20.542H8.45703V17.5212Z"
                            fill="white" />
                    </svg>
                </span>
                <h4 class="ms-3 mb-0">Riwayat Jurnal</h4>
            </div>
        </div>

        <div class="row me-3 mb-3">
            <form method="GET">
                <input type="hidden" name="extracurricular" value="{{ request('extracurricular') }}">
                <div class="col-lg-12">
                    <div
                        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <div class="d-flex align-items-start align-items-md-center mb-3 mb-md-0">
                            <div class="mb-3 mb-md-0 me-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Cari..."
                                    value="{{ old('search', request('search')) }}">
                            </div>
                            <div class="mb-3 mb-md-0 me-md-3">
                                <select name="filter" class="form-select">
                                    <option value="">Tampilkan semua</option>
                                    <option value="terlama"
                                        {{ old('filter', request('filter')) == 'terlama' ? 'selected' : '' }}>
                                        Terlama</option>
                                    <option value="terbaru"
                                        {{ old('filter', request('filter')) == 'terbaru' ? 'selected' : '' }}>
                                        Terbaru</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex align-items-start align-items-md-center">
                            <div class="d-flex">
                                <input type="date" name="date" class="form-control me-3">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row me-3 mb-3">
        @php
            $historyDummyData = [
                [
                    'name' => 'Ekstrakulikuler - ' . ($extracurricular->name ?? 'Basket'),
                    'date' => '09 Des 2025',
                    'description' =>
                        'Kegiatan ekstrakurikuler hari ini sukses bikin capek dan ketawa bareng. Latihan berjalan aman dan tertib. Siswa tetap antusias mengikuti setiap latihan dari awal sampai akhir. Secara keseluruhan, semangat dan kebersamaan siswa patut diapresiasi.',
                    'image' => 'assets/images/example-jurnal-ekstra.png',
                ],
            ];
        @endphp

        @foreach ($historyDummyData as $journal)
            <div class="col-md-12 d-flex align-items-stretch mb-4">
                <div class="card w-100 shadow-sm border" style="border-radius: 8px; overflow: hidden;">
                    <div class="card-header" style="color: #0896D1 !important; background-color: #0896D1 !important;">
                        <h4 class="mb-0 text-white card-title">
                            {{ $journal['name'] }}
                        </h4>
                        <div class="position-absolute top-0 end-0" style="padding: 0px; position: relative;">
                            <img src="{{ asset('assets/images/background/arrow-leftwarning1.png') }}" alt="Description"
                                class="img-fluid" style="max-width: 268px; height: auto; position: relative;">
                            <span class="d-flex align-items-right ms-5"
                                style="position: absolute; top: 50%; left: 65%; transform: translate(-50%, -50%); color: white; font-weight: bold;width: 100%; font-size: 13px">
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="18" height="18"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M12 12h5v5h-5zm7-9h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2m0 2v2H5V5zM5 19V9h14v10z" />
                                </svg>
                                {{ $journal['date'] }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="d-flex flex-column flex-md-row gap-4">
                            <div style="min-width: 200px; max-width: 200px;">
                                <img src="{{ asset('assets/images/example-jurnal-ekstra.png') }}"
                                    class="img-fluid rounded-3 w-100" style="height: 140px; object-fit: cover;"
                                    alt="Kegiatan">
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fw-semibold text-dark mb-2">Deskripsi</h5>
                                <p class="text-muted mb-0" style="line-height: 1.6; text-align: justify;">
                                    {{ $journal['description'] }}
                                </p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <a href="{{ route('extracurricular.journal.show', ['id' => 1]) }}" 
                               class="btn btn-primary d-inline-flex align-items-center px-4 py-2"
                               style="background-color: #0896D1; border: none;">
                                Lihat Detail Jurnal
                                <i class="ti ti-arrow-right ms-2 fs-5"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection
