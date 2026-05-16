<?php

declare(strict_types=1);

namespace Cnpja\Dto\Shared;

final readonly class CountryDto
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            name: (string) $data['name'],
        );
    }
}
