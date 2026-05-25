<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\DatabaseConnectionService;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Cache;

class DataBaseConnectionJob implements ShouldQueue
{
    use Queueable;

    const CACHE_KEY        = 'db_active_connection';

    public function handle(): void
    {
        Cache::put(self::CACHE_KEY, "local");
    }
}
