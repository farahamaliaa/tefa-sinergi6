<?php

namespace Database\Seeders;

use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::create([
            'id' => '1',
            'nip' => '123456789101234567',
            'birth_date' => now(),
            'birth_place' => 'Malang',
            'gender' => GenderEnum::MALE->value,
            'nik' => '12345678910123',
            'phone_number' => '00000000000',
            'address' => 'Permata Regency',
            'status' => RoleEnum::TEACHER->value,
            'active' => '1',
            'user_id' => '2',
            'religion_id' => '1',
        ]);

        Employee::create([
            'id' => '2',
            'nip' => '123456789101234567',
            'birth_date' => now(),
            'birth_place' => 'Malang',
            'gender' => GenderEnum::MALE->value,
            'nik' => '12345678910123',
            'phone_number' => '00000000000',
            'address' => 'Permata Regency',
            'status' => RoleEnum::STAFF->value,
            'active' => '1',
            'user_id' => '4',
            'religion_id' => '1',
            'position' => 'ketua_tu',
        ]);

        // Create Staff Biasa Employee (User ID retrieved dynamically or assumed)
        $staffBiasaUser = \App\Models\User::where('email', 'staff2@gmail.com')->first();
        if ($staffBiasaUser) {
            Employee::create([
                'id' => '3',
                'nip' => '123456789101234568',
                'birth_date' => now(),
                'birth_place' => 'Malang',
                'gender' => GenderEnum::FEMALE->value,
                'nik' => '12345678910124',
                'phone_number' => '081234567890',
                'address' => 'Sukun, Malang',
                'status' => RoleEnum::STAFF->value,
                'active' => '1',
                'user_id' => $staffBiasaUser->id,
                'religion_id' => '1',
                'position' => 'staff_biasa',
            ]);
        }
    }
}
