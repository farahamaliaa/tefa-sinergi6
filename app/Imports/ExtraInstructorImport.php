<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Employee;
use App\Models\Extracurricular;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExtraInstructorImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (empty($row['nama_pembina']) || $row['nama_pembina'] == 'Nama Pembina') {
            return null;
        }

        $email = $row['email'] ?? null;
        $name = $row['nama_pembina'];
        $phoneNumber = $row['nomor_hp'] ?? null;
        $password = $row['password'] ?? 'password123';
        $gender = strtolower($row['jenis_kelamin'] ?? 'male') == 'perempuan' ? 'female' : 'male';
        $address = $row['alamat'] ?? null;
        $extracurricularName = $row['ekstrakurikuler'] ?? null;

        if (!$email) {
            return null;
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            if ($extracurricularName && $user->employee) {
                $extracurricular = Extracurricular::where('name', 'LIKE', "%{$extracurricularName}%")->first();
                if ($extracurricular) {
                    $extracurricular->update(['employee_id' => $user->employee->id]);
                }
            }
            return null;
        }

        $slug = Str::slug($name);
        $count = User::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $user = User::create([
            'name' => $name,
            'slug' => $slug,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'extracurricular',
            'gender' => $gender,
        ]);

        $user->assignRole('extracurricular');

        $employee = Employee::create([
            'user_id' => $user->id,
            'nip' => '000000000000000000',
            'birth_date' => now()->subYears(30)->format('Y-m-d'),
            'birth_place' => '-',
            'nik' => '0000000000000000',
            'phone_number' => $phoneNumber ?? '0000000000000',
            'gender' => $gender,
            'address' => $address ?? '-',
            'status' => 'staff',
            'active' => true,
        ]);

        if ($extracurricularName) {
            $extracurricular = Extracurricular::where('name', 'LIKE', "%{$extracurricularName}%")->first();
            if ($extracurricular) {
                $extracurricular->update(['employee_id' => $employee->id]);
            }
        }

        return null;
    }
}
