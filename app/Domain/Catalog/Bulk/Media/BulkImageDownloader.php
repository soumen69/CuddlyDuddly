<?php

namespace App\Domain\Catalog\Bulk\Media;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BulkImageDownloader
{
    public function store(string $url, string $folder = 'products'): string
    {
        $response = Http::timeout(20)->get($url);

        if (!$response->successful()) {
            throw new \Exception("Image download failed: {$url}");
        }

        $name = $folder . '/' . Str::random(20) . '.jpg';

        Storage::disk('public')->put($name, $response->body());

        return $name;
    }
}
