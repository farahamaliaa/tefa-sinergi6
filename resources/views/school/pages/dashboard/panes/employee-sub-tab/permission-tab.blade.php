<div class="table-responsive rounded-3 mb-4" style="max-height: 400px; overflow-y: auto;">
    <table class="table border text-nowrap customize-table mb-0 align-middle text-center">
        <thead class="text-dark fs-4" style="position: sticky; top: 0; background-color: #0896d1;">
            <tr class="">
                <th class="fs-4 fw-semibold mb-0" style="background-color: #0896d1; color: white">No</th>
                <th class="fs-4 fw-semibold mb-0" style="background-color: #0896d1; color: white">Nama</th>
                <th class="fs-4 fw-semibold mb-0" style="background-color: #0896d1; color: white">NIP</th>
                <th class="fs-4 fw-semibold mb-0" style="background-color: #0896d1; color: white">Jam</th>
                <th class="fs-4 fw-semibold mb-0" style="background-color: #0896d1; color: white">Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $merged_teacher = $sick_teacher->merge($permit_teacher);
            @endphp
            @forelse ($merged_teacher as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->model->user->name ?? '-' }}</td>
                    <td>{{ $item->model->nip ?? '-' }}</td>
                    <td>{{ $item->checkin ? \Carbon\Carbon::parse($item->checkin)->format('H.i') : '-' }}</td>
                    <td>
                        <span class="badge {{ $item->status->color() }} fw-semibold fs-2">{{ $item->status->label() }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center align-middle">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt="" width="300px">
                            <p class="fs-5 text-dark text-center mt-2">Belum ada data</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
