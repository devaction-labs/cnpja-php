<?php

declare(strict_types=1);

namespace Cnpja;

use Saloon\Http\Response;
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

class CnpjaClient
{
    private CnpjaConnector $connector;

    public function __construct(string $apiKey)
    {
        $this->connector = new CnpjaConnector($apiKey);
    }

    public function consultaSaldo(): Response
    {
        return $this->connector->send(new GetCreditRequest())->throw();
    }

    public function consultaCep(string $code): Response
    {
        return $this->connector->send(new GetZipRequest($code))->throw();
    }

    public function consultaEmpresa(string $companyId): Response
    {
        return $this->connector->send(new GetCompanyRequest($companyId))->throw();
    }

    /**
     * @param  array{
     *   simei?: bool,
     *   simplesHistory?: bool,
     *   registrations?: string,
     *   geocoding?: bool,
     *   links?: string,
     *   strategy?: string,
     *   maxAge?: int,
     *   maxStale?: int,
     *   sync?: bool,
     * } $options
     */
    public function consultaCnpj(string $taxId, array $options = []): Response
    {
        return $this->connector->send(new GetOfficeRequest($taxId, $options))->throw();
    }

    /**
     * @param  array{width?: int, height?: int, scale?: int, zoom?: int, type?: string} $options
     */
    public function mapaAereo(string $taxId, array $options = []): Response
    {
        return $this->connector->send(new GetOfficeMapRequest($taxId, $options))->throw();
    }

    /**
     * @param  array{width?: int, height?: int, fov?: int} $options
     */
    public function visaoDaRua(string $taxId, array $options = []): Response
    {
        return $this->connector->send(new GetOfficeStreetRequest($taxId, $options))->throw();
    }

    /**
     * @param  array{
     *   token?: string,
     *   limit?: int,
     *   "alias.in"?: string,
     *   "legalNature.in"?: string,
     *   "alias.nin"?: string,
     *   "legalNature.nin"?: string,
     *   "equity.gte"?: float,
     *   "equity.lte"?: float,
     * } $filters
     */
    public function pesquisaCnpj(array $filters = []): Response
    {
        return $this->connector->send(new SearchOfficesRequest($filters))->throw();
    }

    public function consultaPessoa(string $personId): Response
    {
        return $this->connector->send(new GetPersonRequest($personId))->throw();
    }

    /**
     * @param  array{
     *   token?: string,
     *   limit?: int,
     *   "type.in"?: string,
     *   "name.in"?: string,
     *   "name.nin"?: string,
     *   "taxId.in"?: string,
     *   "age.in"?: string,
     *   "role.in"?: string,
     * } $filters
     */
    public function pesquisaPessoas(array $filters = []): Response
    {
        return $this->connector->send(new SearchPersonsRequest($filters))->throw();
    }

    /**
     * @param  array{strategy?: string, maxAge?: int, maxStale?: int, sync?: bool} $options
     */
    public function consultaRfb(string $taxId, array $options = []): Response
    {
        return $this->connector->send(new GetRfbRequest($taxId, $options))->throw();
    }

    /**
     * @param  array{pages?: string} $options
     */
    public function comprovanteRfb(string $taxId, array $options = []): Response
    {
        return $this->connector->send(new GetRfbCertificateRequest($taxId, $options))->throw();
    }

    /**
     * @param  array{history?: bool, strategy?: string, maxAge?: int, maxStale?: int, sync?: bool} $options
     */
    public function consultaSimples(string $taxId, array $options = []): Response
    {
        return $this->connector->send(new GetSimplesRequest($taxId, $options))->throw();
    }

    public function comprovanteSimples(string $taxId): Response
    {
        return $this->connector->send(new GetSimplesCertificateRequest($taxId))->throw();
    }

    /**
     * @param  array{strategy?: string, maxAge?: int, maxStale?: int, sync?: bool} $options
     */
    public function consultaCcc(string $taxId, string $states, array $options = []): Response
    {
        return $this->connector->send(new GetCccRequest($taxId, $states, $options))->throw();
    }

    public function comprovanteCcc(string $taxId, ?string $state = null): Response
    {
        return $this->connector->send(new GetCccCertificateRequest($taxId, $state))->throw();
    }

    /**
     * @param  array{strategy?: string, maxAge?: int, maxStale?: int, sync?: bool} $options
     */
    public function consultaSuframa(string $taxId, array $options = []): Response
    {
        return $this->connector->send(new GetSuframaRequest($taxId, $options))->throw();
    }

    public function comprovanteSuframa(string $taxId): Response
    {
        return $this->connector->send(new GetSuframaCertificateRequest($taxId))->throw();
    }
}
