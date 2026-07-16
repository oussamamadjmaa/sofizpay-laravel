# CIB transactions

Create a transaction with `MakeCIBTransactionDTO`:

```php
use OussamaMadjmaa\SofizPay\DTOs\MakeCIBTransactionDTO;
use OussamaMadjmaa\SofizPay\SofizPay;

$response = app(SofizPay::class)->cibTransaction()->make(
    new MakeCIBTransactionDTO(
        amount: 2500,
        fullName: 'Oussama Madjmaa',
        phone: '0555123456',
        email: 'oussama@example.com',
        returnUrl: 'https://example.com/payments/return',
        memo: 'Order 1042',
    ),
);
```

The response exposes `success`, `transactionId`, `cibTransactionId`, `paymentUrl`, `amount`, `status`, `moreInfoUrl`, and `cibResponse`. Redirect the customer to `paymentUrl` when appropriate.

The DTO uses the configured account ID unless its `account` argument is supplied. Its `memo`, if present, is limited to 28 characters.

Check a transaction using its order number:

```php
$status = app(SofizPay::class)->cibTransaction()->check('ORDER_NUMBER');

if ($status->isPaid()) {
    // Fulfil the order.
}
```

`CheckCIBTransactionResponse` also provides `isPending()`, `isFailed()`, and `isCancelled()`.
