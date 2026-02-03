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
        'latitude' => env('SCHOOL_LATITUDE', -8.155195),
        'longitude' => env('SCHOOL_LONGITUDE', 113.435391),
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
        'check_in_start' => '05:00',  // Waktu mulai bisa absen
        'check_in_end' => '07:00',    // Batas waktu absen tepat waktu (setelah ini = telat)
        'late_limit' => '09:00',      // Batas waktu absen telat (setelah ini ditolak)
        'check_out_start' => '14:00', // Waktu mulai bisa checkout
        'check_out_end' => '17:00',   // Batas waktu checkout
    ],
];
