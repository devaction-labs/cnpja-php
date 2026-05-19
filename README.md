# CNPJá PHP SDK

SDK PHP para a [API CNPJá](https://cnpja.com) — consulta CNPJ, CEP, Receita Federal, Simples Nacional, CCC e SUFRAMA em tempo real.

Construído com [Saloon v4](https://docs.saloon.dev) e suporte nativo ao Laravel via Service Provider e Facade.

## Requisitos

- PHP 8.4+
- Composer

## Instalação

```bash
composer require devaction/cnpja-php
```

### Laravel

O SDK é auto-descoberto pelo Laravel (via `extra.laravel` no `composer.json`). Publique a config:

```bash
php artisan vendor:publish --tag=cnpja-config
```

Adicione sua chave no `.env`:

```env
CNPJA_API_KEY=sua-chave-aqui
```

## Uso Básico

### Standalone

```php
use Cnpja\CnpjaClient;

$client = new CnpjaClient('sua-chave-api');

$office = $client->getOffice('37335118000180');

echo $office->taxId;            // "37335118000180"
echo $office->alias;            // "CNPJA"
echo $office->status->text;     // "Ativa"
echo $office->address->city;    // "São Paulo"
echo $office->address->state;   // "SP"
echo $office->phones[0]->area;  // "11"
```

### Laravel (Facade)

```php
use Cnpja\Laravel\Facades\Cnpja;

$office = Cnpja::getOffice('37335118000180');
```

### Laravel (Injeção de Dependência)

```php
use Cnpja\CnpjaClient;

class EmpresaController extends Controller
{
    public function show(CnpjaClient $cnpja, string $cnpj)
    {
        $office = $cnpja->getOffice($cnpj);

        return response()->json([
            'nome'     => $office->company?->name,
            'situacao' => $office->status->text,
            'cidade'   => $office->address->city,
        ]);
    }
}
```

---

## Endpoints

### Créditos

```php
$saldo = $client->getCredit();

$saldo->perpetual;   // int — créditos permanentes
$saldo->transient;   // int — créditos temporários
```

---

### CEP

```php
$zip = $client->getZip('01452922');

$zip->code;          // "01452922"
$zip->city;          // "São Paulo"
$zip->state;         // "SP"
$zip->street;        // "Avenida Brigadeiro Faria Lima"
$zip->district;      // "Jardim Paulistano"
$zip->municipality;  // 3550308 (código IBGE)
$zip->updated;       // "2024-06-05T17:52:39.136Z"
```

---

### Empresa (8 primeiros dígitos do CNPJ)

```php
$company = $client->getCompany('37335118');

$company->id;                    // 37335118
$company->name;                  // "CNPJA TECNOLOGIA LTDA"
$company->equity;                // 1000.0 (capital social)
$company->nature->text;          // "Sociedade Empresária Limitada"
$company->size->acronym;         // "ME"
$company->jurisdiction;          // "Uniao"
$company->simples?->optant;      // true
$company->simei?->since;         // "2020-06-05"

// Sócios
foreach ($company->members as $member) {
    $member->person->name;       // "João Silva"
    $member->role->text;         // "Sócio-Administrador"
    $member->since;              // "2020-06-05"
}
```

---

### CNPJ (Estabelecimento)

#### Consulta simples

```php
$office = $client->getOffice('37335118000180');
```

#### Com parâmetros opcionais

```php
use Cnpja\Params\GetOfficeParams;
use Cnpja\Params\CacheParams;

$office = $client->getOffice('37335118000180', new GetOfficeParams(
    simples: true,           // +1 crédito — inclui Simples/MEI
    simplesHistory: true,    // +1 crédito — inclui histórico Simples/MEI
    registrations: 'ALL',        // +1 crédito — inscrições estaduais (ORIGIN, ALL ou UFs)
    registrationsSource: 'CCC', // fonte: AUTO, CCC ou SINTEGRA
    suframa: true,               // +1 crédito — inclui dados da SUFRAMA
    geocoding: true,             // +1 crédito — inclui lat/long do endereço
    links: 'RFB_CERTIFICATE,SIMPLES_CERTIFICATE,CCC_CERTIFICATE,SUFRAMA_CERTIFICATE,OFFICE_MAP,OFFICE_STREET',
    cache: new CacheParams(
        strategy: 'CACHE_IF_ERROR',
        maxAge: 45,
        maxStale: 365,
    ),
));
```

#### Campos disponíveis

```php
$office->taxId;                         // "37335118000180"
$office->updated;                       // "2024-06-05T..."
$office->alias;                         // "CNPJA"
$office->founded;                       // "2020-06-05"
$office->head;                          // true (matriz)
$office->status->id;                    // 2
$office->status->text;                  // "Ativa"
$office->statusDate;                    // "2020-06-05"

// Empresa mãe
$office->company?->name;                // "CNPJA TECNOLOGIA LTDA"
$office->company?->equity;              // 1000.0
$office->company?->nature->text;        // "Sociedade Empresária Limitada"
$office->company?->size->acronym;       // "ME"
$office->company?->simples?->optant;    // true
$office->company?->members[0]->person->name;  // "João Silva"

// Endereço
$office->address->street;               // "Avenida Brigadeiro Faria Lima"
$office->address->number;               // "2369"
$office->address->district;             // "Jardim Paulistano"
$office->address->city;                 // "São Paulo"
$office->address->state;                // "SP"
$office->address->zip;                  // "01452922"
$office->address->latitude;             // -23.5774994 (requer geocoding: true)
$office->address->longitude;            // -46.6864608 (requer geocoding: true)

// Contatos
$office->phones[0]->area;               // "11"
$office->phones[0]->number;             // "971564144"
$office->emails[0]->address;            // "contato@cnpja.com"
$office->emails[0]->domain;             // "cnpja.com"

// Atividades
$office->mainActivity->id;              // 6311900
$office->mainActivity->text;            // "Tratamento de dados..."
$office->sideActivities[0]->text;       // ...

// Situação especial
$office->reason?->text;                 // nullable
$office->special?->text;                // nullable
$office->specialDate;                   // nullable

// Inscrições estaduais (requer registrations)
foreach ($office->registrations as $reg) {
    $reg->number;      // "0962101427"
    $reg->state;       // "RS"
    $reg->enabled;     // true
    $reg->status->text; // "Ativa"
    $reg->type->text;   // "IE Normal"
}

// Links de comprovantes (requer links param)
$office->links?->rfbCertificate;        // URL do PDF
$office->links?->simplesCertificate;    // URL do PDF
$office->links?->cccCertificate;        // URL do PDF
$office->links?->suframaCertificate;    // URL do PDF
$office->links?->officeMap;             // URL da imagem PNG
$office->links?->officeStreet;          // URL da imagem PNG
```

#### Pesquisa de CNPJs

```php
use Cnpja\Params\SearchOfficesParams;

$resultado = $client->searchOffices(new SearchOfficesParams(
    aliasIn: 'teuto',
    stateIn: 'SP,RJ',
    statusIn: '2',          // 2 = Ativa
    simplesOptant: true,
    limit: 10,
));

$resultado->count;          // total de registros
$resultado->next;           // token para próxima página
$resultado->records;        // OfficeDto[]

// Paginação
$pagina2 = $client->searchOffices(new SearchOfficesParams(
    token: $resultado->next,
));
```

#### Imagens do endereço

```php
// Retornam string com bytes PNG
$png = $client->getOfficeMap('37335118000180', ['zoom' => 17, 'width' => 640]);
$png = $client->getOfficeStreetView('37335118000180', ['fov' => 90, 'width' => 640]);

// Salvar em disco
file_put_contents('mapa.png', $png);
```

---

### Receita Federal

```php
use Cnpja\Params\GetRfbParams;
use Cnpja\Params\CacheParams;

$rfb = $client->getRfb('37335118000180', new GetRfbParams(
    cache: new CacheParams(strategy: 'CACHE_IF_ERROR'),
));

$rfb->taxId;                // "37335118000180"
$rfb->name;                 // "CNPJA TECNOLOGIA LTDA"
$rfb->equity;               // 1000.0
$rfb->nature->text;         // "Sociedade Empresária Limitada"
$rfb->size->acronym;        // "ME"
$rfb->jurisdiction;         // "Uniao"
$rfb->status->text;         // "Ativa"
$rfb->address->city;        // "São Paulo"
$rfb->members[0]->person->name;  // "João Silva"

// PDF do comprovante (bytes brutos)
$pdf = $client->getRfbCertificate('37335118000180', pages: 'REGISTRATION,MEMBERS');
file_put_contents('rfb.pdf', $pdf);
```

---

### Simples Nacional e MEI

```php
use Cnpja\Params\GetSimplesParams;
use Cnpja\Params\CacheParams;

$simples = $client->getSimples('37335118000180', new GetSimplesParams(
    history: true,           // +1 crédito — inclui histórico de períodos
    cache: new CacheParams(strategy: 'CACHE_IF_ERROR'),
));

$simples->taxId;              // "37335118000180"
$simples->simples->optant;    // true
$simples->simples->since;     // "2020-06-05"
$simples->simei->optant;      // false

// Histórico de exclusões
foreach ($simples->simples->history as $entry) {
    $entry->from;   // "2012-12-26"
    $entry->until;  // "2013-12-31"
    $entry->text;   // "Excluída por Ato Administrativo..."
}

// PDF do comprovante
$pdf = $client->getSimplesCertificate('37335118000180');
```

---

### CCC (Cadastro Centralizado de Contribuintes)

```php
use Cnpja\Params\GetCccParams;
use Cnpja\Params\CacheParams;

$ccc = $client->getCcc('37335118000180', 'ALL', new GetCccParams(
    source: 'CCC',
    cache: new CacheParams(strategy: 'CACHE_IF_ERROR'),
));

$ccc->taxId;          // "37335118000180"
$ccc->originState;    // "PR"

foreach ($ccc->registrations as $reg) {
    $reg->number;        // "0962101427"
    $reg->state;         // "RS"
    $reg->enabled;       // true
    $reg->statusDate;    // "2021-01-21"
    $reg->status->text;  // "Bloqueado como destinatário na UF"
    $reg->type->text;    // "IE Substituto Tributário"
}

// PDF do comprovante
$pdf = $client->getCccCertificate('37335118000180', state: 'SP');
```

---

### SUFRAMA

```php
use Cnpja\Params\GetSuframaParams;
use Cnpja\Params\CacheParams;

$suframa = $client->getSuframa('37335118000180', new GetSuframaParams(
    cache: new CacheParams(strategy: 'CACHE_IF_ERROR'),
));

$suframa->taxId;           // "37335118000180"
$suframa->number;          // "200400029"
$suframa->name;            // "CNPJA TECNOLOGIA LTDA"
$suframa->approved;        // true
$suframa->approvalDate;    // "2021-01-01"
$suframa->status->text;    // "Ativa"

foreach ($suframa->incentives as $incentive) {
    $incentive->tribute; // "IPI"
    $incentive->benefit; // "Isenção"
    $incentive->purpose; // "Consumo Interno, Industrialização..."
    $incentive->basis;   // "Decreto 7.212 de 2010 (Art. 81)"
}

// PDF do comprovante
$pdf = $client->getSuframaCertificate('37335118000180');
```

---

## Tratamento de Erros

Todos os erros da API lançam exceções tipadas de `Cnpja\Exceptions\CnpjaException`:

```php
use Cnpja\Exceptions\UnauthorizedException;
use Cnpja\Exceptions\NotFoundException;
use Cnpja\Exceptions\RateLimitException;
use Cnpja\Exceptions\ValidationException;
use Cnpja\Exceptions\ServiceUnavailableException;

try {
    $office = $client->getOffice('37335118000180');
} catch (UnauthorizedException $e) {
    // 401 — chave de API inválida ou ausente
    echo $e->getMessage();
} catch (NotFoundException $e) {
    // 404 — CNPJ não encontrado
    echo $e->getMessage();
} catch (RateLimitException $e) {
    // 429 — créditos insuficientes ou limite por minuto excedido
    echo "Necessário: {$e->required}, Disponível: {$e->remaining}";
} catch (ValidationException $e) {
    // 400 — parâmetros inválidos
    echo implode(', ', $e->constraints);
} catch (ServiceUnavailableException $e) {
    // 503 — órgão consultado temporariamente indisponível
} catch (\Cnpja\Exceptions\CnpjaException $e) {
    // qualquer outro erro da API
    $e->response->status();  // código HTTP
    $e->response->json();    // body completo
}
```

## Estratégias de Cache

Disponível nos endpoints que suportam `CacheParams`:

| Estratégia       | Comportamento                                                              |
|------------------|---------------------------------------------------------------------------|
| `CACHE`          | Entrega dados do cache; erro 404 se não disponível (não cobra créditos)   |
| `CACHE_IF_FRESH` | Usa cache se dentro do `maxAge`; consulta online se desatualizado         |
| `CACHE_IF_ERROR` | Como `CACHE_IF_FRESH`; usa cache dentro do `maxStale` se online falhar    |
| `ONLINE`         | Sempre consulta online (ignorar cache; prefira `maxAge=1` como alternativa)|

```php
use Cnpja\Params\CacheParams;

$cache = new CacheParams(
    strategy: 'CACHE_IF_ERROR',
    maxAge: 45,      // dias — idade máxima do cache aceita
    maxStale: 365,   // dias — idade máxima aceita em caso de falha online
    sync: false,     // aguardar compensação síncrona de créditos
);
```

## Estrutura do Projeto

```
src/
├── CnpjaClient.php             # Ponto de entrada principal
├── CnpjaConnector.php          # Conector Saloon (base URL, auth)
├── Dto/
│   ├── Shared/                 # DTOs compartilhados entre endpoints
│   │   ├── AddressDto.php
│   │   ├── ActivityDto.php
│   │   ├── AgentDto.php
│   │   ├── CountryDto.php
│   │   ├── EmailDto.php
│   │   ├── LabelDto.php
│   │   ├── MemberDto.php
│   │   ├── PersonRefDto.php
│   │   ├── PhoneDto.php
│   │   ├── SimplesHistoryDto.php
│   │   ├── SimplesOptDto.php
│   │   ├── SizeLabelDto.php
│   │   └── StateRegistrationDto.php
│   ├── CccDto.php
│   ├── CompanyDto.php
│   ├── CompanyRefDto.php
│   ├── CreditDto.php
│   ├── OfficeDto.php
│   ├── OfficeLinksDto.php
│   ├── OfficeSearchDto.php
│   ├── PersonDto.php
│   ├── PersonMembershipCompanyDto.php
│   ├── PersonMembershipDto.php
│   ├── PersonSearchDto.php
│   ├── RfbDto.php
│   ├── SimplesDto.php
│   ├── SuframaDto.php
│   ├── SuframaIncentiveDto.php
│   └── ZipDto.php
├── Exceptions/                 # Exceções tipadas por código HTTP
│   ├── CnpjaException.php
│   ├── NotFoundException.php
│   ├── RateLimitException.php
│   ├── ServiceUnavailableException.php
│   ├── UnauthorizedException.php
│   └── ValidationException.php
├── Laravel/
│   ├── CnpjaServiceProvider.php
│   └── Facades/Cnpja.php
├── Params/                     # Objetos de parâmetros tipados
│   ├── CacheParams.php
│   ├── GetCccParams.php
│   ├── GetOfficeParams.php
│   ├── GetRfbParams.php
│   ├── GetSimplesParams.php
│   ├── GetSuframaParams.php
│   ├── SearchOfficesParams.php
│   └── SearchPersonsParams.php
└── Requests/                   # Request classes do Saloon (1 por endpoint)
    ├── Ccc/
    ├── Company/
    ├── Credit/
    ├── Office/
    ├── Person/
    ├── Rfb/
    ├── Simples/
    ├── Suframa/
    └── Zip/
```

## Testes

```bash
composer test:unit   # Pest com mocks do Saloon
```

## Licença

MIT
