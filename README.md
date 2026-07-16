# SofizPay for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/oussamamadjmaa/sofizpay-laravel.svg?style=flat-square)](https://packagist.org/packages/oussamamadjmaa/sofizpay-laravel)
[![License](https://img.shields.io/packagist/l/oussamamadjmaa/sofizpay-laravel.svg?style=flat-square)](LICENSE)

A Laravel package for SofizPay CIB transactions and service operations. It provides DTOs for phone, internet, game, and bill operations, plus typed response objects.

## Requirements

- PHP 8.1 or later
- Laravel 10, 11, 12, or 13

## Installation

```bash
composer require oussamamadjmaa/sofizpay-laravel
```

The package is discovered automatically. Publish its configuration when you need to set values in a config file:

```bash
php artisan vendor:publish --provider="OussamaMadjmaa\SofizPay\SofizPayServiceProvider" --tag=config
```

Set the required environment variables:

```env
SOFIZPAY_ACCOUNT_ID=
SOFIZPAY_ENCRYPTED_SK=
SOFIZPAY_SANDBOX=true
```

## Quick start

```php
use OussamaMadjmaa\SofizPay\DTOs\MakeCIBTransactionDTO;
use OussamaMadjmaa\SofizPay\SofizPay;

$payment = app(SofizPay::class)->cibTransaction()->make(
    new MakeCIBTransactionDTO(
        amount: 2500,
        fullName: 'Oussama Madjmaa',
        phone: '0555123456',
        email: 'oussama@example.com',
        returnUrl: 'https://example.com/payments/return',
    ),
);

return redirect()->away($payment->paymentUrl);
```

You may also use the `OussamaMadjmaa\SofizPay\Facades\SofizPay` facade.

## Documentation

- [Installation](docs/installation.md)
- [Configuration](docs/configuration.md)
- [CIB transactions](docs/cib-transactions.md)
- [Service operations](docs/service-operations.md)
- [Sandbox behavior](docs/sandbox.md)
- [Error handling](docs/error-handling.md)
- [Architecture](docs/architecture.md)

## Security

Please report vulnerabilities according to [our security policy](SECURITY.md).

## Contributing

Contributions are welcome. Read [CONTRIBUTING.md](CONTRIBUTING.md) and [CODE_OF_CONDUCT.md](CODE_OF_CONDUCT.md) first.

## License

SofizPay for Laravel is open-sourced software licensed under the [MIT license](LICENSE).
