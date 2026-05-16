<?php

declare(strict_types=1);

namespace Cnpja\Dto\Shared;

final readonly class AgentDto
{
    public function __construct(
        public PersonRefDto $person,
        public LabelDto $role,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            person: PersonRefDto::fromArray($data['person']),
            role: LabelDto::fromArray($data['role']),
        );
    }
}
