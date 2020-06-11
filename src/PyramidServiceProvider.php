<?php

namespace Pyramid;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class PyramidServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        $this->registerMigrations();

        $this->registerPublishing();
    }

    /**
     * Register the package migrations.
     *
     * @return void
     */
    protected function registerMigrations()
    {
        $this->loadMigrationsFrom(base_path('pyramid/database/migrations'));
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        $this->publishes([
            __DIR__.'/../config/pyramid.php' => config_path('pyramid.php'),
        ], 'pyramid-config');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            Console\InstallCommand::class,
            Console\PublishCommand::class,
            Console\VersionCommand::class,
        ]);
    }
}
