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
</style>

@extends('school.layouts.app')

@section('content')

    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Orang Tua</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    Daftar - orang ua
                                </a>
                            </li>
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


    <div class="card mt-4">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-semibold mb-2 text-dark">Daftar Orang Tua</h4>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="ti ti-search"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Cari" id="searchInput">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterKelas">
                    <option value="">Kelas</option>
                    <option value="Nigga">Nigga</option>
                </select>
            </div>
            <div class="col-md-5 text-end">
                <button class="btn text-white" style="background-color: #1ebb9e;">
                    <svg width="20" height="25" viewBox="0 0 28 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.7699 8.92256V23.1726M13.7699 8.92256L18.5199 13.6726M13.7699 8.92256L9.0199 13.6726M22.4782 16.8392C24.8833 16.8392 26.4366 14.8901 26.4366 12.4851C26.4365 11.5329 26.1243 10.607 25.5478 9.84915C24.9712 9.09133 24.1622 8.54338 23.2446 8.28923C23.1034 6.51346 22.3674 4.8372 21.1557 3.53146C19.9439 2.22573 18.3272 1.36684 16.5669 1.09366C14.8066 0.820475 13.0056 1.14897 11.4551 2.02602C9.90454 2.90308 8.69515 4.27744 8.0224 5.9269C6.60599 5.53427 5.09162 5.72038 3.81244 6.44431C2.53325 7.16823 1.59403 8.37065 1.2014 9.78707C0.808771 11.2035 0.994888 12.7178 1.71881 13.997C2.44273 15.2762 3.64516 16.2154 5.06157 16.6081" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>  Import Orang Tua
                </button>
                <button class="btn text-white" style="background-color: #0993CD;">
                    <i class="ti ti-plus"></i> Tambah Orang Tua
                </button>
            </div>
        </div>

        <div class="table-responsive rounded-2">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">No</th>
                        <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">Nama Pembina</th>
                        <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">Email</th>
                        <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">Extrakurikuler</th>
                        <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">No HP</th>
                        <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">Status</th>
                        <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">Aksi</th>
                    </tr>
                </thead>
                <tbody style="background-color: white;">
                    <?php 
                    $dataOrangTua = [
                        [
                            'nama_orang_tua' => 'Maulana Rizki R',
                            'label' => 'Laki-laki',
                            'nama_anak' => 'Agung Prasetya W.',
                            'extracurricular' => 'Nigga',
                            'nomor_hp' => '001301619564',
                            'status' => 'Aktif',
                            'foto' => 'admin_assets/dist/images/breadcrumb/emailSv.png'
                        ],
                        [
                            'nama_orang_tua' => 'Maulana Rizki R',
                            'label' => 'Laki-laki',
                            'nama_anak' => 'Agung Prasetya W.',
                            'extracurricular' => 'Nigga',
                            'nomor_hp' => '001301619564',
                            'status' => 'Aktif',
                            'foto' => 'admin_assets/dist/images/breadcrumb/award.png'
                        ],
                        [
                            'nama_orang_tua' => 'Maulana Rizki R',
                            'label' => 'Laki-laki',
                            'nama_anak' => 'Agung Prasetya W.',
                            'extracurricular' => 'Nigga',
                            'nomor_hp' => '001301619564',
                            'status' => 'Aktif',
                            'foto' => 'admin_assets/dist/images/breadcrumb/emailSv.png'
                        ],
                        [
                            'nama_orang_tua' => 'Maulana Rizki R',
                            'label' => 'Laki-laki',
                            'nama_anak' => 'Agung Prasetya W.',
                            'extracurricular' => 'Nigga',
                            'nomor_hp' => '001301619564',
                            'status' => 'Aktif',
                            'foto' => 'admin_assets/dist/images/breadcrumb/award.png'
                        ],
                        [
                            'nama_orang_tua' => 'Maulana Rizki R',
                            'label' => 'Laki-laki',
                            'nama_anak' => 'Agung Prasetya W.',
                            'extracurricular' => 'Nigga',
                            'nomor_hp' => '001301619564',
                            'status' => 'Aktif',
                            'foto' => 'admin_assets/dist/images/breadcrumb/emailSv.png'
                        ],
                        [
                            'nama_orang_tua' => 'Maulana Rizki R',
                            'label' => 'Laki-laki',
                            'nama_anak' => 'Agung Prasetya W.',
                            'extracurricular' => 'Nigga',
                            'nomor_hp' => '001301619564',
                            'status' => 'Aktif',
                            'foto' => 'admin_assets/dist/images/breadcrumb/award.png'
                        ],
                        [
                            'nama_orang_tua' => 'Maulana Rizki R',
                            'label' => 'Laki-laki',
                            'nama_anak' => 'Agung Prasetya W.',
                            'extracurricular' => 'Nigga',
                            'nomor_hp' => '001301619564',
                            'status' => 'Aktif',
                            'foto' => 'admin_assets/dist/images/breadcrumb/emailSv.png'
                        ],
                        [
                            'nama_orang_tua' => 'Maulana Rizki R',
                            'label' => 'Laki-laki',
                            'nama_anak' => 'Agung Prasetya W.',
                            'extracurricular' => 'Nigga',
                            'nomor_hp' => '001301619564',
                            'status' => 'Aktif',
                            'foto' => 'admin_assets/dist/images/breadcrumb/award.png'
                        ],
                    ];
                    
                    foreach($dataOrangTua as $index => $data): 
                    ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="<?= $data['foto'] ?>" alt="avatar" 
                                     class="rounded-circle me-2" 
                                     style="width: 40px; height: 40px; object-fit: cover;">
                                <div>
                                    <div class="fw-semibold"><?= $data['nama_orang_tua'] ?></div>
                                    <small class="text-muted"><?= $data['label'] ?></small>
                                </div>
                            </div>
                        </td>
                        <td><?= $data['nama_anak'] ?></td>
                        <td><?= $data['extracurricular'] ?></td>
                        <td><?= $data['nomor_hp'] ?></td>
                        <td><?= $data['status'] ?></td>
                        <td>
                            <button class="btn btn-sm me-1" style="background-color: rgba(9, 147, 205, 0.1); color: #0993CD; border: none;" title="Lihat">
                                <i class="ti ti-eye"></i>
                            </button>
                            <button class="btn btn-sm me-1" style="background-color: rgba(255, 193, 7, 0.1); color: #ffc107; border: none;" title="Edit">
                                <i class="ti ti-pencil"></i>
                            </button>
                            <button class="btn btn-sm" style="background-color: rgba(220, 53, 69, 0.1); color: #dc3545; border: none;" title="Hapus">
                                <i class="ti ti-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection