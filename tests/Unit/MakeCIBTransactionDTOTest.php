<?php

use Illuminate\Support\Str;
use OussamaMadjmaa\SofizPay\DTOs\MakeCIBTransactionDTO;

it('drops null values such as an omitted memo', function () {
    $dto = new MakeCIBTransactionDTO(
        amount: 2500,
        fullName: 'Oussama Madjmaa',
        phone: '0555123456',
        email: 'oussama@example.com',
        returnUrl: 'https://your-app.test/payments/callback',
    );

    $payload = $dto->toArray();

    expect($payload)->not->toHaveKey('memo');
    expect($payload['redirect'])->toBe('no');
    expect($payload['keep_return_url'])->toBeFalse();
});

it('includes the memo when provided', function () {
    $dto = new MakeCIBTransactionDTO(
        amount: 2500,
        fullName: 'Oussama Madjmaa',
        phone: '0555123456',
        email: 'oussama@example.com',
        returnUrl: 'https://your-app.test/payments/callback',
        memo: 'Order #1042',
    );

    expect($dto->toArray()['memo'])->toBe('Order #1042');
});

it('truncates the memo to 28 characters', function () {
    $memo = 'This memo is definitely longer than twenty-eight characters';

    $dto = new MakeCIBTransactionDTO(
        amount: 2500,
        fullName: 'Oussama Madjmaa',
        phone: '0555123456',
        email: 'oussama@example.com',
        returnUrl: 'https://your-app.test/payments/callback',
        memo: $memo,
    );

    expect($dto->toArray()['memo'])->toBe(Str::of($memo)->limit(28)->toString());
});
