<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rfid;

class RfidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rfids = [
            'A1B2C3D4E5',
            '001122334455',
            'ABCDEF123456',
            '1234567890AB',
            'RFID0001',
            'RFID0002',
            'RFID0003',
        ];

        foreach ($rfids as $code) {
            Rfid::firstOrCreate(['rfid' => $code]);
        }
    }
}
