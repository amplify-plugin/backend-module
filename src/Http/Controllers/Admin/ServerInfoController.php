<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Number;
use PDO;

class ServerInfoController extends Controller
{

    private function fileSize(string $path): string
    {
        $output = exec("du -sh {$path}");

        return preg_replace('/(\d+[KMG]?)(.+)/i', '$1', $output);
    }

    private function fileInfo(string $path): bool|string
    {
        $output = exec("stat -c \"<b>Owner:</b> %U, <b>Permissions:</b> %A, <b>Last Modified:</b> %y\" {$path}");
        $output .= ",<b>Size:</b> {$this->fileSize($path)}";

        return $output;
    }

    private function getMemoryUsage(): array
    {
        if (PHP_OS_FAMILY === 'Windows') {
            $output = shell_exec(
                'powershell.exe -NoProfile -Command "Get-CimInstance Win32_OperatingSystem | Select-Object TotalVisibleMemorySize,FreePhysicalMemory | ConvertTo-Json -Compress"'
            );

            $memory = json_decode($output, true);

            $totalBytes = ((int) ($memory['TotalVisibleMemorySize'] ?? 0)) * 1024;
            $freeBytes = ((int) ($memory['FreePhysicalMemory'] ?? 0)) * 1024;
        } elseif (is_readable('/proc/meminfo')) {
            $memory = file_get_contents('/proc/meminfo');

            preg_match('/MemTotal:\s+(\d+)/', $memory, $total);
            preg_match('/MemAvailable:\s+(\d+)/', $memory, $available);

            $totalBytes = ((int) ($total[1] ?? 0)) * 1024;
            $freeBytes = ((int) ($available[1] ?? 0)) * 1024;
        } else {
            return [
                'total' => null,
                'used' => null,
                'percent' => null,
            ];
        }

        $usedBytes = $totalBytes - $freeBytes;

        return [
            'total' => Number::fileSize($totalBytes),
            'used' => Number::fileSize($usedBytes),
            'percent' => $totalBytes > 0
                ? round(($usedBytes / $totalBytes) * 100)
                : 0,
        ];
    }
    
    public function __invoke(): View|Application|Factory|array|\Illuminate\Contracts\Foundation\Application
    {
        $path = base_path(); // Laravel project root

        $storageTotal = disk_total_space($path);
        $storageFree  = disk_free_space($path);
        $storageUsed  = $storageTotal - $storageFree;
        $storagePercent = round(($storageUsed / $storageTotal) * 100);
        $storageTotal = Number::fileSize($storageTotal);
        $storageUsed = Number::fileSize($storageUsed);

        $composerPhpVersion = json_decode(file_get_contents(base_path('composer.json')), true)['require']['php'] ?? '^7.4';

        $packages = json_decode(file_get_contents(base_path('some.json')), true)['installed'] ?? [];

        $health = Storage::disk(config('health.result_stores.Spatie\Health\ResultStores\JsonFileHealthResultStore.disk', 'local'))
            ->json(config('health.result_stores.Spatie\Health\ResultStores\JsonFileHealthResultStore.path', 'health/status.json'));


        foreach ($packages as $index => $package) {
            $packages[$index]['name'] = preg_replace('/\//', ' ', $package['name']);
        }

        $memory = $this->getMemoryUsage();

        $ramTotal = $memory['total'] ?? 'N/A';
        $ramUsed = $memory['used'] ?? 'N/A';
        $ramPercent = $memory['percent'] ?? 'N/A';

        $statistics = [
            ['Server Storage', "{$storageUsed}/{$storageTotal} ($storagePercent%)", "30GB"],
            ['Memory Usage', "{$ramUsed}/{$ramTotal} ($ramPercent%)", "4GB"],
            ['OS', php_uname()],
            ['Web Server', match (php_sapi_name()) {
                'apache2handler' => 'Apache2',
                default => 'CLI'
            }, 'Apache2, NGINX'],
            ['User', exec('whoami'), 'ubuntu,www-data'],
            ['PHP', phpversion(), $composerPhpVersion],
            ['Default INI', php_ini_loaded_file()],
            ['Laravel', app()->version(), '10.48.14'],
            ['Environment', ucfirst(app()->environment())],
            [
                'Extensions',
                implode(', ', array_map(fn ($item) => ucfirst($item), get_loaded_extensions())),
            ],
            ['Composer', str_replace(['Composer version '], '', exec('composer -V')), '2.4.2 2024-09-14 12:01:01'],
            ['Request Max Size', ini_get('post_max_size'), '256M'],
            ['Upload File Max size', ini_get('upload_max_filesize'), '256M'],
            ['PHP Allocated RAM', ini_get('memory_limit'), '512M'],
            ['Max Execution Time (Second)', ini_get('max_execution_time'), '300'],
            ['Database', ucfirst(DB::getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME)).'('.DB::getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION).')'],
            ['Database Stats', DB::getPdo()->getAttribute(PDO::ATTR_SERVER_INFO)],
            ['Database BinLog', $this->fileSize('/var/lib/mysql')],
            ['Logger', $this->fileInfo(storage_path('logs'))],
            ['Scheduler', $this->fileInfo(storage_path('logs/scheduler.log'))],
            ['Queue Worker', $this->fileInfo(storage_path('logs/worker.log'))],
            ['Cache Size', $this->fileSize(storage_path('framework/cache/data'))],
            ['Webserver Access Log', $this->fileSize('/var/log/apache2')],
        ];

        return view('backend::pages.server-info.index', [
            'statistics' => $statistics,
            'packages' => $packages,
            'health' => $health ?? [],
        ]);
    }

    public function healthCheck()
    {
        
    }
}
