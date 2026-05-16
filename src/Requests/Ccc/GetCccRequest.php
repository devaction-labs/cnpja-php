<?php

declare(strict_types=1);

namespace Cnpja\Requests\Ccc;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetCccRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array{strategy?: string, maxAge?: int, maxStale?: int, sync?: bool} $options
     */
    public function __construct(
        private readonly string $taxId,
        private readonly string $states,
        private readonly array $options = [],
    ) {}

    public function resolveEndpoint(): string
    {
        return '/ccc';
    }

    protected function defaultQuery(): array
    {
        return array_filter(
            ['taxId' => $this->taxId, 'states' => $this->states, ...$this->options],
            fn ($v) => $v !== null && $v !== '',
        );
    }
}
