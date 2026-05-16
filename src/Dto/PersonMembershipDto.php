<?php

declare(strict_types=1);

namespace Cnpja\Dto;

use Cnpja\Dto\Shared\AgentDto;
use Cnpja\Dto\Shared\LabelDto;

final readonly class PersonMembershipDto
{
    public function __construct(
        public string $since,
        public LabelDto $role,
        public PersonMembershipCompanyDto $company,
        public ?AgentDto $agent,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            since: (string) $data['since'],
            role: LabelDto::fromArray($data['role']),
            company: PersonMembershipCompanyDto::fromArray($data['company']),
            agent: isset($data['agent']) ? AgentDto::fromArray($data['agent']) : null,
        );
    }
}
