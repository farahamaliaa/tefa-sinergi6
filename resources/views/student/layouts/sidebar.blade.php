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

    /* Fix gap submenu level 2 agar tidak terlalu menjorok */
    .sidebar-nav .two-level .sidebar-item .sidebar-link {
        padding-left: 30px !important;
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
                    <a class="sidebar-link" href="{{ route('student.dashboard') }}" aria-expanded="false">
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
                <li class="sidebar-item">
                    <a class="sidebar-link" href="/student/attendance" aria-expanded="false">
                        <span>
                            <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.1742 5.55818L15.7493 6.77622M10.1948 9.19601L12.4813 9.80551M10.3088 16.051L11.223 16.2953C13.8105 16.9853 15.1043 17.3294 16.124 16.7438C17.1427 16.1593 17.4896 14.8722 18.1825 12.3001L19.1628 8.66126C19.8567 6.08814 20.2026 4.80205 19.6142 3.78814C19.0258 2.77422 17.733 2.43018 15.1445 1.74114L14.2303 1.49676C11.6428 0.806761 10.349 0.46272 9.33034 1.04826C8.31067 1.63284 7.96375 2.91989 7.26992 5.49205L6.2905 9.13084C5.59667 11.704 5.24975 12.9901 5.83913 14.004C6.42754 15.0169 7.72129 15.3619 10.3088 16.051Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M10.3334 18.9071L9.42103 19.1562C6.83928 19.8587 5.54936 20.2104 4.53161 19.6134C3.51578 19.0173 3.16886 17.7063 2.4779 15.0824L1.49944 11.3717C0.807525 8.74873 0.461567 7.43677 1.04903 6.40368C1.55694 5.50956 2.66669 5.54214 4.10419 5.54214"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="hide-menu">Absensi</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('student.lesson-schedule') ? 'active' : '' }}"
                        href="{{ route('student.lesson-schedule') }}" aria-expanded="false">
                        <span>
                            <svg width="22" height="17" viewBox="0 0 22 17" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11 17C9.65 16.15 7.2 15.5 5.5 15.5C3.85 15.5 2.15 15.8 0.75 16.55C0.65 16.6 0.6 16.6 0.5 16.6C0.25 16.6 0 16.35 0 16.1V1.5C0.6 1.05 1.25 0.75 2 0.5C3.11 0.15 4.33 0 5.5 0C7.45 0 9.55 0.4 11 1.5C12.45 0.4 14.55 0 16.5 0C17.67 0 18.89 0.15 20 0.5C20.75 0.75 21.4 1.05 22 1.5V16.1C22 16.35 21.75 16.6 21.5 16.6C21.4 16.6 21.35 16.6 21.25 16.55C19.85 15.8 18.15 15.5 16.5 15.5C14.8 15.5 12.35 16.15 11 17ZM10 3C8.64 2.4 6.84 2 5.5 2C4.3 2 3.1 2.15 2 2.5V14C3.1 13.65 4.3 13.5 5.5 13.5C6.84 13.5 8.64 13.9 10 14.5V3ZM12 14.5C13.36 13.9 15.16 13.5 16.5 13.5C17.7 13.5 18.9 13.65 20 14V2.5C18.9 2.15 17.7 2 16.5 2C15.16 2 13.36 2.4 12 3V14.5ZM13 11.85C13.96 11.5 15.12 11.33 16.5 11.33C17.54 11.33 18.38 11.41 19 11.57V10.07C17.01 9.69555 14.9623 9.7604 13 10.26V11.85ZM13 9.19C13.96 8.84 15.12 8.66 16.5 8.66C17.54 8.66 18.38 8.74 19 8.9V7.4C18.13 7.24 17.29 7.17 16.5 7.17C15.22 7.17 14.05 7.32 13 7.62V9.19ZM13 6.5C13.96 6.17 15.12 6 16.5 6C17.41 6 18.26 6.09 19 6.28V4.73C18.13 4.58 17.29 4.5 16.5 4.5C15.18 4.5 14 4.65 13 4.96V6.5Z"
                                    fill="currentColor" stroke-width="0.1" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="hide-menu">Jadwal Pelajaran</span>
                    </a>
                </li>
                {{-- Pengecekan apakah siswa memiliki ekstrakurikuler --}}
                @if (\App\Models\ExtracurricularStudent::where('student_id', auth()->user()->student->id)->exists())
                    @php
                        // Get semua ekstrakurikuler yang diikuti siswa
                        $studentExtracurriculars = \App\Models\ExtracurricularStudent::where(
                            'student_id',
                            auth()->user()->student->id,
                        )
                            ->with('extracurricular')
                            ->get();
                    @endphp

                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow {{ request()->routeIs('student.extracurricular.*') ? 'active' : '' }}"
                            href="javascript:void(0)" aria-expanded="false">
                            <span>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M18.3085 7.0618L17.5347 6.28803L18.0746 5.71895C18.2193 5.57499 18.2916 5.41266 18.2916 5.23196C18.2916 5.05202 18.2193 4.88969 18.0746 4.74498L15.2539 1.92543C15.1099 1.78148 14.948 1.7095 14.768 1.7095C14.5881 1.7095 14.4258 1.78148 14.2811 1.92543L13.712 2.46528L12.9101 1.66339L13.5376 1.0077C13.8676 0.677801 14.2721 0.517723 14.7512 0.52747C15.2303 0.537217 15.6348 0.706668 15.9647 1.03582L18.9642 4.03644C19.2941 4.36634 19.459 4.76597 19.459 5.23534C19.459 5.7047 19.2941 6.10433 18.9642 6.43424L18.3085 7.0618ZM6.43424 18.9642C6.10433 19.2941 5.7047 19.459 5.23534 19.459C4.76597 19.459 4.36634 19.2941 4.03644 18.9642L1.12354 16.0513C0.778646 15.7064 0.606197 15.2775 0.606197 14.7647C0.606197 14.2518 0.778646 13.8233 1.12354 13.4792L1.66339 12.9382L2.4664 13.7412L1.91869 14.2811C1.77473 14.4258 1.70275 14.5881 1.70275 14.768C1.70275 14.948 1.77473 15.1103 1.91869 15.255L4.74611 18.0813C4.89006 18.226 5.05202 18.2984 5.23196 18.2984C5.41191 18.2984 5.57424 18.226 5.71895 18.0813L6.25879 17.5347L7.0618 18.3366L6.43424 18.9642ZM17.3806 11.3119L18.6594 10.0332C18.8034 9.88922 18.8753 9.72352 18.8753 9.53607C18.8753 9.34863 18.8034 9.18293 18.6594 9.03897L10.961 1.34173C10.8171 1.19702 10.6514 1.12467 10.4639 1.12467C10.2765 1.12467 10.1108 1.19665 9.96682 1.34061L8.68807 2.61936C8.54412 2.76331 8.47214 2.92564 8.47214 3.10634C8.47214 3.28628 8.54412 3.44861 8.68807 3.59332L16.4078 11.3119C16.5518 11.4559 16.7137 11.5279 16.8937 11.5279C17.0736 11.5279 17.2359 11.4559 17.3806 11.3119ZM10.0051 18.6875L11.2838 17.402C11.4278 17.2581 11.4997 17.0961 11.4997 16.9162C11.4997 16.7362 11.4278 16.5739 11.2838 16.4292L3.57083 8.71619C3.42687 8.57223 3.26454 8.50025 3.08384 8.50025C2.9039 8.50025 2.74194 8.57223 2.59799 8.71619L1.31249 9.99494C1.16853 10.1389 1.09655 10.3046 1.09655 10.492C1.09655 10.6795 1.16853 10.8452 1.31249 10.9891L9.01085 18.6864C9.15481 18.8311 9.32051 18.9034 9.50796 18.9034C9.6954 18.9034 9.8611 18.8315 10.0051 18.6875ZM9.20879 12.7571L12.7346 9.23691L10.762 7.26537L7.24287 10.7912L9.20879 12.7571ZM10.7856 19.4827C10.4414 19.8276 10.0156 20 9.50796 20C9.00036 20 8.57411 19.8276 8.22921 19.4827L0.517348 11.7708C0.172449 11.4259 0 10.9996 0 10.492C0 9.98444 0.172449 9.55857 0.517348 9.21442L1.79497 7.9143C2.13987 7.5694 2.56875 7.39695 3.08159 7.39695C3.59444 7.39695 4.02294 7.5694 4.36709 7.9143L6.44098 9.98819L9.96682 6.46235L7.89293 4.39521C7.54803 4.05031 7.37558 3.62069 7.37558 3.10634C7.37558 2.59199 7.54803 2.16236 7.89293 1.81747L9.19192 0.517348C9.53682 0.172449 9.96532 0 10.4774 0C10.9895 0 11.4184 0.172449 11.764 0.517348L19.4827 8.23596C19.8276 8.58085 20 9.00973 20 9.52258C20 10.0354 19.8276 10.4639 19.4827 10.8081L18.1837 12.1082C17.8388 12.4531 17.4088 12.6255 16.8937 12.6255C16.3786 12.6255 15.9489 12.4531 15.6048 12.1082L13.5376 10.0332L10.0118 13.559L12.0857 15.6329C12.4306 15.9778 12.603 16.4067 12.603 16.9195C12.603 17.4324 12.4306 17.8609 12.0857 18.205L10.7856 19.4827Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <span class="hide-menu">Ekstrakulikuler</span>
                        </a>
                        <ul aria-expanded="false"
                            class="collapse first-level {{ request()->routeIs('student.extracurricular.*') ? 'in' : '' }}">
                            @foreach ($studentExtracurriculars as $studentExtracurricular)
                                @if ($studentExtracurricular->extracurricular)
                                    <li class="sidebar-item">
                                        <a class="sidebar-link has-arrow" href="javascript:void(0)">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span
                                                class="hide-menu">{{ $studentExtracurricular->extracurricular->name }}</span>
                                        </a>
                                        <!-- Submenu Item (Jadwal, Absensi, Perizinan) -->
                                        <ul aria-expanded="false" class="collapse two-level">
                                            <!-- Jadwal Ekskul -->
                                            <li class="sidebar-item">
                                                <a href="{{ route('student.extracurricular.schedule', ['extracurricular' => $studentExtracurricular->extracurricular->id]) }}"
                                                    class="sidebar-link {{ request()->routeIs('student.extracurricular.schedule') && request()->route('extracurricular') == $studentExtracurricular->extracurricular->id ? 'active' : '' }}">
                                                    <div
                                                        class="round-16 d-flex align-items-center justify-content-center">
                                                    </div>
                                                    <span class="hide-menu">Jadwal Ekskul</span>
                                                </a>
                                            </li>

                                            <li class="sidebar-item">
                                                <a href="{{ route('student.extracurricular.attendance', ['extracurricular' => $studentExtracurricular->extracurricular->id]) }}"
                                                    class="sidebar-link {{ (request()->routeIs('student.extracurricular.attendance') || request()->routeIs('student.extracurricular.attendance.create')) && request()->route('extracurricular') == $studentExtracurricular->extracurricular->id ? 'active' : '' }}">
                                                    <div
                                                        class="round-16 d-flex align-items-center justify-content-center">
                                                    </div>
                                                    <span class="hide-menu">Absensi</span>
                                                </a>
                                            </li>

                                            <li class="sidebar-item">
                                                <a href="{{ route('student.extracurricular.permission', ['extracurricular' => $studentExtracurricular->extracurricular->id]) }}"
                                                    class="sidebar-link {{ request()->routeIs('student.extracurricular.permission') && request()->route('extracurricular') == $studentExtracurricular->extracurricular->id ? 'active' : '' }}">
                                                    <div
                                                        class="round-16 d-flex align-items-center justify-content-center">
                                                    </div>
                                                    <span class="hide-menu">Perizinan</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>
        <div class="fixed-profile p-3 bg-light-secondary rounded sidebar-ad mt-3">
            <div class="hstack gap-3">
                <div class="john-img">
                    <img src="#" class="rounded-circle" width="40" height="40" alt="">
                </div>
                <div class="john-title">
                    <h6 class="mb-0 fs-4 fw-semibold">Mathew</h6>
                    <span class="fs-2 text-dark">Designer</span>
                </div>
                <button class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button"
                    aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
                    <i class="ti ti-power fs-6"></i>
                </button>
            </div>
        </div>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
