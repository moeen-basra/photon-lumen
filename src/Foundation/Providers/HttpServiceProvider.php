<?php


namespace Photon\Foundation\Providers;

use Photon\Foundation\Http\Request;

class HttpServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Request::class, function () {
            return Request::capture();
        });

        $this->app->alias(Request::class, 'request');
    }
}
