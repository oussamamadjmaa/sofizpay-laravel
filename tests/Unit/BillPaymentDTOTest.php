<?php

use OussamaMadjmaa\SofizPay\DTOs\BillPaymentDTO;
use OussamaMadjmaa\SofizPay\Enums\BillPaymentOperator;

it('serialises the operator to its scalar value and includes the offer', function () {
    $dto = new BillPaymentDTO(
        amount: 3200,
        operator: BillPaymentOperator::SONELGAZ,
        bill: '123456789012',
        customerId: '00458712',
    );

    expect($dto->toArray())->toBe([
        'amount' => (float) 3200,
        'operator' => 'sonelgaz',
        'bill' => '123456789012',
        'customerId' => '00458712',
        'offer' => 'sonelgaz',
    ]);
});

it('sets offer from the operator automatically', function () {
    $dto = new BillPaymentDTO(
        amount: 1000,
        operator: BillPaymentOperator::ADE,
        bill: '000111222',
    );

    expect($dto->offer)->toBe('ade');
});
