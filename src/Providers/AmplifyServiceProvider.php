<?php

namespace Amplify\System\Backend\Providers;

use Amplify\System\Backend\Models\SystemConfiguration;
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
        $this->app->booted(function () {
            // Load All Configs to Config system from DB
            foreach (SystemConfiguration::all() as $systemConfig) {
                Config::set("amplify.{$systemConfig->name}.{$systemConfig->option}", UtilityHelper::typeCast($systemConfig->value, $systemConfig->type));
            }

            $this->overwriteBackpackLocale();
        });
    }

    private function overwriteBackpackLocale(): self
    {
        Config::set('backpack.base.default_date_format', Config::get('amplify.basic.date_format', 'D MMM YYYY'));

        Config::set('backpack.base.default_datetime_format',
            strtr(
                Config::get('amplify.basic.date_time_format', 'D MMM YYYY, HH:mm'),
                Config::get('amplify.constant.replacement_moment', [])
            )
        );

        return $this;
    }
}
