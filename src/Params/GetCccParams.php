<?php

declare(strict_types=1);

namespace Cnpja\Params;

final readonly class GetCccParams
{
    public function __construct(
        public ?CacheParams $cache = null,
    ) {}

    public function toArray(): array
    {
        return $this->cache?->toArray() ?? [];
    }
}
