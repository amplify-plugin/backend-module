<?php

namespace Amplify\System\Backend\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

trait ZipperTrait
{
    public function defaultZipFileName()
    {
        return time().'-backup-'.date('Y-m-d').'.zip';
    }

    public function defaultPathToZip()
    {
        return storage_path('app/backups');
    }

    public function takeStorageBackup($folderToZip, ?string $zipFileName = null)
    {
        $zipFileName = $zipFileName ?? $this->defaultZipFileName();
        $result = $this->createZipFromFolder($folderToZip, $zipFileName);

        $localZipPath = storage_path('app/backups/'.$zipFileName);
        if ($result === 'success') {
            try {
                foreach (config('backup.backup.destination.disks') as $disk_name) {
                    $disk = Storage::disk($disk_name);
                    $disk->put($zipFileName, file_get_contents($localZipPath));
                }

                File::delete($localZipPath);

                return 'success';
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        return $result;
    }

    public function createZipFromFolder($folderToZip, ?string $zipFileName = null, ?string $pathToZip = null)
    {
        $zipFileName = $zipFileName ?? $this->defaultZipFileName();
        $pathToZip = $pathToZip ?? $this->defaultPathToZip();
        $zipFileName = $pathToZip.'/'.$zipFileName;

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($folderToZip),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        return $this->addFilesToZip($zipFileName, $files, $folderToZip);
    }

    public function addFilesToZip(string $zipFileName, $filesToZip, ?string $rootPath = null)
    {
        try {
            $zip = new ZipArchive;
            $zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);

            foreach ($filesToZip as $file) {
                // Skip directories (they would be added automatically)
                if (! $file->isDir()) {
                    // Get real and relative path for current file
                    $filePath = $file->getRealPath();
                    $explodedRootPath = explode(DIRECTORY_SEPARATOR, $rootPath);
                    $dirName = end($explodedRootPath);
                    $relativePath = substr($filePath, strrpos($filePath, $dirName));

                    // Add current file to archive
                    $zip->addFile($filePath, $relativePath);
                }
            }
            $zip->close();

            return 'success';
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
