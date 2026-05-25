<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\DatabaseConnectionService;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class DataBaseConnectionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private const MAX_FAILURES     = 3;
    private const STATE_FILE       = storage_path('app/db_state.json');
    private const CACHE_KEY        = 'db_active_connection';

    public function handle(): void
    {
        if($this->canConnect()){
            Log::info('Conexão bem-sucedida com o banco de dados primário.');
            $this->saveState(['failures' => 0]);
            return;
        }

        $failures = ($this->readState()['failures'] ?? 0) + 1;
        $this->saveState(['failures' => $failures]);

        if($failures >= self::MAX_FAILURES){
            Log::error('Falha na conexão com o banco de dados primário. Iniciando failover para o secundário.');
            $this->runFailOver();
        }
    }

    private function canConnect(): bool
    {
        try {
            $pdo = new \PDO(
                'pgsql:host=' . env('DB_HOST') . ';port=' . env('DB_PORT') . ';dbname=' . env('DB_DATABASE'),
                env('DB_USERNAME'),
                env('DB_PASSWORD'),
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );
            $pdo->query('SELECT 1');
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    private function runFailOver(): void
    {
        $script = base_path('scripts/failover.sh');
        $output = shell_exec("bash {$script} failover 2>&1");
        Log::info("Failover executado: {$output}");
    }

    private function readState(): array
    {
        if (!file_exists(self::STATE_FILE)) {
            return ['failures' => 0];
        }

       return json_decode(file_get_contents(self::STATE_FILE), true) ?? [];
    }

    private function saveState(array $data): void
    {
        $state = array_merge($this->readState(), $data, ['updated_at' => now()->toISOString()]);
        file_put_contents(self::STATE_FILE, json_encode($state, JSON_PRETTY_PRINT));
    }

}
