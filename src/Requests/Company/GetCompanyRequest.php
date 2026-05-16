<?php

declare(strict_types=1);

namespace Cnpja\Requests\Company;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetCompanyRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $companyId) {}

    public function resolveEndpoint(): string
    {
        return "/company/{$this->companyId}";
    }
}
