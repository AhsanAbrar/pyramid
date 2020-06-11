<?php

namespace Pyramid\Http\Middleware;

use Pyramid\Pyramid;

class ServePackage
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        $this->request = $request;

        if ($provider = $this->isPyramidRequest()) {
            app()->register($provider);
        }

        return $next($request);
    }

    /**
     * Determine if the given request is intended for Pyramid.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function isPyramidRequest()
    {
        if ($this->request->segment(1) == 'pyramid-api' || $this->request->segment(1) == config('pyramid.admin_prefix')) {
            Pyramid::prefix(config('pyramid.admin_prefix'));

            return $this->getProvider($this->request->segment(2), config('pyramid.providers'));
        }

        $provider = $this->getProvider($this->request->segment(1), config('pyramid.providers'));
        $siteProvider = $this->getProvider($this->request->segment(1), config('pyramid.site_providers'));

        if ($siteProvider) {
            return $siteProvider;
        }

        return config('pyramid.admin_prefix') ? false : $provider;
    }

    /**
     * Get pyramid provider based on current key.
     *
     * @param  string  $key
     * @param  array  $array
     * @return string
     */
    protected function getProvider($key, $array)
    {
        config('pyramid.theme') != 'default' ? Pyramid::theme(config('pyramid.theme')) : '';
        config('pyramid.site_theme') != 'default' ? Pyramid::siteTheme(config('pyramid.site_theme')) : '';

        if (array_key_exists($key, $array)) {
            if (is_string($array[$key])) {
                return $array[$key];
            }

            return $array[$key]['provider'];
        }
        elseif (array_key_exists('', $array)) {
            if (is_string($array[''])) {
                return $array[''];
            }

            return $array['']['provider'];
        }
    }
}
