

<div class="table-responsive rounded-2">
    <table class="table border text-nowrap customize-table mb-0 align-middle text-center">
        <thead>
            <tr>
                <th class="text-white" style="background-color: #098FC6;">No</th>
                <th class="text-white" style="background-color: #098FC6;">Penempatan</th>
                <th class="text-white" style="background-color: #098FC6;">Jam</th>
                <th class="text-white" style="background-color: #098FC6;">Mata Pelajaran</th>
                <th class="text-white" style="background-color: #098FC6;">Pengajar</th>
                <th class="text-white" style="background-color: #098FC6;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse (isset($lessonSchedules['sunday']) ? $lessonSchedules['sunday'] : [] as $index => $lessonSchedule)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>Jam ke {{ str_replace('Jam ke ', '', $lessonSchedule->start->name) }} - {{ str_replace('Jam ke ', '', $lessonSchedule->end->name) }}</td>
                    <td>
                        <span class="badge bg-light-info text-info">
                            {{ \Carbon\Carbon::parse($lessonSchedule->start->start)->format('H:i') }} - {{ \Carbon\Carbon::parse( $lessonSchedule->end->end )->format('H:i') }}
                        </span>
                        @php
                            $lessonHours = App\Models\LessonHour::whereBetween('start', [$lessonSchedule->start->start, $lessonSchedule->end->start])
                                ->where('day', 'sunday')
                                ->where('name', 'Istirahat')
                                ->get();
                        @endphp
                        @foreach ( $lessonHours as $lessonHour )
                            <br>
                            <span class="badge bg-light-warning text-warning mt-1">
                                {{ $lessonHour->name }} : {{ $lessonHour->start }} - {{ $lessonHour->end }}
                            </span>
                        @endforeach
                    </td>
                    <td>{{ $lessonSchedule->teacherSubject->subject->name }}</td>
                    <td>{{ $lessonSchedule->teacherSubject->employee->user->name }}</td>
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            <button class="btn btn-light-warning text-warning btn-edit"
                                data-id="{{ $lessonSchedule->id }}"
                                data-subject="{{ $lessonSchedule->teacherSubject->subject->id }}"
                                data-teacher="{{ $lessonSchedule->teacherSubject->employee->id }}"
                                data-start="{{ $lessonSchedule->lesson_hour_start }}"
                                data-end="{{ $lessonSchedule->lesson_hour_end }}"
                                data-day="sunday">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M21 12a1 1 0 0 0-1 1v6a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h6a1 1 0 0 0 0-2H5a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-6a1 1 0 0 0-1-1m-15 .76V17a1 1 0 0 0 1 1h4.24a1 1 0 0 0 .71-.29l6.92-6.93L21.71 8a1 1 0 0 0 0-1.42l-4.24-4.29a1 1 0 0 0-1.42 0l-2.82 2.83l-6.94 6.93a1 1 0 0 0-.29.71m10.76-8.35l2.83 2.83l-1.42 1.42l-2.83-2.83ZM8 13.17l5.93-5.93l2.83 2.83L10.83 16H8Z" />
                                </svg>
                            </button>
                            <button class="btn btn-light-danger text-danger btn-delete" data-id="{{ $lessonSchedule->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6zM8 9h8v10H8zm7.5-5l-1-1h-5l-1 1H5v2h14V4z" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
            @endforelse
        </tbody>
        </tfoot>
    </table>
</div>
