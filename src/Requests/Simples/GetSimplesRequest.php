<?php

declare(strict_types=1);

namespace Cnpja\Requests\Simples;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetSimplesRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array{history?: bool, strategy?: string, maxAge?: int, maxStale?: int, sync?: bool} $options
     */
    public function __construct(
        private readonly string $taxId,
        private readonly array $options = [],
    ) {}

    public function resolveEndpoint(): string
    {
        return '/simples';
    }

    protected function defaultQuery(): array
    {
        return array_filter(
            ['taxId' => $this->taxId, ...$this->options],
            fn ($v) => $v !== null && $v !== '',
        );
    }
}
