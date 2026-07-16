# Service operations

Resolve the service-operation endpoint with `app(SofizPay::class)->serviceOperation()`.

## Phone recharge

```php
use OussamaMadjmaa\SofizPay\DTOs\PhoneRechargeDTO;

$response = $serviceOperation->performPhoneRecharge(
    new PhoneRechargeDTO(phone: '0555123456', amount: 500, offer: 'prepaid'),
);
```

The operator is inferred from the first two digits: `05` for Ooredoo, `06` for Mobilis, and `07` for Djezzy.

## Internet recharge

```php
use OussamaMadjmaa\SofizPay\DTOs\InternetRechargeDTO;

$response = $serviceOperation->performInternetRecharge(
    new InternetRechargeDTO(phone: '021123456', amount: 2000),
);
```

The operator defaults to `idoom`. Without an explicit offer, a nine-character phone value produces `IDOOM ADSL {amount}`; any other length produces `IDOOM 4G {amount}`.

## Game recharge

```php
use OussamaMadjmaa\SofizPay\DTOs\GameRechargeDTO;
use OussamaMadjmaa\SofizPay\Enums\GameRechargeOperator;

$response = $serviceOperation->performGameRecharge(
    new GameRechargeDTO(1000, GameRechargeOperator::FREEFIRE, 'player-1234', '110'),
);
```

The available enum cases are `GameRechargeOperator::FREEFIRE` and `GameRechargeOperator::PUBG`.

## Bill payment

```php
use OussamaMadjmaa\SofizPay\DTOs\BillPaymentDTO;
use OussamaMadjmaa\SofizPay\Enums\BillPaymentOperator;

$response = $serviceOperation->performBillPayment(
    new BillPaymentDTO(
        amount: 3200,
        operator: BillPaymentOperator::SONELGAZ,
        bill: '123456789012',
        customerId: '00458712',
    ),
);
```

The available enum cases are `BillPaymentOperator::ADE`, `BillPaymentOperator::SONELGAZ`, and `BillPaymentOperator::ALGERIE_TELECOM`.

All convenience methods return `PerformServiceOperationResponse`, which provides `status`, `message`, `operationId`, `transactionId`, and `transactionStatus`.

## Details, history, and products

```php
$details = $serviceOperation->details($response->operationId);
$history = $serviceOperation->history(limit: 10, offset: 0);
$products = $serviceOperation->getProducts(search: 'PUBG');
```

`details()` returns `ServiceOperationDetailsResponse`. `history()` returns `ServiceOperationHistoryResponse`, containing `operations` and `pagination`. `getProducts()` returns `ProductsResponse` with `status`, `count`, and `products`.

For request shapes not covered by a DTO, `perform(array $data)` submits the supplied data and automatically adds `encrypted_sk` unless it is already present.
