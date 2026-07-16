<?php

declare(strict_types=1);

namespace OussamaMadjmaa\SofizPay;

use OussamaMadjmaa\SofizPay\Client\HttpClient;
use OussamaMadjmaa\SofizPay\Endpoints\ServiceOperation;
use OussamaMadjmaa\SofizPay\Endpoints\CIBTransaction;

/**
 * Entry point for SofizPay CIB transactions and service operations.
 */
final class SofizPay
{
    protected string $encryptedSK;
    protected bool $sandbox;
    protected HttpClient $httpClient;

    public function __construct()
    {
        $this->encryptedSK = (string) config('sofizpay.encrypted_sk', '');
        $this->sandbox = (bool) config('sofizpay.sandbox', true);

        $this->httpClient = new HttpClient($this->sandbox);
    }

    public function cibTransaction(): CIBTransaction
    {
        return new CIBTransaction($this->httpClient);
    }

    public function serviceOperation(): ServiceOperation
    {
        return new ServiceOperation($this->httpClient, $this->encryptedSK);
    }

    public function isSandbox(): bool
    {
        return $this->sandbox;
    }

    public function setEncryptedSK(string $encryptedSK): void
    {
        $this->encryptedSK = $encryptedSK;
    }

    public function setSandbox(bool $sandbox): void
    {
        $this->sandbox = $sandbox;
        $this->httpClient = new HttpClient($sandbox);
    }
}
