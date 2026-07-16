<?php

use OussamaMadjmaa\SofizPay\Facades\SofizPay as SofizPayFacade;
use OussamaMadjmaa\SofizPay\SofizPay;

it('resolves the SofizPay singleton via the container', function () {
    $first = app(SofizPay::class);
    $second = app(SofizPay::class);

    expect($first)->toBeInstanceOf(SofizPay::class);
    expect($first)->toBe($second);
});

it('resolves the same instance through the facade accessor', function () {
    expect(SofizPayFacade::getFacadeRoot())->toBe(app(SofizPay::class));
});

it('proxies calls through the facade', function () {
    expect(SofizPayFacade::isSandbox())->toBeTrue();
});
