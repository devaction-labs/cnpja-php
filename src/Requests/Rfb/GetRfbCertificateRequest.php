<?php

declare(strict_types=1);

namespace Cnpja\Requests\Rfb;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetRfbCertificateRequest extends Request
{
    protected Method $method = Method::GET;

    /** @param string|null $pages Páginas a incluir: REGISTRATION, MEMBERS (separadas por vírgula). */
    public function __construct(
        private readonly string $taxId,
        private readonly ?string $pages = null,
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
        $query = ['taxId' => $this->taxId];

        if ($this->pages !== null) {
            $query['pages'] = $this->pages;
        }

        return $query;
    }
}
