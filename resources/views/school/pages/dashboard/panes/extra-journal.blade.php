<div class="row d-flex">
    <div class="col-lg-9 col-md-12">
        <div class="card border">
            <div class="card-body">
                <h5 class="mb-4"><b>Daftar Pembina Tidak Mengisi Jurnal Ekstrakurikuler</b></h5>
                <div class="table-responsive rounded-3 mb-4">
                    <table class="table border text-nowrap customize-table mb-0 align-middle text-center">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="fs-4 fw-semibold mb-0" style="background-color: #0896d1; color: white">No</th>
                                <th class="fs-4 fw-semibold mb-0" style="background-color: #0896d1; color: white">Nama
                                    Pembina</th>
                                <th class="fs-4 fw-semibold mb-0" style="background-color: #0896d1; color: white">
                                    Tanggal</th>
                                <th class="fs-4 fw-semibold mb-0" style="background-color: #0896d1; color: white">
                                    Ekstrakurikuler</th>
                                <th class="fs-4 fw-semibold mb-0" style="background-color: #0896d1; color: white">Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($extraNotFill as $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value->extracurricular->employee->user->name }}</td>
                                    <td>{{ now()->locale('id')->translatedFormat('d F Y') }}</td>
                                    <td>{{ $value->extracurricular->name }}</td>
                                    <td>
                                        <span class="badge bg-light-danger text-danger fw-semibold fs-2">Tidak
                                            Mengisi</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center align-middle">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}"
                                                alt="" width="300px">
                                            <p class="fs-5 text-dark text-center mt-2">Tidak ada pembina yang belum
                                                mengisi jurnal</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-12 mb-3">
        <div class="statistik-container">
            <h4><b>Total Jurnal Extra</b></h4>
            <div class="line">
                <div class="small-line"></div>
                <div class="smaller-line"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border rounded-4 p-0 card-body-with-line2">
                    <div class="card-body">
                        <h5><b>Jurnal Diisi</b></h5>
                        <h3 class="text-success">{{ $extraFill->count() }} Pembina</h3>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card border rounded-4 p-0 card-body-with-line3">
                    <div class="card-body">
                        <h5><b>Jurnal Tidak Diisi</b></h5>
                        <h3 class="text-danger">{{ $extraNotFill->count() }} Pembina</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
