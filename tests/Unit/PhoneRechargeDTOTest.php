<?php

use OussamaMadjmaa\SofizPay\DTOs\PhoneRechargeDTO;
use OussamaMadjmaa\SofizPay\Enums\PhoneRechargeOperator;

it('infers ooredoo from a 05 prefix', function () {
    $dto = new PhoneRechargeDTO(phone: '0555123456', amount: 500, offer: 'prepaid');

    expect($dto->operator)->toBe(PhoneRechargeOperator::OOREDOO);
});

it('infers mobilis from a 06 prefix', function () {
    $dto = new PhoneRechargeDTO(phone: '0655123456', amount: 500, offer: 'prepaid');

    expect($dto->operator)->toBe(PhoneRechargeOperator::MOBILIS);
});

it('infers djezzy from a 07 prefix', function () {
    $dto = new PhoneRechargeDTO(phone: '0755123456', amount: 500, offer: 'prepaid');

    expect($dto->operator)->toBe(PhoneRechargeOperator::DJEZZY);
});

it('throws for an unrecognised prefix', function () {
    new PhoneRechargeDTO(phone: '0355123456', amount: 500, offer: 'prepaid');
})->throws(InvalidArgumentException::class);

it('serialises the operator to its scalar value', function () {
    $dto = new PhoneRechargeDTO(phone: '0555123456', amount: 500, offer: 'prepaid');

    expect($dto->toArray())->toBe([
        'phone' => '0555123456',
        'amount' => (float) 500,
        'operator' => 'ooredoo',
        'offer' => 'prepaid',
    ]);
});
