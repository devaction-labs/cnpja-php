<?php

declare(strict_types=1);

namespace Cnpja\Requests\Ccc;

use Cnpja\Params\GetCccParams;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetCccRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $taxId,
        private readonly string $states,
        private readonly ?GetCccParams $params = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/ccc';
    }

    protected function defaultQuery(): array
    {
        return array_merge(
            ['taxId' => $this->taxId, 'states' => $this->states],
            $this->params?->toArray() ?? [],
        );
    }
}
