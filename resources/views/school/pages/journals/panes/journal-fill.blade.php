<style>
    .btn-primary {
        background-color: #0896D1 !important;
        border-color: #0896D1 !important;
    }

    .btn-primary:hover {
        background-color: #067aa7 !important;
        border-color: #067aa7 !important;
    }

    .btn-import {
        background-color: #1EB196 !important;
        border-color: #1EB196 !important;
        color: #fff !important;
    }

    .btn-import:hover {
        background-color: #1e9c87 !important;
        border-color: #1e9c87 !important;
    }
</style>
<div class="card">
    <div class="card-body">
        <h4 class="fw-semibold mb-4">Daftar Jurnal Guru - Mengisi</h4>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
            <form class="d-flex flex-wrap gap-2 align-items-center" method="GET">
                <div class="position-relative">
                    <i class="ti ti-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" name="search_fill" class="form-control ps-5" placeholder="Cari" style="min-width: 250px;"
                        value="{{ old('search_fill', request()->input('search_fill')) }}">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>

        <div class="table-responsive rounded-2">
            <table class="table border text-nowrap customize-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="background-color: #0896D1;" class="text-white">No</th>
                        <th style="background-color: #0896D1;" class="text-white">Nama Guru</th>
                        <th style="background-color: #0896D1;" class="text-white">Tanggal</th>
                        <th style="background-color: #0896D1;" class="text-white">Kelas</th>
                        <th style="background-color: #0896D1;" class="text-white">Status</th>
                        <th style="background-color: #0896D1;" class="text-white">Deskripsi</th>
                        <th style="background-color: #0896D1;" class="text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($fill_journals as $fill_journal)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-start">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $fill_journal->teacherSubject->employee->image ? asset('storage/'. $fill_journal->teacherSubject->employee->image ) : asset('admin_assets/dist/images/profile/user-10.jpg') }}"
                                        class="rounded-circle me-2 user-profile" style="object-fit: cover" width="40"
                                        height="40" alt="" />
                                    <div class="ms-2">
                                        <h6 class="fs-4 fw-semibold mb-0 text-start">
                                            {{ $fill_journal->teacherSubject->employee->user->name }}</h6>
                                        <span
                                            class="fw-normal">{{$fill_journal->teacherSubject->employee->user->modelHasRfid ? $fill_journal->teacherSubject->employee->user->modelHasRfid->rfid : 'Tidak ada rfid'}}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($fill_journal->created_at)->translatedFormat('d F Y') }}</td>
                            <td>{{ $fill_journal->classroom->name }} - {{ $fill_journal->teacherSubject->subject->name }}</td>
                            <td><span class="mb-1 badge font-medium {{ $fill_journal->teacherJournals->first() ? 'bg-light-success text-success' : 'bg-light-danger text-danger' }}">{{ $fill_journal->teacherJournals->first() ? 'Mengisi' : 'Tidak Mengisi'  }}</span></td>
                            <td>{{ $fill_journal->teacherJournals->first() ? \Illuminate\Support\Str::limit($fill_journal->teacherJournals->first()->description, 50) : 'Kosong..'}}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <a type="button" class="text-secondary btn-detail-journal"
                                        data-author="{{ $fill_journal->teacherSubject->employee->user->name }}"
                                        data-date="{{ \Carbon\Carbon::parse($fill_journal->created_at)->translatedFormat('d F Y') }}"
                                        data-description="{{ $fill_journal->teacherJournals->first() ? $fill_journal->teacherJournals->first()->description : 'kosong...' }}"
                                        data-classroom="{{ $fill_journal->classroom->name }} - {{ $fill_journal->teacherSubject->subject->name }}">
                                        Lihat Detail
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center align-middle">
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt=""
                                    width="300px">
                                <p class="fs-5 text-dark text-center mt-2">
                                    Data tidak ditemukan
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Menampilkan {{ $fill_journals->currentPage() }} dari {{ $fill_journals->lastPage() }} halaman
            </div>
            <div>
                <x-paginate-component :paginator="$fill_journals->appends(request()->input())" />
            </div>
        </div>
    </div>
</div>
