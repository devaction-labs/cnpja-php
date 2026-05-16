<?php

declare(strict_types=1);

namespace Cnpja\Dto\Shared;

final readonly class EmailDto
{
    public function __construct(
        public string $address,
        public string $domain,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            address: (string) $data['address'],
            domain: (string) $data['domain'],
        );
    }
}
