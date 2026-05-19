<?php

declare(strict_types=1);

namespace Cnpja\Params;

final readonly class GetCccParams
{
    public function __construct(
        /** Data source for state registrations: AUTO, CCC, or SINTEGRA. */
        public ?string $source = null,
        public ?CacheParams $cache = null,
    ) {}

    public function toArray(): array
    {
        $params = [];

        if ($this->source !== null) {
            $params['source'] = $this->source;
        }

        return array_merge($params, $this->cache?->toArray() ?? []);
    }
}
