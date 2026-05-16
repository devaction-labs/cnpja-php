<?php

declare(strict_types=1);

namespace Cnpja\Dto;

final readonly class CreditDto
{
    public function __construct(
        public int $perpetual,
        public int $transient,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            perpetual: (int) ($data['perpetual'] ?? 0),
            transient: (int) ($data['transient'] ?? 0),
        );
    }
}
