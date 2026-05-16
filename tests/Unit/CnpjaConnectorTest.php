<?php

declare(strict_types=1);

use Cnpja\CnpjaConnector;

it('resolves the correct base URL', function (): void {
    $connector = new CnpjaConnector('my-key');
    expect($connector->resolveBaseUrl())->toBe('https://api.cnpja.com');
});
