<?php

declare(strict_types=1);

namespace Cnpja\Dto;

final readonly class ZipDto
{
    public function __construct(
        public string $updated,
        public int $municipality,
        public string $code,
        public string $city,
        public string $state,
        public ?string $street,
        public ?string $number,
        public ?string $district,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            updated: (string) $data['updated'],
            municipality: (int) $data['municipality'],
            code: (string) $data['code'],
            city: (string) $data['city'],
            state: (string) $data['state'],
            street: isset($data['street']) ? (string) $data['street'] : null,
            number: isset($data['number']) ? (string) $data['number'] : null,
            district: isset($data['district']) ? (string) $data['district'] : null,
        );
    }
}
