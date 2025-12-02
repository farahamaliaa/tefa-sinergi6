@php
    use App\Enums\SemesterEnum;
    use Carbon\Carbon;
@endphp
@extends('school.layouts.app')

@section('style')
    <style>
        .form-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .select-start-container,
        .select-end-container {
            width: 100% !important;
        }

        .select2-container {
            z-index: 1050;
            /* Higher than modal */
        }

        .select2-container .select2-selection--single {
            height: 36px !important;
            padding: 6px 12px !important;
            font-size: 14px !important;
            line-height: 1.42857143 !important;
            color: #555 !important;
            background-color: #fff !important;
            background-image: none !important;
            border: 1px solid #ccc !important;
            border-radius: 4px !important;
            width: 200px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #555 !important;
            line-height: 1.42857143 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 5px !important;
        }

        .slash {
            font-size: 1.5rem;
            font-weight: bold;
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

        .nav-pills.card {
            border: 1px solid #d6d6d6 !important;
            box-shadow: none !important;
        }


        .nav-pills .nav-link svg path {
            stroke: #098FC6 !important;
            fill: #098FC6 !important;
            transition: 0.2s ease;
        }

        .nav-pills .nav-link.active svg path {
            stroke: #fff !important;
            fill: #fff !important;
        }

        /* .nav-pills .nav-link:hover svg path {
            stroke: #0675a2 !important;
            fill: #0675a2 !important;
        } */


        .btn-custom-year {
            background-color: #169ed7 !important;
            border-color: #169ed7 !important;
            color: white !important;
            border-radius: 10px;
            padding: 10px 18px;
            transition: 0.2s ease;
        }

        .btn-custom-year:hover {
            background-color: #138ec8 !important;
            border-color: #138ec8 !important;
        }

    </style>
    <style>
        .img-background {
            width: 100%;
            height: auto;
        }

        @media (max-width: 768px) {
            .img-background {
                height: 100px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Tahun Ajaran</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-white text-decoration-none"
                                    href="javascript:void(0)">Atur tahun ajaran dan semester disini</a></li>
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

    <ul class="nav nav-pills p-3 mb-3 rounded align-items-center card flex-row" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center active  gap-2" id="pills-semesters-tab" data-bs-toggle="pill" href="#pills-schoolYears"
                role="tab" aria-controls="pills-semesters" aria-selected="false">
                {{-- <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 me-1" width="17" height="17" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M19 19H5V8h14m-3-7v2H8V1H6v2H5c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-1V1m-1 11h-5v5h5z" />
                </svg> --}}
                <svg width="20" height="23" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.75 3.08333V0.75M14.75 3.08333V5.41667M14.75 3.08333H9.5M0.75 10.0833V20.5833C0.75 21.2022 0.995833 21.7957 1.43342 22.2333C1.871 22.6708 2.46449 22.9167 3.08333 22.9167H19.4167C20.0355 22.9167 20.629 22.6708 21.0666 22.2333C21.5042 21.7957 21.75 21.2022 21.75 20.5833V10.0833M0.75 10.0833H21.75M0.75 10.0833V5.41667C0.75 4.79783 0.995833 4.20434 1.43342 3.76675C1.871 3.32917 2.46449 3.08333 3.08333 3.08333H5.41667M21.75 10.0833V5.41667C21.75 4.79783 21.5042 4.20434 21.0666 3.76675C20.629 3.32917 20.0355 3.08333 19.4167 3.08333H18.8333M5.41667 0.75V5.41667" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Tahun Ajaran
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center  gap-2" id="pills-student-tab" data-bs-toggle="pill" href="#pills-semesters" role="tab"
                aria-controls="pills-student" aria-selected="true">
                {{-- <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" class="mb-1 me-1">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M2 5a2 2 0 0 1 2-2h6v18H4a2 2 0 0 1-2-2zm12-2h6a2 2 0 0 1 2 2v5h-8zm0 11h8v5a2 2 0 0 1-2 2h-6z" />
                </svg> --}}
                <svg width="30" height="25" viewBox="0 0 32 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.125 0V8.25H1.375V0H4.125ZM1.375 27.5V19.25H4.125V27.5H1.375ZM5.5 13.75C5.5 15.2762 4.27625 16.5 2.75 16.5C2.2061 16.5 1.67442 16.3387 1.22218 16.0365C0.769948 15.7344 0.417473 15.3049 0.209332 14.8024C0.00119152 14.2999 -0.0532676 13.7469 0.0528417 13.2135C0.158951 12.6801 0.420863 12.1901 0.805457 11.8055C1.19005 11.4209 1.68005 11.1589 2.2135 11.0528C2.74695 10.9467 3.29988 11.0012 3.80238 11.2093C4.30488 11.4175 4.73437 11.7699 5.03654 12.2222C5.33872 12.6744 5.5 13.2061 5.5 13.75ZM20.625 2.75C26.7025 2.75 31.625 7.6725 31.625 13.75C31.625 19.8275 26.7025 24.75 20.625 24.75C15.675 24.75 11.495 21.4775 10.1063 16.9812L6.875 13.75L10.1063 10.5187C11.495 6.0225 15.675 2.75 20.625 2.75ZM20.625 5.5C16.0737 5.5 12.375 9.19875 12.375 13.75C12.375 18.3012 16.0737 22 20.625 22C25.1762 22 28.875 18.3012 28.875 13.75C28.875 9.19875 25.1762 5.5 20.625 5.5ZM19.25 15.125V8.25H21.3125V14.025L25.4375 16.5L24.31 18.2325L19.25 15.125Z" fill="white"/>
                </svg>
                Semester
            </a>
        </li>
        <li class="nav-item ms-auto pt-3 pt-md-0">
            <a href="javascript:void(0)"
                class="btn btn-custom-year d-flex align-items-center gap-2 px-3"
                id="btn-create-school-year"
                data-bs-toggle="modal"
                data-bs-target="#modal-create-school-year">

                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.25 0C7.94 0 8.5 0.56 8.5 1.25V6H13.25C13.5815 6 13.8995 6.1317 14.1339 6.36612C14.3683 6.60054 14.5 6.91848 14.5 7.25C14.5 7.58152 14.3683 7.89946 14.1339 8.13388C13.8995 8.3683 13.5815 8.5 13.25 8.5H8.5V13.25C8.5 13.5815 8.3683 13.8995 8.13388 14.1339C7.89946 14.3683 7.58152 14.5 7.25 14.5C6.91848 14.5 6.60054 14.3683 6.36612 14.1339C6.1317 13.8995 6 13.5815 6 13.25V8.5H1.25C0.918479 8.5 0.600537 8.3683 0.366117 8.13388C0.131696 7.89946 0 7.58152 0 7.25C0 6.91848 0.131696 6.60054 0.366117 6.36612C0.600537 6.1317 0.918479 6 1.25 6H6V1.25C6 0.56 6.56 0 7.25 0Z" fill="white"/>
                </svg>
                <span class="d-block font-weight-medium fs-3">Tambah tahun ajaran</span>
            </a>
        </li>
    </ul>


    <div class="tab-content mt-4" id="pills-tabContent">
        <div class="tab-pane fade" id="pills-semesters" role="tabpanel" aria-labelledby="pills-student-tab">
            @include('school.pages.school-year.panes.tab-semesters')

        </div>
        <div class="tab-pane fade show active" id="pills-schoolYears" role="tabpanel" aria-labelledby="pills-semesters-tab">
            @include('school.pages.school-year.panes.tab-school-year')
        </div>
    </div>

    {{-- modal --}}
    @include('school.pages.school-year.widgets.modal-create-school-year')
    @include('school.pages.school-year.widgets.modal-update-school-year')
    @include('school.pages.school-year.widgets.modal-confirm-active')

    <x-delete-modal-component />
@endsection

@section('script')
    @include('school.pages.school-year.scripts.active-year')
    @include('school.pages.school-year.scripts.delete-year')
    @include('school.pages.school-year.scripts.tab')
    @include('school.pages.school-year.scripts.update-year')
    @include('school.pages.school-year.scripts.modal-create')

    <script>
        $(document).ready(function() {
            $('.select-start').select2({
                dropdownParent: $('#modal-create-school-year')
            });

            $('.select-end').select2({
                dropdownParent: $('#modal-create-school-year')
            });

            $('.select-start-update').select2({
                dropdownParent: $('#modal-update-school-year')
            });

            $('.select-end-update').select2({
                dropdownParent: $('#modal-update-school-year')
            });

            $('.toggle-btn').click(function() {
                $(this).toggleClass('active');
                $('.toggle-btn').not(this).removeClass('active');
                $(this).attr('aria-pressed', $(this).hasClass('active'));
                $('.toggle-btn').not(this).attr('aria-pressed', false);
            });

            function appendRow(type, createdAt) {
                var formattedDate = new Date(createdAt).toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                });

                var newRow = `
                <tr>
                    <td>
                        <div class="d-flex justify-content-center">
                            <p>${type.charAt(0).toUpperCase() + type.slice(1)}</p>
                        </div>
                    </td>
                    <td>${formattedDate}</td>
                </tr>
            `;
                $('#tbody').append(newRow);
            }

            $('.btn-ganjil').click(function() {
                Swal.fire({
                    title: "Apa kamu yakin?",
                    text: "Mengubah semester ke ganjil?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya",
                    cancelButtonText: "Tidak",
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('school.semesters.store') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                            },
                            data: {
                                type: '{{ SemesterEnum::GANJIL->value }}'
                            },
                            success: function(res) {
                                location.reload()
                                // appendRow('ganjil', res.created_at);
                            },
                            error: function(err) {
                                console.log(err);
                            }
                        });
                    }
                });
            });

            $('.btn-genap').click(function() {
                Swal.fire({
                    title: "Apa kamu yakin?",
                    text: "Mengubah semester ke genap?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya",
                    cancelButtonText: "Tidak",
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('school.semesters.store') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                            },
                            data: {
                                type: '{{ SemesterEnum::GENAP->value }}'
                            },
                            success: function(res) {
                                location.reload()
                                // appendRow('genap', res.created_at);
                            },
                            error: function(err) {
                                console.log(err);
                            }
                        });
                    }
                });
            });
        });
    </script>

    <script>
        < script >
            $(document).ready(function() {
                // Initialize Select2 inside the modal
                $('#modal-create-school-year').on('shown.bs.modal', function() {
                    $('#start-year').select2({
                        theme: 'bootstrap4',
                        width: 'resolve'
                    }).data('select2').$container.addClass('select-start-container');

                    $('#end-year').select2({
                        theme: 'bootstrap4',
                        width: 'resolve'
                    }).data('select2').$container.addClass('select-end-container');
                });
            });
    </script>
@endsection
