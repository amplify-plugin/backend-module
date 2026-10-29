<?php

namespace Amplify\System\Backend\Providers;

use Amplify\System\Media\Http\Middleware\FileManagerACL;
use Amplify\System\Media\Services\ACLService\ACLRepository;
use Amplify\System\Media\Services\ConfigService\ConfigRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;

class FileManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/file-manager', 'file-manager');
    }

    /**
     * Register the application services.
     *
     * @return void
     *
     * @throws BindingResolutionException
     */
    public function register()
    {
        // Config Repository
        $this->app->bind(
            ConfigRepository::class,
            $this->app['config']['file-manager.configRepository']
        );

        // ACL Repository
        $this->app->bind(
            ACLRepository::class,
            $this->app->make(ConfigRepository::class)->getAclRepository()
        );

        // register ACL middleware
        $this->app['router']->aliasMiddleware('fm-acl', FileManagerACL::class);
    }
}
