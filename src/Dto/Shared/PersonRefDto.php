<?php

declare(strict_types=1);

namespace Cnpja\Dto\Shared;

final readonly class PersonRefDto
{
    public function __construct(
        public string $id,
        public string $type,
        public string $name,
        public ?string $taxId,
        public ?string $age,
        public ?CountryDto $country,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) $data['id'],
            type: (string) $data['type'],
            name: (string) $data['name'],
            taxId: isset($data['taxId']) ? (string) $data['taxId'] : null,
            age: isset($data['age']) ? (string) $data['age'] : null,
            country: isset($data['country']) ? CountryDto::fromArray($data['country']) : null,
        );
    }
}
