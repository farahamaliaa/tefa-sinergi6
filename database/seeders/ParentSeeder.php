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
        Parents::create([
            'id' => '5',
            'user_id' => '5',
            'name' => 'Bapak Dani',
            'phone_number' => '080212121',
            'address' => 'Jember'
        ]);
    }
}
