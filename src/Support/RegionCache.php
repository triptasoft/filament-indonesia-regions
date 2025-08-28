<?php

namespace Triptasoft\FilamentIndonesiaRegions\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class RegionCache
{
    protected static string $baseUrl = 'https://wilayah.id';

    public static function get(string $endpoint): array
    {
        $cacheKey = "wilayah:{$endpoint}";

        return Cache::remember($cacheKey, now()->addDay(), function () use ($endpoint) {
            $url = rtrim(self::$baseUrl, '/') . '/' . ltrim($endpoint, '/') . '.json';

            return Http::get($url)
                ->collect('data')
                ->mapWithKeys(fn ($item) => [
                    $item['code'] => $item['name'], // langsung string
                ])
                ->toArray();
        });
    }

    public static function getByType(string $type, ?string $parentCode = null): array
    {
        return match ($type) {
            'provinsi'  => self::get('api/provinces'),
            'kabupaten' => $parentCode ? self::get("api/regencies/{$parentCode}") : [],
            'kecamatan' => $parentCode ? self::get("api/districts/{$parentCode}") : [],
            'desa'      => $parentCode ? self::get("api/villages/{$parentCode}") : [],
            default     => [],
        };
    }
}
