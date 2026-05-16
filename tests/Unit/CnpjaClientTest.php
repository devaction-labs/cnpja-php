<?php

declare(strict_types=1);

use Cnpja\CnpjaClient;
use Cnpja\Dto\CccDto;
use Cnpja\Dto\CreditDto;
use Cnpja\Dto\OfficeDto;
use Cnpja\Dto\RfbDto;
use Cnpja\Dto\SimplesDto;
use Cnpja\Dto\SuframaDto;
use Cnpja\Dto\ZipDto;
use Cnpja\Exceptions\NotFoundException;
use Cnpja\Exceptions\RateLimitException;
use Cnpja\Exceptions\UnauthorizedException;
use Cnpja\Params\CacheParams;
use Cnpja\Params\GetOfficeParams;
use Cnpja\Params\GetRfbParams;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function (): void {
    MockClient::destroyGlobal();
    $this->client = new CnpjaClient('test-key');
});

afterEach(fn () => MockClient::destroyGlobal());

it('returns CreditDto with balance', function (): void {
    MockClient::global([MockResponse::make(['perpetual' => 2000, 'transient' => 10000], 200)]);

    $dto = $this->client->getCredit();

    expect($dto)->toBeInstanceOf(CreditDto::class)
        ->and($dto->perpetual)->toBe(2000)
        ->and($dto->transient)->toBe(10000);
});

it('returns ZipDto with ZIP data', function (): void {
    MockClient::global([MockResponse::make([
        'updated' => '2024-06-05T17:52:39.136Z',
        'municipality' => 3550308,
        'code' => '01310100',
        'city' => 'São Paulo',
        'state' => 'SP',
        'street' => 'Avenida Paulista',
        'number' => null,
        'district' => 'Bela Vista',
    ], 200)]);

    $dto = $this->client->getZip('01310100');

    expect($dto)->toBeInstanceOf(ZipDto::class)
        ->and($dto->city)->toBe('São Paulo')
        ->and($dto->state)->toBe('SP')
        ->and($dto->code)->toBe('01310100');
});

it('returns OfficeDto with CNPJ data', function (): void {
    MockClient::global([MockResponse::make([
        'taxId' => '37335118000180',
        'updated' => '2024-06-05T17:52:39.136Z',
        'alias' => 'CNPJA',
        'founded' => '2020-06-05',
        'head' => true,
        'statusDate' => '2020-06-05',
        'status' => ['id' => 2, 'text' => 'Ativa'],
        'address' => ['municipality' => 3550308, 'city' => 'São Paulo', 'state' => 'SP', 'zip' => '01452922'],
        'mainActivity' => ['id' => 6311900, 'text' => 'Tratamento de dados'],
        'phones' => [['area' => '11', 'number' => '971564144']],
        'emails' => [['address' => 'contato@cnpja.com', 'domain' => 'cnpja.com']],
        'sideActivities' => [],
    ], 200)]);

    $dto = $this->client->getOffice('37335118000180');

    expect($dto)->toBeInstanceOf(OfficeDto::class)
        ->and($dto->taxId)->toBe('37335118000180')
        ->and($dto->alias)->toBe('CNPJA')
        ->and($dto->status->text)->toBe('Ativa')
        ->and($dto->address->city)->toBe('São Paulo')
        ->and($dto->phones[0]->area)->toBe('11')
        ->and($dto->emails[0]->domain)->toBe('cnpja.com');
});

it('passes typed GetOfficeParams to the request', function (): void {
    MockClient::global([MockResponse::make([
        'taxId' => '37335118000180', 'updated' => '', 'alias' => '', 'founded' => '',
        'head' => false, 'statusDate' => '', 'status' => ['id' => 2, 'text' => 'Ativa'],
        'address' => ['municipality' => 0, 'city' => '', 'state' => '', 'zip' => ''],
        'mainActivity' => ['id' => 0, 'text' => ''],
        'phones' => [], 'emails' => [], 'sideActivities' => [],
    ], 200)]);

    $params = new GetOfficeParams(
        simples: true,
        geocoding: true,
        registrations: 'SP',
        cache: new CacheParams(strategy: 'CACHE_IF_ERROR', maxAge: 45),
    );

    $dto = $this->client->getOffice('37335118000180', $params);

    expect($dto)->toBeInstanceOf(OfficeDto::class);
});

it('throws UnauthorizedException on 401', function (): void {
    MockClient::global([MockResponse::make(['code' => 401, 'message' => 'invalid authentication'], 401)]);

    $this->client->getOffice('37335118000180');
})->throws(UnauthorizedException::class);

