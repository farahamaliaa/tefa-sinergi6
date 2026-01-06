<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WhatsApp API Provider
    |--------------------------------------------------------------------------
    |
    | Supported: "fonnte", "log" (for testing without sending)
    |
    */
    'provider' => env('WHATSAPP_API_PROVIDER', 'fonnte'),

    /*
    |--------------------------------------------------------------------------
    | Fonnte Configuration
    |--------------------------------------------------------------------------
    */
    'fonnte' => [
        'token' => env('FONNTE_TOKEN', ''),
        'url' => env('FONNTE_URL', 'https://api.fonnte.com/send'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Attendance Recap Settings
    |--------------------------------------------------------------------------
    */
    'recap' => [
        'enabled' => env('ATTENDANCE_RECAP_ENABLED', true),
        'send_time' => env('ATTENDANCE_RECAP_TIME', '08:00'),
    ],
];
