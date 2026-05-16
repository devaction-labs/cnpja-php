<?php

declare(strict_types=1);

namespace Cnpja\Params;

final readonly class GetOfficeParams
{
    public function __construct(
        /** Include Simples Nacional and MEI opt-in (+1 credit). */
        public bool $simples = false,
        /** Include Simples Nacional and MEI history (+1 credit). */
        public bool $simplesHistory = false,
        /** State registrations to include, comma-separated UFs e.g. "BR" or "SP,RJ" (+1 credit). */
        public ?string $registrations = null,
        /** Include SUFRAMA registration (+1 credit). */
        public bool $suframa = false,
        /** Include address latitude and longitude (+1 credit). */
        public bool $geocoding = false,
        /** Public document links: RFB_CERTIFICATE, SIMPLES_CERTIFICATE. */
        public ?string $links = null,
        public ?CacheParams $cache = null,
    ) {}

    public function toArray(): array
    {
        $params = [];

        if ($this->simples) {
            $params['simples'] = 'true';
        }
        if ($this->simplesHistory) {
            $params['simplesHistory'] = 'true';
        }
        if ($this->registrations !== null) {
            $params['registrations'] = $this->registrations;
        }
        if ($this->suframa) {
            $params['suframa'] = 'true';
        }
        if ($this->geocoding) {
            $params['geocoding'] = 'true';
        }
        if ($this->links !== null) {
            $params['links'] = $this->links;
        }

        return array_merge($params, $this->cache?->toArray() ?? []);
    }
}
