<?php

namespace Amplify\System\Backend\Jobs\ProductImage;

use Amplify\System\Backend\Models\ProductImageFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ScanScanningFolderToTableJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 3600;

    public int $tries = 2;

    public function __construct(public bool $rebuild = false) {}

    public function handle(): void
    {
        $diskName = config('amplify.pim.product_images.disk', 'uploads');
        $disk = Storage::disk($diskName);

        $scanningFolder = trim(config('amplify.pim.product_images.scanning_folder'), '/');

        if (empty($scanningFolder)) {
            return;
        }

        $allowedExt = array_map(
            'strtolower',
            config('amplify.pim.product_images.allowed_ext', ['jpg', 'jpeg', 'png', 'webp', 'gif'])
        );
        $chunkSize = (int) config('amplify.pim.product_images.scan_file_chunk', 2000);

        if (! $disk->exists($scanningFolder)) {
            Log::warning('Scanning folder does not exist', [
                'disk' => $diskName,
                'scanning' => $scanningFolder,
            ]);

            return;
        }

        if ($this->rebuild) {
            ProductImageFile::truncate();

            Log::info('product_image_files truncated before rebuild scan', [
                'disk' => $diskName,
                'scanning' => $scanningFolder,
            ]);
        }

        $allFiles = $disk->allFiles($scanningFolder);

        $buffer = [];
        $seen = 0;
        $changed = 0;
        $skipped = 0;
        $deletedDotFiles = 0;

        foreach ($allFiles as $path) {
            $basename = basename($path);

            // Delete macOS metadata files immediately
            if (str_starts_with($basename, '._')) {
                try {
                    $disk->delete($path);
                    $deletedDotFiles++;
                } catch (\Throwable $e) {
                    Log::warning('Failed to delete dot-underscore file', [
                        'disk' => $diskName,
                        'path' => $path,
                        'error' => $e->getMessage(),
                    ]);
                }

                $skipped++;

                continue;
            }

            if ($this->shouldSkipFile($basename)) {
                $skipped++;

                continue;
            }

            $ext = strtolower(pathinfo($basename, PATHINFO_EXTENSION));

            if (! in_array($ext, $allowedExt, true)) {
                $skipped++;

                continue;
            }

            $nameNoExt = trim(pathinfo($basename, PATHINFO_FILENAME));

            if ($this->shouldSkipName($nameNoExt)) {
                $skipped++;

                continue;
            }

            [$code, $kind, $variant] = $this->parseCodeKindAndVariant($nameNoExt);

            if ($code === '') {
                $skipped++;

                continue;
            }

            $buffer[] = $path;
            $seen++;

            if (count($buffer) >= $chunkSize) {
                $changed += $this->processPathChunk($diskName, $buffer);
                $buffer = [];
            }
        }

        if (! empty($buffer)) {
            $changed += $this->processPathChunk($diskName, $buffer);
        }

        Log::info('Scanning scan completed', [
            'disk' => $diskName,
            'scanning' => $scanningFolder,
            'rebuild' => $this->rebuild,
            'files_seen' => $seen,
            'files_skipped' => $skipped,
            'rows_changed_or_added' => $changed,
            'deleted_dot_files' => $deletedDotFiles,
        ]);
    }

    private function processPathChunk(string $diskName, array $paths): int
    {
        $disk = Storage::disk($diskName);
        $now = now();

        $existing = ProductImageFile::query()
            ->select(['path', 'mtime', 'size'])
            ->whereIn('path', $paths)
            ->get();

        $existingMap = [];
        foreach ($existing as $row) {
            $existingMap[$row->path] = [
                'mtime' => (int) ($row->mtime ?? 0),
                'size' => (int) ($row->size ?? 0),
            ];
        }

        $rowsToUpsert = [];
        $changedCount = 0;

        foreach ($paths as $path) {
            $basename = basename($path);

            if ($this->shouldSkipFile($basename)) {
                continue;
            }

            $nameNoExt = trim(pathinfo($basename, PATHINFO_FILENAME));

            if ($this->shouldSkipName($nameNoExt)) {
                continue;
            }

            [$code, $kind, $variant] = $this->parseCodeKindAndVariant($nameNoExt);

            if ($code === '') {
                continue;
            }

            try {
                $mtime = (int) $disk->lastModified($path);
            } catch (\Throwable $e) {
                $mtime = 0;
            }

            try {
                $size = (int) $disk->size($path);
            } catch (\Throwable $e) {
                $size = 0;
            }

            $old = $existingMap[$path] ?? null;
            $isChanged = ! $old || $old['mtime'] !== $mtime || $old['size'] !== $size;

            if (! $isChanged) {
                continue;
            }

            $rowsToUpsert[] = [
                'code' => $code,
                'path' => $path,
                'kind' => $kind,
                'variant' => $variant !== '' ? $variant : null,
                'size' => $size ?: null,
                'mtime' => $mtime ?: null,
                'updated_at' => $now,
                'created_at' => $now,
            ];

            $changedCount++;
        }

        if (! empty($rowsToUpsert)) {
            ProductImageFile::upsert(
                $rowsToUpsert,
                ['path'],
                ['code', 'kind', 'variant', 'size', 'mtime', 'updated_at']
            );
        }

        return $changedCount;
    }

    private function shouldSkipFile(string $basename): bool
    {
        return $basename === ''
            || $basename === '.'
            || $basename === '..';
    }

    private function shouldSkipName(string $nameNoExt): bool
    {
        if ($nameNoExt === '') {
            return true;
        }

        return (bool) preg_match('/\s*-\s*Copy$/i', $nameNoExt);
    }

    /**
     * Returns: [code, kind, variant]
     *
     * Supported filename formats:
     *
     * Main image:
     *   PRODUCTCODE
     *   e.g.
     *     76-038
     *
     * Additional images:
     *   PRODUCTCODE_VARIANT
     *   e.g.
     *     76-038_A
     *     76-038_B
     *     76-038_C
     *     76-038_01
     *     76-038_FRONT
     *
     * Notes:
     * - Files prefixed with "._" are macOS metadata (AppleDouble) files.
     * - These files are deleted during the scanning scan and are never processed.
     * - Additional images are identified only by the "_VARIANT" suffix.
     */
    private function parseCodeKindAndVariant(string $nameNoExt): array
    {
        $nameNoExt = trim($nameNoExt);

        if ($nameNoExt === '') {
            return ['', 'main', ''];
        }

        // PRODUCTCODE_A
        if (preg_match('/^(.+)_([A-Z0-9]+)$/i', $nameNoExt, $matches)) {
            $code = trim($matches[1]);
            $variant = strtoupper($matches[2]);

            if ($code !== '') {
                return [$code, 'additional', $variant];
            }
        }

        // PRODUCTCODE
        return [$nameNoExt, 'main', ''];
    }
}
