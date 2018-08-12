<?php

namespace Spatie\TailTool\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\TailTool\TailToolServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            TailToolServiceProvider::class,
        ];
    }
}
