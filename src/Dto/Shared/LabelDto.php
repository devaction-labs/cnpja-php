<?php

declare(strict_types=1);

namespace Cnpja\Dto\Shared;

final readonly class LabelDto
{
    public function __construct(
        public int $id,
        public string $text,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            text: (string) $data['text'],
        );
    }
}
