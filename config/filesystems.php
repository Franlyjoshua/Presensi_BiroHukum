<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    */

    'disks' => [

        'public_uploads' => [ // Pastikan nama ini sudah benar (bukan 'public_uplouds')
            'driver' => 'local',
            'root' => public_path('uploads'), // File disimpan di project_root/public/uploads/
            'url' => env('APP_URL') . '/uploads', // <-- TAMBAHKAN ATAU PERBAIKI BARIS INI
            'visibility' => 'public', // Pastikan file dapat diakses publik
            'throw' => false,
        ],

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'), // Diubah ke root standar disk local
            // 'root' => storage_path('app/private'), // Path Anda sebelumnya
            'throw' => false,
            // Hapus 'serve' dan 'report' jika tidak digunakan atau menyebabkan error di versi Laravel Anda
            // 'serve' => true,
            // 'report' => false,
        ],

        'public' => [ // Ini adalah disk standar Laravel untuk file di storage/app/public
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage', // Diakses melalui /storage setelah storage:link
            'visibility' => 'public',
            'throw' => false,
            // 'report' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            // 'report' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    */

    'links' => [
        public_path('storage') => storage_path('app/public'), // Ini untuk disk 'public' standar
    ],

];
