<?php

declare(strict_types=1);

namespace OussamaMadjmaa\SofizPay\Endpoints;

use OussamaMadjmaa\SofizPay\Client\HttpClient;
use OussamaMadjmaa\SofizPay\DTOs\MakeCIBTransactionDTO;
use OussamaMadjmaa\SofizPay\Exceptions\SofizPayRequestException;
use OussamaMadjmaa\SofizPay\Responses\CheckCIBTransactionResponse;
use OussamaMadjmaa\SofizPay\Responses\MakeCIBTransactionResponse;

/**
 * Creates CIB transactions and checks their status.
 */
final class CIBTransaction
{
    public function __construct(protected HttpClient $httpClient)
    {
    }

    /**
     * Make a CIB transaction.
     *
     * @throws \InvalidArgumentException When no account is configured or supplied.
     * @throws SofizPayRequestException
     */
    public function make(MakeCIBTransactionDTO $dto): MakeCIBTransactionResponse
    {
        $payload = $dto->toArray();

        if (empty($payload['account'])) {
            $payload['account'] = (string) config('sofizpay.account_id', '');
        }

        if ($payload['account'] === '') {
            throw new \InvalidArgumentException('A SofizPay account ID is required for CIB transactions.');
        }

        $response = $this->httpClient->get('/make-cib-transaction/', $payload);

        return MakeCIBTransactionResponse::fromArray($response->json());
    }

    /**
     * Check the status of a CIB transaction.
     *
     * @throws SofizPayRequestException
     */
    public function check(string $orderNumber): CheckCIBTransactionResponse
    {
        $response = $this->httpClient->get('/cib-transaction-check/', [
            'order_number' => $orderNumber,
        ]);

        return CheckCIBTransactionResponse::fromArray($response->json());
    }
}
