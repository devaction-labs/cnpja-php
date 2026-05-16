<?php

declare(strict_types=1);

namespace Cnpja\Requests\Office;

use Cnpja\Params\SearchOfficesParams;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class SearchOfficesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly ?SearchOfficesParams $params = null) {}

    public function resolveEndpoint(): string
    {
        return '/office';
    }

    protected function defaultQuery(): array
    {
        return $this->params?->toArray() ?? [];
    }
}
