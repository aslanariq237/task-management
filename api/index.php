<?php

// Paksa Laravel membuat folder temporary untuk views dan cache di Vercel
$storageFolders = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/bootstrap/cache'
];

foreach ($storageFolders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }
}

// Set env agar compiler view mengarah ke folder tmp tersebut
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');

// Jalankan Laravel seperti biasa
require __DIR__ . '/../public/index.php';