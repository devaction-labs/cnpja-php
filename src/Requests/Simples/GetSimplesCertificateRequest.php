<?php

declare(strict_types=1);

namespace Cnpja\Requests\Simples;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetSimplesCertificateRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $taxId) {}

    public function resolveEndpoint(): string
    {
        return '/simples/certificate';
    }

    protected function defaultHeaders(): array
    {
        return ['Accept' => 'application/pdf'];
    }

    protected function defaultQuery(): array
    {
        return ['taxId' => $this->taxId];
    }
}
