<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use PDO;

class ServerInfoController extends Controller
{
    public function __invoke(): View|Application|Factory|array|\Illuminate\Contracts\Foundation\Application
    {
        $storage = preg_split('/\s+/', exec('df -h --output=source,size,used,avail,pcent /'));

        $statistics = [
            ['Server Storage', "{$storage[2]}/{$storage[1]} ($storage[4])"],
            ['OS', php_uname()],
            ['Web Server', match (php_sapi_name()) {
                'apache2handler' => 'Apache2',
                default => 'CLI'
            }, 'Apache2, NGINX'],
            ['User', exec('whoami'), 'ubuntu,www-data'],
            ['PHP', phpversion(), '8.1'],
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

        return view('backend::pages.server-info.index', compact('statistics'));
    }

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
}
