<?php

namespace Amplify\System\Backend\Services;

use Amplify\System\Backend\Models\Product;
use Amplify\System\Backend\Models\ProductImage;
use Amplify\System\Backend\Models\ProductImageFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductImageProcessor
{
    private $disk;

    private string $baseUrl;

    private string $outputBase;

    private string $productCodeCol;

    public function __construct()
    {
        $diskName = config('amplify.pim.product_images.disk', 'uploads');

        $this->disk = Storage::disk($diskName);
        $this->baseUrl = rtrim($this->disk->url('/'), '/');
        $this->outputBase = trim(config('amplify.pim.product_images.output_base_folder', 'images/products'), '/');
        $this->productCodeCol = config('amplify.pim.product_images.product_code_column', 'product_code');

        $this->ensureDirectory();
    }

    public function process(array $codes): void
    {
        $codes = $this->normalizeCodes($codes);
        if (empty($codes)) {
            return;
        }

        [$productMap, $existingImages] = $this->loadProducts($codes);
        [$mainMap, $additionalMap] = $this->loadImageMaps($codes);

        $upserts = [];

        foreach ($codes as $code) {
            $result = $this->processSingle($code, $productMap, $existingImages, $mainMap, $additionalMap);

            if (! $result) {
                continue;
            }

            $upserts[] = $result;
        }

        if (empty($upserts)) {
            return;
        }

        ProductImage::query()->upsert(
            $upserts,
            ['product_id'],
            ['main', 'additional', 'updated_at']
        );
    }

    // =========================
    // CORE PROCESSING
    // =========================

    private function processSingle(string $code, array $productMap, $existingImages, $mainMap, $additionalMap): ?array
    {
        $productId = $productMap[$code] ?? null;

        if (! $productId) {
            Log::warning("Product not found: {$code}");

            return null;
        }

        $existing = $existingImages[$productId] ?? null;

        $main = $this->processMain($code, $mainMap[$code] ?? null) ?? $existing->main ?? null;

        $additional = $this->processAdditional(
            $code,
            $additionalMap[$code] ?? [],
            $existing->additional ?? null
        );

        if (! $main && ! $additional) {
            return null;
        }

        return [
            'product_id' => $productId,
            'main' => $main,
            'additional' => $additional,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    private function processMain(string $code, ?string $src): ?string
    {
        if (! $src) {
            return null;
        }
        if (! $this->disk->exists($src)) {
            Log::warning('Main missing', compact('code', 'src'));

            return null;
        }

        $dest = "{$this->outputBase}/{$code}.jpg";

        if (! $this->disk->move($src, $dest)) {
            Log::warning('Main move failed', compact('code', 'src', 'dest'));

            return null;
        }

        return "{$this->baseUrl}/{$dest}";
    }

    private function processAdditional(string $code, array $list, $existingJson): ?string
    {
        // ProductImage casts `additional` to array, so existing values may already be arrays.
        $existingEncoded = $this->encodeAdditional($existingJson);

        if (empty($list)) {
            return $existingEncoded;
        }

        $newUrls = [];

        foreach ($list as $item) {
            $url = $this->moveAdditional($code, $item['path'], $item['variant']);

            if ($url) {
                $newUrls[] = $url;
            }
        }

        if (empty($newUrls)) {
            return $existingEncoded;
        }

        return $this->encodeAdditional(
            $this->mergeUrls($this->decode($existingJson), $newUrls)
        );
    }

    private function moveAdditional(string $code, string $src, string $variant): ?string
    {
        if (! $this->disk->exists($src)) {
            Log::warning('Additional missing', compact('code', 'src'));

            return null;
        }

        $dest = $variant === ''
            ? "{$this->outputBase}/._{$code}.jpg"
            : "{$this->outputBase}/._{$code}_{$variant}.jpg";

        if (! $this->disk->move($src, $dest)) {
            Log::warning('Additional move failed', compact('code', 'src', 'dest'));

            return null;
        }

        return "{$this->baseUrl}/{$dest}";
    }

    // =========================
    // DATA LOADERS
    // =========================

    private function loadProducts(array $codes): array
    {
        $products = Product::query()
            ->select(['id', $this->productCodeCol])
            ->whereIn($this->productCodeCol, $codes)
            ->get();

        $map = [];
        foreach ($products as $p) {
            $map[trim($p->{$this->productCodeCol})] = $p->id;
        }

        $existing = ProductImage::query()
            ->whereIn('product_id', array_values($map))
            ->get()
            ->keyBy('product_id');

        return [$map, $existing];
    }

    private function loadImageMaps(array $codes): array
    {
        $mainMap = ProductImageFile::query()
            ->select('code', DB::raw('MIN(path) AS path'))
            ->where('kind', 'main')
            ->whereIn('code', $codes)
            ->groupBy('code')
            ->pluck('path', 'code');

        $rows = ProductImageFile::query()
            ->select('code', 'path', 'variant')
            ->where('kind', 'additional')
            ->whereIn('code', $codes)
            ->get();

        $additional = [];
        foreach ($rows as $row) {
            $additional[$row->code][] = [
                'path' => $row->path,
                'variant' => $this->extractVariant($row->path, $row->code, $row->variant),
            ];
        }

        return [$mainMap, $additional];
    }

    // =========================
    // HELPERS
    // =========================

    private function normalizeCodes(array $codes): array
    {
        return array_values(array_filter(array_map('trim', $codes)));
    }

    private function ensureDirectory(): void
    {
        $this->disk->exists($this->outputBase) || $this->disk->makeDirectory($this->outputBase);
    }

    private function decode($json): array
    {
        if (is_array($json)) {
            return $json;
        }

        return is_string($json) ? (json_decode($json, true) ?: []) : [];
    }

    private function encodeAdditional($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_array($value)) {
            return empty($value) ? null : json_encode(array_values($value), JSON_UNESCAPED_SLASHES);
        }

        if (is_string($value)) {
            return $value;
        }

        return null;
    }

    private function mergeUrls(array $old, array $new): array
    {
        return array_values(array_unique(array_merge($old, $new)));
    }

    private function extractVariant(string $path, string $code, ?string $variant): string
    {
        if ($variant) {
            return strtoupper(trim($variant));
        }

        $name = pathinfo($path, PATHINFO_FILENAME);

        if (preg_match('/^\._'.preg_quote($code, '/').'_([A-Z0-9]+)$/i', $name, $m)) {
            return strtoupper($m[1]);
        }

        return '';
    }
}
