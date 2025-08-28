<?php

namespace Triptasoft\FilamentIndonesiaRegions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Sushi\Sushi;

class Regency extends Model
{
    use Sushi;

    protected $rows = []; // kosong

    public static function byProvince($provinceCode): array
    {
        $response = Http::get("https://wilayah.id/api/regencies/{$provinceCode}.json");

        return collect($response->json('data'))
            ->map(fn ($item) => [
                'code' => $item['code'],
                'name' => $item['name'],
            ])
            ->toArray();
    }
}
