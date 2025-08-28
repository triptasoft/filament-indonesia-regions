<?php

namespace Triptasoft\FilamentIndonesiaRegions\Forms\Components;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Triptasoft\FilamentIndonesiaRegions\Support\RegionCache;

class RegionSelect
{
    protected static string $baseUrl = 'https://wilayah.id';

    public static function make(): Fieldset
    {
        return Fieldset::make('Wilayah Indonesia')
            ->schema([
                Select::make('provinsi')
                    ->label('Provinsi')
                    ->prefixIcon('heroicon-o-globe-asia-australia')
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->options(fn () => RegionCache::get('api/provinces'))
                    ->afterStateUpdated(function (Set $set) {
                        $set('kabupaten', null);
                        $set('kecamatan', null);
                        $set('desa', null);
                    })
                    ->suffix(function ($state) {
                        return $state;
                    }),

                Select::make('kabupaten')
                    ->label('Kabupaten/Kota')
                    ->prefixIcon('heroicon-o-globe-asia-australia')
                    ->searchable()
                    ->preload()
                    ->reactive()
                    // ->disabled(fn(Get $get) => blank($get('provinsi')))
                    ->options(
                        fn (Get $get) => $get('provinsi')
                            ? RegionCache::get("api/regencies/{$get('provinsi')}")
                            : []
                    )
                    ->afterStateUpdated(function (Set $set) {
                        $set('kecamatan', null);
                        $set('desa', null);
                    })
                    ->suffix(function ($state, $get) {
                        return $state ? $state : null;
                    }),

                Select::make('kecamatan')
                    ->label('Kecamatan')
                    ->prefixIcon('heroicon-o-globe-asia-australia')
                    ->searchable()
                    ->preload()
                    ->reactive()
                    // ->disabled(fn(Get $get) => blank($get('kabupaten')))
                    ->options(
                        fn (Get $get) => $get('provinsi')
                            ? RegionCache::get("api/districts/{$get('kabupaten')}")
                            : []
                    )
                    ->afterStateUpdated(fn (Set $set) => $set('desa', null))
                    ->suffix(function ($state, $get) {
                        return $state ? $state : null;
                    }),

                Select::make('desa')
                    ->label('Desa/Kelurahan')
                    ->prefixIcon('heroicon-o-globe-asia-australia')
                    ->searchable()
                    ->preload()
                    ->reactive()
                    // ->disabled(fn(Get $get) => blank($get('kecamatan')))
                    ->options(
                        fn (Get $get) => $get('provinsi')
                            ? RegionCache::get("api/villages/{$get('kecamatan')}")
                            : []
                    )
                    ->suffix(function ($state, $get) {
                        return $state ? $state : null;
                    }),
            ]);
    }
}
