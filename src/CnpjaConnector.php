<?php

declare(strict_types=1);

namespace Cnpja;

use Saloon\Http\Auth\HeaderAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Response;
use Throwable;
use Cnpja\Exceptions\CnpjaException;
use Cnpja\Exceptions\NotFoundException;
use Cnpja\Exceptions\RateLimitException;
use Cnpja\Exceptions\UnauthorizedException;
use Cnpja\Exceptions\ValidationException;
use Cnpja\Exceptions\ServiceUnavailableException;

class CnpjaConnector extends Connector
{
    public function __construct(private readonly string $apiKey) {}

    public function resolveBaseUrl(): string
    {
        return 'https://api.cnpja.com';
    }

    protected function defaultAuth(): HeaderAuthenticator
    {
        return new HeaderAuthenticator($this->apiKey);
    }

    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() >= 400;
    }

    public function getRequestException(Response $response, ?Throwable $senderException): ?Throwable
    {
        return match ($response->status()) {
            400 => new ValidationException($response),
            401 => new UnauthorizedException($response),
            404 => new NotFoundException($response),
            429 => new RateLimitException($response),
            503 => new ServiceUnavailableException($response),
            default => new CnpjaException($response),
        };
    }
}
