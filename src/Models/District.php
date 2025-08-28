<?php

namespace Triptasoft\FilamentIndonesiaRegions\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;
use Illuminate\Support\Facades\Http;

class District extends Model
{
    use Sushi;

    protected $rows = [];

    public function getRows(): array
    {
        $regencies = Regency::all();
        $allDistricts = collect();

        foreach ($regencies as $regency) {
            $response = Http::get("https://wilayah.id/api/districts/{$regency->code}.json");
            $allDistricts = $allDistricts->merge(
                collect($response->json('data'))->map(fn ($item) => [
                    'code' => $item['code'],
                    'name' => $item['name'],
                    'regency_code' => $regency->code,
                ])
            );
        }

        return $allDistricts->toArray();
    }
}
