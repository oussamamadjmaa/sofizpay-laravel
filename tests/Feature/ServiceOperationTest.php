<?php

use OussamaMadjmaa\SofizPay\DTOs\BillPaymentDTO;
use OussamaMadjmaa\SofizPay\DTOs\GameRechargeDTO;
use OussamaMadjmaa\SofizPay\DTOs\InternetRechargeDTO;
use OussamaMadjmaa\SofizPay\DTOs\PhoneRechargeDTO;
use OussamaMadjmaa\SofizPay\Enums\BillPaymentOperator;
use OussamaMadjmaa\SofizPay\Enums\GameRechargeOperator;
use OussamaMadjmaa\SofizPay\Exceptions\SofizPayRequestException;
use OussamaMadjmaa\SofizPay\SofizPay;
use OussamaMadjmaa\SofizPay\Responses\PerformServiceOperationResponse;
use OussamaMadjmaa\SofizPay\Responses\ProductsResponse;
use OussamaMadjmaa\SofizPay\Responses\ServiceOperationDetailsResponse;
use OussamaMadjmaa\SofizPay\Responses\ServiceOperationHistoryResponse;

it('performs a phone recharge via its DTO', function () {
    $sofizpay = new SofizPay();

    $dto = new PhoneRechargeDTO(phone: '0555123456', amount: 500, offer: 'prepaid');

    $response = $sofizpay->serviceOperation()->performPhoneRecharge($dto);

    expect($response)->toBeInstanceOf(PerformServiceOperationResponse::class);
    expect($response->status)->toBe('success');
});

it('performs an internet recharge via its DTO', function () {
    $sofizpay = new SofizPay();

    $dto = new InternetRechargeDTO(phone: '021123456', amount: 2000);

    $response = $sofizpay->serviceOperation()->performInternetRecharge($dto);

    expect($response)->toBeInstanceOf(PerformServiceOperationResponse::class);
});

it('performs a game recharge via its DTO', function () {
    $sofizpay = new SofizPay();

    $dto = new GameRechargeDTO(amount: 1000, operator: GameRechargeOperator::FREEFIRE, playerId: 'player-1234', offer: '110');

    $response = $sofizpay->serviceOperation()->performGameRecharge($dto);

    expect($response)->toBeInstanceOf(PerformServiceOperationResponse::class);
});

it('performs a bill payment via its DTO', function () {
    $sofizpay = new SofizPay();

    $dto = new BillPaymentDTO(amount: 3200, operator: BillPaymentOperator::SONELGAZ, bill: '123456789012', customerId: '00458712');

    $response = $sofizpay->serviceOperation()->performBillPayment($dto);

    expect($response)->toBeInstanceOf(PerformServiceOperationResponse::class);
});

it('performs a service operation', function () {
    $sofizpay = new SofizPay();

    $data = [
        'phone' => '0512345678',
        'amount' => 1000,
        'offer' => 'prepaid',
    ];

    $response = $sofizpay->serviceOperation()->perform($data);

    expect($response)->toBeInstanceOf(PerformServiceOperationResponse::class);
    expect($response->status)->toBe('success');
    expect($response->transactionStatus)->toBe('confirmed');
});

it('gets service operation details', function () {
    $sofizpay = new SofizPay();

    $response = $sofizpay->serviceOperation()->details('YOUR_OPERATION_ID');

    expect($response)->toBeInstanceOf(ServiceOperationDetailsResponse::class);
    expect($response->status)->toBe('completed');
});

it('throws an exception for invalid service operation details', function () {
    $sofizpay = new SofizPay();

    $sofizpay->serviceOperation()->details('INVALID_OPERATION_ID');
})->throws(SofizPayRequestException::class);

it('gets service operations history', function () {
    $sofizpay = new SofizPay();

    $response = $sofizpay->serviceOperation()->history();

    expect($response)->toBeInstanceOf(ServiceOperationHistoryResponse::class);
    expect($response->operations)->not()->toBeEmpty();
    expect($response->operations[0])->toBeInstanceOf(ServiceOperationDetailsResponse::class);
    expect($response->pagination->totalCount)->toBe(1);
    expect($response->pagination->hasMore)->toBeFalse();
});

it('gets products', function () {
    $sofizpay = new SofizPay();

    $response = $sofizpay->serviceOperation()->getProducts();

    expect($response)->toBeInstanceOf(ProductsResponse::class);
    expect($response->status)->toBe('success');
    expect($response->count)->toBeGreaterThan(0);
    expect($response->products[0])->toHaveKeys(['name', 'price']);
});
