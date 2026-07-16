# Configuration

The package reads these values from `config/sofizpay.php`:

```env
SOFIZPAY_ACCOUNT_ID=
SOFIZPAY_ENCRYPTED_SK=
SOFIZPAY_SANDBOX=true
```

`SOFIZPAY_ACCOUNT_ID` is used when a `MakeCIBTransactionDTO` does not supply its optional `account` value. A CIB transaction cannot be created without either value.

`SOFIZPAY_ENCRYPTED_SK` is included in service-operation requests.

`SOFIZPAY_SANDBOX` defaults to `true`. Set it to `false` only when you intend to use the non-sandbox endpoint.

Resolve the client from the container:

```php
use OussamaMadjmaa\SofizPay\SofizPay;

$sofizPay = app(SofizPay::class);
```

The package also registers the `OussamaMadjmaa\SofizPay\Facades\SofizPay` facade.
