<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\ClassroomStudent;
use App\Models\Classroom;
use Illuminate\Support\Str;
use App\Models\Religion;
use App\Models\Student;
use App\Enums\RoleEnum;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class StudentImport implements ToModel
{
    public function model(array $row)
    {
        if (in_array($row[0], ['Nama', 'Contoh Format(Jangan Dihapus)']) || $row[0] == null) {
            return null;
        }

        $user = User::where('email', $row[1])->first();

        if ($user) {
            return null;
        }

        $user = User::create([
            'name' => $row[0] ?? null,
            'email' => $row[1],
            'slug' => Str::slug($row[0]),
            'password' => Hash::make($row[2])
        ]);

        $user->assignRole(RoleEnum::STUDENT->value);

        $birthDate = $row[3] ? Carbon::instance(Date::excelToDateTimeObject($row[3])) : null;

        $religion = Religion::where('name', $row[12])->first();
        if (!$religion) {
            $user->delete();
            return null;
        }

        $data = [
            'user_id' => $user->id,
            'nisn' => $row[2],
            'religion_id' => $religion->id,
            'gender' => $row[5] == 'Laki-laki' ? 'male' : 'female',
            'birth_date' => $birthDate,
            'birth_place' => $row[4],
            'address' => $row[9],
            'nik' => $row[6],
            'number_kk' => $row[7],
            'number_akta' => $row[8],
            'order_child' => $row[10],
            'count_siblings' => $row[11]
        ];

        if (in_array(null, $data)) {
            $user->delete();
            return null;
        }

        $student = Student::create($data);

        $classroomName = $row[13] ?? null;
        $classroom = Classroom::where('name', $classroomName)->first();

        if (!$classroom) {
            $user->delete();
            $student->delete();
            return null;
        }

        ClassroomStudent::create([
            'student_id' => $student->id,
            'classroom_id' => $classroom->id,
        ]);
    }
}
