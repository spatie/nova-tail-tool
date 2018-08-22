<?php

namespace Spatie\TailTool\Tests;

use Illuminate\Support\Facades\Route;
use Spatie\TailTool\TailToolServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function setUp()
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
