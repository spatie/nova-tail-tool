<?php

namespace Spatie\TailTool\Tests;

use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\TailTool\TailToolServiceProvider;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Route::middlewareGroup('nova', []);
    }

    protected function getPackageProviders($app)
    {
        return [
            TailToolServiceProvider::class,
        ];
    }
}
