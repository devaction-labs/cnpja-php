<?php

declare(strict_types=1);

namespace Cnpja\Requests\Office;

use Cnpja\Params\GetOfficeParams;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetOfficeRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $taxId,
        private readonly ?GetOfficeParams $params = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/office/{$this->taxId}";
    }

    protected function defaultQuery(): array
    {
        return $this->params?->toArray() ?? [];
    }
}
