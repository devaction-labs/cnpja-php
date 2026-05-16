<?php

declare(strict_types=1);

namespace Cnpja\Requests\Person;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetPersonRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly string $personId) {}

    public function resolveEndpoint(): string
    {
        return "/person/{$this->personId}";
    }
}
