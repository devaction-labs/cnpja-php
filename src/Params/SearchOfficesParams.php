<?php

declare(strict_types=1);

namespace Cnpja\Params;

final readonly class SearchOfficesParams
{
    public function __construct(
        /** Pagination token (mutually exclusive with all other filters). */
        public ?string $token = null,
        /** Number of records per page. */
        public ?int $limit = null,
        /** Trade name terms to include (comma or space separated). */
        public ?string $aliasIn = null,
        /** Trade name terms to exclude. */
        public ?string $aliasNin = null,
        /** Company name terms to include. */
        public ?string $companyNameIn = null,
        /** Company name terms to exclude. */
        public ?string $companyNameNin = null,
        /** Legal nature codes to include (comma-separated). */
        public ?string $legalNatureIn = null,
        /** Legal nature codes to exclude. */
        public ?string $legalNatureNin = null,
        /** Share capital greater than or equal to value. */
        public ?float $equityGte = null,
        /** Share capital less than or equal to value. */
        public ?float $equityLte = null,
        /** Company size IDs to include (1=ME, 3=EPP, 5=other). */
        public ?string $sizeIn = null,
        /** Enrolled in Simples Nacional (true/false). */
        public ?bool $simplesOptant = null,
        /** Enrolled as MEI (true/false). */
        public ?bool $simeiOptant = null,
        /** Headquarters only (true/false). */
        public ?bool $head = null,
        /** Status codes to include (1=Null, 2=Active, 3=Suspended, 4=Unfit, 8=Closed). */
        public ?string $statusIn = null,
        /** IBGE municipality codes to include (comma-separated). */
        public ?string $municipalityIn = null,
        /** State abbreviations to include (comma-separated, e.g. SP,RJ). */
        public ?string $stateIn = null,
        /** ZIP codes to include (comma-separated). */
        public ?string $zipIn = null,
        /** Primary activity CNAE codes to include. */
        public ?string $mainActivityIn = null,
        /** Secondary activity CNAE codes to include. */
        public ?string $sideActivityIn = null,
        /** Has phone number (true/false). */
        public ?bool $hasPhone = null,
        /** Has e-mail address (true/false). */
        public ?bool $hasEmail = null,
    ) {}

    public function toArray(): array
    {
        $params = [];

        if ($this->token !== null) {
            return ['token' => $this->token];
        }

        $map = [
            'limit' => $this->limit,
            'alias.in' => $this->aliasIn,
            'alias.nin' => $this->aliasNin,
            'company.name.in' => $this->companyNameIn,
            'company.name.nin' => $this->companyNameNin,
            'company.nature.id.in' => $this->legalNatureIn,
            'company.nature.id.nin' => $this->legalNatureNin,
            'company.equity.gte' => $this->equityGte,
            'company.equity.lte' => $this->equityLte,
            'company.size.id.in' => $this->sizeIn,
            'head.eq' => $this->head !== null ? ($this->head ? 'true' : 'false') : null,
            'status.id.in' => $this->statusIn,
            'address.municipality.in' => $this->municipalityIn,
            'address.state.in' => $this->stateIn,
            'address.zip.in' => $this->zipIn,
            'mainActivity.id.in' => $this->mainActivityIn,
            'sideActivities.id.in' => $this->sideActivityIn,
            'phones.ex' => $this->hasPhone !== null ? ($this->hasPhone ? 'true' : 'false') : null,
            'emails.ex' => $this->hasEmail !== null ? ($this->hasEmail ? 'true' : 'false') : null,
        ];

        if ($this->simplesOptant !== null) {
            $map['company.simples.optant.eq'] = $this->simplesOptant ? 'true' : 'false';
        }
        if ($this->simeiOptant !== null) {
            $map['company.simei.optant.eq'] = $this->simeiOptant ? 'true' : 'false';
        }

        foreach ($map as $key => $value) {
            if ($value !== null && $value !== '') {
                $params[$key] = $value;
            }
        }

        return $params;
    }
}
