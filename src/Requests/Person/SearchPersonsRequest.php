<?php

declare(strict_types=1);

namespace Cnpja\Requests\Person;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class SearchPersonsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array{
     *   token?: string,
     *   limit?: int,
     *   "type.in"?: string,
     *   "name.in"?: string,
     *   "name.nin"?: string,
     *   "taxId.in"?: string,
     *   "age.in"?: string,
     *   "role.in"?: string,
     * } $filters
     */
    public function __construct(private readonly array $filters = []) {}

    public function resolveEndpoint(): string
    {
        return '/person';
    }

    protected function defaultQuery(): array
    {
        return array_filter($this->filters, fn ($v) => $v !== null && $v !== '');
    }
}
