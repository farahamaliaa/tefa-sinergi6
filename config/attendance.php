<?php

return [
    /*
    |--------------------------------------------------------------------------
    | School Location Configuration
    |--------------------------------------------------------------------------
    |
    | Koordinat lokasi sekolah untuk validasi absensi GPS
    | SMKN 6 Jember - Jl. PB. Sudirman No. 114 Tanggul - Jember
    |
    */

    'school' => [
        'latitude' => env('SCHOOL_LATITUDE', -7.900010),
        'longitude' => env('SCHOOL_LONGITUDE', 112.606749),
        'radius' => env('SCHOOL_RADIUS', 200), // dalam meter
        'name' => 'SMKN 6 Jember',
        'address' => 'Jl. PB. Sudirman No. 114 Tanggul - Jember',
    ],

    /*
    |--------------------------------------------------------------------------
    | Attendance Time Rules
    |--------------------------------------------------------------------------
    |
    | Aturan waktu untuk menentukan status absensi
    |
    */

    'time' => [
        'check_in_start' => '11:00',  // Waktu mulai bisa absen
        'check_in_end' => '15:00',    // Batas waktu absen tepat waktu (setelah ini = telat)
        'late_limit' => '15:00',      // Batas waktu absen telat (setelah ini ditolak)
        'check_out_start' => '18:00', // Waktu mulai bisa checkout
        'check_out_end' => '20:00',   // Batas waktu checkout
    ],
];
