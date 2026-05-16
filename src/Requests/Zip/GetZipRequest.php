<?php

declare(strict_types=1);

namespace Cnpja\Requests\Zip;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetZipRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $code) {}

    public function resolveEndpoint(): string
    {
        return "/zip/{$this->code}";
    }
}
