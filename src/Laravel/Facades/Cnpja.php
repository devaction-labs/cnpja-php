<?php

declare(strict_types=1);

namespace Cnpja\Laravel\Facades;

use Cnpja\CnpjaClient;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Saloon\Http\Response consultaSaldo()
 * @method static \Saloon\Http\Response consultaCep(string $code)
 * @method static \Saloon\Http\Response consultaEmpresa(string $companyId)
 * @method static \Saloon\Http\Response consultaCnpj(string $taxId, array $options = [])
 * @method static \Saloon\Http\Response mapaAereo(string $taxId, array $options = [])
 * @method static \Saloon\Http\Response visaoDaRua(string $taxId, array $options = [])
 * @method static \Saloon\Http\Response pesquisaCnpj(array $filters = [])
 * @method static \Saloon\Http\Response consultaPessoa(string $personId)
 * @method static \Saloon\Http\Response pesquisaPessoas(array $filters = [])
 * @method static \Saloon\Http\Response consultaRfb(string $taxId, array $options = [])
 * @method static \Saloon\Http\Response comprovanteRfb(string $taxId, array $options = [])
 * @method static \Saloon\Http\Response consultaSimples(string $taxId, array $options = [])
 * @method static \Saloon\Http\Response comprovanteSimples(string $taxId)
 * @method static \Saloon\Http\Response consultaCcc(string $taxId, string $states, array $options = [])
 * @method static \Saloon\Http\Response comprovanteCcc(string $taxId, ?string $state = null)
 * @method static \Saloon\Http\Response consultaSuframa(string $taxId, array $options = [])
 * @method static \Saloon\Http\Response comprovanteSuframa(string $taxId)
 *
 * @see \Cnpja\CnpjaClient
 */
class Cnpja extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CnpjaClient::class;
    }
}
