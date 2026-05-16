<?php

declare(strict_types=1);

namespace Cnpja\Dto;

use Cnpja\Dto\Shared\LabelDto;
use Cnpja\Dto\Shared\MemberDto;
use Cnpja\Dto\Shared\SimplesOptDto;
use Cnpja\Dto\Shared\SizeLabelDto;

/**
 * Referência à empresa embutida dentro do OfficeDto.
 * Idêntico ao CompanyDto mas sem o array de offices (evita recursão).
 */
final readonly class CompanyRefDto
{
    /** @param MemberDto[] $members */
    public function __construct(
        public int $id,
        public string $name,
        public float $equity,
        public LabelDto $nature,
        public SizeLabelDto $size,
        public string $jurisdiction,
        public array $members,
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
            simples: isset($data['simples']) ? SimplesOptDto::fromArray($data['simples']) : null,
            simei: isset($data['simei']) ? SimplesOptDto::fromArray($data['simei']) : null,
        );
    }
}
