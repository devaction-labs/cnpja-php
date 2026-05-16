<?php

declare(strict_types=1);

namespace Cnpja\Dto;

final readonly class SuframaIncentiveDto
{
    public function __construct(
        public string $tribute,
        public string $benefit,
        public string $purpose,
        public string $basis,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            tribute: (string) $data['tribute'],
            benefit: (string) $data['benefit'],
            purpose: (string) $data['purpose'],
            basis: (string) $data['basis'],
        );
    }
}
