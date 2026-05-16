<?php

declare(strict_types=1);

namespace Cnpja\Requests\Office;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetOfficeMapRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array{width?: int, height?: int, scale?: int, zoom?: int, type?: string}  $options
     */
    public function __construct(
        private readonly string $taxId,
        private readonly array $options = [],
    ) {}

    public function resolveEndpoint(): string
    {
        return "/office/{$this->taxId}/map";
    }

    protected function defaultHeaders(): array
    {
        return ['Accept' => 'image/png'];
    }

    protected function defaultQuery(): array
    {
        return $this->options;
    }
}
