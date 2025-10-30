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
                <li class="nav-small-cap" style="color: #2A3547;">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <!-- =================== -->
                <!-- Dashboard -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('school.index') }}" aria-expanded="false">
                        <span>
                            <svg width="22" height="23" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.8848 3.66429C11.375 3.66429 11.8512 3.70631 12.3134 3.79035C12.5936 3.84638 12.9998 3.95143 13.532 4.1055L13.6581 4.14752C14.1763 4.28759 14.7226 4.55371 15.2968 4.9459L15.8011 5.26105C16.3613 5.65323 16.9076 6.16447 17.4398 6.79477C18.3783 7.88728 19.0156 9.27394 19.3518 10.9547C19.4078 11.2068 19.4358 11.424 19.4358 11.606C19.4498 11.7321 19.4568 11.9632 19.4568 12.2994V12.4044C19.4568 13.4129 19.3097 14.3513 19.0156 15.2197C18.7635 15.9341 18.3923 16.6624 17.9021 17.4048C17.6499 17.7829 17.3978 18.0981 17.1457 18.3502L16.6625 18.8334C16.2703 19.2256 15.7941 19.5828 15.2338 19.9049C14.5335 20.2971 13.8682 20.5913 13.2379 20.7874C12.4535 21.0255 11.6131 21.1445 10.7167 21.1445C10.1984 21.1445 9.70821 21.1025 9.24599 21.0185C8.90983 20.9624 8.49664 20.8644 8.0064 20.7243C7.51617 20.5843 7.01894 20.3742 6.5147 20.094C6.19255 19.8979 5.77235 19.6178 5.25411 19.2536C5.07202 19.1276 4.8129 18.8895 4.47674 18.5393L4.28765 18.3502C4.04954 18.1121 3.79042 17.7829 3.51029 17.3627C3.02005 16.6344 2.65588 15.9201 2.41777 15.2197C2.12363 14.3513 1.97656 13.4129 1.97656 12.4044C1.97656 11.8161 2.02559 11.2699 2.12363 10.7656C2.19366 10.3735 2.31972 9.91124 2.50181 9.37899L2.52282 9.29495C2.59285 9.11286 2.64188 8.9868 2.66989 8.91677L2.94302 8.37051C3.43325 7.39005 4.15459 6.49363 5.10704 5.68124C5.68131 5.19101 6.31161 4.78482 6.99793 4.46267C7.75429 4.1125 8.55266 3.87439 9.39306 3.74833C9.78524 3.69231 10.0864 3.66429 10.2965 3.66429H10.8848ZM13.553 6.0174C12.7406 5.61121 11.7742 5.40812 10.6537 5.40812L10.0654 5.42912C9.79925 5.42912 9.50511 5.47114 9.18296 5.55518C9.00087 5.5972 8.73475 5.68124 8.38458 5.8073L8.13246 5.89134C7.97839 5.94737 7.77179 6.04541 7.51267 6.18548C7.25355 6.32555 7.06796 6.4376 6.95591 6.52164L7.20803 7.23598C7.39011 7.82425 7.68425 8.72768 8.09044 9.94625L8.90983 9.37899C9.58215 8.90276 10.2265 8.44054 10.8427 7.99233L13.553 6.0174ZM12.2294 9.16889C12.6916 9.50505 13.3639 9.99528 14.2463 10.6396C16.5154 12.2924 17.657 13.1187 17.671 13.1187C17.685 13.1187 17.692 13.0487 17.692 12.9086L17.713 12.3834C17.713 11.571 17.5939 10.8497 17.3558 10.2194C17.1597 9.70114 16.9496 9.24592 16.7255 8.85374C16.5014 8.46155 16.2283 8.07637 15.9061 7.69819C15.8081 7.58614 15.612 7.39705 15.3179 7.13093L15.1708 7.00487L12.2294 9.16889ZM3.72038 12.4044C3.72038 12.9367 3.79042 13.5179 3.93048 14.1482H5.75834L7.58621 14.1272L6.91389 12.0683L5.50623 7.74021L5.04401 8.30748C5.00199 8.36351 4.93196 8.47556 4.83391 8.64364L4.72886 8.79071C4.51876 9.11286 4.35768 9.43501 4.24563 9.75716L4.16159 9.94625C4.10557 10.0863 4.07055 10.1844 4.05654 10.2404C3.94449 10.6186 3.86745 10.9547 3.82543 11.2489C3.7554 11.627 3.72038 12.0122 3.72038 12.4044ZM12.7757 11.7321C12.0893 11.2419 11.403 10.7446 10.7167 10.2404L8.67872 11.7531L9.43508 14.1482H11.9983L12.6916 12.0052L12.7757 11.7321ZM14.2674 12.8456C14.2674 12.8456 14.2604 12.8666 14.2463 12.9086C13.9522 13.7631 13.2659 15.871 12.1874 19.2326C12.3695 19.2326 12.6636 19.1556 13.0698 19.0015L13.3639 18.8755C13.7421 18.7494 14.1203 18.5603 14.4985 18.3082C14.7226 18.1541 15.0377 17.902 15.4439 17.5518L15.4859 17.5308C15.71 17.3487 15.9622 17.0686 16.2423 16.6904C16.7465 16.0181 17.0687 15.4438 17.2087 14.9676C16.2143 14.1973 15.2338 13.4899 14.2674 12.8456ZM8.04842 15.9131C6.9279 15.9131 5.80036 15.9201 4.66583 15.9341C5.19808 16.7745 5.78636 17.4398 6.43066 17.93C6.96291 18.3362 7.5792 18.6864 8.27953 18.9805C8.33556 19.0085 8.44761 19.0435 8.61569 19.0856L8.80478 19.1276C8.97286 19.1836 9.274 19.2466 9.70821 19.3167L9.81326 19.3377C9.98133 19.3657 10.1004 19.3797 10.1704 19.3797H10.2965L10.8427 17.6779C10.9688 17.2717 11.1299 16.7885 11.326 16.2282L11.41 15.9341C11.41 15.9201 10.2895 15.9131 8.04842 15.9131Z" fill="#0896D1"/>
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
                <li class="nav-small-cap" style="color: #2A3547;">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Master</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('school.employees.index') || request()->routeIs('school.teacher.show') ? 'active' : '' }}"
                        href="{{ route('school.employees.index') }}" aria-expanded="false">
                        <span>
                            <svg width="21" height="23" viewBox="0 0 21 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.58469 10.6632C8.77709 10.6632 7.98762 10.4009 7.31612 9.90949C6.64462 9.41808 6.12124 8.71961 5.81219 7.90242C5.50313 7.08523 5.42226 6.18601 5.57982 5.31849C5.73738 4.45096 6.12628 3.65409 6.69734 3.02864C7.26841 2.40318 7.99599 1.97725 8.78808 1.80468C9.58016 1.63212 10.4012 1.72069 11.1473 2.05918C11.8934 2.39767 12.5312 2.97089 12.9799 3.70634C13.4285 4.44179 13.668 5.30645 13.668 6.19097C13.668 7.37708 13.2378 8.51461 12.472 9.35331C11.7063 10.192 10.6677 10.6632 9.58469 10.6632ZM9.58469 3.04764C9.00783 3.04764 8.44392 3.23499 7.96428 3.586C7.48464 3.93701 7.1108 4.43592 6.89005 5.01962C6.66929 5.60333 6.61153 6.24563 6.72407 6.86529C6.83661 7.48495 7.1144 8.05415 7.5223 8.5009C7.9302 8.94765 8.4499 9.25189 9.01568 9.37515C9.58146 9.49841 10.1679 9.43515 10.7009 9.19337C11.2338 8.95159 11.6893 8.54215 12.0098 8.01682C12.3303 7.4915 12.5014 6.87389 12.5014 6.24209C12.5014 5.82259 12.4259 5.40719 12.2793 5.01962C12.1328 4.63206 11.9179 4.2799 11.6471 3.98327C11.3763 3.68664 11.0547 3.45134 10.7009 3.2908C10.347 3.13027 9.96772 3.04764 9.58469 3.04764ZM12.8339 11.4363C9.67713 10.6578 6.37451 11.0325 3.43053 12.5032C3.02563 12.715 2.68401 13.0485 2.44545 13.4647C2.20689 13.881 2.0812 14.3629 2.08303 14.8543V18.6557C2.08303 18.7396 2.09812 18.8227 2.12743 18.9002C2.15675 18.9777 2.19971 19.0481 2.25388 19.1075C2.30805 19.1668 2.37236 19.2138 2.44313 19.246C2.5139 19.2781 2.58976 19.2946 2.66636 19.2946C2.74297 19.2946 2.81882 19.2781 2.88959 19.246C2.96037 19.2138 3.02467 19.1668 3.07884 19.1075C3.13301 19.0481 3.17598 18.9777 3.20529 18.9002C3.23461 18.8227 3.24969 18.7396 3.24969 18.6557V14.8543C3.24462 14.6056 3.30594 14.3607 3.42614 14.1496C3.54634 13.9385 3.72019 13.7704 3.92636 13.666C5.69979 12.7689 7.63128 12.3087 9.58469 12.3179C10.6792 12.3165 11.77 12.4581 12.8339 12.7396V11.4363ZM12.9155 17.5121H16.4972V18.4065H12.9155V17.5121Z" fill="#0896D1"/>
                            <path d="M19.3498 13.7167H16.334V14.9945H18.7665V20.342H10.5007V14.9945H14.1757V15.2628C14.1757 15.4323 14.2371 15.5948 14.3465 15.7146C14.4559 15.8344 14.6043 15.9017 14.759 15.9017C14.9137 15.9017 15.0621 15.8344 15.1715 15.7146C15.2809 15.5948 15.3423 15.4323 15.3423 15.2628V12.7776C15.3423 12.6081 15.2809 12.4456 15.1715 12.3258C15.0621 12.206 14.9137 12.1387 14.759 12.1387C14.6043 12.1387 14.4559 12.206 14.3465 12.3258C14.2371 12.4456 14.1757 12.6081 14.1757 12.7776V13.7167H9.91732C9.76261 13.7167 9.61423 13.784 9.50484 13.9039C9.39544 14.0237 9.33398 14.1862 9.33398 14.3556V20.9809C9.33398 21.1503 9.39544 21.3128 9.50484 21.4327C9.61423 21.5525 9.76261 21.6198 9.91732 21.6198H19.3498C19.5045 21.6198 19.6529 21.5525 19.7623 21.4327C19.8717 21.3128 19.9332 21.1503 19.9332 20.9809V14.3556C19.9332 14.1862 19.8717 14.0237 19.7623 13.9039C19.6529 13.784 19.5045 13.7167 19.3498 13.7167Z" fill="#0896D1"/>
                            </svg>
                        </span>
                        <span class="hide-menu">Staf</span>
                    </a>
                </li>


                {{-- <li class="sidebar-item">
                    <a class="sidebar-link" href="/school/teacher" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" color="currentColor">
                                    <path
                                        d="M2 2h14c1.886 0 2.828 0 3.414.586S20 4.114 20 6v6c0 1.886 0 2.828-.586 3.414S17.886 16 16 16H9m1-9.5h6M2 17v-4c0-.943 0-1.414.293-1.707S3.057 11 4 11h2m-4 6h4m-4 0v5m4-5v-6m0 6v5m0-11h6" />
                                    <path d="M6 6.5a2 2 0 1 1-4 0a2 2 0 0 1 4 0" />
                                </g>
                            </svg>
                        </span>
                        <span class="hide-menu">Guru</span>
                    </a>
                </li> --}}
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('school.students.index') }}" aria-expanded="false">
                        <span>
                            <svg width="24" height="18" viewBox="0 0 24 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.5 17.25C22.5 17.25 24 17.25 24 15.8125C24 14.375 22.5 10.0625 16.5 10.0625C10.5 10.0625 9 14.375 9 15.8125C9 17.25 10.5 17.25 10.5 17.25H22.5ZM10.533 15.8125L10.5 15.8068C10.5015 15.4273 10.7505 14.3261 11.64 13.3343C12.468 12.4042 13.923 11.5 16.5 11.5C19.0755 11.5 20.5305 12.4056 21.36 13.3343C22.2495 14.3261 22.497 15.4287 22.5 15.8068L22.488 15.8096L22.467 15.8125H10.533ZM16.5 7.1875C17.2956 7.1875 18.0587 6.8846 18.6213 6.34543C19.1839 5.80626 19.5 5.075 19.5 4.3125C19.5 3.55 19.1839 2.81873 18.6213 2.27957C18.0587 1.7404 17.2956 1.4375 16.5 1.4375C15.7044 1.4375 14.9413 1.7404 14.3787 2.27957C13.8161 2.81873 13.5 3.55 13.5 4.3125C13.5 5.075 13.8161 5.80626 14.3787 6.34543C14.9413 6.8846 15.7044 7.1875 16.5 7.1875ZM21 4.3125C21 4.87883 20.8836 5.43961 20.6575 5.96282C20.4313 6.48604 20.0998 6.96145 19.682 7.3619C19.2641 7.76235 18.768 8.08001 18.2221 8.29673C17.6761 8.51345 17.0909 8.625 16.5 8.625C15.9091 8.625 15.3239 8.51345 14.7779 8.29673C14.232 8.08001 13.7359 7.76235 13.318 7.3619C12.9002 6.96145 12.5687 6.48604 12.3425 5.96282C12.1164 5.43961 12 4.87883 12 4.3125C12 3.16875 12.4741 2.07185 13.318 1.2631C14.1619 0.454352 15.3065 0 16.5 0C17.6935 0 18.8381 0.454352 19.682 1.2631C20.5259 2.07185 21 3.16875 21 4.3125ZM10.404 10.465C9.80364 10.2852 9.18526 10.1662 8.559 10.1099C8.20706 10.077 7.85361 10.0612 7.5 10.0625C1.5 10.0625 0 14.375 0 15.8125C0 16.7708 0.5 17.25 1.5 17.25H7.824C7.60174 16.8012 7.49084 16.3092 7.5 15.8125C7.5 14.3606 8.0655 12.8771 9.135 11.638C9.4995 11.2154 9.924 10.8201 10.404 10.465ZM7.38 11.5C6.49279 12.7786 6.01327 14.2771 6 15.8125H1.5C1.5 15.4388 1.746 14.3319 2.64 13.3343C3.4575 12.42 4.878 11.5288 7.38 11.5014V11.5ZM2.25 5.03125C2.25 3.8875 2.72411 2.7906 3.56802 1.98185C4.41193 1.1731 5.55653 0.71875 6.75 0.71875C7.94347 0.71875 9.08807 1.1731 9.93198 1.98185C10.7759 2.7906 11.25 3.8875 11.25 5.03125C11.25 6.175 10.7759 7.2719 9.93198 8.08065C9.08807 8.8894 7.94347 9.34375 6.75 9.34375C5.55653 9.34375 4.41193 8.8894 3.56802 8.08065C2.72411 7.2719 2.25 6.175 2.25 5.03125ZM6.75 2.15625C5.95435 2.15625 5.19129 2.45915 4.62868 2.99832C4.06607 3.53748 3.75 4.26875 3.75 5.03125C3.75 5.79375 4.06607 6.52501 4.62868 7.06418C5.19129 7.60335 5.95435 7.90625 6.75 7.90625C7.54565 7.90625 8.30871 7.60335 8.87132 7.06418C9.43393 6.52501 9.75 5.79375 9.75 5.03125C9.75 4.26875 9.43393 3.53748 8.87132 2.99832C8.30871 2.45915 7.54565 2.15625 6.75 2.15625Z" fill="#0896D1"/>
                            </svg>
                        </span>
                        <span class="hide-menu">Siswa</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('parents.index') }}" aria-expanded="false">
                        <span>
                            <!-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="1.5"
                                    d="M17.928 19.634h2.138a1.165 1.165 0 0 0 1.116-1.555a6.851 6.851 0 0 0-6.117-3.95m0-2.759a3.664 3.664 0 0 0 3.665-3.664a3.664 3.664 0 0 0-3.665-3.674m-1.04 16.795a1.908 1.908 0 0 0 1.537-3.035a8.026 8.026 0 0 0-6.222-3.196a8.026 8.026 0 0 0-6.222 3.197a1.909 1.909 0 0 0 1.536 3.034zM9.34 11.485a4.16 4.16 0 0 0 4.15-4.161a4.151 4.151 0 0 0-8.302 0a4.16 4.16 0 0 0 4.151 4.16" />
                            </svg> -->
                            <svg width="18" height="24" viewBox="0 0 18 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 0C10.1017 0 11.1582 0.379285 11.9372 1.05442C12.7162 1.72955 13.1538 2.64522 13.1538 3.6C13.1538 4.55478 12.7162 5.47045 11.9372 6.14558C11.1582 6.82071 10.1017 7.2 9 7.2C7.89833 7.2 6.84178 6.82071 6.06279 6.14558C5.28379 5.47045 4.84615 4.55478 4.84615 3.6C4.84615 2.64522 5.28379 1.72955 6.06279 1.05442C6.84178 0.379285 7.89833 0 9 0ZM9 8.4C11.2569 8.4 13.32 8.82 15.2308 9.66C17.0862 10.512 18 11.532 18 12.732V19.656C18 21 16.8092 22.128 14.3862 23.028V20.4C14.3862 19.26 13.1954 18.456 10.8138 17.964C10.0385 17.808 9.42923 17.736 9 17.736C7.79538 17.736 6.64615 17.94 5.59385 18.36C4.52769 18.768 3.89077 19.296 3.68308 19.932C5.53846 20.568 7.31077 20.892 9 20.892L10.3846 20.772V23.928L9 24C7.14646 24.0016 5.31261 23.6706 3.61385 23.028C1.19077 22.128 0 21 0 19.656V12.732C0 11.532 0.913846 10.512 2.76923 9.66C4.68 8.82 6.75692 8.4 9 8.4ZM9 10.8C8.26555 10.8 7.56119 11.0529 7.04186 11.5029C6.52253 11.953 6.23077 12.5635 6.23077 13.2C6.23077 13.8365 6.52253 14.447 7.04186 14.8971C7.56119 15.3471 8.26555 15.6 9 15.6C9.73445 15.6 10.4388 15.3471 10.9581 14.8971C11.4775 14.447 11.7692 13.8365 11.7692 13.2C11.7692 12.5635 11.4775 11.953 10.9581 11.5029C10.4388 11.0529 9.73445 10.8 9 10.8Z" fill="#0896D1"/>
                            </svg>
                        </span>
                        <span class="hide-menu">Orang Tua</span>
                    </a>
                </li>                
                {{-- <li class="sidebar-item">
                    <a class="sidebar-link
                    {{ request()->routeIs('school.class-alumni.index') ||
                        request()->routeIs('alumni.index') ? 'active' : '' }}" href="{{ route('school.class-alumni.index') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 256 256">
                                <path fill="currentColor"
                                    d="m251.76 88.94l-120-64a8 8 0 0 0-7.52 0l-120 64a8 8 0 0 0 0 14.12L32 117.87v48.42a15.9 15.9 0 0 0 4.06 10.65C49.16 191.53 78.51 216 128 216a130 130 0 0 0 48-8.76V240a8 8 0 0 0 16 0v-40.49a115.6 115.6 0 0 0 27.94-22.57a15.9 15.9 0 0 0 4.06-10.65v-48.42l27.76-14.81a8 8 0 0 0 0-14.12M128 200c-43.27 0-68.72-21.14-80-33.71V126.4l76.24 40.66a8 8 0 0 0 7.52 0L176 143.47v46.34c-12.6 5.88-28.48 10.19-48 10.19m80-33.75a97.8 97.8 0 0 1-16 14.25v-45.57l16-8.53Zm-20-47.31l-.22-.13l-56-29.87a8 8 0 0 0-7.52 14.12L171 128l-43 22.93L25 96l103-54.93L231 96Z" />
                            </svg>
                        </span>
                        <span class="hide-menu">Alumni</span>
                    </a>
                </li> --}}
                

                <li class="nav-small-cap" style="color: #2A3547;">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Pengaturan</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('school.school-years.index') }}" aria-expanded="false">
                        <span>
                            <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.375 3.83464V1.91797M14.375 3.83464V5.7513M14.375 3.83464H10.0625M2.875 9.58464V18.2096C2.875 18.718 3.07693 19.2055 3.43638 19.5649C3.79582 19.9244 4.28334 20.1263 4.79167 20.1263H18.2083C18.7167 20.1263 19.2042 19.9244 19.5636 19.5649C19.9231 19.2055 20.125 18.718 20.125 18.2096V9.58464M2.875 9.58464H20.125M2.875 9.58464V5.7513C2.875 5.24297 3.07693 4.75546 3.43638 4.39601C3.79582 4.03657 4.28334 3.83464 4.79167 3.83464H6.70833M20.125 9.58464V5.7513C20.125 5.24297 19.9231 4.75546 19.5636 4.39601C19.2042 4.03657 18.7167 3.83464 18.2083 3.83464H17.7292M6.70833 1.91797V5.7513" stroke="#0896D1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
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
                            <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.2857 16.6154H17.1429V1.38462C17.1429 1.01739 16.9923 0.66521 16.7244 0.405544C16.4565 0.145879 16.0932 0 15.7143 0H4.28571C3.90683 0 3.54347 0.145879 3.27556 0.405544C3.00765 0.66521 2.85714 1.01739 2.85714 1.38462V16.6154H0.714286C0.524845 16.6154 0.343164 16.6883 0.209209 16.8182C0.0752549 16.948 0 17.1241 0 17.3077C0 17.4913 0.0752549 17.6674 0.209209 17.7972C0.343164 17.9271 0.524845 18 0.714286 18H19.2857C19.4752 18 19.6568 17.9271 19.7908 17.7972C19.9247 17.6674 20 17.4913 20 17.3077C20 17.1241 19.9247 16.948 19.7908 16.8182C19.6568 16.6883 19.4752 16.6154 19.2857 16.6154ZM4.28571 1.38462H15.7143V16.6154H4.28571V1.38462ZM13.5714 9.34615C13.5714 9.55154 13.5086 9.75232 13.3909 9.92309C13.2731 10.0939 13.1058 10.227 12.91 10.3056C12.7142 10.3842 12.4988 10.4047 12.291 10.3647C12.0831 10.3246 11.8922 10.2257 11.7424 10.0805C11.5925 9.93523 11.4905 9.75019 11.4492 9.54875C11.4078 9.34731 11.429 9.13851 11.5101 8.94875C11.5912 8.759 11.7286 8.59681 11.9047 8.4827C12.0809 8.3686 12.2881 8.30769 12.5 8.30769C12.7842 8.30769 13.0567 8.4171 13.2576 8.61185C13.4585 8.8066 13.5714 9.07074 13.5714 9.34615Z" fill="#0896D1"/>
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
                        <svg width="15" height="18" viewBox="0 0 15 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_6248_3253)">
                        <path d="M9.09847 0.640625V8.35491L12.7274 14.2306C12.9041 14.5151 13.0143 14.8573 13.0451 15.2178C13.0759 15.5783 13.0262 15.9426 12.9017 16.2688C12.7771 16.595 12.5828 16.8699 12.341 17.062C12.0992 17.2542 11.8197 17.3557 11.5346 17.3549H2.619C2.33389 17.3557 2.0544 17.2542 1.81259 17.062C1.57078 16.8699 1.37646 16.595 1.25192 16.2688C1.12738 15.9426 1.07767 15.5783 1.1085 15.2178C1.13933 14.8573 1.24945 14.5151 1.42621 14.2306L5.05512 8.35491V0.640625M3.53886 0.640625H10.6147" stroke="#0896D1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_6248_3253">
                        <rect width="14.1517" height="18" fill="white"/>
                        </clipPath>
                        </defs>
                        </svg>
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
                            <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.25354 19.7585C5.73589 19.2689 4.36142 18.3631 3.26391 17.1293C3.61703 16.6768 3.83715 16.1208 3.89612 15.5323C3.95508 14.9439 3.8502 14.3498 3.5949 13.8262C3.3396 13.3025 2.94549 12.873 2.463 12.5927C1.98051 12.3124 1.43158 12.1941 0.886465 12.2527C0.762279 11.5955 0.699872 10.9264 0.700197 10.2556C0.700197 9.21961 0.847009 8.2203 1.12045 7.28147H1.15899C1.62684 7.28163 2.08701 7.15295 2.49605 6.90759C2.90509 6.66223 3.2495 6.30828 3.49676 5.87916C3.74402 5.45003 3.88597 4.9599 3.90921 4.45505C3.93244 3.95019 3.8362 3.44726 3.62956 2.99375C4.70524 1.91157 6.00612 1.12492 7.42237 0.700195C7.65286 1.18914 8.00404 1.59967 8.43708 1.88636C8.87011 2.17304 9.36811 2.32471 9.87597 2.32457C10.3838 2.32471 10.8818 2.17304 11.3149 1.88636C11.7479 1.59967 12.0991 1.18914 12.3296 0.700195C13.7458 1.12492 15.0467 1.91157 16.1224 2.99375C15.9142 3.45044 15.8181 3.9572 15.8431 4.46553C15.8681 4.97386 16.0135 5.46675 16.2652 5.89702C16.517 6.32728 16.8668 6.68052 17.2811 6.92293C17.6954 7.16533 18.1604 7.28878 18.6315 7.28147C18.9109 8.24396 19.0526 9.24689 19.0518 10.2556C19.0518 10.9397 18.9875 11.6078 18.8655 12.2532C18.3204 12.1946 17.7714 12.3129 17.289 12.5932C16.8065 12.8735 16.4124 13.303 16.1571 13.8267C15.9018 14.3503 15.7969 14.9444 15.8558 15.5328C15.9148 16.1213 16.1349 16.6773 16.488 17.1298C15.3905 18.3634 14.016 19.269 12.4984 19.7585C12.3202 19.1583 11.9702 18.6348 11.4989 18.2634C11.0276 17.892 10.4593 17.6919 9.87597 17.6919C9.29263 17.6919 8.72434 17.892 8.25304 18.2634C7.78174 18.6348 7.43175 19.1583 7.25354 19.7585Z" stroke="#0896D1" stroke-width="1.4" stroke-linejoin="round"/>
                            <path d="M9.87754 13.7258C10.2993 13.7258 10.7169 13.636 11.1065 13.4617C11.4962 13.2873 11.8502 13.0317 12.1484 12.7095C12.4466 12.3873 12.6832 12.0048 12.8446 11.5838C13.006 11.1628 13.0891 10.7116 13.0891 10.256C13.0891 9.8003 13.006 9.34909 12.8446 8.92812C12.6832 8.50714 12.4466 8.12463 12.1484 7.80242C11.8502 7.48022 11.4962 7.22463 11.1065 7.05026C10.7169 6.87588 10.2993 6.78613 9.87754 6.78613C9.02579 6.78613 8.20893 7.1517 7.60665 7.80242C7.00437 8.45314 6.66602 9.33571 6.66602 10.256C6.66602 11.1762 7.00437 12.0588 7.60665 12.7095C8.20893 13.3602 9.02579 13.7258 9.87754 13.7258Z" stroke="#0896D1" stroke-width="1.4" stroke-linejoin="round"/>
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
                <li class="nav-small-cap" style="color: #2A3547;">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Absensi</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('school.clock-settings.index') }}" aria-expanded="false">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 10C19 8.22006 18.4722 6.48008 17.4834 5.00008C16.4945 3.52008 15.089 2.36653 13.4446 1.68528C11.8002 1.00403 9.9907 0.825685 8.24493 1.17279C6.49915 1.5199 4.8955 2.37686 3.63675 3.63534C2.378 4.89381 1.52067 6.49727 1.17318 8.24297C0.825688 9.98866 1.00363 11.7982 1.68451 13.4428C2.3654 15.0873 3.51864 16.4931 4.99842 17.4823C6.4782 18.4714 8.21806 18.9996 9.998 19M17.001 19C16.4706 19 15.9619 18.7893 15.5868 18.4142C15.2117 18.0391 15.001 17.5304 15.001 17C15.001 16.4696 15.2117 15.9609 15.5868 15.5858C15.9619 15.2107 16.4706 15 17.001 15M17.001 19C17.5314 19 18.0401 18.7893 18.4152 18.4142C18.7903 18.0391 19.001 17.5304 19.001 17C19.001 16.4696 18.7903 15.9609 18.4152 15.5858C18.0401 15.2107 17.5314 15 17.001 15M17.001 19V20.5M17.001 15V13.5M20.032 15.25L18.733 16M15.27 18L13.97 18.75M13.97 15.25L15.27 16M18.733 18L20.033 18.75" stroke="#0896D1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 5V10L12 12" stroke="#0896D1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
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
                <!-- <li class="sidebar-item">
                    <a class="sidebar-link" href="" aria-expanded="false">
                        <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.96037 3.12305C7.01734 2.59423 7.26775 2.10513 7.66347 1.74974C8.05919 1.39436 8.57229 1.19777 9.10417 1.19775H13.8958C14.4277 1.19777 14.9408 1.39436 15.3365 1.74974C15.7322 2.10513 15.9827 2.59423 16.0396 3.12305C16.7708 3.13742 17.4033 3.17575 17.9438 3.27446C18.6702 3.40863 19.2884 3.66259 19.7915 4.16571C20.3684 4.74263 20.6157 5.46905 20.7326 6.33155C20.8438 7.16146 20.8438 8.2185 20.8438 9.52855V15.384C20.8438 16.695 20.8438 17.751 20.7326 18.5819C20.6157 19.4444 20.3684 20.1708 19.7915 20.7478C19.2146 21.3247 18.4882 21.5719 17.6257 21.6888C16.7948 21.8 15.7378 21.8 14.4277 21.8H8.57229C7.26225 21.8 6.20521 21.8 5.37433 21.6888C4.51183 21.5729 3.78542 21.3247 3.2085 20.7478C2.63158 20.1708 2.38433 19.4444 2.26838 18.5819C2.15625 17.751 2.15625 16.694 2.15625 15.384V9.52855C2.15625 8.2185 2.15625 7.16146 2.26838 6.33155C2.38338 5.46905 2.63254 4.74263 3.2085 4.16571C3.71162 3.66259 4.32975 3.40863 5.05617 3.27446C5.59667 3.17575 6.22917 3.13742 6.96037 3.12305ZM6.96229 4.56055C6.27421 4.57492 5.74329 4.61038 5.31587 4.68896C4.77346 4.78863 4.45817 4.94771 4.22529 5.18155C3.95983 5.447 3.78733 5.8198 3.69246 6.52321C3.59567 7.24675 3.59375 8.20605 3.59375 9.58125V15.3313C3.59375 16.7074 3.59567 17.6667 3.69246 18.3903C3.78733 19.0937 3.96079 19.4655 4.22529 19.7319C4.49075 19.9964 4.86258 20.1699 5.56696 20.2638C6.28954 20.3615 7.24979 20.3625 8.625 20.3625H14.375C15.7502 20.3625 16.7095 20.3615 17.434 20.2638C18.1374 20.1699 18.5092 19.9964 18.7747 19.731C19.0402 19.4665 19.2127 19.0937 19.3075 18.3903C19.4043 17.6667 19.4062 16.7074 19.4062 15.3313V9.58125C19.4062 8.20605 19.4043 7.24675 19.3075 6.52225C19.2127 5.8198 19.0392 5.447 18.7747 5.18155C18.5409 4.94867 18.2265 4.78863 17.6841 4.68896C17.2567 4.61038 16.7258 4.57492 16.0377 4.56055C15.9768 5.08592 15.725 5.57059 15.3301 5.92239C14.9352 6.27419 14.4247 6.46858 13.8958 6.46859H9.10417C8.57543 6.4686 8.06511 6.27435 7.67022 5.92275C7.27533 5.57114 7.02339 5.0867 6.96229 4.5615M9.10417 2.63525C8.91354 2.63525 8.73073 2.71098 8.59593 2.84577C8.46114 2.98056 8.38542 3.16338 8.38542 3.354V4.31234C8.38542 4.70909 8.70742 5.03109 9.10417 5.03109H13.8958C14.0865 5.03109 14.2693 4.95536 14.4041 4.82057C14.5389 4.68578 14.6146 4.50296 14.6146 4.31234V3.354C14.6146 3.16338 14.5389 2.98056 14.4041 2.84577C14.2693 2.71098 14.0865 2.63525 13.8958 2.63525H9.10417ZM14.9002 10.0508C15.0303 10.1901 15.0998 10.3754 15.0933 10.5659C15.0868 10.7564 15.0049 10.9365 14.8657 11.0667L10.7582 14.9C10.6251 15.0244 10.4498 15.0935 10.2676 15.0935C10.0854 15.0935 9.91003 15.0244 9.77692 14.9L8.13433 13.3667C8.06432 13.3025 8.00772 13.2251 7.96779 13.1389C7.92787 13.0528 7.90542 12.9595 7.90174 12.8646C7.89806 12.7697 7.91322 12.6751 7.94635 12.586C7.97948 12.497 8.02992 12.4155 8.09476 12.3461C8.1596 12.2767 8.23754 12.2208 8.32409 12.1818C8.41064 12.1427 8.50408 12.1211 8.59901 12.1183C8.69394 12.1156 8.78847 12.1316 8.87715 12.1656C8.96583 12.1996 9.0469 12.2508 9.11567 12.3163L10.2676 13.3916L13.8843 10.0163C14.0236 9.88621 14.2089 9.81675 14.3994 9.82322C14.5899 9.82969 14.77 9.91156 14.9002 10.0508Z" fill="#0896D1"/>
                        </svg>
                        <span class="hide-menu">Absensi Ekstrakurikuler</span>
                    </a>
                </li> -->

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow {{ request()->routeIs('school.detail-presence-class.index') ? 'active' : '' }}"
                        href="javascript:void(0)" aria-expanded="false">
                        <span>
                            <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.625 16.2917H6.70833V9.58333H8.625V16.2917ZM12.4583 16.2917H10.5417V6.70833H12.4583V16.2917ZM16.2917 16.2917H14.375V12.4583H16.2917V16.2917ZM18.2083 18.2083H4.79167V4.79167H18.2083V18.3042M18.2083 2.875H4.79167C3.7375 2.875 2.875 3.7375 2.875 4.79167V18.2083C2.875 19.2625 3.7375 20.125 4.79167 20.125H18.2083C19.2625 20.125 20.125 19.2625 20.125 18.2083V4.79167C20.125 3.7375 19.2625 2.875 18.2083 2.875Z" fill="#0896D1"/>
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
                </li>
                <li class="nav-small-cap" style="color: #2A3547;">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Jurnal</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('school.journals.detail') || request()->routeIs('school.export-journal.index') ? 'active' : '' }}"
                        href="{{ route('school.journals.detail') }}" aria-expanded="false">
                        <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.1367 11.5029V3.83203H11.2326V10.5352L13.1426 9.38791C13.2277 9.33692 13.325 9.30999 13.4242 9.30999C13.5234 9.30999 13.6208 9.33692 13.7058 9.38791L15.6159 10.5352V3.83203H16.7117V11.5029C16.7117 11.5998 16.686 11.695 16.6372 11.7788C16.5884 11.8626 16.5183 11.9319 16.4339 11.9797C16.3496 12.0275 16.2541 12.052 16.1572 12.0509C16.0602 12.0497 15.9653 12.0228 15.8822 11.973L13.4242 10.498L10.9663 11.9741C10.883 12.024 10.788 12.0508 10.691 12.052C10.594 12.0531 10.4984 12.0284 10.414 11.9805C10.3296 11.9326 10.2595 11.8631 10.2108 11.7792C10.1621 11.6953 10.1365 11.5999 10.1367 11.5029Z" fill="#0896D1"/>
                        <path d="M6.84987 2.73438H17.8082C18.3895 2.73438 18.9469 2.96528 19.3579 3.3763C19.769 3.78732 19.9999 4.34478 19.9999 4.92604V18.076C19.9999 18.6573 19.769 19.2148 19.3579 19.6258C18.9469 20.0368 18.3895 20.2677 17.8082 20.2677H6.84987C6.2686 20.2677 5.71114 20.0368 5.30013 19.6258C4.88911 19.2148 4.6582 18.6573 4.6582 18.076V16.9802H5.75404V18.076C5.75404 18.3667 5.86949 18.6454 6.075 18.8509C6.28051 19.0564 6.55924 19.1719 6.84987 19.1719H17.8082C18.0988 19.1719 18.3776 19.0564 18.5831 18.8509C18.7886 18.6454 18.904 18.3667 18.904 18.076V4.92604C18.904 4.63541 18.7886 4.35668 18.5831 4.15117C18.3776 3.94566 18.0988 3.83021 17.8082 3.83021H6.84987C6.55924 3.83021 6.28051 3.94566 6.075 4.15117C5.86949 4.35668 5.75404 4.63541 5.75404 4.92604V6.02187H4.6582V4.92604C4.6582 4.34478 4.88911 3.78732 5.30013 3.3763C5.71114 2.96528 6.2686 2.73438 6.84987 2.73438Z" fill="#0896D1"/>
                        <path d="M4.65833 8.21302V7.6651C4.65833 7.51979 4.71606 7.38042 4.81881 7.27767C4.92157 7.17491 5.06093 7.11719 5.20625 7.11719C5.35157 7.11719 5.49093 7.17491 5.59369 7.27767C5.69644 7.38042 5.75417 7.51979 5.75417 7.6651V8.21302H6.30208C6.4474 8.21302 6.58676 8.27075 6.68952 8.3735C6.79227 8.47626 6.85 8.61562 6.85 8.76094C6.85 8.90625 6.79227 9.04562 6.68952 9.14837C6.58676 9.25113 6.4474 9.30885 6.30208 9.30885H4.11042C3.9651 9.30885 3.82574 9.25113 3.72298 9.14837C3.62023 9.04562 3.5625 8.90625 3.5625 8.76094C3.5625 8.61562 3.62023 8.47626 3.72298 8.3735C3.82574 8.27075 3.9651 8.21302 4.11042 8.21302H4.65833ZM4.65833 11.5005V10.9526C4.65833 10.8073 4.71606 10.6679 4.81881 10.5652C4.92157 10.4624 5.06093 10.4047 5.20625 10.4047C5.35157 10.4047 5.49093 10.4624 5.59369 10.5652C5.69644 10.6679 5.75417 10.8073 5.75417 10.9526V11.5005H6.30208C6.4474 11.5005 6.58676 11.5582 6.68952 11.661C6.79227 11.7638 6.85 11.9031 6.85 12.0484C6.85 12.1938 6.79227 12.3331 6.68952 12.4359C6.58676 12.5386 6.4474 12.5964 6.30208 12.5964H4.11042C3.9651 12.5964 3.82574 12.5386 3.72298 12.4359C3.62023 12.3331 3.5625 12.1938 3.5625 12.0484C3.5625 11.9031 3.62023 11.7638 3.72298 11.661C3.82574 11.5582 3.9651 11.5005 4.11042 11.5005H4.65833ZM4.65833 14.788V14.2401C4.65833 14.0948 4.71606 13.9554 4.81881 13.8527C4.92157 13.7499 5.06093 13.6922 5.20625 13.6922C5.35157 13.6922 5.49093 13.7499 5.59369 13.8527C5.69644 13.9554 5.75417 14.0948 5.75417 14.2401V14.788H6.30208C6.4474 14.788 6.58676 14.8457 6.68952 14.9485C6.79227 15.0513 6.85 15.1906 6.85 15.3359C6.85 15.4813 6.79227 15.6206 6.68952 15.7234C6.58676 15.8261 6.4474 15.8839 6.30208 15.8839H4.11042C3.9651 15.8839 3.82574 15.8261 3.72298 15.7234C3.62023 15.6206 3.5625 15.4813 3.5625 15.3359C3.5625 15.1906 3.62023 15.0513 3.72298 14.9485C3.82574 14.8457 3.9651 14.788 4.11042 14.788H4.65833Z" fill="#0896D1"/>
                        </svg>
                        <span class="hide-menu">Jurnal Guru</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('school.employee-journal.show') || request()->routeIs('school.employee-journal.export') ? 'active' : '' }}"
                        href="{{ route('school.employee-journal.show') }}" aria-expanded="false">
                        <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.1367 11.5029V3.83203H11.2326V10.5352L13.1426 9.38791C13.2277 9.33692 13.325 9.30999 13.4242 9.30999C13.5234 9.30999 13.6208 9.33692 13.7058 9.38791L15.6159 10.5352V3.83203H16.7117V11.5029C16.7117 11.5998 16.686 11.695 16.6372 11.7788C16.5884 11.8626 16.5183 11.9319 16.4339 11.9797C16.3496 12.0275 16.2541 12.052 16.1572 12.0509C16.0602 12.0497 15.9653 12.0228 15.8822 11.973L13.4242 10.498L10.9663 11.9741C10.883 12.024 10.788 12.0508 10.691 12.052C10.594 12.0531 10.4984 12.0284 10.414 11.9805C10.3296 11.9326 10.2595 11.8631 10.2108 11.7792C10.1621 11.6953 10.1365 11.5999 10.1367 11.5029Z" fill="#0896D1"/>
                        <path d="M6.84987 2.73438H17.8082C18.3895 2.73438 18.9469 2.96528 19.3579 3.3763C19.769 3.78732 19.9999 4.34478 19.9999 4.92604V18.076C19.9999 18.6573 19.769 19.2148 19.3579 19.6258C18.9469 20.0368 18.3895 20.2677 17.8082 20.2677H6.84987C6.2686 20.2677 5.71114 20.0368 5.30013 19.6258C4.88911 19.2148 4.6582 18.6573 4.6582 18.076V16.9802H5.75404V18.076C5.75404 18.3667 5.86949 18.6454 6.075 18.8509C6.28051 19.0564 6.55924 19.1719 6.84987 19.1719H17.8082C18.0988 19.1719 18.3776 19.0564 18.5831 18.8509C18.7886 18.6454 18.904 18.3667 18.904 18.076V4.92604C18.904 4.63541 18.7886 4.35668 18.5831 4.15117C18.3776 3.94566 18.0988 3.83021 17.8082 3.83021H6.84987C6.55924 3.83021 6.28051 3.94566 6.075 4.15117C5.86949 4.35668 5.75404 4.63541 5.75404 4.92604V6.02187H4.6582V4.92604C4.6582 4.34478 4.88911 3.78732 5.30013 3.3763C5.71114 2.96528 6.2686 2.73438 6.84987 2.73438Z" fill="#0896D1"/>
                        <path d="M4.65833 8.21302V7.6651C4.65833 7.51979 4.71606 7.38042 4.81881 7.27767C4.92157 7.17491 5.06093 7.11719 5.20625 7.11719C5.35157 7.11719 5.49093 7.17491 5.59369 7.27767C5.69644 7.38042 5.75417 7.51979 5.75417 7.6651V8.21302H6.30208C6.4474 8.21302 6.58676 8.27075 6.68952 8.3735C6.79227 8.47626 6.85 8.61562 6.85 8.76094C6.85 8.90625 6.79227 9.04562 6.68952 9.14837C6.58676 9.25113 6.4474 9.30885 6.30208 9.30885H4.11042C3.9651 9.30885 3.82574 9.25113 3.72298 9.14837C3.62023 9.04562 3.5625 8.90625 3.5625 8.76094C3.5625 8.61562 3.62023 8.47626 3.72298 8.3735C3.82574 8.27075 3.9651 8.21302 4.11042 8.21302H4.65833ZM4.65833 11.5005V10.9526C4.65833 10.8073 4.71606 10.6679 4.81881 10.5652C4.92157 10.4624 5.06093 10.4047 5.20625 10.4047C5.35157 10.4047 5.49093 10.4624 5.59369 10.5652C5.69644 10.6679 5.75417 10.8073 5.75417 10.9526V11.5005H6.30208C6.4474 11.5005 6.58676 11.5582 6.68952 11.661C6.79227 11.7638 6.85 11.9031 6.85 12.0484C6.85 12.1938 6.79227 12.3331 6.68952 12.4359C6.58676 12.5386 6.4474 12.5964 6.30208 12.5964H4.11042C3.9651 12.5964 3.82574 12.5386 3.72298 12.4359C3.62023 12.3331 3.5625 12.1938 3.5625 12.0484C3.5625 11.9031 3.62023 11.7638 3.72298 11.661C3.82574 11.5582 3.9651 11.5005 4.11042 11.5005H4.65833ZM4.65833 14.788V14.2401C4.65833 14.0948 4.71606 13.9554 4.81881 13.8527C4.92157 13.7499 5.06093 13.6922 5.20625 13.6922C5.35157 13.6922 5.49093 13.7499 5.59369 13.8527C5.69644 13.9554 5.75417 14.0948 5.75417 14.2401V14.788H6.30208C6.4474 14.788 6.58676 14.8457 6.68952 14.9485C6.79227 15.0513 6.85 15.1906 6.85 15.3359C6.85 15.4813 6.79227 15.6206 6.68952 15.7234C6.58676 15.8261 6.4474 15.8839 6.30208 15.8839H4.11042C3.9651 15.8839 3.82574 15.8261 3.72298 15.7234C3.62023 15.6206 3.5625 15.4813 3.5625 15.3359C3.5625 15.1906 3.62023 15.0513 3.72298 14.9485C3.82574 14.8457 3.9651 14.788 4.11042 14.788H4.65833Z" fill="#0896D1"/>
                        </svg>
                        <span class="hide-menu">Jurnal Staf</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('school.employee-journal.show') || request()->routeIs('school.employee-journal.export') ? 'active' : '' }}"
                        href="{{ route('school.employee-journal.show') }}" aria-expanded="false">
                        <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.1367 11.5029V3.83203H11.2326V10.5352L13.1426 9.38791C13.2277 9.33692 13.325 9.30999 13.4242 9.30999C13.5234 9.30999 13.6208 9.33692 13.7058 9.38791L15.6159 10.5352V3.83203H16.7117V11.5029C16.7117 11.5998 16.686 11.695 16.6372 11.7788C16.5884 11.8626 16.5183 11.9319 16.4339 11.9797C16.3496 12.0275 16.2541 12.052 16.1572 12.0509C16.0602 12.0497 15.9653 12.0228 15.8822 11.973L13.4242 10.498L10.9663 11.9741C10.883 12.024 10.788 12.0508 10.691 12.052C10.594 12.0531 10.4984 12.0284 10.414 11.9805C10.3296 11.9326 10.2595 11.8631 10.2108 11.7792C10.1621 11.6953 10.1365 11.5999 10.1367 11.5029Z" fill="#0896D1"/>
                        <path d="M6.84987 2.73438H17.8082C18.3895 2.73438 18.9469 2.96528 19.3579 3.3763C19.769 3.78732 19.9999 4.34478 19.9999 4.92604V18.076C19.9999 18.6573 19.769 19.2148 19.3579 19.6258C18.9469 20.0368 18.3895 20.2677 17.8082 20.2677H6.84987C6.2686 20.2677 5.71114 20.0368 5.30013 19.6258C4.88911 19.2148 4.6582 18.6573 4.6582 18.076V16.9802H5.75404V18.076C5.75404 18.3667 5.86949 18.6454 6.075 18.8509C6.28051 19.0564 6.55924 19.1719 6.84987 19.1719H17.8082C18.0988 19.1719 18.3776 19.0564 18.5831 18.8509C18.7886 18.6454 18.904 18.3667 18.904 18.076V4.92604C18.904 4.63541 18.7886 4.35668 18.5831 4.15117C18.3776 3.94566 18.0988 3.83021 17.8082 3.83021H6.84987C6.55924 3.83021 6.28051 3.94566 6.075 4.15117C5.86949 4.35668 5.75404 4.63541 5.75404 4.92604V6.02187H4.6582V4.92604C4.6582 4.34478 4.88911 3.78732 5.30013 3.3763C5.71114 2.96528 6.2686 2.73438 6.84987 2.73438Z" fill="#0896D1"/>
                        <path d="M4.65833 8.21302V7.6651C4.65833 7.51979 4.71606 7.38042 4.81881 7.27767C4.92157 7.17491 5.06093 7.11719 5.20625 7.11719C5.35157 7.11719 5.49093 7.17491 5.59369 7.27767C5.69644 7.38042 5.75417 7.51979 5.75417 7.6651V8.21302H6.30208C6.4474 8.21302 6.58676 8.27075 6.68952 8.3735C6.79227 8.47626 6.85 8.61562 6.85 8.76094C6.85 8.90625 6.79227 9.04562 6.68952 9.14837C6.58676 9.25113 6.4474 9.30885 6.30208 9.30885H4.11042C3.9651 9.30885 3.82574 9.25113 3.72298 9.14837C3.62023 9.04562 3.5625 8.90625 3.5625 8.76094C3.5625 8.61562 3.62023 8.47626 3.72298 8.3735C3.82574 8.27075 3.9651 8.21302 4.11042 8.21302H4.65833ZM4.65833 11.5005V10.9526C4.65833 10.8073 4.71606 10.6679 4.81881 10.5652C4.92157 10.4624 5.06093 10.4047 5.20625 10.4047C5.35157 10.4047 5.49093 10.4624 5.59369 10.5652C5.69644 10.6679 5.75417 10.8073 5.75417 10.9526V11.5005H6.30208C6.4474 11.5005 6.58676 11.5582 6.68952 11.661C6.79227 11.7638 6.85 11.9031 6.85 12.0484C6.85 12.1938 6.79227 12.3331 6.68952 12.4359C6.58676 12.5386 6.4474 12.5964 6.30208 12.5964H4.11042C3.9651 12.5964 3.82574 12.5386 3.72298 12.4359C3.62023 12.3331 3.5625 12.1938 3.5625 12.0484C3.5625 11.9031 3.62023 11.7638 3.72298 11.661C3.82574 11.5582 3.9651 11.5005 4.11042 11.5005H4.65833ZM4.65833 14.788V14.2401C4.65833 14.0948 4.71606 13.9554 4.81881 13.8527C4.92157 13.7499 5.06093 13.6922 5.20625 13.6922C5.35157 13.6922 5.49093 13.7499 5.59369 13.8527C5.69644 13.9554 5.75417 14.0948 5.75417 14.2401V14.788H6.30208C6.4474 14.788 6.58676 14.8457 6.68952 14.9485C6.79227 15.0513 6.85 15.1906 6.85 15.3359C6.85 15.4813 6.79227 15.6206 6.68952 15.7234C6.58676 15.8261 6.4474 15.8839 6.30208 15.8839H4.11042C3.9651 15.8839 3.82574 15.8261 3.72298 15.7234C3.62023 15.6206 3.5625 15.4813 3.5625 15.3359C3.5625 15.1906 3.62023 15.0513 3.72298 14.9485C3.82574 14.8457 3.9651 14.788 4.11042 14.788H4.65833Z" fill="#0896D1"/>
                        </svg>
                        <span class="hide-menu">Jurnal Pembina Ekskul</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('school.feedback') }}" aria-expanded="false">
                        <svg width="23" height="21" viewBox="0 0 23 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_6248_3315)">
                        <path d="M6.59954 -0.00195312L5.86621 0.73138V2.97098C6.35365 2.91768 6.84544 2.91768 7.33288 2.97098V1.46471H20.5329V8.79805H18.0293L16.1329 10.6944V8.79805H13.1599C13.2132 9.28548 13.2132 9.77728 13.1599 10.2647H14.6662V12.4647L15.9187 12.9839L18.6365 10.2647H21.2662L21.9995 9.53138V0.73138L21.2662 -0.00195312H6.59954Z" fill="#0896D1"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.4116 13.8267C10.3365 13.2212 11.0412 12.3334 11.4209 11.2952C11.8007 10.2571 11.8352 9.12411 11.5193 8.06479C11.2034 7.00548 10.5539 6.07643 9.66762 5.41585C8.7813 4.75527 7.70541 4.39844 6.6 4.39844C5.49459 4.39844 4.4187 4.75527 3.53238 5.41585C2.64605 6.07643 1.99664 7.00548 1.68074 8.06479C1.36484 9.12411 1.39933 10.2571 1.77908 11.2952C2.15882 12.3334 2.86354 13.2212 3.7884 13.8267C2.65561 14.36 1.69791 15.2047 1.0271 16.2619C0.356301 17.3191 7.07382e-05 18.5454 0 19.7975L0 20.5308H1.46667V19.7975C1.51168 18.466 2.07223 17.2042 3.03 16.2783C3.98777 15.3523 5.26783 14.8348 6.6 14.8348C7.93217 14.8348 9.21223 15.3523 10.17 16.2783C11.1278 17.2042 11.6883 18.466 11.7333 19.7975V20.5308H13.2V19.7975C13.1999 18.5454 12.8437 17.3191 12.1729 16.2619C11.5021 15.2047 10.5444 14.36 9.4116 13.8267ZM6.6 13.1975C5.62754 13.1975 4.69491 12.8111 4.00728 12.1235C3.31964 11.4359 2.93333 10.5032 2.93333 9.53079C2.93333 8.55833 3.31964 7.6257 4.00728 6.93806C4.69491 6.25043 5.62754 5.86412 6.6 5.86412C7.57246 5.86412 8.50509 6.25043 9.19273 6.93806C9.88036 7.6257 10.2667 8.55833 10.2667 9.53079C10.2667 10.5032 9.88036 11.4359 9.19273 12.1235C8.50509 12.8111 7.57246 13.1975 6.6 13.1975Z" fill="#0896D1"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_6248_3315">
                        <rect width="23" height="20.5308" fill="white"/>
                        </clipPath>
                        </defs>
                        </svg>
                        <span class="hide-menu">Tanggapan Siswa</span>
                    </a>
                </li>

                <li class="nav-small-cap" style="color: #2A3547;">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Pelanggaran</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('school.access-violation.index') }}"
                        aria-expanded="false">
                        <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.55833 10C5.175 8.8 4.12083 8 2.875 8C1.24583 8 0 9.3 0 11C0 12.7 1.24583 14 2.875 14C4.12083 14 5.175 13.2 5.55833 12H6.70833V14H8.625V12H10.5417V10H5.55833ZM2.875 12C2.3 12 1.91667 11.6 1.91667 11C1.91667 10.4 2.3 10 2.875 10C3.45 10 3.83333 10.4 3.83333 11C3.83333 11.6 3.45 12 2.875 12ZM15.3333 4C13.225 4 11.5 5.8 11.5 8C11.5 10.2 13.225 12 15.3333 12C17.4417 12 19.1667 10.2 19.1667 8C19.1667 5.8 17.4417 4 15.3333 4ZM15.3333 10.1C14.1833 10.1 13.3208 9.2 13.3208 8C13.3208 6.8 14.1833 5.9 15.3333 5.9C16.4833 5.9 17.3458 6.8 17.3458 8C17.3458 9.2 16.4833 10.1 15.3333 10.1ZM15.3333 13C12.7458 13 7.66667 14.3 7.66667 17V20H23V17C23 14.3 17.9208 13 15.3333 13ZM21.1792 18.1H9.4875V17C9.4875 16.4 12.4583 14.9 15.3333 14.9C18.2083 14.9 21.1792 16.4 21.1792 17V18.1Z" fill="#0896D1"/>
                        </svg>
                        <span class="hide-menu">Akses Pelanggaran</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('school.violation.index') ? 'active' : '' }}"
                        href="{{ route('school.violation.index') }}" aria-expanded="false">
                        <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.3001 3.14844L21.9342 18.1024C22.0658 18.3305 22.1351 18.5891 22.1351 18.8524C22.1351 19.1157 22.0658 19.3744 21.9342 19.6024C21.8025 19.8304 21.6132 20.0198 21.3851 20.1515C21.1571 20.2831 20.8985 20.3524 20.6352 20.3524H3.36715C3.10385 20.3524 2.84519 20.2831 2.61716 20.1515C2.38914 20.0198 2.19979 19.8304 2.06814 19.6024C1.93649 19.3744 1.86719 19.1157 1.86719 18.8524C1.86719 18.5891 1.9365 18.3305 2.06815 18.1024L10.7021 3.14844C11.2791 2.14844 12.7221 2.14844 13.3001 3.14844ZM12.0011 4.89844L4.23315 18.3524H19.7691L12.0011 4.89844ZM12.0011 15.0004C12.2664 15.0004 12.5207 15.1058 12.7083 15.2933C12.8958 15.4809 13.0011 15.7352 13.0011 16.0004C13.0011 16.2657 12.8958 16.52 12.7083 16.7075C12.5207 16.8951 12.2664 17.0004 12.0011 17.0004C11.7359 17.0004 11.4816 16.8951 11.294 16.7075C11.1065 16.52 11.0011 16.2657 11.0011 16.0004C11.0011 15.7352 11.1065 15.4809 11.294 15.2933C11.4816 15.1058 11.7359 15.0004 12.0011 15.0004ZM12.0011 8.00044C12.2664 8.00044 12.5207 8.10579 12.7083 8.29333C12.8958 8.48087 13.0011 8.73522 13.0011 9.00044V13.0004C13.0011 13.2657 12.8958 13.52 12.7083 13.7075C12.5207 13.8951 12.2664 14.0004 12.0011 14.0004C11.7359 14.0004 11.4816 13.8951 11.294 13.7075C11.1065 13.52 11.0011 13.2657 11.0011 13.0004V9.00044C11.0011 8.73522 11.1065 8.48087 11.294 8.29333C11.4816 8.10579 11.7359 8.00044 12.0011 8.00044Z" fill="#0896D1"/>
                        </svg>
                        <span class="hide-menu">Daftar Pelanggaran</span>
                    </a>
                </li>

                <li class="nav-small-cap" style="color: #2A3547;">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Buku tamu</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('school.guest-book.index') }}" aria-expanded="false">
                        <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.55833 10C5.175 8.8 4.12083 8 2.875 8C1.24583 8 0 9.3 0 11C0 12.7 1.24583 14 2.875 14C4.12083 14 5.175 13.2 5.55833 12H6.70833V14H8.625V12H10.5417V10H5.55833ZM2.875 12C2.3 12 1.91667 11.6 1.91667 11C1.91667 10.4 2.3 10 2.875 10C3.45 10 3.83333 10.4 3.83333 11C3.83333 11.6 3.45 12 2.875 12ZM15.3333 4C13.225 4 11.5 5.8 11.5 8C11.5 10.2 13.225 12 15.3333 12C17.4417 12 19.1667 10.2 19.1667 8C19.1667 5.8 17.4417 4 15.3333 4ZM15.3333 10.1C14.1833 10.1 13.3208 9.2 13.3208 8C13.3208 6.8 14.1833 5.9 15.3333 5.9C16.4833 5.9 17.3458 6.8 17.3458 8C17.3458 9.2 16.4833 10.1 15.3333 10.1ZM15.3333 13C12.7458 13 7.66667 14.3 7.66667 17V20H23V17C23 14.3 17.9208 13 15.3333 13ZM21.1792 18.1H9.4875V17C9.4875 16.4 12.4583 14.9 15.3333 14.9C18.2083 14.9 21.1792 16.4 21.1792 17V18.1Z" fill="#0896D1"/>
                        </svg>
                        <span class="hide-menu">Buku Tamu</span>
                    </a>
                </li>
                <li class="nav-small-cap" style="color: #2A3547;">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Managemen Ekstrakurikuler</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('school.extracurricular.index') || request()->routeIs('school.extracurricular.show') ? 'active' : '' }}"
                        href="{{ route('school.extracurricular.index') }}" aria-expanded="false">
                        <span>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.3085 7.0618L17.5347 6.28803L18.0746 5.71895C18.2193 5.57499 18.2916 5.41266 18.2916 5.23196C18.2916 5.05202 18.2193 4.88969 18.0746 4.74498L15.2539 1.92543C15.1099 1.78148 14.948 1.7095 14.768 1.7095C14.5881 1.7095 14.4258 1.78148 14.2811 1.92543L13.712 2.46528L12.9101 1.66339L13.5376 1.0077C13.8676 0.677801 14.2721 0.517723 14.7512 0.52747C15.2303 0.537217 15.6348 0.706668 15.9647 1.03582L18.9642 4.03644C19.2941 4.36634 19.459 4.76597 19.459 5.23534C19.459 5.7047 19.2941 6.10433 18.9642 6.43424L18.3085 7.0618ZM6.43424 18.9642C6.10433 19.2941 5.7047 19.459 5.23534 19.459C4.76597 19.459 4.36634 19.2941 4.03644 18.9642L1.12354 16.0513C0.778646 15.7064 0.606197 15.2775 0.606197 14.7647C0.606197 14.2518 0.778646 13.8233 1.12354 13.4792L1.66339 12.9382L2.4664 13.7412L1.91869 14.2811C1.77473 14.4258 1.70275 14.5881 1.70275 14.768C1.70275 14.948 1.77473 15.1103 1.91869 15.255L4.74611 18.0813C4.89006 18.226 5.05202 18.2984 5.23196 18.2984C5.41191 18.2984 5.57424 18.226 5.71895 18.0813L6.25879 17.5347L7.0618 18.3366L6.43424 18.9642ZM17.3806 11.3119L18.6594 10.0332C18.8034 9.88922 18.8753 9.72352 18.8753 9.53607C18.8753 9.34863 18.8034 9.18293 18.6594 9.03897L10.961 1.34173C10.8171 1.19702 10.6514 1.12467 10.4639 1.12467C10.2765 1.12467 10.1108 1.19665 9.96682 1.34061L8.68807 2.61936C8.54412 2.76331 8.47214 2.92564 8.47214 3.10634C8.47214 3.28628 8.54412 3.44861 8.68807 3.59332L16.4078 11.3119C16.5518 11.4559 16.7137 11.5279 16.8937 11.5279C17.0736 11.5279 17.2359 11.4559 17.3806 11.3119ZM10.0051 18.6875L11.2838 17.402C11.4278 17.2581 11.4997 17.0961 11.4997 16.9162C11.4997 16.7362 11.4278 16.5739 11.2838 16.4292L3.57083 8.71619C3.42687 8.57223 3.26454 8.50025 3.08384 8.50025C2.9039 8.50025 2.74194 8.57223 2.59799 8.71619L1.31249 9.99494C1.16853 10.1389 1.09655 10.3046 1.09655 10.492C1.09655 10.6795 1.16853 10.8452 1.31249 10.9891L9.01085 18.6864C9.15481 18.8311 9.32051 18.9034 9.50796 18.9034C9.6954 18.9034 9.8611 18.8315 10.0051 18.6875ZM9.20879 12.7571L12.7346 9.23691L10.762 7.26537L7.24287 10.7912L9.20879 12.7571ZM10.7856 19.4827C10.4414 19.8276 10.0156 20 9.50796 20C9.00036 20 8.57411 19.8276 8.22921 19.4827L0.517348 11.7708C0.172449 11.4259 0 10.9996 0 10.492C0 9.98444 0.172449 9.55857 0.517348 9.21442L1.79497 7.9143C2.13987 7.5694 2.56875 7.39695 3.08159 7.39695C3.59444 7.39695 4.02294 7.5694 4.36709 7.9143L6.44098 9.98819L9.96682 6.46235L7.89293 4.39521C7.54803 4.05031 7.37558 3.62069 7.37558 3.10634C7.37558 2.59199 7.54803 2.16236 7.89293 1.81747L9.19192 0.517348C9.53682 0.172449 9.96532 0 10.4774 0C10.9895 0 11.4184 0.172449 11.764 0.517348L19.4827 8.23596C19.8276 8.58085 20 9.00973 20 9.52258C20 10.0354 19.8276 10.4639 19.4827 10.8081L18.1837 12.1082C17.8388 12.4531 17.4088 12.6255 16.8937 12.6255C16.3786 12.6255 15.9489 12.4531 15.6048 12.1082L13.5376 10.0332L10.0118 13.559L12.0857 15.6329C12.4306 15.9778 12.603 16.4067 12.603 16.9195C12.603 17.4324 12.4306 17.8609 12.0857 18.205L10.7856 19.4827Z" fill="#0896D1"/>
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

