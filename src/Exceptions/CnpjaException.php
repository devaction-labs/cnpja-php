<?php

declare(strict_types=1);

namespace Cnpja\Exceptions;

use JsonException;
use RuntimeException;
use Saloon\Http\Response;

class CnpjaException extends RuntimeException
{
    /**
     * @throws JsonException
     */
    public function __construct(
        public readonly Response $response,
        string $message = '',
    ) {
        $data = $response->json();
        $msg = $message ?: ($data['message'] ?? "CNPJá API error [{$response->status()}]");
        parent::__construct($msg, $response->status());
    }
}
