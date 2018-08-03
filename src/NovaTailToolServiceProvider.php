<?php

namespace Spatie\NovaTailTool;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;
use Spatie\NovaTailTool\Controllers\TailController;

class NovaTailToolServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'NovaTailTool');
    }

    public function register()
    {
        $router = $this->app['router'];

        $router->post($this->getNovaUrl('tail-tool'), TailController::class);
    }

    public function getNovaUrl(string $url = '/'): string
    {
        if (! class_exists(Nova::class)) {
            return "/nova/{$url}";
        }

        return Nova::path() . "/{$url}";
    }
}
