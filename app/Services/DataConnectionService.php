<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DatabaseConnectionService
{
    const CACHE_KEY        = 'db_active_connection';
    const FAILURE_KEY      = 'db_cloud_failures';
    const FAILURE_THRESHOLD = 3;
    const COOLDOWN_SECONDS  = 60;

    public function getActiveConnection(): string
    {
        return Cache::get(self::CACHE_KEY, 'cloud');
        
    }

    public function handleConnectionFailure(string $connection): void
    {
        if ($connection !== 'cloud') return;

        $failures = Cache::increment(self::FAILURE_KEY);
        Cache::put(self::FAILURE_KEY, $failures, now()->addMinutes(10));

        if ($failures >= self::FAILURE_THRESHOLD) {
            $this->switchToLocal();
        }
    }

    public function switchToLocal(): void
    {
        Cache::put(self::CACHE_KEY, 'local', now()->addHours(2));
        Log::critical('FAILOVER: Banco cloud indisponível. Usando banco local.');
    }

    public function switchToCloud(): void
    {
        Cache::forget(self::FAILURE_KEY);
        Cache::put(self::CACHE_KEY, 'cloud', now()->addHours(24));
        Log::info('FAILBACK: Banco cloud restaurado.');
       
    }
}