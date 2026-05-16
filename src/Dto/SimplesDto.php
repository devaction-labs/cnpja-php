<?php

declare(strict_types=1);

namespace Cnpja\Dto;

use Cnpja\Dto\Shared\SimplesOptDto;

final readonly class SimplesDto
{
    public function __construct(
        public string $taxId,
        public string $updated,
        public SimplesOptDto $simples,
        public SimplesOptDto $simei,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            taxId: (string) $data['taxId'],
            updated: (string) $data['updated'],
            simples: SimplesOptDto::fromArray($data['simples']),
            simei: SimplesOptDto::fromArray($data['simei']),
        );
    }
}
