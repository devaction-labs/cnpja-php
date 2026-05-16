<?php

declare(strict_types=1);

use Cnpja\CnpjaClient;
use Cnpja\Laravel\Facades\Cnpja;

it('resolves CnpjaClient from the container', function (): void {
    $client = app(CnpjaClient::class);
    expect($client)->toBeInstanceOf(CnpjaClient::class);
});

it('facade points to CnpjaClient', function (): void {
    expect(Cnpja::getFacadeRoot())->toBeInstanceOf(CnpjaClient::class);
});

it('loads the cnpja.api_key config value', function (): void {
    expect(config('cnpja.api_key'))->toBe('test-api-key');
});
