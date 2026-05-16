<?php

declare(strict_types=1);

use Cnpja\CnpjaConnector;

it('resolve a URL base correta', function () {
    $connector = new CnpjaConnector('my-key');
    expect($connector->resolveBaseUrl())->toBe('https://api.cnpja.com');
});
