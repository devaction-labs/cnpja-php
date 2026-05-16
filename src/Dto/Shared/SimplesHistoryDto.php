<?php

declare(strict_types=1);

namespace Cnpja\Dto\Shared;

final readonly class SimplesHistoryDto
{
    public function __construct(
        public string $from,
        public string $until,
        public string $text,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            from: (string) $data['from'],
            until: (string) $data['until'],
            text: (string) $data['text'],
        );
    }
}
