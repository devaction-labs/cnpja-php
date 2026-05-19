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
        /** State registrations to include: comma-separated UFs, "ORIGIN" for home state, or "ALL" for every state (+1 credit). */
        public ?string $registrations = null,
        /** Data source for state registrations: AUTO, CCC, or SINTEGRA. */
        public ?string $registrationsSource = null,
        /** Include SUFRAMA registration (+1 credit). */
        public bool $suframa = false,
        /** Include address latitude and longitude (+1 credit). */
        public bool $geocoding = false,
        /** Public document links: RFB_CERTIFICATE, SIMPLES_CERTIFICATE, CCC_CERTIFICATE, SUFRAMA_CERTIFICATE, OFFICE_MAP, OFFICE_STREET. */
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
        if ($this->registrationsSource !== null) {
            $params['registrationsSource'] = $this->registrationsSource;
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
