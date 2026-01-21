    <h4 class="mb-3">Jam Pelajaran</h4>
    <div class="table-responsive rounded-2">
        <form action="{{ route('school.lesson-hours.bulk-destroy') }}" method="POST">
            @csrf
            @method('DELETE')
            <table class="table border text-nowrap customize-table mb-0 align-middle">
            <thead>
                <tr>
                    <th class="text-white" style="background-color: #0896D1;">No</th>
                    <th class="text-white" style="background-color: #0896D1;">Jam</th>
                    <th class="text-white" style="background-color: #0896D1;">Penempatan</th>
                    <th class="text-white" style="background-color: #0896D1;">Keterangan</th>
                    <th class="text-white" style="background-color: #0896D1;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lessonHours['sunday'] ?? [] as $index => $lessonHour)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @php
                                $badgeClass = 'bg-light-secondary text-secondary';
                                if ($lessonHour->name == 'Istirahat') {
                                    $badgeClass = 'bg-light-danger text-danger';
                                } elseif ($lessonHour->name == 'Upacara') {
                                    $badgeClass = 'bg-light-warning text-warning';
                                } elseif ($lessonHour->name == 'Literasi') {
                                    $badgeClass = 'bg-light-success text-success';
                                }
                            @endphp
                            <span class="badge {{ $badgeClass }}">
                                {{ date('H:i', strtotime($lessonHour->start)) }} - {{ date('H:i', strtotime($lessonHour->end)) }}
                            </span>
                        </td>
                        <td>{{ $lessonHour->name }}</td>
                        <td>
                            @if($lessonHour->name == 'Upacara')
                                <span class="badge bg-light-warning text-warning">Upacara Bendera</span>
                            @elseif($lessonHour->name == 'Literasi')
                                <span class="badge bg-light-success text-success">Literasi Religi</span>
                            @elseif($lessonHour->name == 'Istirahat')
                                <span class="badge bg-light-danger text-danger">Istirahat</span>
                            @else
                                <span class="text-dark">Pembelajaran</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="form-check mb-0">
                                    <input class="form-check-input form-secondary" type="checkbox" name="ids[]" value="{{ $lessonHour->id }}" id="check-{{ $lessonHour->id }}">
                                </div>
                                <button class="btn btn-sm btn-light-warning text-warning btn-edit" data-bs-toggle="modal" data-bs-target="#modal-update" data-id="{{ $lessonHour->id }}" data-name="{{ $lessonHour->name }}" data-start="{{ $lessonHour->start }}" data-end="{{ $lessonHour->end }}">
                                    <i class="ti ti-pencil fs-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center align-middle">
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt=""
                                    width="300px">
                                <p class="fs-5 text-dark text-center mt-2">
                                    Jam Pelajaran belum ditambahkan
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                @if (isset($lessonHours['sunday']) && count($lessonHours['sunday']) > 0)
                    <tr>
                        <td colspan="5">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-danger">
                                    <i class="ti ti-trash me-2"></i>Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @endif
            </tfoot>
        </table>
        </form>
    </div>
