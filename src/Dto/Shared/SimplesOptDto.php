<?php

declare(strict_types=1);

namespace Cnpja\Dto\Shared;

final readonly class SimplesOptDto
{
    /** @param SimplesHistoryDto[] $history */
    public function __construct(
        public bool $optant,
        public ?string $since,
        public array $history,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            optant: (bool) $data['optant'],
            since: isset($data['since']) ? (string) $data['since'] : null,
            history: array_map(
                SimplesHistoryDto::fromArray(...),
                $data['history'] ?? [],
            ),
        );
    }
}