<style>
/* ============================= */
/* TEMA UTAMA SIDEBAR: #0A93CD */
/* ============================= */
.sidebar-item > .sidebar-link {
  display: flex;
  align-items: center;
  padding: 10px 16px;
  color: #2A3547;
  border-radius: 8px;
  transition: all 0.2s ease;
}

/* Hover efek */
.sidebar-item > .sidebar-link:hover {
  background-color: rgba(10,147,205,0.1);
  color: #0A93CD;
}

/* Hilangkan warna biru bootstrap default (#5D86F9) */
.sidebar-link:focus,
.sidebar-link:active,
.sidebar-link.show,
.sidebar-link[aria-expanded="true"] {
  box-shadow: none !important;
  outline: none !important;
  background-color: transparent !important;
  color: inherit !important;
}

/* ============================= */
/* ACTIVE STATE MENU UTAMA */
/* ============================= */
.sidebar-item > .sidebar-link.active {
  background-color: #0A93CD !important;
  color: #fff !important;
  font-weight: 600;
}

.sidebar-item > .sidebar-link.active svg path {
  fill: #fff !important;
  stroke: #fff !important;
}

/* ============================= */
/* SUBMENU AREA */
/* ============================= */
.sidebar-nav .collapse.first-level {
  background-color: #FFFFFF;
  border-radius: 0 0 8px 8px;
  padding: 6px 0;
}

