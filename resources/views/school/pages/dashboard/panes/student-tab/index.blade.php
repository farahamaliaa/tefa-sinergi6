<style>
    .stat-card {
        min-height: 160px;
        padding: 30px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-radius: 16px;
        background: #fff;
        /* box-shadow: 0 4px 12px rgba(0,0,0,0.05); */
        transition: all 0.25s ease-in-out;
        margin-bottom: 15px;
    }

    .stat-section {
        margin-bottom: 20px; 
    }

    .stat-card:hover {
        transform: translateY(-2px);
        /* box-shadow: 0 4px 12px rgba(0,0,0,0.08); */
    }

    .stat-title {
        font-weight: 600;
        font-size: 17px;
        color: #000;
        margin-bottom: 12px;
    }

    .stat-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 16px;
    }

    /* Warna lembut */
    .bg-primary-soft { background-color: #ECF2FF; color: #0896D1; }
    .bg-warning-soft { background-color: #FEF5E5; color: #FFAE1F; }
    .bg-danger-soft  { background-color: #FBF2EF; color: #F73131; }

    .icon-box {
    width: 72px;
    height: 72px;
    border-radius: 14px;
    display: flex;
    justify-content: center;
    align-items: center;
    }

    .card-body .nav-pills {
        background-color: #fff !important;
        border: 1px solid #dfe4ea !important;
        border-radius: 50px !important;
        padding: 4px !important;
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        width: max-content;
        max-width: 100%;
    }

    .card-body .nav-pills::-webkit-scrollbar {
        display: none;
    }
    .card-body .nav-pills {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .card-body .nav-pills .nav-item {
        flex: 0 0 auto;
        display: inline-block;
    }

    .card-body .nav-pills .nav-link {
        color: #000 !important;
        font-weight: 600;
        border-radius: 50px !important;
        transition: all 0.3s ease;
        white-space: nowrap;
        display: inline-block;
        background-color: transparent !important;
    }

    .card-body .nav-pills .nav-link.active {
        background-color: #0896D1 !important;
        color: #fff !important;
        box-shadow: 0 2px 6px rgba(8,150,209,0.3) !important;
    }

    .card-body .nav-pills .nav-link:not(.active):hover {
        background-color: rgba(8,150,209,0.1) !important;
        color: #0896D1 !important;
    }

    @media (max-width: 576px) {
        .card-body .nav-pills .nav-link {
            padding: 8px 16px;
            font-size: 14px;
        }
    }

</style>

<div class="row g-3">
    <div class="col-md-6 col-lg-4">
        <div class="stat-card border">
            <div>
                <div class="stat-title">Jumlah Siswa Telat Absen</div>
                <div class="stat-badge bg-primary-soft">{{ $lates->count() }} Siswa</div>
            </div>
            <div class="icon-box bg-primary-soft">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="64" height="64" rx="8" fill="#ECF2FF"/>
                    <g clip-path="url(#clip0_6117_2572)">
                        <path d="M32 16C23.1625 16 16 23.1625 16 32C16 40.8375 23.1625 48 32 48C40.8375 48 48 40.8375 48 32C48 23.1625 40.8375 16 32 16ZM32 45.3312C24.6375 45.3312 18.6688 39.3625 18.6688 32C18.6688 24.6375 24.6375 18.6688 32 18.6688C39.3625 18.6688 45.3312 24.6375 45.3312 32C45.3312 39.3625 39.3625 45.3312 32 45.3312ZM30.6687 30.6687L25.3313 36L27.3313 38L33.3312 32V21.3313H30.6625V30.6687H30.6687Z" fill="#0896D1"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_6117_2572">
                            <rect width="32" height="32" fill="white" transform="translate(16 16)"/>
                        </clipPath>
                    </defs>
                </svg>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="stat-card border">
            <div>
                <div class="stat-title">Jumlah Siswa Izin</div>
                <div class="stat-badge bg-warning-soft">{{ $totalPermit }} Siswa</div>
            </div>
            <div class="icon-box bg-warning-soft">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="64" height="64" rx="8" fill="#FEF5E5"/>
                    <path d="M38.6667 44L35 40L36.5467 38.4533L38.6667 40.5733L43.4533 35.7867L45 37.6667M33.0667 44H22.6667C21.1867 44 20 42.8133 20 41.3333V22.6667C20 21.1867 21.1867 20 22.6667 20H41.3333C42.8133 20 44 21.1867 44 22.6667V33.0667C43.1867 32.6 42.2933 32.2667 41.3333 32.1067V22.6667H22.6667V41.3333H32.1067C32.2667 42.2933 32.6 43.1867 33.0667 44ZM32 38.6667H25.3333V36H32M35.5733 33.3333H25.3333V30.6667H38.6667V32.1067C37.5333 32.2933 36.4933 32.72 35.5733 33.3333ZM38.6667 28H25.3333V25.3333H38.6667" fill="#FFAE1F"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="stat-card border">
            <div>
                <div class="stat-title">Jumlah Siswa Alfa</div>
                <div class="stat-badge bg-danger-soft">{{ $alpha->count() }} Siswa</div>
            </div>
            <div class="icon-box bg-danger-soft">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="64" height="64" rx="8" fill="#FBF2EF"/>
                    <path d="M36.9468 27.0544C36.8228 26.9294 36.6754 26.8303 36.5129 26.7626C36.3504 26.6949 36.1761 26.66 36.0001 26.66C35.8241 26.66 35.6498 26.6949 35.4873 26.7626C35.3249 26.8303 35.1774 26.9294 35.0534 27.0544L32.0001 30.1211L28.9468 27.0544C28.6957 26.8033 28.3552 26.6623 28.0001 26.6623C27.645 26.6623 27.3045 26.8033 27.0534 27.0544C26.8024 27.3055 26.6613 27.646 26.6613 28.0011C26.6613 28.3562 26.8024 28.6967 27.0534 28.9477L30.1201 32.0011L27.0534 35.0544C26.9285 35.1784 26.8293 35.3258 26.7616 35.4883C26.6939 35.6508 26.659 35.8251 26.659 36.0011C26.659 36.1771 26.6939 36.3514 26.7616 36.5139C26.8293 36.6763 26.9285 36.8238 27.0534 36.9478C27.1774 37.0727 27.3249 37.1719 27.4873 37.2396C27.6498 37.3073 27.8241 37.3421 28.0001 37.3421C28.1761 37.3421 28.3504 37.3073 28.5129 37.2396C28.6754 37.1719 28.8228 37.0727 28.9468 36.9478L32.0001 33.8811L35.0534 36.9478C35.1774 37.0727 35.3249 37.1719 35.4873 37.2396C35.6498 37.3073 35.8241 37.3421 36.0001 37.3421C36.1761 37.3421 36.3504 37.3073 36.5129 37.2396C36.6754 37.1719 36.8228 37.0727 36.9468 36.9478C37.0717 36.8238 37.1709 36.6763 37.2386 36.5139C37.3063 36.3514 37.3412 36.1771 37.3412 36.0011C37.3412 35.8251 37.3063 35.6508 37.2386 35.4883C37.1709 35.3258 37.0717 35.1784 36.9468 35.0544L33.8801 32.0011L36.9468 28.9477C37.0717 28.8238 37.1709 28.6763 37.2386 28.5139C37.3063 28.3514 37.3412 28.1771 37.3412 28.0011C37.3412 27.8251 37.3063 27.6508 37.2386 27.4883C37.1709 27.3258 37.0717 27.1784 36.9468 27.0544ZM41.4268 22.5744C40.1968 21.3009 38.7256 20.2852 37.0988 19.5864C35.4721 18.8876 33.7225 18.5198 31.9521 18.5044C30.1817 18.489 28.426 18.8264 26.7874 19.4968C25.1488 20.1672 23.6601 21.1572 22.4082 22.4091C21.1563 23.6611 20.1662 25.1497 19.4958 26.7884C18.8254 28.427 18.488 30.1827 18.5034 31.9531C18.5188 33.7235 18.8866 35.4731 19.5854 37.0998C20.2842 38.7265 21.3 40.1978 22.5734 41.4277C23.8034 42.7012 25.2747 43.717 26.9014 44.4158C28.5281 45.1146 30.2777 45.4824 32.0481 45.4978C33.8185 45.5131 35.5742 45.1758 37.2128 44.5054C38.8514 43.835 40.3401 42.8449 41.592 41.593C42.8439 40.3411 43.834 38.8524 44.5044 37.2138C45.1748 35.5752 45.5122 33.8195 45.4968 32.0491C45.4814 30.2787 45.1136 28.5291 44.4148 26.9024C43.716 25.2756 42.7002 23.8044 41.4268 22.5744ZM39.5468 39.5477C37.8028 41.2936 35.5075 42.3808 33.0518 42.6242C30.5962 42.8675 28.1321 42.2518 26.0795 40.8821C24.0268 39.5124 22.5126 37.4734 21.7947 35.1124C21.0769 32.7514 21.1998 30.2146 22.1427 27.9341C23.0855 25.6537 24.7898 23.7706 26.9653 22.6058C29.1408 21.4411 31.6528 21.0666 34.0734 21.5462C36.4941 22.0259 38.6735 23.33 40.2404 25.2364C41.8074 27.1427 42.6648 29.5334 42.6668 32.0011C42.6715 33.4028 42.3982 34.7915 41.8627 36.0869C41.3271 37.3823 40.54 38.5586 39.5468 39.5477Z" fill="#F73131"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="row d-flex">
    <div class="col-lg-8 col-md-12 d-flex mb-4">
        <div class="card w-100 h-100 border">
            <div class="card-body">
                <h5 class="mb-4"><b>Data Absensi Siswa</b></h5>
                <ul class="nav nav-pills mb-4 p-1 rounded-pill bg-light d-inline-flex">
                    <li class="nav-item">
                        <a href="#late-content" data-bs-toggle="tab"
                            class="nav-link rounded-pill px-4 py-2 active"
                            id="late">
                            Telat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#permission-content" data-bs-toggle="tab"
                            class="nav-link rounded-pill px-4 py-2"
                            id="permission">
                            Izin
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#alpha-content" data-bs-toggle="tab"
                            class="nav-link rounded-pill px-4 py-2"
                            id="alpha">
                            Alfa
                        </a>
                    </li>
                </ul>


                <div class="tab-content">
                    <div id="late-content" class="tab-pane fade show active">
                        <div class="note-has-grid row">
                            <div class="col-12">
                                @include('school.pages.dashboard.panes.student-tab.late-tab')
                            </div>
                        </div>
                    </div>

                    <div id="permission-content" class="tab-pane fade">
                        <div class="note-has-grid row">
                            <div class="col-12">
                                @include('school.pages.dashboard.panes.student-tab.permisson-tab')
                            </div>
                        </div>
                    </div>

                    <div id="alpha-content" class="tab-pane fade">
                        <div class="note-has-grid row">
                            <div class="col-12">
                                @include('school.pages.dashboard.panes.student-tab.alpha-tab')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 d-flex mb-4">
        <div class="card w-100 h-100 overflow-hidden border">
            <div class="card-body">
                <div class="row align-items-center">
                    <h5 class="card-title fw-semibold">Statistik Absensi Siswa</h5>
                    <h6 class="mb-3">Hari ini</h6>
                    <div id="chart-student" class="d-flex justify-content-center"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const navRoleLinks = document.querySelectorAll('.nav-role .nav-link');
    
    navRoleLinks.forEach(link => {
        link.addEventListener('click', function() {
            navRoleLinks.forEach(l => {
                l.classList.remove('active');
                l.style.backgroundColor = '';
                l.style.color = '';
            });

            this.classList.add('active');
            this.style.backgroundColor = '#0896D1';
            this.style.color = '#fff';
        });
    });


    const navStatusLinks = document.querySelectorAll('.nav-status .nav-link');
    
    navStatusLinks.forEach(link => {
        link.addEventListener('click', function() {
            navStatusLinks.forEach(l => {
                l.classList.remove('active');
                l.style.backgroundColor = '';
                l.style.color = '';
            });

            this.classList.add('active');
            this.style.backgroundColor = '#0896D1';
            this.style.color = '#fff';
        });
    });
});
</script>