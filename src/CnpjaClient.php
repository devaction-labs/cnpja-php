<?php

declare(strict_types=1);

namespace Cnpja;

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
use Cnpja\Exceptions\CnpjaException;
use Cnpja\Params\GetCccParams;
use Cnpja\Params\GetOfficeParams;
use Cnpja\Params\GetRfbParams;
use Cnpja\Params\GetSimplesParams;
use Cnpja\Params\GetSuframaParams;
use Cnpja\Params\SearchOfficesParams;
use Cnpja\Params\SearchPersonsParams;
use Cnpja\Requests\Ccc\GetCccCertificateRequest;
use Cnpja\Requests\Ccc\GetCccRequest;
use Cnpja\Requests\Company\GetCompanyRequest;
use Cnpja\Requests\Credit\GetCreditRequest;
use Cnpja\Requests\Office\GetOfficeMapRequest;
use Cnpja\Requests\Office\GetOfficeRequest;
use Cnpja\Requests\Office\GetOfficeStreetRequest;
use Cnpja\Requests\Office\SearchOfficesRequest;
use Cnpja\Requests\Person\GetPersonRequest;
use Cnpja\Requests\Person\SearchPersonsRequest;
use Cnpja\Requests\Rfb\GetRfbCertificateRequest;
use Cnpja\Requests\Rfb\GetRfbRequest;
use Cnpja\Requests\Simples\GetSimplesCertificateRequest;
use Cnpja\Requests\Simples\GetSimplesRequest;
use Cnpja\Requests\Suframa\GetSuframaCertificateRequest;
use Cnpja\Requests\Suframa\GetSuframaRequest;
use Cnpja\Requests\Zip\GetZipRequest;
use Saloon\Exceptions\Request\FatalRequestException;

class CnpjaClient
{
    private readonly CnpjaConnector $connector;

    public function __construct(string $apiKey)
    {
        $this->connector = new CnpjaConnector($apiKey);
    }

    /**
     * @throws CnpjaException
     * @throws FatalRequestException
     */
    public function getCredit(): CreditDto
    {
        $response = $this->connector->send(new GetCreditRequest)->throw();

        return CreditDto::fromArray($response->json());
    }

    /**
     * @throws CnpjaException
     * @throws FatalRequestException
     */
    public function getZip(string $code): ZipDto
    {
        $response = $this->connector->send(new GetZipRequest($code))->throw();

        return ZipDto::fromArray($response->json());
    }

    /**
     * @throws CnpjaException
     * @throws FatalRequestException
     */
    public function getCompany(string $companyId): CompanyDto
    {
        $response = $this->connector->send(new GetCompanyRequest($companyId))->throw();

        return CompanyDto::fromArray($response->json());
    }

    /**
     * @throws CnpjaException
     * @throws FatalRequestException
     */
    public function getOffice(string $taxId, ?GetOfficeParams $params = null): OfficeDto
    {
        $response = $this->connector->send(new GetOfficeRequest($taxId, $params))->throw();

        return OfficeDto::fromArray($response->json());
    }

    /**
     * Returns a PNG aerial map image of the establishment's address.
     *
     * @param  array{width?: int, height?: int, scale?: int, zoom?: int, type?: string}  $options
     *
     * @throws CnpjaException
     * @throws FatalRequestException
     */
    public function getOfficeMap(string $taxId, array $options = []): string
    {
        return $this->connector->send(new GetOfficeMapRequest($taxId, $options))->throw()->body();
    }

    /**
     * Returns a PNG street-view image of the establishment's address.
     *
     * @param  array{width?: int, height?: int, fov?: int}  $options
     *
     * @throws CnpjaException
     * @throws FatalRequestException
     */
    public function getOfficeStreetView(string $taxId, array $options = []): string
    {
        return $this->connector->send(new GetOfficeStreetRequest($taxId, $options))->throw()->body();
    }

    /**
     * @throws CnpjaException
     * @throws FatalRequestException
     */
    public function searchOffices(?SearchOfficesParams $params = null): OfficeSearchDto
    {
        $response = $this->connector->send(new SearchOfficesRequest($params))->throw();

        return OfficeSearchDto::fromArray($response->json());
    }

    /**
     * @throws CnpjaException
     * @throws FatalRequestException
     */
    public function getPerson(string $personId): PersonDto
    {
        $response = $this->connector->send(new GetPersonRequest($personId))->throw();

        return PersonDto::fromArray($response->json());
    }

    /**
     * @throws CnpjaException
     * @throws FatalRequestException
     */
    public function searchPersons(?SearchPersonsParams $params = null): PersonSearchDto
    {
        $response = $this->connector->send(new SearchPersonsRequest($params))->throw();

        return PersonSearchDto::fromArray($response->json());
    }

    /**
     * @throws CnpjaException
     * @throws FatalRequestException
     */
    public function getRfb(string $taxId, ?GetRfbParams $params = null): RfbDto
    {
        $response = $this->connector->send(new GetRfbRequest($taxId, $params))->throw();

        return RfbDto::fromArray($response->json());
    }

    /**
     * Returns the RFB certificate as raw PDF bytes.
     *
     * @param  string|null  $pages  Pages to include: REGISTRATION, MEMBERS (comma-separated).
     *
     * @throws CnpjaException
     * @throws FatalRequestException
     */
    public function getRfbCertificate(string $taxId, ?string $pages = null): string
    {
        return $this->connector->send(new GetRfbCertificateRequest($taxId, $pages))->throw()->body();
    }

    /**
     * @throws CnpjaException
     * @throws FatalRequestException
     */
    public function getSimples(string $taxId, ?GetSimplesParams $params = null): SimplesDto
    {
        $response = $this->connector->send(new GetSimplesRequest($taxId, $params))->throw();

        return SimplesDto::fromArray($response->json());
    }

    /**
     * Returns the Simples Nacional / MEI certificate as raw PDF bytes.
     *
     * @throws CnpjaException
     * @throws FatalRequestException
     */
    public function getSimplesCertificate(string $taxId): string
    {
        return $this->connector->send(new GetSimplesCertificateRequest($taxId))->throw()->body();
    }

    /**
     * @throws CnpjaException
     * @throws FatalRequestException
     */
    public function getCcc(string $taxId, string $states, ?GetCccParams $params = null): CccDto
    {
        $response = $this->connector->send(new GetCccRequest($taxId, $states, $params))->throw();

        return CccDto::fromArray($response->json());
    }

    /**
     * Returns the CCC certificate as raw PDF bytes.
     *
     * @throws CnpjaException
     * @throws FatalRequestException
     */
    public function getCccCertificate(string $taxId, ?string $state = null): string
    {
        return $this->connector->send(new GetCccCertificateRequest($taxId, $state))->throw()->body();
    }

    /**
     * @throws CnpjaException
     * @throws FatalRequestException
     */
    public function getSuframa(string $taxId, ?GetSuframaParams $params = null): SuframaDto
    {
        $response = $this->connector->send(new GetSuframaRequest($taxId, $params))->throw();

        return SuframaDto::fromArray($response->json());
    }

    /**
     * Returns the SUFRAMA certificate as raw PDF bytes.
     *
     * @throws CnpjaException
     * @throws FatalRequestException
     */
    public function getSuframaCertificate(string $taxId): string
    {
        return $this->connector->send(new GetSuframaCertificateRequest($taxId))->throw()->body();
    }
}
