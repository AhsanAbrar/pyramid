<?php

namespace Pyramid;

use Pyramid\Pyramid;
use Illuminate\Support\ServiceProvider;
use Pyramid\Http\Middleware\ServePackage;
use Illuminate\Contracts\Http\Kernel as HttpKernel;

class PyramidCoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__.'/../config/pyramid.php', 'pyramid');
        }

        if (Pyramid::runningInConsole()) {
            $this->app->register(PyramidServiceProvider::class);

            foreach (array_merge(config('pyramid.site_providers'), config('pyramid.providers')) as $key => $provider) {
                if (is_string($provider)) {
                    $this->app->register($provider);
                }
                else {
                    $this->app->register($provider['provider']);
                }
            }
        }

        $this->app->make(HttpKernel::class)
                    ->pushMiddleware(ServePackage::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
