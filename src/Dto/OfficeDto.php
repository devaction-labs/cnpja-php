<?php

declare(strict_types=1);

namespace Cnpja\Dto;

use Cnpja\Dto\Shared\ActivityDto;
use Cnpja\Dto\Shared\AddressDto;
use Cnpja\Dto\Shared\EmailDto;
use Cnpja\Dto\Shared\LabelDto;
use Cnpja\Dto\Shared\PhoneDto;
use Cnpja\Dto\Shared\StateRegistrationDto;

final readonly class OfficeDto
{
    /**
     * @param  PhoneDto[]  $phones
     * @param  EmailDto[]  $emails
     * @param  ActivityDto[]  $sideActivities
     * @param  StateRegistrationDto[]  $registrations
     */
    public function __construct(
        public string $taxId,
        public string $updated,
        public string $alias,
        public string $founded,
        public bool $head,
        public string $statusDate,
        public LabelDto $status,
        public AddressDto $address,
        public ActivityDto $mainActivity,
        public array $phones,
        public array $emails,
        public array $sideActivities,
        public ?CompanyRefDto $company,
        public ?LabelDto $reason,
        public ?string $specialDate,
        public ?LabelDto $special,
        public array $registrations,
        public ?SuframaDto $suframa,
        public ?OfficeLinksDto $links,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            taxId: (string) $data['taxId'],
            updated: (string) $data['updated'],
            alias: (string) ($data['alias'] ?? ''),
            founded: (string) ($data['founded'] ?? ''),
            head: (bool) ($data['head'] ?? false),
            statusDate: (string) ($data['statusDate'] ?? ''),
            status: LabelDto::fromArray($data['status']),
            address: AddressDto::fromArray($data['address']),
            mainActivity: ActivityDto::fromArray($data['mainActivity']),
            phones: array_map(PhoneDto::fromArray(...), $data['phones'] ?? []),
            emails: array_map(EmailDto::fromArray(...), $data['emails'] ?? []),
            sideActivities: array_map(ActivityDto::fromArray(...), $data['sideActivities'] ?? []),
            company: isset($data['company']) ? CompanyRefDto::fromArray($data['company']) : null,
            reason: isset($data['reason']) ? LabelDto::fromArray($data['reason']) : null,
            specialDate: isset($data['specialDate']) ? (string) $data['specialDate'] : null,
            special: isset($data['special']) ? LabelDto::fromArray($data['special']) : null,
            registrations: array_map(StateRegistrationDto::fromArray(...), $data['registrations'] ?? []),
            suframa: isset($data['suframa']) ? SuframaDto::fromArray($data['suframa']) : null,
            links: isset($data['links']) ? OfficeLinksDto::fromArray($data['links']) : null,
        );
    }
}
