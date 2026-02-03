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
                    <a class="sidebar-link {{ request()->routeIs('extracurricular.dashboard') ? 'active' : '' }}"
                        href="{{ route('extracurricular.dashboard') }}" aria-expanded="false">
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

                @php
                    $employee = auth()->user()->employee;
                    $extracurriculars = $employee
                        ? \App\Models\Extracurricular::where('employee_id', $employee->id)->get()
                        : collect([]);
                @endphp

                @if ($extracurriculars->count() > 0)
                    {{-- <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Ekstrakurikuler</span>
                    </li> --}}

                    @if ($extracurriculars->count() > 0)
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow {{ request()->routeIs('extracurricular.students.*') || request()->routeIs('extracurricular.attendance.*') || request()->routeIs('extracurricular.permission.*') || request()->routeIs('extracurricular.schedule.*') || request()->routeIs('extracurricular.journal.*') ? 'active' : '' }}"
                                href="javascript:void(0)" aria-expanded="false">
                                <span>
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M18.3085 7.0618L17.5347 6.28803L18.0746 5.71895C18.2193 5.57499 18.2916 5.41266 18.2916 5.23196C18.2916 5.05202 18.2193 4.88969 18.0746 4.74498L15.2539 1.92543C15.1099 1.78148 14.948 1.7095 14.768 1.7095C14.5881 1.7095 14.4258 1.78148 14.2811 1.92543L13.712 2.46528L12.9101 1.66339L13.5376 1.0077C13.8676 0.677801 14.2721 0.517723 14.7512 0.52747C15.2303 0.537217 15.6348 0.706668 15.9647 1.03582L18.9642 4.03644C19.2941 4.36634 19.459 4.76597 19.459 5.23534C19.459 5.7047 19.2941 6.10433 18.9642 6.43424L18.3085 7.0618ZM6.43424 18.9642C6.10433 19.2941 5.7047 19.459 5.23534 19.459C4.76597 19.459 4.36634 19.2941 4.03644 18.9642L1.12354 16.0513C0.778646 15.7064 0.606197 15.2775 0.606197 14.7647C0.606197 14.2518 0.778646 13.8233 1.12354 13.4792L1.66339 12.9382L2.4664 13.7412L1.91869 14.2811C1.77473 14.4258 1.70275 14.5881 1.70275 14.768C1.70275 14.948 1.77473 15.1103 1.91869 15.255L4.74611 18.0813C4.89006 18.226 5.05202 18.2984 5.23196 18.2984C5.41191 18.2984 5.57424 18.226 5.71895 18.0813L6.25879 17.5347L7.0618 18.3366L6.43424 18.9642ZM17.3806 11.3119L18.6594 10.0332C18.8034 9.88922 18.8753 9.72352 18.8753 9.53607C18.8753 9.34863 18.8034 9.18293 18.6594 9.03897L10.961 1.34173C10.8171 1.19702 10.6514 1.12467 10.4639 1.12467C10.2765 1.12467 10.1108 1.19665 9.96682 1.34061L8.68807 2.61936C8.54412 2.76331 8.47214 2.92564 8.47214 3.10634C8.47214 3.28628 8.54412 3.44861 8.68807 3.59332L16.4078 11.3119C16.5518 11.4559 16.7137 11.5279 16.8937 11.5279C17.0736 11.5279 17.2359 11.4559 17.3806 11.3119ZM10.0051 18.6875L11.2838 17.402C11.4278 17.2581 11.4997 17.0961 11.4997 16.9162C11.4997 16.7362 11.4278 16.5739 11.2838 16.4292L3.57083 8.71619C3.42687 8.57223 3.26454 8.50025 3.08384 8.50025C2.9039 8.50025 2.74194 8.57223 2.59799 8.71619L1.31249 9.99494C1.16853 10.1389 1.09655 10.3046 1.09655 10.492C1.09655 10.6795 1.16853 10.8452 1.31249 10.9891L9.01085 18.6864C9.15481 18.8311 9.32051 18.9034 9.50796 18.9034C9.6954 18.9034 9.8611 18.8315 10.0051 18.6875ZM9.20879 12.7571L12.7346 9.23691L10.762 7.26537L7.24287 10.7912L9.20879 12.7571ZM10.7856 19.4827C10.4414 19.8276 10.0156 20 9.50796 20C9.00036 20 8.57411 19.8276 8.22921 19.4827L0.517348 11.7708C0.172449 11.4259 0 10.9996 0 10.492C0 9.98444 0.172449 9.55857 0.517348 9.21442L1.79497 7.9143C2.13987 7.5694 2.56875 7.39695 3.08159 7.39695C3.59444 7.39695 4.02294 7.5694 4.36709 7.9143L6.44098 9.98819L9.96682 6.46235L7.89293 4.39521C7.54803 4.05031 7.37558 3.62069 7.37558 3.10634C7.37558 2.59199 7.54803 2.16236 7.89293 1.81747L9.19192 0.517348C9.53682 0.172449 9.96532 0 10.4774 0C10.9895 0 11.4184 0.172449 11.764 0.517348L19.4827 8.23596C19.8276 8.58085 20 9.00973 20 9.52258C20 10.0354 19.8276 10.4639 19.4827 10.8081L18.1837 12.1082C17.8388 12.4531 17.4088 12.6255 16.8937 12.6255C16.3786 12.6255 15.9489 12.4531 15.6048 12.1082L13.5376 10.0332L10.0118 13.559L12.0857 15.6329C12.4306 15.9778 12.603 16.4067 12.603 16.9195C12.603 17.4324 12.4306 17.8609 12.0857 18.205L10.7856 19.4827Z"
                                            fill="#0896D1" />
                                    </svg>
                                </span>
                                <span class="hide-menu">Ekstrakurikuler</span>
                            </a>
                            <ul aria-expanded="false"
                                class="collapse first-level {{ request()->routeIs('extracurricular.students.*') || request()->routeIs('extracurricular.attendance.*') || request()->routeIs('extracurricular.permission.*') || request()->routeIs('extracurricular.schedule.*') || request()->routeIs('extracurricular.journal.*') ? 'in' : '' }}">
                                @foreach ($extracurriculars as $extracurricular)
                                    <li class="sidebar-item">
                                        <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false">
                                            <span class="hide-menu">{{ $extracurricular->name }}</span>
                                        </a>
                                        <ul aria-expanded="false" class="collapse first-level">
                                            <li class="sidebar-item">
                                                <a href="{{ route('extracurricular.students.index', ['extracurricular' => $extracurricular->id]) }}"
                                                    class="sidebar-link {{ request()->routeIs('extracurricular.students.*') && request()->get('extracurricular') == $extracurricular->id ? 'active' : '' }}">
                                                    <span class="hide-menu">Daftar Siswa</span>
                                                </a>
                                            </li>

                                            <li class="sidebar-item">
                                                <a href="{{ route('extracurricular.attendance.index', ['extracurricular' => $extracurricular->id]) }}"
                                                    class="sidebar-link {{ request()->routeIs('extracurricular.attendance.*') && request()->get('extracurricular') == $extracurricular->id ? 'active' : '' }}">
                                                    <span class="hide-menu">Absensi Siswa</span>
                                                </a>
                                            </li>

                                            <li class="sidebar-item">
                                                <a href="{{ route('extracurricular.permission.index', ['extracurricular' => $extracurricular->id]) }}"
                                                    class="sidebar-link {{ request()->routeIs('extracurricular.permission.*') && request()->get('extracurricular') == $extracurricular->id ? 'active' : '' }}">
                                                    <span class="hide-menu">Perizinan</span>
                                                </a>
                                            </li>

                                            <li class="sidebar-item">
                                                <a href="{{ route('extracurricular.schedule.index', ['extracurricular' => $extracurricular->id]) }}"
                                                    class="sidebar-link {{ request()->routeIs('extracurricular.schedule.*') && request()->get('extracurricular') == $extracurricular->id ? 'active' : '' }}">
                                                    <span class="hide-menu">Jadwal</span>
                                                </a>
                                            </li>

                                            <li class="sidebar-item">
                                                <a href="{{ route('extracurricular.journal.index', ['extracurricular' => $extracurricular->id]) }}"
                                                    class="sidebar-link {{ request()->routeIs('extracurricular.journal.*') && request()->get('extracurricular') == $extracurricular->id ? 'active' : '' }}">
                                                    <span class="hide-menu">Jurnal</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endif
            </ul>
        </nav>

        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
