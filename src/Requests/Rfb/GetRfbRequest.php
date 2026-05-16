<?php

declare(strict_types=1);

namespace Cnpja\Requests\Rfb;

use Cnpja\Params\GetRfbParams;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetRfbRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $taxId,
        private readonly ?GetRfbParams $params = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/rfb';
    }

    protected function defaultQuery(): array
    {
        return array_merge(['taxId' => $this->taxId], $this->params?->toArray() ?? []);
    }
}
