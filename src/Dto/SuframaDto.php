<?php

declare(strict_types=1);

namespace Cnpja\Dto;

use Cnpja\Dto\Shared\ActivityDto;
use Cnpja\Dto\Shared\AddressDto;
use Cnpja\Dto\Shared\EmailDto;
use Cnpja\Dto\Shared\LabelDto;
use Cnpja\Dto\Shared\PhoneDto;

final readonly class SuframaDto
{
    /**
     * @param  PhoneDto[]  $phones
     * @param  EmailDto[]  $emails
     * @param  ActivityDto[]  $sideActivities
     * @param  SuframaIncentiveDto[]  $incentives
     */
    public function __construct(
        public string $taxId,
        public string $updated,
        public string $number,
        public string $name,
        public string $since,
        public bool $head,
        public bool $approved,
        public ?string $approvalDate,
        public LabelDto $status,
        public LabelDto $nature,
        public ?AddressDto $address,
        public ActivityDto $mainActivity,
        public array $phones,
        public array $emails,
        public array $sideActivities,
        public array $incentives,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            taxId: (string) $data['taxId'],
            updated: (string) ($data['updated'] ?? ''),
            number: (string) ($data['number'] ?? ''),
            name: (string) ($data['name'] ?? ''),
            since: (string) ($data['since'] ?? ''),
            head: (bool) ($data['head'] ?? false),
            approved: (bool) ($data['approved'] ?? false),
            approvalDate: isset($data['approvalDate']) ? (string) $data['approvalDate'] : null,
            status: LabelDto::fromArray($data['status']),
            nature: LabelDto::fromArray($data['nature']),
            address: isset($data['address']) ? AddressDto::fromArray($data['address']) : null,
            mainActivity: ActivityDto::fromArray($data['mainActivity']),
            phones: array_map(PhoneDto::fromArray(...), $data['phones'] ?? []),
            emails: array_map(EmailDto::fromArray(...), $data['emails'] ?? []),
            sideActivities: array_map(ActivityDto::fromArray(...), $data['sideActivities'] ?? []),
            incentives: array_map(SuframaIncentiveDto::fromArray(...), $data['incentives'] ?? []),
        );
    }
}
