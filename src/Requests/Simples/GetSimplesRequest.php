<?php

declare(strict_types=1);

namespace Cnpja\Requests\Simples;

use Cnpja\Params\GetSimplesParams;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetSimplesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $taxId,
        private readonly ?GetSimplesParams $params = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/simples';
    }

    protected function defaultQuery(): array
    {
        return array_merge(['taxId' => $this->taxId], $this->params?->toArray() ?? []);
    }
}
