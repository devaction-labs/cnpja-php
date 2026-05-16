<?php

declare(strict_types=1);

namespace Cnpja\Dto;

use Cnpja\Dto\Shared\StateRegistrationDto;

final readonly class CccDto
{
    /** @param StateRegistrationDto[] $registrations */
    public function __construct(
        public string $taxId,
        public string $updated,
        public string $originState,
        public array $registrations,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            taxId: (string) $data['taxId'],
            updated: (string) $data['updated'],
            originState: (string) ($data['originState'] ?? ''),
            registrations: array_map(
                StateRegistrationDto::fromArray(...),
                $data['registrations'] ?? [],
            ),
        );
    }
}
