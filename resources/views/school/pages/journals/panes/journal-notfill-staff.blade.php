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
        <h4 class="fw-semibold mb-4">Daftar Jurnal Staff - Belum Selesai</h4>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
            <form class="d-flex flex-wrap gap-2 align-items-center" method="GET">
                <div class="position-relative">
                    <i class="ti ti-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" name="name" class="form-control ps-5" placeholder="Cari" style="min-width: 250px;"
                        value="{{ old('name', request()->input('name')) }}">
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
                        <th style="background-color: #0896D1;" class="text-white">Nama Staff</th>
                        <th style="background-color: #0896D1;" class="text-white">Tanggal</th>
                        <th style="background-color: #0896D1;" class="text-white">Status</th>
                        <th style="background-color: #0896D1;" class="text-white">Deskripsi</th>
                        <th style="background-color: #0896D1;" class="text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($notCompletedJournals as $journal)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-start">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $journal->employee->image ? asset('storage/' . $journal->employee->image) : asset('assets/images/default-user.jpeg') }}"
                                        class="rounded-circle me-2 user-profile" style="object-fit: cover"
                                        width="40" height="40" alt="" />
                                    <div class="ms-2">
                                        <h6 class="fs-4 fw-semibold mb-0 text-start">
                                            {{ $journal->employee->user->name }}</h6>
                                        <span class="fw-normal">{{ $journal->employee->user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($journal->created_at)->translatedFormat('d F Y') }}</td>
                            <td>
                                <span
                                    class="mb-1 badge font-medium bg-light-{{ $journal->status->color() }} text-{{ $journal->status->color() }}">
                                    {{ $journal->status->label() }}
                                </span>
                            </td>
                            <td>{{ \Illuminate\Support\Str::limit($journal->description, 65, '...') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <a type="button" class="text-secondary btn-detail-journal"
                                        data-author="{{ $journal->employee->user->name }}"
                                        data-title="{{ $journal->title }}"
                                        data-date="{{ \Carbon\Carbon::parse($journal->created_at)->translatedFormat('d F Y') }}"
                                        data-description="{{ $journal->description }}">
                                        Lihat Detail
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center align-middle">
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
                Menampilkan {{ $notCompletedJournals->currentPage() }} dari {{ $notCompletedJournals->lastPage() }} halaman
            </div>
            <div>
                <x-paginate-component :paginator="$notCompletedJournals->appends(request()->input())" />
            </div>
        </div>
    </div>
</div>
