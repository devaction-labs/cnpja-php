<?php

declare(strict_types=1);

namespace Cnpja\Requests\Credit;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetCreditRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/credit';
    }
}
