<?php

declare(strict_types=1);

namespace OussamaMadjmaa\SofizPay\Facades;

use Illuminate\Support\Facades\Facade;
use OussamaMadjmaa\SofizPay\Endpoints\CIBTransaction;
use OussamaMadjmaa\SofizPay\Endpoints\ServiceOperation;

/**
 * @method static CIBTransaction cibTransaction()
 * @method static ServiceOperation serviceOperation()
 * @method static bool isSandbox()
 * @method static void setEncryptedSK(string $encryptedSK)
 * @method static void setSandbox(bool $sandbox)
 *
 * @see \OussamaMadjmaa\SofizPay\SofizPay
 */
final class SofizPay extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'sofizpay';
    }
}
