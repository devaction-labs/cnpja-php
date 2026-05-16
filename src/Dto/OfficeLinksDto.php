<?php

declare(strict_types=1);

namespace Cnpja\Dto;

final readonly class OfficeLinksDto
{
    public function __construct(
        public ?string $rfbCertificate,
        public ?string $simplesCertificate,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            rfbCertificate: isset($data['rfbCertificate']) ? (string) $data['rfbCertificate'] : null,
            simplesCertificate: isset($data['simplesCertificate']) ? (string) $data['simplesCertificate'] : null,
        );
    }
}
