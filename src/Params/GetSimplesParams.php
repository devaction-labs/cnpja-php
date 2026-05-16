<?php

declare(strict_types=1);

namespace Cnpja\Params;

final readonly class GetSimplesParams
{
    public function __construct(
        /** Include history of previous Simples Nacional and MEI periods (+1 credit). */
        public bool $history = false,
        public ?CacheParams $cache = null,
    ) {}

    public function toArray(): array
    {
        $params = [];

        if ($this->history) {
            $params['history'] = 'true';
        }

        return array_merge($params, $this->cache?->toArray() ?? []);
    }
}
