<?php

use OussamaMadjmaa\SofizPay\DTOs\GameRechargeDTO;
use OussamaMadjmaa\SofizPay\Enums\GameRechargeOperator;

it('serialises the operator to its scalar value and drops nulls', function () {
    $dto = new GameRechargeDTO(
        amount: 1000,
        operator: GameRechargeOperator::FREEFIRE,
        playerId: 'player-id-1234',
        offer: '110'
    );

    expect($dto->toArray())->toBe([
        'amount' => (float) 1000,
        'operator' => 'freefire',
        'playerId' => 'player-id-1234',
        'offer' => '110',
    ]);
});

it('serialises the operator to its scalar value and includes the offer', function () {
    $dto = new GameRechargeDTO(
        amount: 1000,
        operator: GameRechargeOperator::PUBG,
        playerId: 'player-id-1234',
        offer: '110',
    );

    expect($dto->toArray())->toBe([
        'amount' => (float) 1000,
        'operator' => 'pubg',
        'playerId' => 'player-id-1234',
        'offer' => '110',
    ]);
});
