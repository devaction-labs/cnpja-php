<?php

declare(strict_types=1);

namespace Cnpja\Dto;

use Cnpja\Dto\Shared\LabelDto;
use Cnpja\Dto\Shared\SizeLabelDto;

final readonly class PersonMembershipCompanyDto
{
    public function __construct(
        public int $id,
        public string $name,
        public float $equity,
        public LabelDto $nature,
        public SizeLabelDto $size,
        public string $jurisdiction,
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
        );
    }
}
