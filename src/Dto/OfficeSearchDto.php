<?php

declare(strict_types=1);

namespace Cnpja\Dto;

final readonly class OfficeSearchDto
{
    /** @param OfficeDto[] $records */
    public function __construct(
        public ?string $next,
        public int $limit,
        public int $count,
        public array $records,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            next: isset($data['next']) ? (string) $data['next'] : null,
            limit: (int) ($data['limit'] ?? 0),
            count: (int) ($data['count'] ?? 0),
            records: array_map(OfficeDto::fromArray(...), $data['records'] ?? []),
        );
    }
}
