<?php

namespace Spatie\TailTool;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Http\Middleware\Authorize as AuthorizeNova;
use Laravel\Nova\Nova;
use Spatie\TailTool\Http\Middleware\Authorize;

class TailToolServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->booted(function () {
            $this->routes();
        });
    }

    protected function routes(): void
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Nova::router(['nova', 'nova.auth', AuthorizeNova::class, Authorize::class], 'application-log')
            ->group(__DIR__.'/../routes/inertia.php');

        Route::middleware(['nova', 'nova.auth', AuthorizeNova::class, Authorize::class])
            ->prefix('/nova-vendor/spatie/tail-tool')
            ->group(
                __DIR__.'/../routes/api.php'
            );
    }
}
