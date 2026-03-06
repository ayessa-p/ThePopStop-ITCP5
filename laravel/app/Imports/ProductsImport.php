<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading, WithBatchInserts
{
    public function model(array $row)
    {
        $sku = (string) ($row['sku'] ?? '');
        $existing = $sku !== '' ? Product::withTrashed()->where('sku', $sku)->first() : null;

        $imagePath = null;
        $imageUrl = trim((string) ($row['image_url'] ?? ($row['image'] ?? '')));
        if ($imageUrl !== '') {
            $imagePath = $this->resolveLocalPublicRelative($imageUrl)
                ?? $this->downloadAndStoreImage($imageUrl)
                ?? $this->useRemoteIfPublic($imageUrl);
        }

        $status = 'Out of Stock';
        $stock = (int) ($row['stock_quantity'] ?? 0);
        if ($stock > 10) {
            $status = 'In Stock';
        } elseif ($stock > 0) {
            $status = 'Low Stock';
        }

        if ($existing) {
            $data = [
                'name' => $row['name'] ?? $existing->name,
                'series' => $row['series'] ?? $existing->series,
                'brand' => $row['brand'] ?? $existing->brand,
                'price' => (float) ($row['price'] ?? $existing->price),
                'cost_price' => isset($row['cost_price']) ? (float) $row['cost_price'] : $existing->cost_price,
                'sku' => $sku,
                'description' => $row['description'] ?? $existing->description,
                'character' => $row['character'] ?? $existing->character,
                'stock_quantity' => $stock,
                'category' => $row['category'] ?? $existing->category,
                'type' => $row['type'] ?? $existing->type,
                'status' => $status,
            ];
            if ($imagePath) {
                $data['image_url'] = $imagePath;
            }
            $existing->fill($data)->save();
            $existing->updateStatus();
            return null;
        }

        return new Product([
            'name' => $row['name'] ?? '',
            'series' => $row['series'] ?? '',
            'brand' => $row['brand'] ?? '',
            'price' => (float) ($row['price'] ?? 0),
            'cost_price' => isset($row['cost_price']) ? (float) $row['cost_price'] : null,
            'sku' => $row['sku'] ?? '',
            'description' => $row['description'] ?? null,
            'character' => $row['character'] ?? null,
            'stock_quantity' => $stock,
            'category' => $row['category'] ?? null,
            'type' => $row['type'] ?? null,
            'image_url' => $imagePath,
            'status' => $status,
        ]);
    }
    public function chunkSize(): int
    {
        return 200;
    }
    public function batchSize(): int
    {
        return 200;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'series' => 'required|string',
            'brand' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string',
            'stock_quantity' => 'required|integer|min:0',
            'image_url' => 'nullable|string',
        ];
    }

    /**
     * Attempt to download an image and store it on the public disk.
     * Returns the stored relative path or null on failure.
     */
    protected function downloadAndStoreImage(string $rawUrl): ?string
    {
        $url = $this->normalizeDriveLink($rawUrl);

        try {
            $response = Http::timeout(8)->connectTimeout(5)->retry(1, 200)->get($url);
            if (! $response->ok()) {
                return null;
            }

            $contentType = (string) $response->header('Content-Type', '');
            $extension = $this->guessExtension($contentType, $url);
            if (! $extension) {
                return null;
            }

            $filename = 'products/' . Str::uuid() . '.' . $extension;
            Storage::disk('public')->put($filename, $response->body());
            return $filename;
        } catch (\Throwable $e) {
            return null;
        }
    }
    protected function useRemoteIfPublic(string $url): ?string
    {
        if (preg_match('~^https?://~i', $url)) {
            return $url;
        }
        return null;
    }

    /**
     * Try to infer an image extension from content type or URL.
     */
    protected function guessExtension(string $contentType, string $url): ?string
    {
        $map = [
            'image/jpeg' => 'jpg',
            'image/jpg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif',
        ];
        foreach ($map as $ct => $ext) {
            if (str_contains(strtolower($contentType), $ct)) {
                return $ext;
            }
        }

        $path = parse_url($url, PHP_URL_PATH) ?: '';
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (in_array($ext, array_values($map), true)) {
            return $ext;
        }
        return null;
    }

    /**
     * Convert common Google Drive share links to direct-download links.
     */
    protected function normalizeDriveLink(string $url): string
    {
        if (str_contains($url, 'drive.google.com')) {
            if (preg_match('~/file/d/([^/]+)/~', $url, $m)) {
                return 'https://drive.google.com/uc?export=download&id=' . $m[1];
            }
            if (preg_match('~[?&]id=([^&]+)~', $url, $m)) {
                return 'https://drive.google.com/uc?export=download&id=' . $m[1];
            }
        }
        return $url;
    }

    /**
     * Recognize local paths like:
     * - storage/app/public/products/xxx.jpg
     * - public/storage/products/xxx.jpg
     * - storage/products/xxx.jpg
     * - products/xxx.jpg
     * and normalize to a 'products/xxx.jpg' relative path.
     */
    protected function resolveLocalPublicRelative(string $path): ?string
    {
        $p = str_replace('\\', '/', trim($path));
        if ($p === '') {
            return null;
        }

        if (preg_match('~products/[^\\s]+\\.(jpg|jpeg|png|gif|webp)$~i', $p, $m)) {
            $rel = substr($p, strpos($p, 'products/'));
            return $rel;
        }

        $prefixes = [
            'storage/app/public/',
            '/storage/app/public/',
            'public/storage/',
            '/public/storage/',
            'storage/',
            '/storage/',
        ];
        foreach ($prefixes as $prefix) {
            if (str_starts_with($p, $prefix)) {
                $rel = ltrim(substr($p, strlen($prefix)), '/');
                if (!str_starts_with($rel, 'products/')) {
                    $rel = 'products/' . ltrim($rel, '/');
                }
                return $rel;
            }
        }

        // Absolute path under storage/app/public
        $storagePublic = str_replace('\\', '/', storage_path('app/public/'));
        if (str_starts_with($p, $storagePublic)) {
            $rel = ltrim(substr($p, strlen($storagePublic)), '/');
            return $rel;
        }

        return null;
    }
}
