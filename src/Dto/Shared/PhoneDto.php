<?php

declare(strict_types=1);

namespace Cnpja\Dto\Shared;

final readonly class PhoneDto
{
    public function __construct(
        public string $area,
        public string $number,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            area: (string) $data['area'],
            number: (string) $data['number'],
        );
    }
}
