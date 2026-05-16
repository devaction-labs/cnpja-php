<?php

declare(strict_types=1);

use Cnpja\CnpjaClient;
use Cnpja\Laravel\Facades\Cnpja;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('resolve CnpjaClient via container', function () {
    $client = app(CnpjaClient::class);
    expect($client)->toBeInstanceOf(CnpjaClient::class);
});

it('facade aponta para CnpjaClient', function () {
    expect(Cnpja::getFacadeRoot())->toBeInstanceOf(CnpjaClient::class);
});

it('config cnpja.api_key é carregada', function () {
    expect(config('cnpja.api_key'))->toBe('test-api-key');
});
