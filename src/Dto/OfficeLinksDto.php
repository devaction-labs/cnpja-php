<?php

declare(strict_types=1);

namespace Cnpja\Dto;

final readonly class OfficeLinksDto
{
    public function __construct(
        public ?string $rfbCertificate,
        public ?string $simplesCertificate,
        public ?string $cccCertificate,
        public ?string $suframaCertificate,
        public ?string $officeMap,
        public ?string $officeStreet,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            rfbCertificate: isset($data['rfbCertificate']) ? (string) $data['rfbCertificate'] : null,
            simplesCertificate: isset($data['simplesCertificate']) ? (string) $data['simplesCertificate'] : null,
            cccCertificate: isset($data['cccCertificate']) ? (string) $data['cccCertificate'] : null,
            suframaCertificate: isset($data['suframaCertificate']) ? (string) $data['suframaCertificate'] : null,
            officeMap: isset($data['officeMap']) ? (string) $data['officeMap'] : null,
            officeStreet: isset($data['officeStreet']) ? (string) $data['officeStreet'] : null,
        );
    }
}
