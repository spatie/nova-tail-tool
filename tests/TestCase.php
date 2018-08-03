<?php

namespace Spatie\NovaTailTool\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\NovaTailTool\NovaTailToolServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            NovaTailToolServiceProvider::class,
        ];
    }
}
