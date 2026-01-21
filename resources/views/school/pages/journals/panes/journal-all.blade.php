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
        <h4 class="fw-semibold mb-4">Daftar Jurnal Guru</h4>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
            <form class="d-flex flex-wrap gap-2 align-items-center" method="GET">
                <div class="position-relative">
                    <i class="ti ti-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" name="search" class="form-control ps-5" placeholder="Cari" style="min-width: 250px;"
                        value="{{ old('search', request()->input('search')) }}">
                </div>
                <div>
                    <select name="status" class="form-select" id="search-status" style="min-width: 120px;">
                        <option value="" {{ old('status', request('status')) == '' ? 'selected' : '' }}>Semua</option>
                        <option value="filled" {{ old('status', request('status')) == 'filled' ? 'selected' : '' }}>Mengisi</option>
                        <option value="not_filled" {{ old('status', request('status')) == 'not_filled' ? 'selected' : '' }}>Tidak Mengisi</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
            <div class="mt-2 mt-md-0">
                <a href="{{ route('school.export-journal.index') }}" class="btn btn-import">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.5 18.75L21.4395 17.6895L19.5 19.629V13.5H18V19.629L16.0605 17.6895L15 18.75L18.75 22.5L22.5 18.75Z" fill="white"/>
                        <path d="M13.5 20.9999H6V2.99986H12V7.49986C12.0012 7.89732 12.1596 8.27816 12.4407 8.55921C12.7217 8.84025 13.1025 8.99867 13.5 8.99986H18V11.2499H19.5V7.49986C19.5026 7.40129 19.4839 7.30332 19.4451 7.21269C19.4062 7.12206 19.3482 7.04092 19.275 6.97486L14.025 1.72486C13.9593 1.65125 13.8782 1.59296 13.7875 1.55409C13.6968 1.51521 13.5986 1.4967 13.5 1.49986H6C5.60254 1.50104 5.2217 1.65946 4.94065 1.94051C4.6596 2.22156 4.50119 2.6024 4.5 2.99986V20.9999C4.50119 21.3973 4.6596 21.7782 4.94065 22.0592C5.2217 22.3403 5.60254 22.4987 6 22.4999H13.5V20.9999ZM13.5 3.29986L17.7 7.49986H13.5V3.29986Z" fill="white"/>
                    </svg>
                    Download Jurnal
                </a>
            </div>
        </div>

        <div class="table-responsive rounded-2">
            <table class="table border text-nowrap customize-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="background-color: #0896D1;" class="text-white">No</th>
                        <th style="background-color: #0896D1;" class="text-white">Nama Guru</th>
                        <th style="background-color: #0896D1;" class="text-white">Tanggal</th>
                        <th style="background-color: #0896D1;" class="text-white">Kelas</th>
                        <th style="background-color: #0896D1;" class="text-white">Waktu</th>
                        <th style="background-color: #0896D1;" class="text-white">Status</th>
                        <th style="background-color: #0896D1;" class="text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($all_journals as $all_journal)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-start">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $all_journal->teacherSubject->employee->image ? asset('storage/' . $all_journal->teacherSubject->employee->image) : asset('admin_assets/dist/images/profile/user-10.jpg') }}"
                                        class="rounded-circle me-2 user-profile" style="object-fit: cover"
                                        width="40" height="40" alt="" />
                                    <div class="ms-2">
                                        <h6 class="fs-4 fw-semibold mb-0 text-start">
                                            {{ $all_journal->teacherSubject->employee->user->name }}</h6>
                                        <span
                                            class="fw-normal">{{ $all_journal->teacherSubject->employee->user->modelHasRfid ? $all_journal->teacherSubject->employee->user->modelHasRfid->rfid : 'Tidak ada rfid' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($all_journal->created_at)->translatedFormat('d F Y') }}</td>
                            <td>{{ $all_journal->classroom->name }}</td>
                            <td>
                                @if($all_journal->start && $all_journal->end)
                                    @php
                                        $startNum = preg_replace('/[^0-9]/', '', $all_journal->start->name);
                                        $endNum = preg_replace('/[^0-9]/', '', $all_journal->end->name);
                                    @endphp
                                    Jam ke {{ $startNum }}-{{ $endNum }}
                                @else
                                    -
                                @endif
                            </td>
                            <!-- <td>{{ $all_journal->teacherJournals->first() ? \Illuminate\Support\Str::limit($all_journal->teacherJournals->first()->description, 50) : 'kosong..' }}</td> -->
                            <td><span
                                    class="mb-1 badge font-medium {{ $all_journal->teacherJournals->first() ? 'bg-light-success text-success' : 'bg-light-danger text-danger' }}">{{ $all_journal->teacherJournals->first() ? 'Mengisi' : 'Tidak Mengisi' }}</span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <button type="button" class="btn btn-primary btn-detail-journal"
                                        data-author="{{ $all_journal->teacherSubject->employee->user->name }}"
                                        data-date="{{ \Carbon\Carbon::parse($all_journal->created_at)->translatedFormat('d F Y') }}"
                                        data-description="{{ $all_journal->teacherJournals->first() ? $all_journal->teacherJournals->first()->description : 'kosong...' }}"
                                        data-classroom="{{ $all_journal->classroom->name }} - {{ $all_journal->teacherSubject->subject->name }}">
                                        Lihat Detail
                                    </button>
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
                Menampilkan {{ $all_journals->currentPage() }} dari {{ $all_journals->lastPage() }} halaman
            </div>
            <div>
                <x-paginate-component :paginator="$all_journals" />
            </div>
        </div>  
    </div>
</div>