it('throws NotFoundException on 404', function (): void {
    MockClient::global([MockResponse::make(['code' => 404, 'message' => 'not found'], 404)]);

    $this->client->getOffice('00000000000000');
})->throws(NotFoundException::class);

it('throws RateLimitException on 429 with correct credit fields', function (): void {
    MockClient::global([
        MockResponse::make(['code' => 429, 'message' => 'not enough credits', 'required' => 3, 'remaining' => 1], 429),
    ]);

    try {
        $this->client->getOffice('37335118000180');
    } catch (RateLimitException $e) {
        expect($e->required)->toBe(3)
            ->and($e->remaining)->toBe(1);
    }
});

it('returns RfbDto with cache params', function (): void {
    MockClient::global([MockResponse::make([
        'taxId' => '37335118000180', 'updated' => '', 'name' => 'CNPJA',
        'equity' => 1000, 'nature' => ['id' => 2062, 'text' => 'Ltda'],
        'size' => ['id' => 1, 'acronym' => 'ME', 'text' => 'Microempresa'],
        'jurisdiction' => 'Uniao', 'alias' => '', 'founded' => '', 'head' => false,
        'statusDate' => '', 'status' => ['id' => 2, 'text' => 'Ativa'],
        'address' => ['municipality' => 0, 'city' => '', 'state' => '', 'zip' => ''],
        'mainActivity' => ['id' => 0, 'text' => ''],
        'members' => [], 'phones' => [], 'emails' => [], 'sideActivities' => [],
    ], 200)]);

    $dto = $this->client->getRfb('37335118000180', new GetRfbParams(
        cache: new CacheParams(strategy: 'CACHE_IF_ERROR', maxAge: 45),
    ));

    expect($dto)->toBeInstanceOf(RfbDto::class)
        ->and($dto->name)->toBe('CNPJA')
        ->and($dto->nature->text)->toBe('Ltda')
        ->and($dto->size->acronym)->toBe('ME');
});

it('returns SimplesDto with optant true', function (): void {
    MockClient::global([MockResponse::make([
        'taxId' => '37335118000180',
        'updated' => '2024-06-05T17:52:39.136Z',
        'simples' => ['optant' => true, 'since' => '2020-06-05', 'history' => []],
        'simei' => ['optant' => false, 'since' => null, 'history' => []],
    ], 200)]);

    $dto = $this->client->getSimples('37335118000180');

    expect($dto)->toBeInstanceOf(SimplesDto::class)
        ->and($dto->simples->optant)->toBeTrue()
        ->and($dto->simei->optant)->toBeFalse();
});

it('returns CccDto with state registrations', function (): void {
    MockClient::global([MockResponse::make([
        'taxId' => '37335118000180',
        'updated' => '2024-06-05T17:52:39.136Z',
        'originState' => 'PR',
        'registrations' => [
            [
                'number' => '0962101427',
                'state' => 'RS',
                'enabled' => true,
                'statusDate' => '2021-01-21',
                'status' => ['id' => 2, 'text' => 'Bloqueado'],
                'type' => ['id' => 2, 'text' => 'IE Substituto'],
            ],
        ],
    ], 200)]);

    $dto = $this->client->getCcc('37335118000180', 'PR,RS,SC');

    expect($dto)->toBeInstanceOf(CccDto::class)
        ->and($dto->originState)->toBe('PR')
        ->and($dto->registrations[0]->state)->toBe('RS')
        ->and($dto->registrations[0]->enabled)->toBeTrue();
});

it('returns SuframaDto with incentives', function (): void {
    MockClient::global([MockResponse::make([
        'taxId' => '37335118000180',
        'updated' => '2024-06-05T17:52:39.136Z',
        'number' => '200400029',
        'name' => 'CNPJA',
        'since' => '2020-01-01',
        'head' => true,
        'approved' => true,
        'approvalDate' => '2021-01-01',
        'status' => ['id' => 1, 'text' => 'Ativa'],
        'nature' => ['id' => 2062, 'text' => 'Ltda'],
        'mainActivity' => ['id' => 6311900, 'text' => 'Tratamento de dados'],
        'phones' => [],
        'emails' => [],
        'sideActivities' => [],
        'incentives' => [
            ['tribute' => 'IPI', 'benefit' => 'Isenção', 'purpose' => 'Consumo Interno', 'basis' => 'Decreto 7.212'],
        ],
    ], 200)]);

    $dto = $this->client->getSuframa('37335118000180');

    expect($dto)->toBeInstanceOf(SuframaDto::class)
        ->and($dto->number)->toBe('200400029')
        ->and($dto->approved)->toBeTrue()
        ->and($dto->incentives[0]->tribute)->toBe('IPI');
});
