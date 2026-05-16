<?php

declare(strict_types=1);

use Cnpja\CnpjaClient;
use Cnpja\Exceptions\NotFoundException;
use Cnpja\Exceptions\RateLimitException;
use Cnpja\Exceptions\UnauthorizedException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    MockClient::destroyGlobal();
    $this->client = new CnpjaClient('test-key');
});

afterEach(fn () => MockClient::destroyGlobal());

it('consulta saldo com sucesso', function () {
    MockClient::global([MockResponse::make(['remaining' => 100, 'used' => 5], 200)]);

    $response = $this->client->consultaSaldo();

    expect($response->status())->toBe(200)
        ->and($response->json('remaining'))->toBe(100);
});

it('consulta CEP com sucesso', function () {
    MockClient::global([MockResponse::make(['code' => '01310100', 'city' => 'São Paulo'], 200)]);

    $response = $this->client->consultaCep('01310100');

    expect($response->status())->toBe(200)
        ->and($response->json('city'))->toBe('São Paulo');
});

it('consulta empresa com sucesso', function () {
    MockClient::global([MockResponse::make(['id' => '37335118', 'name' => 'Empresa Teste'], 200)]);

    $response = $this->client->consultaEmpresa('37335118');

    expect($response->status())->toBe(200)
        ->and($response->json('id'))->toBe('37335118');
});

it('consulta CNPJ com sucesso', function () {
    MockClient::global([MockResponse::make(['taxId' => '37335118000180'], 200)]);

    $response = $this->client->consultaCnpj('37335118000180');

    expect($response->status())->toBe(200)
        ->and($response->json('taxId'))->toBe('37335118000180');
});

it('lança UnauthorizedException em 401', function () {
    MockClient::global([MockResponse::make(['code' => 401, 'message' => 'invalid authentication'], 401)]);

    $this->client->consultaCnpj('37335118000180');
})->throws(UnauthorizedException::class);

it('lança NotFoundException em 404', function () {
    MockClient::global([MockResponse::make(['code' => 404, 'message' => 'not found'], 404)]);

    $this->client->consultaCnpj('00000000000000');
})->throws(NotFoundException::class);

it('lança RateLimitException em 429 com créditos', function () {
    MockClient::global([
        MockResponse::make(['code' => 429, 'message' => 'not enough credits', 'required' => 3, 'remaining' => 1], 429),
    ]);

    try {
        $this->client->consultaCnpj('37335118000180');
    } catch (RateLimitException $e) {
        expect($e->required)->toBe(3)
            ->and($e->remaining)->toBe(1);
    }
});

it('consulta RFB com opções de cache', function () {
    MockClient::global([MockResponse::make(['taxId' => '37335118000180'], 200)]);

    $response = $this->client->consultaRfb('37335118000180', ['strategy' => 'CACHE_IF_ERROR', 'maxAge' => 45]);

    expect($response->status())->toBe(200);
});

it('consulta Simples Nacional', function () {
    MockClient::global([MockResponse::make(['taxId' => '37335118000180', 'simples' => ['optant' => true]], 200)]);

    $response = $this->client->consultaSimples('37335118000180');

    expect($response->json('simples.optant'))->toBeTrue();
});

it('consulta CCC com estados', function () {
    MockClient::global([MockResponse::make(['taxId' => '37335118000180', 'registrations' => []], 200)]);

    $response = $this->client->consultaCcc('37335118000180', 'PR,RS,SC');

    expect($response->status())->toBe(200);
});

it('consulta SUFRAMA', function () {
    MockClient::global([MockResponse::make(['taxId' => '37335118000180'], 200)]);

    $response = $this->client->consultaSuframa('37335118000180');

    expect($response->status())->toBe(200);
});
