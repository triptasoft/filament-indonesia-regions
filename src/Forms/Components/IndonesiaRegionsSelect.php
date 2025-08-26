<?php

namespace Triptasoft\FilamentIndonesiaRegions\Forms\Components;

use Filament\Schemas\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class IndonesiaRegionsSelect
{
    protected static string $baseUrl = 'https://wilayah.id';

    protected static function fetchWilayah(string $endpoint): array
    {
        return Cache::remember("wilayah-{$endpoint}", now()->addDay(), function () use ($endpoint) {
            $url = self::$baseUrl . '/' . $endpoint . '.json';

            return Http::get($url)
                ->collect('data')
                ->mapWithKeys(fn($item) => [$item['code'] => $item['name']])
                ->toArray();
        });
    }

    public static function make(): Fieldset
    {
        return Fieldset::make('Wilayah Indonesia')
            ->schema([
                Select::make('provinsi')
                    ->label('Provinsi')
                    ->options(fn() => self::fetchWilayah('api/provinces'))
                    ->reactive()
                    ->afterStateUpdated(function (Set $set) {
                        $set('kabupaten', null);
                        $set('kecamatan', null);
                        $set('desa', null);
                    }),

                Select::make('kabupaten')
                    ->label('Kabupaten/Kota')
                    ->options(
                        fn(Get $get) =>
                        $get('provinsi')
                            ? self::fetchWilayah("api/regencies/{$get('provinsi')}")
                            : []
                    )
                    ->reactive()
                    ->disabled(fn(Get $get) => blank($get('provinsi')))
                    ->afterStateUpdated(function (Set $set) {
                        $set('kecamatan', null);
                        $set('desa', null);
                    }),

                Select::make('kecamatan')
                    ->label('Kecamatan')
                    ->options(
                        fn(Get $get) =>
                        $get('kabupaten')
                            ? self::fetchWilayah("api/districts/{$get('kabupaten')}")
                            : []
                    )
                    ->reactive()
                    ->disabled(fn(Get $get) => blank($get('kabupaten')))
                    ->afterStateUpdated(fn(Set $set) => $set('desa', null)),

                Select::make('desa')
                    ->label('Desa/Kelurahan')
                    ->options(
                        fn(Get $get) =>
                        $get('kecamatan')
                            ? self::fetchWilayah("api/villages/{$get('kecamatan')}")
                            : []
                    )
                    ->reactive()
                    ->disabled(fn(Get $get) => blank($get('kecamatan'))),
            ]);
    }
}
