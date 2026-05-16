<?php

declare(strict_types=1);

namespace Cnpja\Requests\Rfb;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetRfbCertificateRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array{pages?: string} $options
     */
    public function __construct(
        private readonly string $taxId,
        private readonly array $options = [],
    ) {}

    public function resolveEndpoint(): string
    {
        return '/rfb/certificate';
    }

    protected function defaultHeaders(): array
    {
        return ['Accept' => 'application/pdf'];
    }

    protected function defaultQuery(): array
    {
        return array_filter(
            ['taxId' => $this->taxId, ...$this->options],
            fn ($v) => $v !== null && $v !== '',
        );
    }
}
