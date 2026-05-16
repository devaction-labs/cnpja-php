<?php

declare(strict_types=1);

namespace Tests;

use Cnpja\Laravel\CnpjaServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [CnpjaServiceProvider::class];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('cnpja.api_key', 'test-api-key');
    }
}
