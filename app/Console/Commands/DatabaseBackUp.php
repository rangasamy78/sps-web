<?php

namespace App\Console\Commands;

use ZipArchive;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DatabaseBackUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a backup of the database and zip it.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $backupFileName = "backup-{$timestamp}.sql";
        $zipFileName = "backup-{$timestamp}.zip";
        $backupPath = storage_path("app/backup/{$backupFileName}");
        $zipPath = storage_path("app/backup/{$zipFileName}");

        // Ensure the backup directory exists
        $this->ensureBackupDirectoryExists();

        // Create SQL backup
        if ($this->createSqlBackup($backupPath) === false) {
            $this->error('Database backup failed.');
            return;
        }
        $this->info('New DB backup started.');
        Log::info("New DB backup started");

        // Create ZIP archive
        if ($this->createZipArchive($backupPath, $zipPath, $backupFileName) === false) {
            $this->error('Failed to create ZIP archive.');
            return;
        }
        $this->info('Backup successfully created and zipped.');
        Log::info("Backup successfully created and zipped.");

        // Remove the SQL backup file
        $this->removeBackupFile($backupPath);
    }

    /**
     * Ensure the backup directory exists.
     *
     * @return void
     */
    protected function ensureBackupDirectoryExists(): void
    {
        if (!Storage::exists('backup')) {
            Storage::makeDirectory('backup');
        }
    }

    /**
     * Create the SQL backup file.
     *
     * @param string $backupPath
     * @return bool
     */
    protected function createSqlBackup(string $backupPath): bool
    {
        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_HOST'),
            env('DB_DATABASE'),
            $backupPath
        );

        exec($command, $output, $returnVar);
        return $returnVar === 0;
    }

    /**
     * Create a ZIP archive of the SQL backup file.
     *
     * @param string $backupPath
     * @param string $zipPath
     * @param string $backupFileName
     * @return bool
     */
    protected function createZipArchive(string $backupPath, string $zipPath, string $backupFileName): bool
    {
        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            $zip->addFile($backupPath, $backupFileName);
            $zip->close();
            return true;
        }
        return false;
    }

    /**
     * Remove the SQL backup file after creating the ZIP archive.
     *
     * @param string $backupPath
     * @return void
     */
    protected function removeBackupFile(string $backupPath): void
    {
        if (file_exists($backupPath)) {
            unlink($backupPath);
        }
    }
}
