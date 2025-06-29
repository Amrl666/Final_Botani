<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database {--type=full : Type of backup (full, incremental)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database and important files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting backup process...');

        try {
            // Create backup directory
            $backupDir = 'backups/' . date('Y-m-d');
            if (!Storage::disk('local')->exists($backupDir)) {
                Storage::disk('local')->makeDirectory($backupDir);
            }

            // Database backup
            $this->backupDatabase($backupDir);

            // File backup
            $this->backupFiles($backupDir);

            // Clean old backups
            $this->cleanOldBackups();

            $this->info('Backup completed successfully!');
            $this->info('Backup location: storage/app/' . $backupDir);

        } catch (\Exception $e) {
            $this->error('Backup failed: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }

    protected function backupDatabase($backupDir)
    {
        $this->info('Backing up database...');

        $filename = 'database_' . date('Y-m-d_H-i-s') . '.sql';
        $filepath = storage_path('app/' . $backupDir . '/' . $filename);

        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');

        $command = "mysqldump -h {$host} -u {$username}";
        
        if ($password) {
            $command .= " -p{$password}";
        }
        
        $command .= " {$database} > {$filepath}";

        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            throw new \Exception('Database backup failed');
        }

        $this->info('Database backup completed: ' . $filename);
    }

    protected function backupFiles($backupDir)
    {
        $this->info('Backing up important files...');

        $filesToBackup = [
            'public/storage' => 'storage',
            '.env' => 'env',
        ];

        foreach ($filesToBackup as $source => $name) {
            if (file_exists($source)) {
                $filename = $name . '_' . date('Y-m-d_H-i-s') . '.zip';
                $filepath = storage_path('app/' . $backupDir . '/' . $filename);

                $zip = new \ZipArchive();
                if ($zip->open($filepath, \ZipArchive::CREATE) === TRUE) {
                    if (is_dir($source)) {
                        $this->addFolderToZip($zip, $source, $name);
                    } else {
                        $zip->addFile($source, basename($source));
                    }
                    $zip->close();
                    $this->info("File backup completed: {$filename}");
                }
            }
        }
    }

    protected function addFolderToZip($zip, $folder, $exclusiveLength)
    {
        $handle = opendir($folder);
        while (false !== $f = readdir($handle)) {
            if ($f != '.' && $f != '..') {
                $filePath = "$folder/$f";
                $localPath = substr($filePath, $exclusiveLength);
                
                if (is_file($filePath)) {
                    $zip->addFile($filePath, $localPath);
                } elseif (is_dir($filePath)) {
                    $zip->addEmptyDir($localPath);
                    $this->addFolderToZip($zip, $filePath, $exclusiveLength);
                }
            }
        }
        closedir($handle);
    }

    protected function cleanOldBackups()
    {
        $this->info('Cleaning old backups...');

        $backupDays = 7; // Keep backups for 7 days
        $cutoffDate = Carbon::now()->subDays($backupDays);

        $backupDirs = Storage::disk('local')->directories('backups');
        
        foreach ($backupDirs as $dir) {
            $dirDate = Carbon::createFromFormat('Y-m-d', basename($dir));
            
            if ($dirDate->lt($cutoffDate)) {
                Storage::disk('local')->deleteDirectory($dir);
                $this->info("Deleted old backup: {$dir}");
            }
        }
    }
}
