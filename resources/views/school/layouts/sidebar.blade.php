<style>
    .sidebar-nav .sidebar-item .sidebar-link svg {
        stroke: #1191C6 !important;
        color: #1191C6 !important;
    }

    .sidebar-nav .sidebar-item .sidebar-link .hide-menu {
        color: #000000 !important;
    }

    .sidebar-nav .sidebar-item .sidebar-link:hover {
        background-color: rgba(13, 147, 202, 0.25) !important;
    }

    .sidebar-nav .sidebar-item .sidebar-link:hover .hide-menu,
    .sidebar-nav .sidebar-item .sidebar-link:hover svg {
        color: #1191C6 !important;
        stroke: #1191C6 !important;
    }

    /* Top */
    #sidebarnav > .sidebar-item > .active.sidebar-link,
    #sidebarnav > .sidebar-item.selected > .sidebar-link {
        background-color: #0D93CA !important;
        border-radius: 8px;
    }

    #sidebarnav > .sidebar-item > .active.sidebar-link .hide-menu,
    #sidebarnav > .sidebar-item.selected > .sidebar-link .hide-menu,
    #sidebarnav > .sidebar-item > .active.sidebar-link svg,
    #sidebarnav > .sidebar-item.selected > .sidebar-link svg {
        color: #ffffff !important;
        stroke: #ffffff !important;
    }

    /* Submenu */
    .sidebar-nav .collapse .sidebar-item .active.sidebar-link,
    .sidebar-nav .collapse .sidebar-item.selected > .sidebar-link {
        background-color: transparent !important;
        border-radius: 8px;
    }

    .sidebar-nav .collapse .sidebar-item .active.sidebar-link .hide-menu,
    .sidebar-nav .collapse .sidebar-item.selected > .sidebar-link .hide-menu,
    .sidebar-nav .collapse .sidebar-item .active.sidebar-link svg,
    .sidebar-nav .collapse .sidebar-item.selected > .sidebar-link svg {
        color: #1191C6 !important;
        stroke: #1191C6 !important;
    }

