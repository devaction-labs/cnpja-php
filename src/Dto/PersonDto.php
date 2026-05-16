<?php

declare(strict_types=1);

namespace Cnpja\Dto;

use Cnpja\Dto\Shared\CountryDto;

final readonly class PersonDto
{
    /** @param PersonMembershipDto[] $membership */
    public function __construct(
        public string $id,
        public string $type,
        public string $name,
        public array $membership,
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
            membership: array_map(PersonMembershipDto::fromArray(...), $data['membership'] ?? []),
            taxId: isset($data['taxId']) ? (string) $data['taxId'] : null,
            age: isset($data['age']) ? (string) $data['age'] : null,
            country: isset($data['country']) ? CountryDto::fromArray($data['country']) : null,
        );
    }
}
