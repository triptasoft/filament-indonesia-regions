<?php

namespace Triptasoft\FilamentIndonesiaRegions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Sushi\Sushi;

class Village extends Model
{
    use Sushi;

    protected $rows = [];

    public function getRows(): array
    {
        $districts = District::all();
        $allVillages = collect();

        foreach ($districts as $district) {
            $response = Http::get("https://wilayah.id/api/villages/{$district->code}.json");
            $allVillages = $allVillages->merge(
                collect($response->json('data'))->map(fn ($item) => [
                    'code' => $item['code'],
                    'name' => $item['name'],
                    'district_code' => $district->code,
                ])
            );
        }

        return $allVillages->toArray();
    }
}
