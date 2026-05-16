<?php

declare(strict_types=1);

namespace Cnpja\Dto\Shared;

final readonly class AddressDto
{
    public function __construct(
        public int $municipality,
        public string $city,
        public string $state,
        public string $zip,
        public ?string $street,
        public ?string $number,
        public ?string $district,
        public ?string $details,
        public ?CountryDto $country,
        public ?float $latitude,
        public ?float $longitude,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            municipality: (int) $data['municipality'],
            city: (string) $data['city'],
            state: (string) $data['state'],
            zip: (string) ($data['zip'] ?? $data['code'] ?? ''),
            street: isset($data['street']) ? (string) $data['street'] : null,
            number: isset($data['number']) ? (string) $data['number'] : null,
            district: isset($data['district']) ? (string) $data['district'] : null,
            details: isset($data['details']) ? (string) $data['details'] : null,
            country: isset($data['country']) ? CountryDto::fromArray($data['country']) : null,
            latitude: isset($data['latitude']) ? (float) $data['latitude'] : null,
            longitude: isset($data['longitude']) ? (float) $data['longitude'] : null,
        );
    }
}
