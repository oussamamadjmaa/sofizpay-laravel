<?php

use OussamaMadjmaa\SofizPay\DTOs\InternetRechargeDTO;

it('infers an ADSL offer for a 9-digit landline number', function () {
    $dto = new InternetRechargeDTO(phone: '021123456', amount: 2000);

    expect($dto->offer)->toBe('IDOOM ADSL 2000');
});

it('infers a 4G offer for any other phone number length', function () {
    $dto = new InternetRechargeDTO(phone: '0555123456', amount: 1500);

    expect($dto->offer)->toBe('IDOOM 4G 1500');
});

it('respects an explicitly provided offer', function () {
    $dto = new InternetRechargeDTO(phone: '0555123456', amount: 1500, offer: 'Custom Offer');

    expect($dto->offer)->toBe('Custom Offer');
});

it('defaults the operator to idoom', function () {
    $dto = new InternetRechargeDTO(phone: '0555123456', amount: 1500);

    expect($dto->operator)->toBe('idoom');
});
