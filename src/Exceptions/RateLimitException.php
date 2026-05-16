<?php

declare(strict_types=1);

namespace Cnpja\Exceptions;

use Saloon\Http\Response;

class RateLimitException extends CnpjaException
{
    public readonly int $required;

    public readonly int $remaining;

    public function __construct(Response $response)
    {
        $this->required = (int) ($response->json('required') ?? 0);
        $this->remaining = (int) ($response->json('remaining') ?? 0);
        parent::__construct($response);
    }
}
