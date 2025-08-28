<?php

namespace Triptasoft\FilamentIndonesiaRegions\Forms\Components;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class RegionStats
{
    protected static string $baseUrl = 'https://api.datawilayah.com';

    protected static function fetchWilayah(string $endpoint): array
    {
        return Cache::remember("wilayah-{$endpoint}", now()->addDay(), function () use ($endpoint) {
            $url = self::$baseUrl . '/' . $endpoint . '.json';

            return Http::get($url)
                ->collect('data')
                ->mapWithKeys(fn ($item) => [$item['kode_wilayah'] => $item['nama_wilayah']])
                ->toArray();
        });
    }

    public static function make(): Fieldset
    {
        return Fieldset::make('Statistik Wilayah Indonesia')
            ->schema([
                Select::make('provinsi')
                    ->label('Provinsi')
                    ->options(fn () => self::fetchWilayah('api/provinsi'))
                    ->reactive()
                    ->afterStateUpdated(function (Set $set) {
                        $set('kabupaten', null);
                        $set('kecamatan', null);
                        $set('desa', null);
                    }),

                Select::make('kabupaten')
                    ->label('Kabupaten/Kota')
                    ->options(
                        fn (Get $get) => $get('provinsi')
                            ? self::fetchWilayah("api/kabupaten_kota/{$get('provinsi')}")
                            : []
                    )
                    ->reactive()
                    ->disabled(fn (Get $get) => blank($get('provinsi')))
                    ->afterStateUpdated(function (Set $set) {
                        $set('kecamatan', null);
                        $set('desa', null);
                    }),

                Select::make('kecamatan')
                    ->label('Kecamatan')
                    ->options(
                        fn (Get $get) => $get('kabupaten')
                            ? self::fetchWilayah("api/kecamatan/{$get('kabupaten')}")
                            : []
                    )
                    ->reactive()
                    ->disabled(fn (Get $get) => blank($get('kabupaten')))
                    ->afterStateUpdated(fn (Set $set) => $set('desa', null)),

                Select::make('desa')
                    ->label('Desa/Kelurahan')
                    ->options(
                        fn (Get $get) => $get('kecamatan')
                            ? self::fetchWilayah("api/desa_kelurahan/{$get('kecamatan')}")
                            : []
                    )
                    ->reactive()
                    ->disabled(fn (Get $get) => blank($get('kecamatan'))),
            ]);
    }
}
