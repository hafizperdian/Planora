<?php

// Buat database SQLite di direktori sementara Vercel (/tmp)
$dbPath = '/tmp/database.sqlite';
if (!file_exists($dbPath)) {
    touch($dbPath);
}

// Buat direktori storage sementara agar Laravel tidak crash saat menulis cache/session
$storageDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

$_ENV['APP_STORAGE'] = '/tmp/storage';

require __DIR__ . '/../public/index.php';