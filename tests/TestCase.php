<?php

namespace Spatie\TailTool\Tests;

use Inertia\ServiceProvider as InertiaServiceProvider;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaCoreServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\TailTool\TailTool;
use Spatie\TailTool\TailToolServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Nova::$tools = [new TailTool];
        Nova::auth(fn () => true);
    }

    protected function getPackageProviders($app): array
    {
        return [InertiaServiceProvider::class, NovaCoreServiceProvider::class, TailToolServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('app.key', 'base64:'.base64_encode(str_repeat('a', 32)));
        $app['config']->set('session.driver', 'array');
        $app['config']->set('cache.default', 'array');
    }
}
