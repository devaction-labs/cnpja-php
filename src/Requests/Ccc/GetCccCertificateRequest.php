<?php

declare(strict_types=1);

namespace Cnpja\Requests\Ccc;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetCccCertificateRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $taxId,
        private readonly ?string $state = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/ccc/certificate';
    }

    protected function defaultHeaders(): array
    {
        return ['Accept' => 'application/pdf'];
    }

    protected function defaultQuery(): array
    {
        return array_filter(
            ['taxId' => $this->taxId, 'state' => $this->state],
            fn ($v) => $v !== null,
        );
    }
}
