<?php

declare(strict_types=1);

namespace Cnpja\Requests\Person;

use Cnpja\Params\SearchPersonsParams;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class SearchPersonsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly ?SearchPersonsParams $params = null) {}

    public function resolveEndpoint(): string
    {
        return '/person';
    }

    protected function defaultQuery(): array
    {
        return $this->params?->toArray() ?? [];
    }
}
