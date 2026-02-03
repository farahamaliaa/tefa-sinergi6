<?php

namespace Database\Seeders;

use App\Models\Parents;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Account 1: parent@gmail.com
        $user1 = User::updateOrCreate(
            ['email' => 'parent@gmail.com'],
            [
                'name' => 'parent',
                'slug' => 'parent',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $user1->assignRole('parent');

        Parents::updateOrCreate(
            ['user_id' => $user1->id],
            [
                'name' => 'parent',
                'phone_number' => '080212121',
                'address' => 'Jember'
            ]
        );

        // Account 2: parent2@gmail.com
        $user2 = User::updateOrCreate(
            ['email' => 'parent2@gmail.com'],
            [
                'name' => 'parent2',
                'slug' => 'parent2',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $user2->assignRole('parent');

        Parents::updateOrCreate(
            ['user_id' => $user2->id],
            [
                'name' => 'parent2',
                'phone_number' => '08123456789',
                'address' => 'Sukun, Malang'
            ]
        );
    }
}
