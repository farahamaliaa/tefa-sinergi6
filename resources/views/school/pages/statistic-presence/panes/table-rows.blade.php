                @forelse ($attendances as $attendance)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $attendance->model ? $attendance->model->student->user->name : 'siswa tidak ditemukan' }}</td>
                        <td>{{ $attendance->checkin ? Carbon\Carbon::parse($attendance->checkin)->format('H.i') : '-' }}
                        </td>
                        <td>{{ $attendance->checkout ? Carbon\Carbon::parse($attendance->checkout)->format('H.i') : '-' }}
                        </td>
                        <td>{{ $attendance->point }}</td>
                        <td>
                            <span class="badge {{ $attendance->status->color() }}">
                                {{ $attendance->status->label() }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center align-middle">
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt=""
                                    width="300px">
                                <p class="fs-5 text-dark text-center mt-2">
                                    Tidak ada kehadiran siswa
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
