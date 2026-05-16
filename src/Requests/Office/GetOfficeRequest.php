<?php

declare(strict_types=1);

namespace Cnpja\Requests\Office;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetOfficeRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array{
     *   simei?: bool,
     *   simplesHistory?: bool,
     *   registrations?: string,
     *   geocoding?: bool,
     *   links?: string,
     *   strategy?: string,
     *   maxAge?: int,
     *   maxStale?: int,
     *   sync?: bool,
     * } $options
     */
    public function __construct(
        private readonly string $taxId,
        private readonly array $options = [],
    ) {}

    public function resolveEndpoint(): string
    {
        return "/office/{$this->taxId}";
    }

    protected function defaultQuery(): array
    {
        return array_filter($this->options, fn ($v) => $v !== null && $v !== '');
    }
}
