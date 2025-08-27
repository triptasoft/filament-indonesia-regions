<?php

namespace Triptasoft\FilamentIndonesiaRegions\Infolists\Entries;

use Filament\Infolists\Components\Entry;
use Illuminate\Support\Facades\Http;

class RegionEntry extends Entry
{
    protected string $view = 'filament-indonesia-regions::infolists.entries.region-entry';

    protected string $regionType = 'provinsi'; // default type

    protected static array $cache = [];

    public function type(string $type): static
    {
        $this->regionType = $type;
        return $this;
    }

    public function getState(): ?string
    {
        $record = $this->getRecord();
        $value = $record->{$this->getName()};

        if (!$value) {
            return null;
        }

        // Tentukan kode induk untuk panggilan API
        $parentCode = match ($this->regionType) {
            'provinsi' => null,
            'kabupaten' => $record->provinsi ?? null,
            'kecamatan' => $record->kabupaten ?? null,
            'desa' => $record->kecamatan ?? null,
            default => null,
        };

        $cacheKey = "{$this->regionType}.{$parentCode}";

        if (!isset(static::$cache[$cacheKey])) {
            $url = 'https://wilayah.id';
            $endpoint = match ($this->regionType) {
                'provinsi' => '/api/provinces.json',
                'kabupaten' => "/api/regencies/{$parentCode}.json",
                'kecamatan' => "/api/districts/{$parentCode}.json",
                'desa' => "/api/villages/{$parentCode}.json",
                default => '/api/provinces.json',
            };

            static::$cache[$cacheKey] = Http::get($url . $endpoint)
                ->collect('data')
                ->keyBy('code');
        }

        return static::$cache[$cacheKey][$value]['name'] ?? $value;
    }
}
