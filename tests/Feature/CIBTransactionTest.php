<?php

use Illuminate\Support\Facades\Http;
use OussamaMadjmaa\SofizPay\DTOs\MakeCIBTransactionDTO;
use OussamaMadjmaa\SofizPay\Exceptions\SofizPayRequestException;
use OussamaMadjmaa\SofizPay\Responses\CheckCIBTransactionResponse;
use OussamaMadjmaa\SofizPay\SofizPay;

function makeCibDto(): MakeCIBTransactionDTO
{
    return new MakeCIBTransactionDTO(
        amount: 2500,
        fullName: 'Oussama Madjmaa',
        phone: '0555123456',
        email: 'oussama@example.com',
        returnUrl: 'https://your-app.test/payments/callback',
        memo: 'Order #1042',
    );
}

it('checks the status of a CIB transaction', function () {
    $sofizpay = new SofizPay();

    $response = $sofizpay->cibTransaction()->check('SANDBOX_ORDER_NUMBER');

    expect($response)->toBeInstanceOf(CheckCIBTransactionResponse::class);
    expect($response->isPaid())->toBeTrue();
});

it('throws a SofizPayRequestException carrying the failed response', function () {
    Http::fake([
        '*/make-cib-transaction/*' => Http::response([
            'message' => 'Invalid phone number',
        ], 422),
    ]);

    $sofizpay = new SofizPay();
    $cibTransaction = $sofizpay->cibTransaction();

    try {
        $cibTransaction->make(makeCibDto());

        throw new RuntimeException('Expected SofizPayRequestException was not thrown.');
    } catch (SofizPayRequestException $e) {
        expect($e->getMessage())->toContain('Invalid phone number');
        expect($e->response)->not->toBeNull();
        expect($e->response->status())->toBe(422);
        expect($e->context())->toBe(['message' => 'Invalid phone number']);
    }
});
