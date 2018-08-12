<?php

namespace Spatie\TailTool;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;
use Spatie\TailTool\Controllers\TailController;
use Spatie\TailTool\Middleware\Authenticate;

class TailToolServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'TailTool');
    }

    public function register()
    {
        Route::post($this->getNovaUrl('tail-tool'), TailController::class)->middleware(Authenticate::class);
    }

    public function getNovaUrl(string $url = '/'): string
    {
        if (! class_exists(Nova::class)) {
            return "/nova/{$url}";
        }

        return Nova::path() . "/{$url}";
    }
}
