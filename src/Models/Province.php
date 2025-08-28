<?php

namespace Triptasoft\FilamentIndonesiaRegions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Sushi\Sushi;

class Province extends Model
{
    use Sushi;

    protected $rows = [];

    public function getRows(): array
    {
        return cache()->remember('provinces', 86400, function () {
            $response = Http::get('https://wilayah.id/api/provinces.json');

            return collect($response->json('data'))
                ->map(fn ($item) => [
                    'code' => $item['code'],
                    'name' => $item['name'],
                ])
                ->toArray();
        });
    }
}