.sidebar-nav .first-level .sidebar-link {
  display: flex;
  align-items: center;
  padding: 8px 20px 8px 46px;
  color: #2A3547;
  border-radius: 6px;
  transition: all 0.2s ease;
}

/* Hover submenu */
.sidebar-nav .first-level .sidebar-link:hover {
  background-color: #E1F5FE;
  color: #0A93CD;
}

/* Active submenu */
.sidebar-nav .first-level .sidebar-link.active {
  background-color: transparent !important;
  color: #0A93CD !important;
  font-weight: 600;
}

/* Indikator bulat */
.round-16 {
  width: 8px;
  height: 8px;
  min-width: 8px;
  background-color: #5A6A85;
  border-radius: 50%;
  margin-right: 10px;
}

/* Indikator saat active */
.sidebar-nav .first-level .sidebar-link.active .round-16 {
  background-color: #0A93CD !important;
}

/* Bersihkan list style */
.sidebar-nav ul, .sidebar-nav li {
  list-style: none;
  margin: 0;
  padding: 0;
}

/* Hilangkan efek active/hover Bootstrap default (warna biru 5D86F9) */
.nav-link:focus,
.nav-link:active,
.nav-link.show,
.sidebar-link:focus,
.sidebar-link:active {
  box-shadow: none !important;
  outline: none !important;
  color: inherit !important;
  background-color: transparent !important;
}

