# Installation

Install the package with Composer:

```bash
composer require oussamamadjmaa/sofizpay-laravel
```

Laravel discovers the service provider automatically. To publish the package configuration, run:

```bash
php artisan vendor:publish --provider="OussamaMadjmaa\SofizPay\SofizPayServiceProvider" --tag=config
```

The published file is `config/sofizpay.php`.
