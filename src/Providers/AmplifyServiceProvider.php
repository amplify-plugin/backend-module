<?php

namespace Amplify\System\Backend\Providers;

use Amplify\System\Helpers\UtilityHelper;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AmplifyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Load All Configs to Config system from DB
        if (file_exists(storage_path('installed'))) {
            foreach (\DB::table('system_configurations')->where('active', true)->get() as $systemConfig) {
                Config::set("amplify.{$systemConfig->name}.{$systemConfig->option}", UtilityHelper::typeCast($systemConfig->value, $systemConfig->type));
            }
        }

        $this->app->booted(function () {
            $this->overwriteBackpackLocale();
        });
    }

    private function overwriteBackpackLocale(): self
    {
        Config::set('backpack.ui.default_date_format', Config::get('amplify.basic.date_format', 'D MMM YYYY'));

        Config::set('backpack.ui.default_datetime_format',
            strtr(
                Config::get('amplify.basic.date_time_format', 'D MMM YYYY, HH:mm'),
                Config::get('amplify.constant.replacement_moment', [])
            )
        );

        return $this;
    }
}
