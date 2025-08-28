<?php

namespace Triptasoft\FilamentIndonesiaRegions\Tables\Columns;

use Filament\Tables\Columns\Column;
use Triptasoft\FilamentIndonesiaRegions\Support\RegionCache;

class RegionColumn extends Column
{
    protected string $view = 'filament-indonesia-regions::tables.columns.region-column';

    protected string $type = 'region';

    protected string $regionType = 'provinsi';

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
