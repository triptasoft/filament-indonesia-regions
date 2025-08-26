<?php

namespace Triptasoft\FilamentIndonesiaRegions\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Triptasoft\FilamentIndonesiaRegions\FilamentIndonesiaRegions
 */
class FilamentIndonesiaRegions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Triptasoft\FilamentIndonesiaRegions\FilamentIndonesiaRegions::class;
    }
}
