<?php

declare(strict_types=1);

namespace Cnpja\Dto\Shared;

final readonly class MemberDto
{
    public function __construct(
        public string $since,
        public PersonRefDto $person,
        public LabelDto $role,
        public ?AgentDto $agent,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            since: (string) $data['since'],
            person: PersonRefDto::fromArray($data['person']),
            role: LabelDto::fromArray($data['role']),
            agent: isset($data['agent']) ? AgentDto::fromArray($data['agent']) : null,
        );
    }
}
