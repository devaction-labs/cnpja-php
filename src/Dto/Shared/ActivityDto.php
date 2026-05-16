<?php

declare(strict_types=1);

namespace Cnpja\Dto\Shared;

final readonly class ActivityDto
{
    public function __construct(
        public int $id,
        public string $text,
        public ?bool $performed = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            text: (string) $data['text'],
            performed: isset($data['performed']) ? (bool) $data['performed'] : null,
        );
    }
}
