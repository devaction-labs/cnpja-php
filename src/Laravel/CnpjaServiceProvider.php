<?php

declare(strict_types=1);

namespace Cnpja\Laravel;

use Cnpja\CnpjaClient;
use Illuminate\Support\ServiceProvider;

class CnpjaServiceProvider extends ServiceProvider
{
    #[\Override]
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/cnpja.php', 'cnpja');

        $this->app->singleton(CnpjaClient::class, fn () => new CnpjaClient(config('cnpja.api_key')));
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/cnpja.php' => config_path('cnpja.php'),
            ], 'cnpja-config');
        }
    }
}
