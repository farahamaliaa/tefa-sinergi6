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
        height: 90px;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 80'%3E%3Cpath fill='%23FFFFFF55' d='M0 32l48 10.7C96 53 192 75 288 69.3c96-5.3 192-42.7 288-48C672 16 768 48 864 58.7 960 69 1056 59 1152 53.3 1248 48 1344 48 1392 48h48v32H0z'/%3E%3C/svg%3E");
        background-size: cover;
        opacity: 0.6;
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
                    <option value="XI RPL 1">XI RPL 1</option>
                </select>
            </div>
            <div class="col-md-5 text-end">
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
                        <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">Nama Orang Tua</th>
                        <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">Nama Anak</th>
                        <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">Jurusan/Kelas</th>
                        <th style="background-color: #0993CD; color: white; padding: 12px; font-weight: 600;">Nomor HP</th>
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
                            'jurusan_kelas' => 'XI RPL 1',
                            'nomor_hp' => '001301619564',
                            'foto' => 'admin_assets/dist/images/breadcrumb/emailSv.png'
                        ],
                        [
                            'nama_orang_tua' => 'Maulana Rizki R',
                            'label' => 'Laki-laki',
                            'nama_anak' => 'Agung Prasetya W.',
                            'jurusan_kelas' => 'XI RPL 1',
                            'nomor_hp' => '001301619564',
                            'foto' => 'admin_assets/dist/images/breadcrumb/award.png'
                        ],
                        [
                            'nama_orang_tua' => 'Maulana Rizki R',
                            'label' => 'Laki-laki',
                            'nama_anak' => 'Agung Prasetya W.',
                            'jurusan_kelas' => 'XI RPL 1',
                            'nomor_hp' => '001301619564',
                            'foto' => 'admin_assets/dist/images/breadcrumb/emailSv.png'
                        ],
                        [
                            'nama_orang_tua' => 'Maulana Rizki R',
                            'label' => 'Laki-laki',
                            'nama_anak' => 'Agung Prasetya W.',
                            'jurusan_kelas' => 'XI RPL 1',
                            'nomor_hp' => '001301619564',
                            'foto' => 'admin_assets/dist/images/breadcrumb/award.png'
                        ],
                        [
                            'nama_orang_tua' => 'Maulana Rizki R',
                            'label' => 'Laki-laki',
                            'nama_anak' => 'Agung Prasetya W.',
                            'jurusan_kelas' => 'XI RPL 1',
                            'nomor_hp' => '001301619564',
                            'foto' => 'admin_assets/dist/images/breadcrumb/emailSv.png'
                        ],
                        [
                            'nama_orang_tua' => 'Maulana Rizki R',
                            'label' => 'Laki-laki',
                            'nama_anak' => 'Agung Prasetya W.',
                            'jurusan_kelas' => 'XI RPL 1',
                            'nomor_hp' => '001301619564',
                            'foto' => 'admin_assets/dist/images/breadcrumb/award.png'
                        ],
                        [
                            'nama_orang_tua' => 'Maulana Rizki R',
                            'label' => 'Laki-laki',
                            'nama_anak' => 'Agung Prasetya W.',
                            'jurusan_kelas' => 'XI RPL 1',
                            'nomor_hp' => '001301619564',
                            'foto' => 'admin_assets/dist/images/breadcrumb/emailSv.png'
                        ],
                        [
                            'nama_orang_tua' => 'Maulana Rizki R',
                            'label' => 'Laki-laki',
                            'nama_anak' => 'Agung Prasetya W.',
                            'jurusan_kelas' => 'XI RPL 1',
                            'nomor_hp' => '001301619564',
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
                        <td><?= $data['jurusan_kelas'] ?></td>
                        <td><?= $data['nomor_hp'] ?></td>
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