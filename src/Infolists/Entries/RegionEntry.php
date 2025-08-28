<?php

namespace Triptasoft\FilamentIndonesiaRegions\Infolists\Entries;

use Filament\Infolists\Components\Entry;
use Triptasoft\FilamentIndonesiaRegions\Support\RegionCache;

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
        $value = $record?->{$this->getName()};

        if (! $value) {
            return null;
        }

        $parentCode = match ($this->regionType) {
            'kabupaten' => $record->provinsi ?? null,
            'kecamatan' => $record->kabupaten ?? null,
            'desa' => $record->kecamatan ?? null,
            default => null,
        };

        $regions = RegionCache::getByType($this->regionType, $parentCode);

        return $regions[$value] ?? $value;
    }
}
