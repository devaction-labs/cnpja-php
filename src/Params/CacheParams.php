<?php

declare(strict_types=1);

namespace Cnpja\Params;

final readonly class CacheParams
{
    public function __construct(
        public ?string $strategy = null,
        public ?int $maxAge = null,
        public ?int $maxStale = null,
        public bool $sync = false,
    ) {}

    public function toArray(): array
    {
        $params = [];

        if ($this->strategy !== null) {
            $params['strategy'] = $this->strategy;
        }
        if ($this->maxAge !== null) {
            $params['maxAge'] = $this->maxAge;
        }
        if ($this->maxStale !== null) {
            $params['maxStale'] = $this->maxStale;
        }
        if ($this->sync) {
            $params['sync'] = 'true';
        }

        return $params;
    }
}
