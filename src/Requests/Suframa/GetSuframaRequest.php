<?php

declare(strict_types=1);

namespace Cnpja\Requests\Suframa;

use Cnpja\Params\GetSuframaParams;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetSuframaRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $taxId,
        private readonly ?GetSuframaParams $params = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/suframa';
    }

    protected function defaultQuery(): array
    {
        return array_merge(['taxId' => $this->taxId], $this->params?->toArray() ?? []);
    }
}
