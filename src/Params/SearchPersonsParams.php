<?php

declare(strict_types=1);

namespace Cnpja\Params;

final readonly class SearchPersonsParams
{
    public function __construct(
        /** Pagination token (mutually exclusive with all other filters). */
        public ?string $token = null,
        /** Number of records per page. */
        public ?int $limit = null,
        /** Person types to include: NATURAL, LEGAL, FOREIGN, UNKNOWN. */
        public ?string $typeIn = null,
        /** Name terms to include (comma-separated). */
        public ?string $nameIn = null,
        /** Name terms to exclude. */
        public ?string $nameNin = null,
        /** Partial CPF digits (positions 4–9, comma-separated). */
        public ?string $taxIdIn = null,
        /** Age ranges to include, e.g. "21-30,31-40". */
        public ?string $ageIn = null,
        /** M49 country codes to include (comma-separated). */
        public ?string $countryIn = null,
    ) {}

    public function toArray(): array
    {
        if ($this->token !== null) {
            return ['token' => $this->token];
        }

        $map = [
            'limit' => $this->limit,
            'type.in' => $this->typeIn,
            'name.in' => $this->nameIn,
            'name.nin' => $this->nameNin,
            'taxId.in' => $this->taxIdIn,
            'age.in' => $this->ageIn,
            'country.id.in' => $this->countryIn,
        ];

        return array_filter($map, static fn ($value) => $value !== null && $value !== '');
    }
}
