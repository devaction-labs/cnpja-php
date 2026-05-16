<?php

declare(strict_types=1);

namespace Cnpja\Laravel\Facades;

use Cnpja\CnpjaClient;
use Cnpja\Dto\CccDto;
use Cnpja\Dto\CompanyDto;
use Cnpja\Dto\CreditDto;
use Cnpja\Dto\OfficeDto;
use Cnpja\Dto\OfficeSearchDto;
use Cnpja\Dto\PersonDto;
use Cnpja\Dto\PersonSearchDto;
use Cnpja\Dto\RfbDto;
use Cnpja\Dto\SimplesDto;
use Cnpja\Dto\SuframaDto;
use Cnpja\Dto\ZipDto;
use Cnpja\Params\GetCccParams;
use Cnpja\Params\GetOfficeParams;
use Cnpja\Params\GetRfbParams;
use Cnpja\Params\GetSimplesParams;
use Cnpja\Params\GetSuframaParams;
use Cnpja\Params\SearchOfficesParams;
use Cnpja\Params\SearchPersonsParams;
use Illuminate\Support\Facades\Facade;

/**
 * @method static CreditDto getCredit()
 * @method static ZipDto getZip(string $code)
 * @method static CompanyDto getCompany(string $companyId)
 * @method static OfficeDto getOffice(string $taxId, ?GetOfficeParams $params = null)
 * @method static string getOfficeMap(string $taxId, array $options = [])
 * @method static string getOfficeStreetView(string $taxId, array $options = [])
 * @method static OfficeSearchDto searchOffices(?SearchOfficesParams $params = null)
 * @method static PersonDto getPerson(string $personId)
 * @method static PersonSearchDto searchPersons(?SearchPersonsParams $params = null)
 * @method static RfbDto getRfb(string $taxId, ?GetRfbParams $params = null)
 * @method static string getRfbCertificate(string $taxId, ?string $pages = null)
 * @method static SimplesDto getSimples(string $taxId, ?GetSimplesParams $params = null)
 * @method static string getSimplesCertificate(string $taxId)
 * @method static CccDto getCcc(string $taxId, string $states, ?GetCccParams $params = null)
 * @method static string getCccCertificate(string $taxId, ?string $state = null)
 * @method static SuframaDto getSuframa(string $taxId, ?GetSuframaParams $params = null)
 * @method static string getSuframaCertificate(string $taxId)
 *
 * @see CnpjaClient
 */
class Cnpja extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CnpjaClient::class;
    }
}