/* Paksa menu nonaktif benar-benar kembali ke default */
.sidebar-link:not(.active) {
  background-color: transparent !important;
  color: #2A3547 !important;
}

/* ============================= */
/* SIDEBAR ACTIVE (ISOLATED) */
/* ============================= */
.sidebar-link.sidebar-active {
  background-color: #0E93C9 !important;
  color: #fff !important;
  font-weight: 600 !important;
}

.sidebar-link.sidebar-active svg path {
  fill: #fff !important;
  stroke: #fff !important;
}
.sidebar-link.sidebar-active {
  background-color: #0E93C9 !important;
  color: #fff !important;
  font-weight: 600 !important;
}

.sidebar-link.sidebar-active svg path {
  fill: #fff !important;
  stroke: #fff !important;
}

/* --- PAKSA NAV-PILLS (TABS) AKTIF TAMPIL DENGAN JELAS --- */
.nav.nav-pills .nav-link,
.nav-pills .nav-link {
  transition: background-color 0.15s, color 0.15s;
}

/* warna active untuk pill/tab (override semua aturan global yang tidak diinginkan) */
.nav-pills .nav-link.active,
.nav-pills .nav-link:active,
.nav-pills .nav-link.show {
  background-color: #0E93C9 !important;
  color: #ffffff !important;
  border-color: #0E93C9 !important;
  box-shadow: none !important;
}

