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
        'latitude' => env('SCHOOL_LATITUDE', -8.2482),
        'longitude' => env('SCHOOL_LONGITUDE', 113.4969),
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
        'check_in_start' => '06:00',  // Waktu mulai bisa absen
        'check_in_end' => '08:00',    // Batas waktu absen tepat waktu
        'late_limit' => '09:00',      // Batas waktu absen telat
        'check_out_start' => '14:00', // Waktu mulai bisa checkout
    ],
];
