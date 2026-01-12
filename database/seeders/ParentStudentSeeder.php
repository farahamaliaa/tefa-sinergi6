<?php

namespace Database\Seeders;

use App\Models\Parents;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParentStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Get User Parent (create if not exists)
        $userParent = User::whereHas('roles', function($q) {
            $q->where('name', 'parent');
        })->first();

        if (!$userParent) {
            $userParent = User::create([
                'name' => 'Orang Tua Siswa',
                'email' => 'orangtua@gmail.com',
                'password' => bcrypt('password'),
            ]);
            $userParent->assignRole('parent');
        }

        // 2. Create Parent Profile
        $parent = DB::table('parents')->where('user_id', $userParent->id)->first();
        
        if (!$parent) {
            $parentId = DB::table('parents')->insertGetId([
                'user_id' => $userParent->id,
                'name' => 'Orang Tua Siswa',
                'phone_number' => '081234567890',
                'address' => 'Jl. Kebon Jeruk No. 1',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $parent = DB::table('parents')->find($parentId);
        }

        // 3. Get Random Student
        $student = Student::first();
        
        if (!$student) {
            $this->command->info('No student found. Please run StudentSeeder first.');
            return;
        }

        // 4. Attach Student to Parent
        if (!DB::table('parent_students')->where('parent_id', $parent->id)->where('student_id', $student->id)->exists()) {
             DB::table('parent_students')->insert([
                'parent_id' => $parent->id,
                'student_id' => $student->id,
                'created_at' => now(),
                'updated_at' => now(),
             ]);
            $this->command->info("Connected Parent '{$userParent->name}' to Student '{$student->user->name}'");
        } else {
            $this->command->info("Parent '{$userParent->name}' is already connected to Student '{$student->user->name}'");
        }
    }
}
