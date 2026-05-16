<?php

declare(strict_types=1);

namespace Cnpja\Dto;

use Cnpja\Dto\Shared\LabelDto;
use Cnpja\Dto\Shared\MemberDto;
use Cnpja\Dto\Shared\SimplesOptDto;
use Cnpja\Dto\Shared\SizeLabelDto;

final readonly class CompanyDto
{
    /**
     * @param  MemberDto[]  $members
     * @param  OfficeDto[]  $offices
     */
    public function __construct(
        public int $id,
        public string $name,
        public float $equity,
        public LabelDto $nature,
        public SizeLabelDto $size,
        public string $jurisdiction,
        public array $members,
        public array $offices,
        public ?SimplesOptDto $simples,
        public ?SimplesOptDto $simei,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            name: (string) $data['name'],
            equity: (float) ($data['equity'] ?? 0),
            nature: LabelDto::fromArray($data['nature']),
            size: SizeLabelDto::fromArray($data['size']),
            jurisdiction: (string) ($data['jurisdiction'] ?? ''),
            members: array_map(MemberDto::fromArray(...), $data['members'] ?? []),
            offices: array_map(OfficeDto::fromArray(...), $data['offices'] ?? []),
            simples: isset($data['simples']) ? SimplesOptDto::fromArray($data['simples']) : null,
            simei: isset($data['simei']) ? SimplesOptDto::fromArray($data['simei']) : null,
        );
    }
}