</style>
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="/" class="text-nowrap logo-img">
                <img src="{{ asset('landing_assets/images/logo/sinergi6.png') }}" width="180px" alt="">
            </a>
            <div class="close-btn d-lg-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8 text-muted"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
            <ul id="sidebarnav">
                <!-- ============================= -->
                <!-- Home -->
                <!-- ============================= -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <!-- =================== -->
                <!-- Dashboard -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('school.index') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-aperture">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M3.6 15h10.55" />
                                <path d="M6.551 4.938l3.26 10.034" />
                                <path d="M17.032 4.636l-8.535 6.201" />
                                <path d="M20.559 14.51l-8.535 -6.201" />
                                <path d="M12.257 20.916l3.261 -10.034" />
                            </svg>
                        </span>
                        <span class="hide-menu">Beranda</span>
                    </a>
                </li>
                {{-- <li class="sidebar-item">
                    <a class="sidebar-link has-arrow {{ request()->routeIs('school.detail-presence-class.index') ? 'active' : '' }}"
                        href="javascript:void(0)" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M9 17H7v-7h2zm4 0h-2V7h2zm4 0h-2v-4h2zm2 2H5V5h14zm0-16H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2" />
                            </svg>
                        </span>
                        <span class="hide-menu">Statistik Absensi</span>
                    </a>
                    <ul aria-expanded="false"
                        class="collapse first-level {{ request()->routeIs('school.detail-presence-class.index') ? 'in' : '' }}">
                        <li class="sidebar-item">
                            <a href="{{ route('school.statistic-presence.index') }}"
                                class="sidebar-link {{ request()->routeIs('school.detail-presence-class.index') ? 'active' : '' }}">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle"></i>
                                </div>
                                <span class="hide-menu">Siswa</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('school.statistic-presence-employee.index') }}" class="sidebar-link">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle"></i>
                                </div>
                                <span class="hide-menu">Guru</span>
                            </a>
                        </li>
                    </ul>
                </li> --}}
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Master</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('school.employees.index') || request()->routeIs('school.teacher.show') ? 'active' : '' }}"
                        href="{{ route('school.employees.index') }}" aria-expanded="false">
                        <span>
                            <svg width="26" height="20" viewBox="0 0 26 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0V1.9375H21.3125V17.4375H7.75V19.375H25.1875V17.4375H23.25V0H0ZM3.87694 2.90625C2.85014 2.90982 1.8664 3.31916 1.14016 4.04504C0.413919 4.77092 0.00408462 5.75446 0 6.78125C0 8.91153 1.74762 10.6562 3.87694 10.6562C4.90321 10.6522 5.88627 10.2425 6.61178 9.51666C7.33729 8.79078 7.74643 7.80753 7.75 6.78125C7.75 4.65291 6.00431 2.90625 3.87694 2.90625ZM9.6875 3.875V5.8125H14.5312V3.875H9.6875ZM16.4688 3.875V5.8125H19.375V3.875H16.4688ZM3.87694 4.84375C4.95612 4.84375 5.8125 5.69916 5.8125 6.78125C5.8125 7.86625 4.95709 8.71875 3.87694 8.71875C2.79194 8.71875 1.9375 7.86625 1.9375 6.78125C1.9375 5.69916 2.79291 4.84375 3.87694 4.84375ZM9.6875 7.75V9.6875H19.375V7.75H9.6875ZM0 11.625V19.375H1.9375V13.5625H4.84375V19.375H6.78125V14.1999L8.78075 15.2578C9.34747 15.5581 10.0285 15.5572 10.5942 15.2578V15.2598L14.0139 13.4511L13.1101 11.7364L9.68944 13.5451L6.69019 11.9621C6.27168 11.7408 5.80543 11.6251 5.332 11.625H0Z" fill="#0896D1"/>
                            </svg>
                        </span>
                        <span class="hide-menu">Pegawai</span>
                    </a>
                </li>


                {{-- <li class="sidebar-item">
                    <a class="sidebar-link" href="/school/teacher" aria-expanded="false">
                        <span>
                            <svg width="26" height="20" viewBox="0 0 26 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0V1.9375H21.3125V17.4375H7.75V19.375H25.1875V17.4375H23.25V0H0ZM3.87694 2.90625C2.85014 2.90982 1.8664 3.31916 1.14016 4.04504C0.413919 4.77092 0.00408462 5.75446 0 6.78125C0 8.91153 1.74762 10.6562 3.87694 10.6562C4.90321 10.6522 5.88627 10.2425 6.61178 9.51666C7.33729 8.79078 7.74643 7.80753 7.75 6.78125C7.75 4.65291 6.00431 2.90625 3.87694 2.90625ZM9.6875 3.875V5.8125H14.5312V3.875H9.6875ZM16.4688 3.875V5.8125H19.375V3.875H16.4688ZM3.87694 4.84375C4.95612 4.84375 5.8125 5.69916 5.8125 6.78125C5.8125 7.86625 4.95709 8.71875 3.87694 8.71875C2.79194 8.71875 1.9375 7.86625 1.9375 6.78125C1.9375 5.69916 2.79291 4.84375 3.87694 4.84375ZM9.6875 7.75V9.6875H19.375V7.75H9.6875ZM0 11.625V19.375H1.9375V13.5625H4.84375V19.375H6.78125V14.1999L8.78075 15.2578C9.34747 15.5581 10.0285 15.5572 10.5942 15.2578V15.2598L14.0139 13.4511L13.1101 11.7364L9.68944 13.5451L6.69019 11.9621C6.27168 11.7408 5.80543 11.6251 5.332 11.625H0Z" fill="#0896D1"/>
                            </svg>
                        </span>
                        <span class="hide-menu">Guru</span>
                    </a>
                </li> --}}
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('school.students.index') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="1.5"
                                    d="M17.928 19.634h2.138a1.165 1.165 0 0 0 1.116-1.555a6.851 6.851 0 0 0-6.117-3.95m0-2.759a3.664 3.664 0 0 0 3.665-3.664a3.664 3.664 0 0 0-3.665-3.674m-1.04 16.795a1.908 1.908 0 0 0 1.537-3.035a8.026 8.026 0 0 0-6.222-3.196a8.026 8.026 0 0 0-6.222 3.197a1.909 1.909 0 0 0 1.536 3.034zM9.34 11.485a4.16 4.16 0 0 0 4.15-4.161a4.151 4.151 0 0 0-8.302 0a4.16 4.16 0 0 0 4.151 4.16" />
                            </svg>
                        </span>
                        <span class="hide-menu">Siswa</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('school.parent.index') }}" aria-expanded="false">
                        <span>
                            <svg width="18" height="24" viewBox="0 0 18 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 0C10.1017 0 11.1582 0.379285 11.9372 1.05442C12.7162 1.72955 13.1538 2.64522 13.1538 3.6C13.1538 4.55478 12.7162 5.47045 11.9372 6.14558C11.1582 6.82071 10.1017 7.2 9 7.2C7.89833 7.2 6.84178 6.82071 6.06279 6.14558C5.28379 5.47045 4.84615 4.55478 4.84615 3.6C4.84615 2.64522 5.28379 1.72955 6.06279 1.05442C6.84178 0.379285 7.89833 0 9 0ZM9 8.4C11.2569 8.4 13.32 8.82 15.2308 9.66C17.0862 10.512 18 11.532 18 12.732V19.656C18 21 16.8092 22.128 14.3862 23.028V20.4C14.3862 19.26 13.1954 18.456 10.8138 17.964C10.0385 17.808 9.42923 17.736 9 17.736C7.79538 17.736 6.64615 17.94 5.59385 18.36C4.52769 18.768 3.89077 19.296 3.68308 19.932C5.53846 20.568 7.31077 20.892 9 20.892L10.3846 20.772V23.928L9 24C7.14646 24.0016 5.31261 23.6706 3.61385 23.028C1.19077 22.128 0 21 0 19.656V12.732C0 11.532 0.913846 10.512 2.76923 9.66C4.68 8.82 6.75692 8.4 9 8.4ZM9 10.8C8.26555 10.8 7.56119 11.0529 7.04186 11.5029C6.52253 11.953 6.23077 12.5635 6.23077 13.2C6.23077 13.8365 6.52253 14.447 7.04186 14.8971C7.56119 15.3471 8.26555 15.6 9 15.6C9.73445 15.6 10.4388 15.3471 10.9581 14.8971C11.4775 14.447 11.7692 13.8365 11.7692 13.2C11.7692 12.5635 11.4775 11.953 10.9581 11.5029C10.4388 11.0529 9.73445 10.8 9 10.8Z" fill="#0896D1" />
                            </svg>
                        </span>
                        <span class="hide-menu">OrangTua</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" aria-expanded="false">
                        <span>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.39645 3.81763C4.14427 3.81763 3.8167 3.93435 3.34842 4.23796C3.53433 4.45742 3.73125 4.69203 4.12045 5.14058C4.39148 5.45291 4.66505 5.76355 4.87167 5.98845C4.87345 5.99042 4.87425 5.99103 4.87598 5.99295L6.32414 5.15239L5.63733 4.4892C5.10802 4.04839 4.76339 3.83924 4.44586 3.81922C4.42939 3.81818 4.41295 3.81765 4.39645 3.81763ZM10.0252 4.5246C9.98391 4.52415 9.94261 4.5243 9.90131 4.52506C9.411 4.53411 8.95444 4.6296 8.64778 4.77931L5.49487 6.60922C5.60972 6.63472 5.72386 6.66528 5.83645 6.70391C6.64622 6.98155 7.38769 7.55811 8.15995 8.33047L18.3056 18.3383L22.1014 16.2555L12.121 5.22092C11.7152 4.85342 11.0668 4.61586 10.401 4.54621C10.2761 4.53324 10.1507 4.52604 10.0252 4.52464L10.0252 4.5246ZM2.72967 4.81592C1.90734 5.78731 1.76545 6.55902 2.01127 7.48799C2.0437 7.61071 2.15456 7.78597 2.31 7.97877C2.4159 7.82713 2.52668 7.67896 2.64216 7.53449C2.82919 7.30035 3.0352 7.10403 3.25552 6.94583L3.25055 6.93645L3.3803 6.86099C3.4432 6.82086 3.50779 6.78344 3.57389 6.74881L4.1302 6.42585C3.91211 6.1839 3.69643 5.9398 3.48319 5.69356C3.23065 5.40221 2.97944 5.10966 2.72967 4.81592ZM11.359 5.44583L14.0972 8.33661C11.937 8.1005 11.4352 8.95536 10.8616 9.93974L8.17406 7.15986L11.359 5.44583ZM4.86295 7.37014C4.82936 7.36937 4.79576 7.3694 4.76217 7.37024C4.43517 7.37867 4.09622 7.46671 3.71911 7.6461C3.57684 7.75344 3.43833 7.88966 3.30145 8.06103C2.09348 9.57341 1.87411 10.833 2.10689 11.974C2.33967 13.115 3.06952 14.161 3.8842 15.0891C4.5083 15.8001 5.23702 16.2137 6.15633 16.3983C7.07573 16.583 8.19248 16.5253 9.53039 16.2354C11.0888 15.8979 12.6246 16.6301 14.0215 17.5322C15.2458 18.3229 16.3969 19.2708 17.3487 19.8736L17.7607 18.986L7.56445 8.92808L7.56342 8.92705C6.83573 8.19936 6.17756 7.71275 5.5627 7.50196C5.32739 7.42124 5.09747 7.37567 4.86295 7.37014ZM22.0698 17.2353L18.6269 19.1245L18.1356 20.1823L21.4559 18.3819L22.0698 17.2353L22.0698 17.2353Z" fill="#0896D1" />
                            </svg>
                        </span>
                        <span class="hide-menu">Pembina Extrakulikuler</span>
                    </a>
                </li>

                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Pengaturan</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('school.school-years.index') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 4V2m0 2v2m0-2h-4.5M3 10v9a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-9zm0 0V6a2 2 0 0 1 2-2h2m0-2v4m14 4V6a2 2 0 0 0-2-2h-.5" />
                            </svg>
                        </span>
                        <span class="hide-menu">Tahun Ajaran</span>
                    </a>
                </li>
                {{-- <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('class-level.index') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24">
                                <g fill="none">
                                    <path
                                        d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                    <path fill="currentColor"
                                        d="M14 3a2 2 0 0 1 2 2v3h4a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2h4V5a2 2 0 0 1 2-2zm0 2h-4v14h4zm6 5h-4v9h4zM8 13H4v6h4z" />
                                </g>
                            </svg>
                        </span>
                        <span class="hide-menu">Tingkatan Kelas</span>
                    </a>
                </li> --}}
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('school.classroom.index') || request()->routeIs('school.class-student.index') ? 'active' : '' }}"
                        href="{{ route('school.classroom.index') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 256 256">
                                <path fill="currentColor"
                                    d="M232 212h-20V40a20 20 0 0 0-20-20H64a20 20 0 0 0-20 20v172H24a12 12 0 0 0 0 24h208a12 12 0 0 0 0-24M68 44h120v168H68Zm104 88a16 16 0 1 1-16-16a16 16 0 0 1 16 16" />
                            </svg>
                        </span>
                        <span class="hide-menu">Kelas</span>
                    </a>
                </li>
                {{-- <li class="sidebar-item">
                    <a class="sidebar-link" href="/school/semesters" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2"
                                    d="M2 5a2 2 0 0 1 2-2h6v18H4a2 2 0 0 1-2-2zm12-2h6a2 2 0 0 1 2 2v5h-8zm0 11h8v5a2 2 0 0 1-2 2h-6z" />
                            </svg>
                        </span>
                        <span class="hide-menu">Semester</span>
                    </a>
                </li> --}}
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <span class="d-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 14 14">
                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 .5v6l3.59 4.57a1.5 1.5 0 0 1-1.18 2.43H2.59a1.5 1.5 0 0 1-1.18-2.43L5 6.5v-6M3.5.5h7" />
                            </svg>
                        </span>
                        <span class="hide-menu">Mata Pelajaran</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('school.subject.index') }}" class="sidebar-link">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle"></i>
                                </div>
                                <span class="hide-menu">Mata Pelajaran</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('school.lesson-hours.index') }}" class="sidebar-link">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle"></i>
                                </div>
                                <span class="hide-menu">Jam Pelajaran</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('school.lesson-schedule.index') }}" class="sidebar-link">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle"></i>
                                </div>
                                <span class="hide-menu">Jadwal Pelajaran</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- <li class="sidebar-item">
                    <a class="sidebar-link" href="/attendance-test" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2"
                                    d="M9 12V8m6 4v-2m-3 2v-1M3 4h18M4 4v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4m-8 12v4m-3 0h6" />
                            </svg>
                        </span>
                        <span class="hide-menu">Test Absensi</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="/attendance-test-teacher" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2"
                                    d="M9 12V8m6 4v-2m-3 2v-1M3 4h18M4 4v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4m-8 12v4m-3 0h6" />
                            </svg>
                        </span>
                        <span class="hide-menu">Test Absensi Guru</span>
                    </a>
                </li> --}}
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <span class="d-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 1024 1024">
                                <path fill="currentColor"
                                    d="M600.704 64a32 32 0 0 1 30.464 22.208l35.2 109.376c14.784 7.232 28.928 15.36 42.432 24.512l112.384-24.192a32 32 0 0 1 34.432 15.36L944.32 364.8a32 32 0 0 1-4.032 37.504l-77.12 85.12a357 357 0 0 1 0 49.024l77.12 85.248a32 32 0 0 1 4.032 37.504l-88.704 153.6a32 32 0 0 1-34.432 15.296L708.8 803.904c-13.44 9.088-27.648 17.28-42.368 24.512l-35.264 109.376A32 32 0 0 1 600.704 960H423.296a32 32 0 0 1-30.464-22.208L357.696 828.48a352 352 0 0 1-42.56-24.64l-112.32 24.256a32 32 0 0 1-34.432-15.36L79.68 659.2a32 32 0 0 1 4.032-37.504l77.12-85.248a357 357 0 0 1 0-48.896l-77.12-85.248A32 32 0 0 1 79.68 364.8l88.704-153.6a32 32 0 0 1 34.432-15.296l112.32 24.256c13.568-9.152 27.776-17.408 42.56-24.64l35.2-109.312A32 32 0 0 1 423.232 64H600.64zm-23.424 64H446.72l-36.352 113.088l-24.512 11.968a294 294 0 0 0-34.816 20.096l-22.656 15.36l-116.224-25.088l-65.28 113.152l79.68 88.192l-1.92 27.136a293 293 0 0 0 0 40.192l1.92 27.136l-79.808 88.192l65.344 113.152l116.224-25.024l22.656 15.296a294 294 0 0 0 34.816 20.096l24.512 11.968L446.72 896h130.688l36.48-113.152l24.448-11.904a288 288 0 0 0 34.752-20.096l22.592-15.296l116.288 25.024l65.28-113.152l-79.744-88.192l1.92-27.136a293 293 0 0 0 0-40.256l-1.92-27.136l79.808-88.128l-65.344-113.152l-116.288 24.96l-22.592-15.232a288 288 0 0 0-34.752-20.096l-24.448-11.904L577.344 128zM512 320a192 192 0 1 1 0 384a192 192 0 0 1 0-384m0 64a128 128 0 1 0 0 256a128 128 0 0 0 0-256" />
                            </svg>
                        </span>
                        <span class="hide-menu">Setting</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('school.settings-information.index') }}" class="sidebar-link">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle"></i>
                                </div>
                                <span class="hide-menu">Informasi</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('school.rfid-active.index') }}" class="sidebar-link">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle"></i>
                                </div>
                                <span class="hide-menu">RFID</span>
                            </a>
                        </li>
                        {{-- <li class="sidebar-item">
                            <a href="javascript:void(0)" class="sidebar-link has-arrow" aria-expanded="false"
                                style="display: flex; align-items: center;">
                                <div class="d-flex">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu ms-4">RFID</span>
                                </div>
                                <i class="ti ti-angle-down" style="margin-left: auto;"></i>
                            </a>
                            <ul aria-expanded="false" class="collapse second-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('school.rfid-school.index') }}" class="sidebar-link"
                                        style="display: flex; align-items: center; margin-left: 20px;">
                                        <div class="round-16 d-flex align-items-center justify-content-center ms-3">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu ">Belum Digunakan</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('school.rfid-active.index') }}" class="sidebar-link"
                                        style="display: flex; align-items: center; margin-left: 20px;">
                                        <div class="round-16 d-flex align-items-center justify-content-center ms-3">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu ">Sudah Digunakan</span>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}
                    </ul>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Absensi</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('school.clock-settings.index') }}" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2">
                                <path
                                    d="M21 12a9 9 0 1 0-9.002 9m5.003-2a2 2 0 1 0 4 0a2 2 0 1 0-4 0m2-3.5V17m0 4v1.5m3.031-5.25l-1.299.75m-3.463 2l-1.3.75m0-3.5l1.3.75m3.463 2l1.3.75" />
                                <path d="M12 7v5l2 2" />
                            </g>
                        </svg>
                        <span class="hide-menu">Pengaturan Jam</span>
                    </a>
                </li>
                {{-- <li class="sidebar-item">
                    <a class="sidebar-link has-arrow {{ request()->routeIs('school.detail-presence-class.index') ? 'active' : '' }}"
                        href="javascript:void(0)" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M12 5a3.5 3.5 0 0 0-3.5 3.5A3.5 3.5 0 0 0 12 12a3.5 3.5 0 0 0 3.5-3.5A3.5 3.5 0 0 0 12 5m0 2a1.5 1.5 0 0 1 1.5 1.5A1.5 1.5 0 0 1 12 10a1.5 1.5 0 0 1-1.5-1.5A1.5 1.5 0 0 1 12 7M5.5 8A2.5 2.5 0 0 0 3 10.5c0 .94.53 1.75 1.29 2.18c.36.2.77.32 1.21.32s.85-.12 1.21-.32c.37-.21.68-.51.91-.87A5.42 5.42 0 0 1 6.5 8.5v-.28c-.3-.14-.64-.22-1-.22m13 0c-.36 0-.7.08-1 .22v.28c0 1.2-.39 2.36-1.12 3.31c.12.19.25.34.4.49a2.48 2.48 0 0 0 1.72.7c.44 0 .85-.12 1.21-.32c.76-.43 1.29-1.24 1.29-2.18A2.5 2.5 0 0 0 18.5 8M12 14c-2.34 0-7 1.17-7 3.5V19h14v-1.5c0-2.33-4.66-3.5-7-3.5m-7.29.55C2.78 14.78 0 15.76 0 17.5V19h3v-1.93c0-1.01.69-1.85 1.71-2.52m14.58 0c1.02.67 1.71 1.51 1.71 2.52V19h3v-1.5c0-1.74-2.78-2.72-4.71-2.95M12 16c1.53 0 3.24.5 4.23 1H7.77c.99-.5 2.7-1 4.23-1" />
                            </svg>
                        </span>
                        <span class="hide-menu">Kehadiran</span>
                    </a>
                    <ul aria-expanded="false"
                        class="collapse first-level {{ request()->routeIs('school.detail-presence-class.index') ? 'in' : '' }}">
                        <li class="sidebar-item">
                            <a href="{{ route('school.student-attendance.index') }}"
                                class="sidebar-link {{ request()->routeIs('school.detail-presence-class.index') ? 'active' : '' }}">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle"></i>
                                </div>
                                <span class="hide-menu">Siswa</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('school.teacher-attendance.index') }}" class="sidebar-link">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle"></i>
                                </div>
                                <span class="hide-menu">Guru</span>
                            </a>
                        </li>
                    </ul>
                </li> --}}

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow {{ request()->routeIs('school.detail-presence-class.index') ? 'active' : '' }}"
                        href="javascript:void(0)" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M9 17H7v-7h2zm4 0h-2V7h2zm4 0h-2v-4h2zm2 2H5V5h14zm0-16H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2" />
                            </svg>
                        </span>
                        <span class="hide-menu">Statistik Absensi</span>
                    </a>
                    <ul aria-expanded="false"
                        class="collapse first-level {{ request()->routeIs('school.detail-presence-class.index') ? 'in' : '' }}">
                        <li class="sidebar-item">
                            <a href="{{ route('school.statistic-presence.index') }}"
                                class="sidebar-link {{ request()->routeIs('school.detail-presence-class.index') ? 'active' : '' }}">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle"></i>
                                </div>
                                <span class="hide-menu">Siswa</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('school.statistic-presence-employee.index') }}" class="sidebar-link">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle"></i>
                                </div>
                                <span class="hide-menu">Staff</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('school.statistic-presence-extracurricular.index') }}" class="sidebar-link">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle"></i>
                                </div>
                                <span class="hide-menu">Ekskul</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Jurnal</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('school.journals.detail') || request()->routeIs('school.export-journal.index') ? 'active' : '' }}"
                        href="{{ route('school.journals.detail') }}" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16">
                            <g fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M6 8V1h1v6.117L8.743 6.07a.5.5 0 0 1 .514 0L11 7.117V1h1v7a.5.5 0 0 1-.757.429L9 7.083L6.757 8.43A.5.5 0 0 1 6 8" />
                                <path
                                    d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2" />
                                <path
                                    d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z" />
                            </g>
                        </svg>
                        <span class="hide-menu">Jurnal Guru</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('school.employee-journal.show') || request()->routeIs('school.employee-journal.export') ? 'active' : '' }}"
                        href="{{ route('school.employee-journal.show') }}" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16">
                            <g fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M6 8V1h1v6.117L8.743 6.07a.5.5 0 0 1 .514 0L11 7.117V1h1v7a.5.5 0 0 1-.757.429L9 7.083L6.757 8.43A.5.5 0 0 1 6 8" />
                                <path
                                    d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2" />
                                <path
                                    d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z" />
                            </g>
                        </svg>
                        <span class="hide-menu">Jurnal Staff</span>
                    </a>
                </li>

                {{-- <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('school.feedback') }}" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                            <path fill="currentColor"
                                d="M11.5 1A1.5 1.5 0 0 0 10 2.5v5A1.5 1.5 0 0 0 11.5 9h6A1.5 1.5 0 0 0 19 7.5v-5A1.5 1.5 0 0 0 17.5 1zm1 5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1 0-1M12 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5M4.6 3H9v1H4.6C3.704 4 3 4.713 3 5.566v6.71c0 .853.704 1.566 1.6 1.566h1.6V17h.003l.002-.001l4.276-3.157H15.4c.896 0 1.6-.713 1.6-1.566V10h.5q.257 0 .5-.05v2.326c0 1.418-1.164 2.566-2.6 2.566h-4.59l-4.011 2.961a1.01 1.01 0 0 1-1.4-.199a.98.98 0 0 1-.199-.59v-2.172h-.6c-1.436 0-2.6-1.149-2.6-2.566v-6.71C2 4.149 3.164 3 4.6 3" />
                        </svg>
                        <span class="hide-menu">Tanggapan Siswa</span>
                    </a>
                </li> --}}

                {{-- <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Pelanggaran</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('school.access-violation.index') }}"
                        aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M5.8 10C5.4 8.8 4.3 8 3 8c-1.7 0-3 1.3-3 3s1.3 3 3 3c1.3 0 2.4-.8 2.8-2H7v2h2v-2h2v-2zM3 12c-.6 0-1-.4-1-1s.4-1 1-1s1 .4 1 1s-.4 1-1 1m13-8c-2.2 0-4 1.8-4 4s1.8 4 4 4s4-1.8 4-4s-1.8-4-4-4m0 6.1c-1.2 0-2.1-.9-2.1-2.1s.9-2.1 2.1-2.1s2.1.9 2.1 2.1s-.9 2.1-2.1 2.1m0 2.9c-2.7 0-8 1.3-8 4v3h16v-3c0-2.7-5.3-4-8-4m6.1 5.1H9.9V17c0-.6 3.1-2.1 6.1-2.1s6.1 1.5 6.1 2.1z" />
                        </svg>
                        <span class="hide-menu">Akses Pelanggaran</span>
                    </a>
                </li> --}}
                {{-- <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('school.violation.index') ? 'active' : '' }}"
                        href="{{ route('school.violation.index') }}" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 256 256">
                            <path fill="currentColor"
                                d="M240.26 186.1L152.81 34.23a28.74 28.74 0 0 0-49.62 0L15.74 186.1a27.45 27.45 0 0 0 0 27.71A28.31 28.31 0 0 0 40.55 228h174.9a28.31 28.31 0 0 0 24.79-14.19a27.45 27.45 0 0 0 .02-27.71m-20.8 15.7a4.46 4.46 0 0 1-4 2.2H40.55a4.46 4.46 0 0 1-4-2.2a3.56 3.56 0 0 1 0-3.73L124 46.2a4.77 4.77 0 0 1 8 0l87.44 151.87a3.56 3.56 0 0 1 .02 3.73M116 136v-32a12 12 0 0 1 24 0v32a12 12 0 0 1-24 0m28 40a16 16 0 1 1-16-16a16 16 0 0 1 16 16" />
                        </svg>
                        <span class="hide-menu">Pelanggaran</span>
                    </a>
                </li>

                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Buku tamu</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('school.guest-book.index') }}" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M5.8 10C5.4 8.8 4.3 8 3 8c-1.7 0-3 1.3-3 3s1.3 3 3 3c1.3 0 2.4-.8 2.8-2H7v2h2v-2h2v-2zM3 12c-.6 0-1-.4-1-1s.4-1 1-1s1 .4 1 1s-.4 1-1 1m13-8c-2.2 0-4 1.8-4 4s1.8 4 4 4s4-1.8 4-4s-1.8-4-4-4m0 6.1c-1.2 0-2.1-.9-2.1-2.1s.9-2.1 2.1-2.1s2.1.9 2.1 2.1s-.9 2.1-2.1 2.1m0 2.9c-2.7 0-8 1.3-8 4v3h16v-3c0-2.7-5.3-4-8-4m6.1 5.1H9.9V17c0-.6 3.1-2.1 6.1-2.1s6.1 1.5 6.1 2.1z" />
                        </svg>
                        <span class="hide-menu">Buku Tamu</span>
                    </a>
                </li> --}}

                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Managemen Ekstrakurikuler</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('school.extracurricular.index') || request()->routeIs('school.extracurricular.show') ? 'active' : '' }}"
                        href="{{ route('school.extracurricular.index') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m20.65 9.375l-1.4-1.4L20 7.2L16.8 4l-.775.75L14.6 3.325l.75-.775q.575-.575 1.425-.563t1.425.588L21.425 5.8Q22 6.375 22 7.212t-.575 1.413zM8.65 21.4q-.575.575-1.412.575T5.825 21.4L2.6 18.175q-.575-.575-.575-1.412T2.6 15.35l.75-.75l1.425 1.425l-.775.75L7.225 20l.75-.775L9.4 20.65zm9.925-8.4L20 11.575L12.425 4L11 5.425zm-7 7L13 18.55L5.45 11L4 12.425zm-.15-5.85l2.75-2.725l-1.6-1.6l-2.725 2.75zM13 21.4q-.575.575-1.425.575T10.15 21.4L2.6 13.85q-.575-.575-.575-1.425T2.6 11l1.425-1.425Q4.6 9 5.437 9t1.413.575l1.575 1.575l2.75-2.75L9.6 6.85q-.575-.575-.575-1.425T9.6 4l1.425-1.425Q11.6 2 12.438 2t1.412.575l7.575 7.575q.575.575.575 1.412t-.575 1.413L20 14.4q-.575.575-1.425.575T17.15 14.4l-1.55-1.575l-2.75 2.75l1.575 1.575q.575.575.575 1.413t-.575 1.412z" />
                            </svg>
                        </span>
                        <span class="hide-menu">Ekstrakurikuler</span>
                    </a>
                </li>               
            </ul>
        </nav>
    </div>
    <!-- End Sidebar scroll-->
</aside>
