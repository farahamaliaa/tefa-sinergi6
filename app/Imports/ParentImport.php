<?php

namespace App\Imports;

use App\Models\Parents;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ParentImport implements ToModel, WithHeadingRow
{
    protected $createdParents = [];

    public function model(array $row)
    {
        if (empty($row['nama_orang_tua']) || $row['nama_orang_tua'] == 'Nama Orang Tua') {
            return null;
        }

        $email = $row['email'] ?? null;
        $parentName = $row['nama_orang_tua'];
        $childName = $row['nama_anak'] ?? null;
        $phoneNumber = $row['nomor_hp'] ?? null;
        $password = $row['password'] ?? 'password123';
        $gender = strtolower($row['jenis_kelamin'] ?? 'male') == 'perempuan' ? 'female' : 'male';

        $user = null;
        $parent = null;

        if ($email) {
            $user = User::where('email', $email)->first();
        }

        if ($user) {
            $parent = Parents::where('user_id', $user->id)->first();
        } else {
            if (!$email) {
                return null;
            }

            $slug = Str::slug($parentName);
            $count = User::where('slug', 'LIKE', "{$slug}%")->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }

            $user = User::create([
                'name' => $parentName,
                'slug' => $slug,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'parent',
                'gender' => $gender,
            ]);

            $user->assignRole('parent');

            $parent = Parents::create([
                'user_id' => $user->id,
                'name' => $parentName,
                'phone_number' => $phoneNumber,
            ]);
        }

        if ($childName && $parent) {
            $student = Student::whereHas('user', function($query) use ($childName) {
                $query->where('name', 'LIKE', "%{$childName}%");
            })->first();

            if ($student) {
                $parent->students()->syncWithoutDetaching([$student->id]);
            }
        }

        return null;
    }
}
