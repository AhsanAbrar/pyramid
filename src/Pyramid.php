<?php

namespace Pyramid;

use Illuminate\Support\Str;

class Pyramid
{
    /**
     * Get the current Pyramid version.
     */
    public static function version()
    {
        return '0.1.0';
    }

    /**
     * Indicates if the application is running in the console.
     */
    protected static $isRunningInConsole;

    /**
     * Humanize the given value into a proper name.
     *
     * @param  string  $value
     * @return string
     */
    public static function humanize($value)
    {
        if (is_object($value)) {
            return static::humanize(class_basename(get_class($value)));
        }

        return Str::title(Str::snake($value, ' '));
    }

    /**
     * Determine if the application is running in the console.
     *
     * @return bool
     */
    public static function registerAllProviders()
    {
        static::$isRunningInConsole = true;

        app()->register(PyramidServiceProvider::class);

        foreach (array_merge(config('pyramid.site_providers'), config('pyramid.providers')) as $key => $provider) {
            if (is_string($provider)) {
                app()->register($provider);
            }
            else {
                app()->register($provider['provider']);
            }
        }
    }

    /**
     * Determine if the application is running in the console.
     *
     * @return bool
     */
    public static function runningInConsole($force = null)
    {
        if ( static::$isRunningInConsole === null) {
            static::$isRunningInConsole = $force ?? (\PHP_SAPI === 'cli' || \PHP_SAPI === 'phpdbg');
        }

        return static::$isRunningInConsole;
    }
}
