<?php

declare(strict_types=1);

namespace Cnpja\Dto\Shared;

final readonly class StateRegistrationDto
{
    public function __construct(
        public string $number,
        public string $state,
        public bool $enabled,
        public string $statusDate,
        public LabelDto $status,
        public LabelDto $type,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            number: (string) $data['number'],
            state: (string) $data['state'],
            enabled: (bool) $data['enabled'],
            statusDate: (string) $data['statusDate'],
            status: LabelDto::fromArray($data['status']),
            type: LabelDto::fromArray($data['type']),
        );
    }
}
