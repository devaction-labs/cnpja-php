<?php

declare(strict_types=1);

namespace Cnpja\Exceptions;

use Saloon\Http\Response;

class ValidationException extends CnpjaException
{
    /** @var string[] */
    public readonly array $constraints;

    public function __construct(Response $response)
    {
        $this->constraints = $response->json('constraints') ?? [];
        parent::__construct($response);
    }
}
