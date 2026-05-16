<?php

declare(strict_types=1);

namespace Cnpja\Requests\Office;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class SearchOfficesRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array{
     *   token?: string,
     *   limit?: int,
     *   "alias.in"?: string,
     *   "legalNature.in"?: string,
     *   "alias.nin"?: string,
     *   "legalNature.nin"?: string,
     *   "equity.gte"?: float,
     *   "equity.lte"?: float,
     * } $filters
     */
    public function __construct(private readonly array $filters = []) {}

    public function resolveEndpoint(): string
    {
        return '/office';
    }

    protected function defaultQuery(): array
    {
        return array_filter($this->filters, fn ($v) => $v !== null && $v !== '');
    }
}
