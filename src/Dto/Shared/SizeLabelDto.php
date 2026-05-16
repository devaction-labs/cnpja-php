<?php

declare(strict_types=1);

namespace Cnpja\Dto\Shared;

final readonly class SizeLabelDto
{
    public function __construct(
        public int $id,
        public string $acronym,
        public string $text,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            acronym: (string) $data['acronym'],
            text: (string) $data['text'],
        );
    }
}
