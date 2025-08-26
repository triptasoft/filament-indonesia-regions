<?php

namespace Triptasoft\FilamentIndonesiaRegions\Commands;

use Illuminate\Console\Command;

class FilamentIndonesiaRegionsCommand extends Command
{
    public $signature = 'filament-indonesia-regions';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
