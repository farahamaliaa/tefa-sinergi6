@extends('school.layouts.app')

@section('content')
<h3>Data Orang Tua</h3>
<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>HP</th>
            <th>Anak</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($parents as $parent)
        <tr>
            <td>{{ $parent['name'] }}</td>
            <td>{{ $parent['phone'] }}</td>
            <td>
                @foreach ($parent['students'] as $student)
                    {{ $student['name'] }} <br>
                @endforeach
            </td>
            <td>
                <!-- contoh button detach / attach -->
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
