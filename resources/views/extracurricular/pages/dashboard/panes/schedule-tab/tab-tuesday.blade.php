<div class="table-responsive rounded-2">
    <table class="table border text-nowrap customize-table mb-0 align-middle">
        <thead>
            <tr>
                <th class="text-white" style="background-color: #098FC6;">No</th>
                <th class="text-white" style="background-color: #098FC6;">Hari</th>
                <th class="text-white" style="background-color: #098FC6;">Ekstrakulikuler</th>
                <th class="text-white" style="background-color: #098FC6;">Lokasi</th>
                <th class="text-white" style="background-color: #098FC6;">Waktu</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($schedules['tuesday']))
                @foreach ($schedules['tuesday'] as $schedule)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ ucfirst(App\Enums\DayEnum::tryFrom($schedule->day)?->label() ?? $schedule->day) }}</td>
                        <td>{{ $schedule->extracurricular->name }}</td>
                        <td>{{ $schedule->location_name ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center align-middle">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt=""
                                width="300px">
                            <p class="fs-5 text-dark text-center mt-2">
                                Belum ada jadwal
                            </p>
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
