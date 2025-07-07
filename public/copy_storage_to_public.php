<?php
// Jalankan script ini sekali saja dari browser: https://namadomain.com/copy_storage_to_public.php
// Setelah selesai, HAPUS file ini demi keamanan!

function copyDir($src, $dst) {
    $dir = opendir($src);
    @mkdir($dst, 0755, true);
    while(false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                copyDir($src . '/' . $file, $dst . '/' . $file);
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

$src = realpath(__DIR__ . '/../storage/app/public');
$dst = __DIR__ . '/storage';

if (!is_dir($src)) {
    die('Source folder tidak ditemukan: ' . $src);
}

copyDir($src, $dst);
echo "<h2>Copy selesai!</h2><p>Semua file dari <b>$src</b> sudah dicopy ke <b>$dst</b>.</p><p><b>HAPUS file ini sekarang demi keamanan!</b></p>"; 