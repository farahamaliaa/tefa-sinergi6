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
    #sidebarnav>.sidebar-item>.active.sidebar-link,
    #sidebarnav>.sidebar-item.selected>.sidebar-link {
        background-color: #0D93CA !important;
        border-radius: 8px;
    }

    #sidebarnav>.sidebar-item>.active.sidebar-link .hide-menu,
    #sidebarnav>.sidebar-item.selected>.sidebar-link .hide-menu,
    #sidebarnav>.sidebar-item>.active.sidebar-link svg,
    #sidebarnav>.sidebar-item.selected>.sidebar-link svg {
        color: #ffffff !important;
        stroke: #ffffff !important;
    }

    /* Submenu */
    .sidebar-nav .collapse .sidebar-item .active.sidebar-link,
    .sidebar-nav .collapse .sidebar-item.selected>.sidebar-link {
        background-color: transparent !important;
        border-radius: 8px;
    }

    .sidebar-nav .collapse .sidebar-item .active.sidebar-link .hide-menu,
    .sidebar-nav .collapse .sidebar-item.selected>.sidebar-link .hide-menu,
    .sidebar-nav .collapse .sidebar-item .active.sidebar-link svg,
    .sidebar-nav .collapse .sidebar-item.selected>.sidebar-link svg {
        color: #1191C6 !important;
        stroke: #1191C6 !important;
    }

    .collapse .sidebar-item .sidebar-link {
        padding-left: 30px !important;
    }

    .collapse .collapse .sidebar-item .sidebar-link {
        padding-left: 50px !important;
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
            {{-- role guru --}}
            @role('teacher')
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
                    <a class="sidebar-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}"
                        href="{{ route('teacher.dashboard') }}" aria-expanded="false">
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
                <!-- <li class="sidebar-item">
                                                                <a class="sidebar-link" href="/teacher/attendance/history" aria-expanded="false">
                                                                    <span>
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                                            <g fill="none" stroke="currentColor" stroke-width="1.5">
                                                                                <circle cx="9" cy="9" r="2" />
                                                                                <path d="M13 15c0 1.105 0 2-4 2s-4-.895-4-2s1.79-2 4-2s4 .895 4 2Z" />
                                                                                <path
                                                                                    d="M2 12c0-3.771 0-5.657 1.172-6.828S6.229 4 10 4h4c3.771 0 5.657 0 6.828 1.172S22 8.229 22 12s0 5.657-1.172 6.828S17.771 20 14 20h-4c-3.771 0-5.657 0-6.828-1.172S2 15.771 2 12Z" />
                                                                                <path stroke-linecap="round" d="M19 12h-4m4-3h-5m5 6h-3" />
                                                                            </g>
                                                                        </svg>
                                                                    </span>
                                                                    <span class="hide-menu">Absensi</span>

                                                                </a>
                                                            </li> -->
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('teacher.journals.index') || request()->routeIs('teacher.journals.create') || request()->routeIs('teacher.journals.show') || request()->routeIs('teacher.journals.edit') ? 'active' : '' }}"
                        href="{{ route('teacher.journals.index') }}" aria-expanded="false">
                        <span>
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
                        </span>
                        <span class="hide-menu">Jurnal</span>

                    </a>
                </li>

                {{-- @if ($permission_feedback)
                <li class="sidebar-item">
                    <a class="sidebar-link" href="/teacher/student-feedback" aria-expanded="false">
                        <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 20 20">
                                <path fill="currentColor"
                                    d="M11.5 1A1.5 1.5 0 0 0 10 2.5v5A1.5 1.5 0 0 0 11.5 9h6A1.5 1.5 0 0 0 19 7.5v-5A1.5 1.5 0 0 0 17.5 1zm1 5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1 0-1M12 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5M4.6 3H9v1H4.6C3.704 4 3 4.713 3 5.566v6.71c0 .853.704 1.566 1.6 1.566h1.6V17h.003l.002-.001l4.276-3.157H15.4c.896 0 1.6-.713 1.6-1.566V10h.5q.257 0 .5-.05v2.326c0 1.418-1.164 2.566-2.6 2.566h-4.59l-4.011 2.961a1.01 1.01 0 0 1-1.4-.199a.98.98 0 0 1-.199-.59v-2.172h-.6c-1.436 0-2.6-1.149-2.6-2.566v-6.71C2 4.149 3.164 3 4.6 3" />
                            </svg>
                        </span>
                        <span class="hide-menu">Tanggapan Siswa</span>
                    </a>
                </li>
                @endif --}}

                @if (App\Models\Classroom::where('employee_id', auth()->user()->employee->id)->exists())
                    @php
                        // Get first classroom (wali kelas biasanya hanya 1 kelas)
                        $classroom = $teacherClassrooms->first();
                    @endphp
                    @if ($classroom)
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow {{ request()->routeIs('teacher.list-student-class.*') || request()->routeIs('teacher.classroom-attendance.*') || request()->routeIs('teacher.classroom-permission.*') ? 'active' : '' }}"
                                href="javascript:void(0)" aria-expanded="false">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 256 256">
                                        <path fill="currentColor"
                                            d="M232 212h-20V40a20 20 0 0 0-20-20H64a20 20 0 0 0-20 20v172H24a12 12 0 0 0 0 24h208a12 12 0 0 0 0-24M68 44h120v168H68Zm104 88a16 16 0 1 1-16-16a16 16 0 0 1 16 16" />
                                    </svg>
                                </span>
                                <span class="hide-menu">Kelas {{ $classroom->name }}</span>
                            </a>
                            <ul aria-expanded="false"
                                class="collapse first-level {{ request()->routeIs('teacher.list-student-class.*') || request()->routeIs('teacher.classroom-attendance.*') || request()->routeIs('teacher.classroom-permission.*') ? 'in' : '' }}">
                                <li class="sidebar-item">
                                    <a href="{{ route('teacher.list-student-class.index', ['classroom' => $classroom->id]) }}"
                                        class="sidebar-link {{ request()->routeIs('teacher.list-student-class.*') ? 'active' : '' }}">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Informasi Kelas</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('teacher.classroom-attendance.index', ['classroom' => $classroom->id]) }}"
                                        class="sidebar-link {{ request()->routeIs('teacher.classroom-attendance.*') ? 'active' : '' }}">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Absensi Siswa</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('teacher.classroom-permission.index', ['classroom' => $classroom->id]) }}"
                                        class="sidebar-link {{ request()->routeIs('teacher.classroom-permission.*') ? 'active' : '' }}">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Perizinan</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif


                @if (\App\Models\Extracurricular::where('employee_id', auth()->user()->employee->id)->exists())
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow {{ request()->routeIs('teacher.extracurricular-students.*') || request()->routeIs('teacher.extracurricular-attendance.*') || request()->routeIs('teacher.extracurricular-permission.*') ? 'active' : '' }}"
                            href="javascript:void(0)" aria-expanded="false">
                            <span>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M18.3085 7.0618L17.5347 6.28803L18.0746 5.71895C18.2193 5.57499 18.2916 5.41266 18.2916 5.23196C18.2916 5.05202 18.2193 4.88969 18.0746 4.74498L15.2539 1.92543C15.1099 1.78148 14.948 1.7095 14.768 1.7095C14.5881 1.7095 14.4258 1.78148 14.2811 1.92543L13.712 2.46528L12.9101 1.66339L13.5376 1.0077C13.8676 0.677801 14.2721 0.517723 14.7512 0.52747C15.2303 0.537217 15.6348 0.706668 15.9647 1.03582L18.9642 4.03644C19.2941 4.36634 19.459 4.76597 19.459 5.23534C19.459 5.7047 19.2941 6.10433 18.9642 6.43424L18.3085 7.0618ZM6.43424 18.9642C6.10433 19.2941 5.7047 19.459 5.23534 19.459C4.76597 19.459 4.36634 19.2941 4.03644 18.9642L1.12354 16.0513C0.778646 15.7064 0.606197 15.2775 0.606197 14.7647C0.606197 14.2518 0.778646 13.8233 1.12354 13.4792L1.66339 12.9382L2.4664 13.7412L1.91869 14.2811C1.77473 14.4258 1.70275 14.5881 1.70275 14.768C1.70275 14.948 1.77473 15.1103 1.91869 15.255L4.74611 18.0813C4.89006 18.226 5.05202 18.2984 5.23196 18.2984C5.41191 18.2984 5.57424 18.226 5.71895 18.0813L6.25879 17.5347L7.0618 18.3366L6.43424 18.9642ZM17.3806 11.3119L18.6594 10.0332C18.8034 9.88922 18.8753 9.72352 18.8753 9.53607C18.8753 9.34863 18.8034 9.18293 18.6594 9.03897L10.961 1.34173C10.8171 1.19702 10.6514 1.12467 10.4639 1.12467C10.2765 1.12467 10.1108 1.19665 9.96682 1.34061L8.68807 2.61936C8.54412 2.76331 8.47214 2.92564 8.47214 3.10634C8.47214 3.28628 8.54412 3.44861 8.68807 3.59332L16.4078 11.3119C16.5518 11.4559 16.7137 11.5279 16.8937 11.5279C17.0736 11.5279 17.2359 11.4559 17.3806 11.3119ZM10.0051 18.6875L11.2838 17.402C11.4278 17.2581 11.4997 17.0961 11.4997 16.9162C11.4997 16.7362 11.4278 16.5739 11.2838 16.4292L3.57083 8.71619C3.42687 8.57223 3.26454 8.50025 3.08384 8.50025C2.9039 8.50025 2.74194 8.57223 2.59799 8.71619L1.31249 9.99494C1.16853 10.1389 1.09655 10.3046 1.09655 10.492C1.09655 10.6795 1.16853 10.8452 1.31249 10.9891L9.01085 18.6864C9.15481 18.8311 9.32051 18.9034 9.50796 18.9034C9.6954 18.9034 9.8611 18.8315 10.0051 18.6875ZM9.20879 12.7571L12.7346 9.23691L10.762 7.26537L7.24287 10.7912L9.20879 12.7571ZM10.7856 19.4827C10.4414 19.8276 10.0156 20 9.50796 20C9.00036 20 8.57411 19.8276 8.22921 19.4827L0.517348 11.7708C0.172449 11.4259 0 10.9996 0 10.492C0 9.98444 0.172449 9.55857 0.517348 9.21442L1.79497 7.9143C2.13987 7.5694 2.56875 7.39695 3.08159 7.39695C3.59444 7.39695 4.02294 7.5694 4.36709 7.9143L6.44098 9.98819L9.96682 6.46235L7.89293 4.39521C7.54803 4.05031 7.37558 3.62069 7.37558 3.10634C7.37558 2.59199 7.54803 2.16236 7.89293 1.81747L9.19192 0.517348C9.53682 0.172449 9.96532 0 10.4774 0C10.9895 0 11.4184 0.172449 11.764 0.517348L19.4827 8.23596C19.8276 8.58085 20 9.00973 20 9.52258C20 10.0354 19.8276 10.4639 19.4827 10.8081L18.1837 12.1082C17.8388 12.4531 17.4088 12.6255 16.8937 12.6255C16.3786 12.6255 15.9489 12.4531 15.6048 12.1082L13.5376 10.0332L10.0118 13.559L12.0857 15.6329C12.4306 15.9778 12.603 16.4067 12.603 16.9195C12.603 17.4324 12.4306 17.8609 12.0857 18.205L10.7856 19.4827Z"
                                        fill="#0896D1" />
                                </svg>
                            </span>
                            <span class="hide-menu">Extrakulikuler</span>
                        </a>
                        <ul aria-expanded="false"
                            class="collapse first-level {{ request()->routeIs('teacher.extracurricular-*') ? 'in' : '' }}">
                            @foreach ($teacherExtracurriculars as $extracurricular)
                                <!-- Nama ekskul sebagai item -->
                                <li class="sidebar-item">
                                    <a class="sidebar-link has-arrow" href="javascript:void(0)">
                                        <span class="hide-menu">{{ $extracurricular->name }}</span>
                                    </a>
                                    <!-- Submenu anak -->
                                    <ul class="collapse first-level">
                                        <li class="sidebar-item">
                                            <a href="{{ route('teacher.extracurricular-students.index', ['extracurricular' => $extracurricular->id]) }}"
                                                class="sidebar-link {{ request()->routeIs('teacher.extracurricular-students.*') && request()->route('extracurricular') == $extracurricular->id ? 'active' : '' }}">
                                                <span class="hide-menu">Daftar Siswa</span>
                                            </a>
                                        </li>

                                        <li class="sidebar-item">
                                            <a href="{{ route('teacher.extracurricular-attendance.index', ['extracurricular' => $extracurricular->id]) }}"
                                                class="sidebar-link {{ request()->routeIs('teacher.extracurricular-attendance.*') && request()->route('extracurricular') == $extracurricular->id ? 'active' : '' }}">
                                                <span class="hide-menu">Absensi Siswa</span>
                                            </a>
                                        </li>

                                        <li class="sidebar-item">
                                            <a href="{{ route('teacher.extracurricular-permission.index', ['extracurricular' => $extracurricular->id]) }}"
                                                class="sidebar-link {{ request()->routeIs('teacher.extracurricular-permission.*') && request()->route('extracurricular') == $extracurricular->id ? 'active' : '' }}">
                                                <span class="hide-menu">Perizinan</span>
                                            </a>
                                        </li>

                                        <li class="sidebar-item">
                                            <a href="{{ route('teacher.extracurricular-schedule.index', ['extracurricular' => $extracurricular->id]) }}"
                                                class="sidebar-link {{ request()->routeIs('teacher.extracurricular-schedule.*') && request()->route('extracurricular') == $extracurricular->id ? 'active' : '' }}">
                                                <span class="hide-menu">Jadwal</span>
                                            </a>
                                        </li>

                                        <li class="sidebar-item">
                                            <a href="{{ route('teacher.extracurricular-journal.index', ['extracurricular' => $extracurricular->id]) }}"
                                                class="sidebar-link {{ request()->routeIs('teacher.extracurricular-journal.*') && request()->route('extracurricular') == $extracurricular->id ? 'active' : '' }}">
                                                <span class="hide-menu">Jurnal</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif

                <!-- <li class="sidebar-item">
                                                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                                                <span class="d-flex">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M2 6s1.5-2 5-2s5 2 5 2v14s-1.5-1-5-1s-5 1-5 1zm10 0s1.5-2 5-2s5 2 5 2v14s-1.5-1-5-1s-5 1-5 1z" />
                                                                    </svg>
                                                                </span>
                                                                <span class="hide-menu">E - Learning</span>
                                                            </a>
                                                            <ul aria-expanded="false" class="collapse first-level">
                                                                <li class="sidebar-item">
                                                                    <a href="javascript:void(0)" class="sidebar-link">
                                                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                                                            <i class="ti ti-circle"></i>
                                                                        </div>
                                                                        <span class="hide-menu">E - Learning</span>
                                                                    </a>
                                                                </li>
                                                                <li class="sidebar-item">
                                                                    <a href="javascript:void(0)" class="sidebar-link">
                                                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                                                            <i class="ti ti-circle"></i>
                                                                        </div>
                                                                        <span class="hide-menu">Kelas</span>
                                                                    </a>
                                                                </li>
                                                                <li class="sidebar-item">
                                                                    <a href="javascript:void(0)" class="sidebar-link">
                                                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                                                            <i class="ti ti-circle"></i>
                                                                        </div>
                                                                        <span class="hide-menu">Daftar Tugas</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </li>

                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                                                <span class="d-flex">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
                                                                        <path fill="currentColor"
                                                                            d="M13 14H9a1 1 0 0 0 0 2h4a1 1 0 0 0 0-2m4-10h-1.18A3 3 0 0 0 13 2h-2a3 3 0 0 0-2.82 2H7a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3m-7 1a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v1h-4Zm8 14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1v1a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V6h1a1 1 0 0 1 1 1Zm-3-9H9a1 1 0 0 0 0 2h6a1 1 0 0 0 0-2" />
                                                                    </svg>
                                                                </span>
                                                                <span class="hide-menu">Rapor</span>
                                                            </a>
                                                            <ul aria-expanded="false" class="collapse first-level">
                                                                <li class="sidebar-item">
                                                                    <a href="javascript:void(0)" class="sidebar-link">
                                                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                                                            <i class="ti ti-circle"></i>
                                                                        </div>
                                                                        <span class="hide-menu">Input Nilai</span>
                                                                    </a>
                                                                </li>
                                                                <li class="sidebar-item">
                                                                    <a href="javascript:void(0)" class="sidebar-link">
                                                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                                                            <i class="ti ti-circle"></i>
                                                                        </div>
                                                                        <span class="hide-menu">Deskripsi Karakter</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                                                <span class="d-flex">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                                        viewBox="0 0 24 24">
                                                                        <path fill="currentColor"
                                                                            d="M20.5 11H19V7a2 2 0 0 0-2-2h-4V3.5A2.5 2.5 0 0 0 10.5 1A2.5 2.5 0 0 0 8 3.5V5H4a2 2 0 0 0-2 2v3.8h1.5c1.5 0 2.7 1.2 2.7 2.7S5 16.2 3.5 16.2H2V20a2 2 0 0 0 2 2h3.8v-1.5c0-1.5 1.2-2.7 2.7-2.7s2.7 1.2 2.7 2.7V22H17a2 2 0 0 0 2-2v-4h1.5a2.5 2.5 0 0 0 2.5-2.5a2.5 2.5 0 0 0-2.5-2.5" />
                                                                    </svg>
                                                                </span>
                                                                <span class="hide-menu">Ujian</span>
                                                            </a>
                                                            <ul aria-expanded="false" class="collapse first-level">
                                                                <li class="sidebar-item">
                                                                    <a href="javascript:void(0)" class="sidebar-link">
                                                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                                                            <i class="ti ti-circle"></i>
                                                                        </div>
                                                                        <span class="hide-menu">Input Nilai</span>
                                                                    </a>
                                                                </li>
                                                                <li class="sidebar-item">
                                                                    <a href="javascript:void(0)" class="sidebar-link">
                                                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                                                            <i class="ti ti-circle"></i>
                                                                        </div>
                                                                        <span class="hide-menu">Deskripsi Karakter</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </li> -->
            </ul>
            @endrole

            @role('staff')
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
                    <a class="sidebar-link" href="{{ route('employee.dashboard') }}" aria-expanded="false">
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
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Buku Tamu</span>
                </li>

                <li class="sidebar-item ">
                    <a class="sidebar-link" href="{{ route('employee.guestbook.create') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M3 2h16.005C20.107 2 21 2.898 21 3.99v16.02c0 1.099-.893 1.99-1.995 1.99H3zm4 2H5v16h2zm2 16h10V4H9zm2-4a3 3 0 1 1 6 0zm3-4a2 2 0 1 1 0-4a2 2 0 0 1 0 4m8-6h2v4h-2zm0 6h2v4h-2z" />
                            </svg>
                        </span>
                        <span class="hide-menu">Buku Tamu</span>
                    </a>
                </li>

                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Jurnal</span>
                </li>
                <li class="sidebar-item ">
                    <a class="sidebar-link {{ request()->routeIs('employee.journal.index') || request()->routeIs('employee.journal.detail') ? 'active' : '' }}"
                        href="{{ route('employee.journal.index') }}" aria-expanded="false">
                        <span>
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
                        </span>
                        <span class="hide-menu">Jurnal</span>
                    </a>
                </li>

                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Perizinan Siswa</span>
                </li>

                <li class="sidebar-item ">
                    <a class="sidebar-link" href="{{ route('employee.permission') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="4">
                                    <path stroke-linejoin="round"
                                        d="M20 10H6a2 2 0 0 0-2 2v26a2 2 0 0 0 2 2h36a2 2 0 0 0 2-2v-2.5" />
                                    <path d="M10 23h8m-8 8h24" />
                                    <circle cx="34" cy="16" r="6" stroke-linejoin="round" />
                                    <path stroke-linejoin="round"
                                        d="M44 28.419C42.047 24.602 38 22 34 22s-5.993 1.133-8.05 3" />
                                </g>
                            </svg>
                        </span>
                        <span class="hide-menu">Perizinan</span>
                    </a>
                </li>
            </ul>
            @endrole

            @can('view_violation')
                <ul id="sidebarnav">
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Pelanggaran</span>
                    </li>

                    <li class="sidebar-item ">
                        <a class="sidebar-link" href="{{ route('employee.violation.overview') }}" aria-expanded="false">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-activity-heartbeat">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 12h4.5l1.5 -6l4 12l2 -9l1.5 3h4.5" />
                                </svg>
                            </span>
                            <span class="hide-menu">Overview</span>
                        </a>
                    </li>

                    <li class="sidebar-item ">
                        <a class="sidebar-link" href="/employee/rfid-student-violation" aria-expanded="false">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 20 20">
                                    <path fill="currentColor"
                                        d="M4.5 5.75a2.25 2.25 0 1 1 4.5 0a2.25 2.25 0 0 1-4.5 0M6.75 2.5a3.25 3.25 0 1 0 0 6.5a3.25 3.25 0 0 0 0-6.5M1.5 12a2 2 0 0 1 2-2H10a2 2 0 0 1 .993.263q-.416.346-.758.765A1 1 0 0 0 10 11H3.5a1 1 0 0 0-1 1v.078l.007.083a2.95 2.95 0 0 0 .498 1.336C3.492 14.201 4.513 15 6.75 15c.954 0 1.687-.145 2.252-.367q.013.525.12 1.02C8.476 15.87 7.695 16 6.75 16c-2.513 0-3.867-.92-4.568-1.934a3.95 3.95 0 0 1-.67-1.807a3 3 0 0 1-.012-.175zM13 6.5a1.5 1.5 0 1 1 3 0a1.5 1.5 0 0 1-3 0M14.5 4a2.5 2.5 0 1 0 0 5a2.5 2.5 0 0 0 0-5M19 14.5a4.5 4.5 0 1 1-9 0a4.5 4.5 0 0 1 9 0M14.5 12a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 1 0v-2a.5.5 0 0 0-.5-.5m0 5.125a.625.625 0 1 0 0-1.25a.625.625 0 0 0 0 1.25" />
                                </svg>
                            </span>
                            <span class="hide-menu">Tambah Pelanggaran</span>
                        </a>
                    </li>

                    <li class="sidebar-item ">
                        <a class="sidebar-link {{ request()->routeIs('employee.violation.student-point.index') || request()->routeIs('employee.violation.student-point.detail') || request()->routeIs('employee.violation.class-point.detail') ? 'active' : '' }}"
                            href="{{ route('employee.violation.student-point.index') }}" aria-expanded="false">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M20 11q-.425 0-.712-.288T19 10t.288-.712T20 9t.713.288T21 10t-.288.713T20 11m-1-3V3h2v5zM9 12q-1.65 0-2.825-1.175T5 8t1.175-2.825T9 4t2.825 1.175T13 8t-1.175 2.825T9 12m-8 8v-2.8q0-.85.438-1.562T2.6 14.55q1.55-.775 3.15-1.162T9 13t3.25.388t3.15 1.162q.725.375 1.163 1.088T17 17.2V20zm2-2h12v-.8q0-.275-.137-.5t-.363-.35q-1.35-.675-2.725-1.012T9 15t-2.775.338T3.5 16.35q-.225.125-.363.35T3 17.2zm6-8q.825 0 1.413-.587T11 8t-.587-1.412T9 6t-1.412.588T7 8t.588 1.413T9 10m0 8" />
                                </svg>
                            </span>
                            <span class="hide-menu">Daftar Point Siswa</span>
                        </a>
                    </li>

                    <li class="sidebar-item ">
                        <a class="sidebar-link" href="{{ route('employee.violation.students') }}" aria-expanded="false">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <g fill="none">
                                        <path
                                            d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                        <path fill="currentColor"
                                            d="m12.702 2.195l7 2.625A2 2 0 0 1 21 6.693v5.363a9 9 0 0 1-4.975 8.05l-3.354 1.677a1.5 1.5 0 0 1-1.342 0l-3.354-1.677A9 9 0 0 1 3 12.056V6.693A2 2 0 0 1 4.298 4.82l7-2.625a2 2 0 0 1 1.404 0M12 4.068L5 6.693v5.363a7 7 0 0 0 3.87 6.26L12 19.883l3.13-1.565A7 7 0 0 0 19 12.056V6.693zM12 14a1 1 0 1 1 0 2a1 1 0 0 1 0-2m0-7a1 1 0 0 1 1 1v4a1 1 0 1 1-2 0V8a1 1 0 0 1 1-1" />
                                    </g>
                                </svg>
                            </span>
                            <span class="hide-menu">Daftar Pelanggaran</span>
                        </a>
                    </li>

                    <li class="sidebar-item ">
                        <a class="sidebar-link" href="{{ route('employee.violation.student-repair.index') }}"
                            aria-expanded="false">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                                    <g fill="none">
                                        <rect width="38" height="26" x="5" y="16" stroke="currentColor"
                                            stroke-linejoin="round" stroke-width="4" rx="3" />
                                        <path fill="currentColor"
                                            d="M19 8h10V4H19zm11 1v7h4V9zm-12 7V9h-4v7zm11-8a1 1 0 0 1 1 1h4a5 5 0 0 0-5-5zM19 4a5 5 0 0 0-5 5h4a1 1 0 0 1 1-1z" />
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="4" d="M18 29h12m-6-6v12" />
                                    </g>
                                </svg>
                            </span>
                            <span class="hide-menu">Daftar Perbaikan Siswa</span>
                        </a>
                    </li>
                </ul>
            @endcan
        </nav>

        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>