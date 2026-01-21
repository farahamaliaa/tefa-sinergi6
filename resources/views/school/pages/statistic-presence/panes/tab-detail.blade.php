<style>
    .a{
        padding: 5px 5px;
        border-radius: 7px;
        background: #F3F6FF;
        text-align: center;
    }

    .text-color {
        color: #0896D1;
    }

    .btn-primary {
        background-color: #1A94C8;
        border-color: #1A94C8;
    }

    .btn-primary:hover {
        background-color: #0896D1;
        border-color: #0896D1;
    }

</style>

{{-- <div class="row">
    <div class="col-lg-2 mt-3 mb-3">
        <div class="d-flex justify-content-between mb-3 align-items-center">
            <form class="d-flex gap-2 align-items-center flex-grow-1" method="GET">
                <div class="position-relative flex-grow-1">
                    <input type="text" name="search" class="form-control search-chat py-2 px-4 ps-5" id="search-name"
                        placeholder="Cari" value="{{ old('search', request('search')) }}">
                    <i class="ti ti-search position-absolute top-50 translate-middle-y fs-6 text-dark ms-3"></i>
                </div>
            </form>
        </div>
    </div>
</div> --}}
<div class="row">
    @forelse ($classrooms as $classroom)
        <div class="col-lg-3 mb-3">
            <div class="card d-flex flex-column h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h4 class="mb-2"><b>{{ $classroom->name }}</b></h4>
                        <div class="a d-flex align-items-center">
                            {{-- <div class="category-selector btn-group">
                            <a class="nav-link category-dropdown label-group p-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">
                                <div class="category d-flex align-items-center">
                                    <div class="category-business"></div>
                                    <div class="category-social"></div>
                                    <span class="more-options text-dark ms-2">
                                        <i class="ti ti-dots-vertical fs-5"></i>
                                    </span>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end category-menu overflow-auto" style="max-height: 200px;">
                                <button type="button" class="btn-update-classroom note-business badge-group-item badge-business dropdown-item position-relative category-business d-flex align-items-center btn-edit">
                                    Edit
                                </button>
                                <button class="note-business text-danger badge-group-item badge-business dropdown-item position-relative category-business d-flex align-items-center btn-delete-class">
                                    Hapus
                                </button>
                            </div>
                        </div> --}}
                        <span class="text-color fs-3">MERDEKA</span>
                        <span class="text-color fs-3 ms-1 me-1">|</span>
                        <span class="text-color fs-3">{{ $classroom->schoolYear->school_year }}</span>
                        </div>
                    </div>

                    <div class="d-flex">
                       <span class="fs-3">{{ $classroom->employee->user->name }}</span> 
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <div class="a d-flex align-items-center">
                            <svg width="26" height="25" viewBox="0 0 26 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M24.375 21.875C24.375 21.875 26 21.875 26 20.3125C26 18.75 24.375 14.0625 17.875 14.0625C11.375 14.0625 9.75 18.75 9.75 20.3125C9.75 21.875 11.375 21.875 11.375 21.875H24.375ZM11.4107 20.3125L11.375 20.3062C11.3766 19.8938 11.6464 18.6969 12.61 17.6187C13.507 16.6078 15.0833 15.625 17.875 15.625C20.6651 15.625 22.2414 16.6094 23.14 17.6187C24.1036 18.6969 24.3717 19.8953 24.375 20.3062L24.362 20.3094L24.3392 20.3125H11.4107ZM17.875 10.9375C18.737 10.9375 19.5636 10.6083 20.1731 10.0222C20.7826 9.43616 21.125 8.6413 21.125 7.8125C21.125 6.9837 20.7826 6.18884 20.1731 5.60279C19.5636 5.01674 18.737 4.6875 17.875 4.6875C17.013 4.6875 16.1864 5.01674 15.5769 5.60279C14.9674 6.18884 14.625 6.9837 14.625 7.8125C14.625 8.6413 14.9674 9.43616 15.5769 10.0222C16.1864 10.6083 17.013 10.9375 17.875 10.9375ZM22.75 7.8125C22.75 8.42807 22.6239 9.03761 22.3789 9.60633C22.1339 10.175 21.7748 10.6918 21.3221 11.1271C20.8695 11.5623 20.332 11.9076 19.7406 12.1432C19.1491 12.3788 18.5152 12.5 17.875 12.5C17.2348 12.5 16.6009 12.3788 16.0094 12.1432C15.418 11.9076 14.8805 11.5623 14.4279 11.1271C13.9752 10.6918 13.6161 10.175 13.3711 9.60633C13.1261 9.03761 13 8.42807 13 7.8125C13 6.5693 13.5136 5.37701 14.4279 4.49794C15.3421 3.61886 16.5821 3.125 17.875 3.125C19.1679 3.125 20.4079 3.61886 21.3221 4.49794C22.2364 5.37701 22.75 6.5693 22.75 7.8125ZM11.271 14.5C10.6206 14.3045 9.9507 14.1752 9.27225 14.1141C8.89098 14.0783 8.50808 14.0611 8.125 14.0625C1.625 14.0625 0 18.75 0 20.3125C0 21.3542 0.541667 21.875 1.625 21.875H8.476C8.23521 21.3872 8.11508 20.8524 8.125 20.3125C8.125 18.7344 8.73763 17.1219 9.89625 15.775C10.2911 15.3156 10.751 14.8859 11.271 14.5ZM7.995 15.625C7.03385 17.0148 6.51437 18.6436 6.5 20.3125H1.625C1.625 19.9062 1.8915 18.7031 2.86 17.6187C3.74563 16.625 5.2845 15.6563 7.995 15.6266V15.625ZM2.4375 8.59375C2.4375 7.35055 2.95111 6.15826 3.86535 5.27919C4.77959 4.40011 6.01957 3.90625 7.3125 3.90625C8.60543 3.90625 9.84541 4.40011 10.7596 5.27919C11.6739 6.15826 12.1875 7.35055 12.1875 8.59375C12.1875 9.83695 11.6739 11.0292 10.7596 11.9083C9.84541 12.7874 8.60543 13.2812 7.3125 13.2812C6.01957 13.2812 4.77959 12.7874 3.86535 11.9083C2.95111 11.0292 2.4375 9.83695 2.4375 8.59375ZM7.3125 5.46875C6.45055 5.46875 5.6239 5.79799 5.0144 6.38404C4.40491 6.97009 4.0625 7.76495 4.0625 8.59375C4.0625 9.42255 4.40491 10.2174 5.0144 10.8035C5.6239 11.3895 6.45055 11.7188 7.3125 11.7188C8.17445 11.7188 9.0011 11.3895 9.6106 10.8035C10.2201 10.2174 10.5625 9.42255 10.5625 8.59375C10.5625 7.76495 10.2201 6.97009 9.6106 6.38404C9.0011 5.79799 8.17445 5.46875 7.3125 5.46875Z" fill="#0896D1"/>
                            </svg>
                            <span class="text-color fs-3 ms-2">
                                {{ $classroom->classroomStudents->count() }} Siswa
                            </span>
                        </div>
                    </div>

                    <!-- Spacer to push the button to the bottom -->
                    <div class="mt-auto"></div>

                    <a href="{{ route('school.detail-presence-class.index', ['classroom' => $classroom->id]) }}"
                        class="btn waves-effect waves-light btn-primary w-100">Masuk Kelas</a>
                </div>
            </div>
        </div>
    @empty
        <div class="d-flex flex-column justify-content-center align-items-center">
            <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt="" width="300px">
            <p class="fs-5 text-dark text-center mt-2">
                Kelas belum ditambahkan
            </p>
        </div>
    @endforelse
</div>
<div class="pagination justify-content-center mb-0">
    <x-paginate-component :paginator="$classrooms" />
</div>