/* pastikan fokus/hover tetap bagus */
.nav-pills .nav-link:focus {
  outline: none !important;
  box-shadow: none !important;
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const sidebar = document.querySelector('.sidebar-nav');
  if (!sidebar) return; // safety guard

  const collapseClass = 'show';
  const dropdownSelector = '.sidebar-link.has-arrow';
  const submenuSelector = '.first-level .sidebar-link';

  function clearSidebarActive(except = []) {
    const allLinks = sidebar.querySelectorAll('.sidebar-link');
    allLinks.forEach(l => {
      if (!except.includes(l)) l.classList.remove('sidebar-active');
    });
  }

  function openCollapseFor(link) {
    const target = link.nextElementSibling;
    if (target && target.classList.contains('collapse')) {
      target.classList.add(collapseClass);
      link.setAttribute('aria-expanded', 'true');
    }
  }

  function toggleCollapse(link) {
    const target = link.nextElementSibling;
    if (!target || !target.classList.contains('collapse')) return;
    const isOpen = target.classList.contains(collapseClass);

    if (isOpen) {
      target.classList.remove(collapseClass);
      link.setAttribute('aria-expanded', 'false');
      link.classList.remove('sidebar-active');
    } else {
      openCollapseFor(link);
      link.classList.add('sidebar-active');
    }
  }

  // Event listener HANYA berlaku di dalam sidebar-nav
  sidebar.addEventListener('click', e => {
    const link = e.target.closest('.sidebar-link');
    if (!link) return; // pastikan klik di sidebar saja

    // Jika klik link di luar sidebar, abaikan (tidak ganggu tombol dashboard)
    if (!sidebar.contains(link)) return;

    if (link.classList.contains('has-arrow')) {
      e.preventDefault();
      clearSidebarActive([link]);
      toggleCollapse(link);
      return;
    }

    const isSub = link.closest('.first-level') !== null;
    if (isSub) {
      const parentCollapse = link.closest('.collapse');
      const parentDropdown = parentCollapse ? parentCollapse.previousElementSibling : null;
      const keep = parentDropdown ? [link, parentDropdown] : [link];
      clearSidebarActive(keep);
      link.classList.add('sidebar-active');
      if (parentDropdown) parentDropdown.classList.add('sidebar-active');
      return;
    }

    clearSidebarActive([link]);
    link.classList.add('sidebar-active');
  });

  // Inisialisasi berdasarkan URL
  const currentPath = window.location.pathname;
  const allLinks = sidebar.querySelectorAll('.sidebar-link');
  allLinks.forEach(link => {
    const href = link.getAttribute('href');
    if (href && href !== '#' && currentPath === href) {
      clearSidebarActive([link]);
      link.classList.add('sidebar-active');
      const parentCollapse = link.closest('.collapse');
      if (parentCollapse) parentCollapse.classList.add(collapseClass);
      const parentDropdown = parentCollapse ? parentCollapse.previousElementSibling : null;
      if (parentDropdown) parentDropdown.classList.add('sidebar-active');
    }
  });
});
</script>

