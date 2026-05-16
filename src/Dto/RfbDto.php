<?php

declare(strict_types=1);

namespace Cnpja\Dto;

use Cnpja\Dto\Shared\ActivityDto;
use Cnpja\Dto\Shared\AddressDto;
use Cnpja\Dto\Shared\EmailDto;
use Cnpja\Dto\Shared\LabelDto;
use Cnpja\Dto\Shared\MemberDto;
use Cnpja\Dto\Shared\PhoneDto;
use Cnpja\Dto\Shared\SizeLabelDto;

final readonly class RfbDto
{
    /**
     * @param  MemberDto[]  $members
     * @param  PhoneDto[]  $phones
     * @param  EmailDto[]  $emails
     * @param  ActivityDto[]  $sideActivities
     */
    public function __construct(
        public string $taxId,
        public string $updated,
        public string $name,
        public float $equity,
        public LabelDto $nature,
        public SizeLabelDto $size,
        public string $jurisdiction,
        public string $alias,
        public string $founded,
        public bool $head,
        public string $statusDate,
        public LabelDto $status,
        public AddressDto $address,
        public ActivityDto $mainActivity,
        public array $members,
        public array $phones,
        public array $emails,
        public array $sideActivities,
        public ?LabelDto $reason,
        public ?string $specialDate,
        public ?LabelDto $special,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            taxId: (string) $data['taxId'],
            updated: (string) $data['updated'],
            name: (string) $data['name'],
            equity: (float) ($data['equity'] ?? 0),
            nature: LabelDto::fromArray($data['nature']),
            size: SizeLabelDto::fromArray($data['size']),
            jurisdiction: (string) ($data['jurisdiction'] ?? ''),
            alias: (string) ($data['alias'] ?? ''),
            founded: (string) ($data['founded'] ?? ''),
            head: (bool) ($data['head'] ?? false),
            statusDate: (string) ($data['statusDate'] ?? ''),
            status: LabelDto::fromArray($data['status']),
            address: AddressDto::fromArray($data['address']),
            mainActivity: ActivityDto::fromArray($data['mainActivity']),
            members: array_map(MemberDto::fromArray(...), $data['members'] ?? []),
            phones: array_map(PhoneDto::fromArray(...), $data['phones'] ?? []),
            emails: array_map(EmailDto::fromArray(...), $data['emails'] ?? []),
            sideActivities: array_map(ActivityDto::fromArray(...), $data['sideActivities'] ?? []),
            reason: isset($data['reason']) ? LabelDto::fromArray($data['reason']) : null,
            specialDate: isset($data['specialDate']) ? (string) $data['specialDate'] : null,
            special: isset($data['special']) ? LabelDto::fromArray($data['special']) : null,
        );
    }
}
