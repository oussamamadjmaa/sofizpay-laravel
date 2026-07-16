<?php

declare(strict_types=1);

namespace OussamaMadjmaa\SofizPay\Endpoints;

use OussamaMadjmaa\SofizPay\Client\HttpClient;
use OussamaMadjmaa\SofizPay\DTOs\BillPaymentDTO;
use OussamaMadjmaa\SofizPay\DTOs\GameRechargeDTO;
use OussamaMadjmaa\SofizPay\DTOs\InternetRechargeDTO;
use OussamaMadjmaa\SofizPay\DTOs\PhoneRechargeDTO;
use OussamaMadjmaa\SofizPay\Exceptions\SofizPayRequestException;
use OussamaMadjmaa\SofizPay\Responses\ProductsResponse;
use OussamaMadjmaa\SofizPay\Responses\PerformServiceOperationResponse;
use OussamaMadjmaa\SofizPay\Responses\ServiceOperationDetailsResponse;
use OussamaMadjmaa\SofizPay\Responses\ServiceOperationHistoryResponse;

/**
 * Performs and retrieves SofizPay service operations.
 */
final class ServiceOperation
{
    public function __construct(protected HttpClient $httpClient, protected string $encryptedSK)
    {
    }

    /**
     * Perform a phone recharge operation.
     *
     * @throws SofizPayRequestException
     */
    public function performPhoneRecharge(PhoneRechargeDTO $dto): PerformServiceOperationResponse
    {
        return $this->perform($dto->toArray());
    }

    /**
     * Perform an internet recharge operation.
     *
     * @throws SofizPayRequestException
     */
    public function performInternetRecharge(InternetRechargeDTO $dto): PerformServiceOperationResponse
    {
        return $this->perform($dto->toArray());
    }

    /**
     * Perform a game recharge operation.
     *
     * @throws SofizPayRequestException
     */
    public function performGameRecharge(GameRechargeDTO $dto): PerformServiceOperationResponse
    {
        return $this->perform($dto->toArray());
    }

    /**
     * Perform a bill payment operation.
     *
     * @throws SofizPayRequestException
     */
    public function performBillPayment(BillPaymentDTO $dto): PerformServiceOperationResponse
    {
        return $this->perform($dto->toArray());
    }

    /**
     * Perform a service operation with the given data.
     *
     * @param array<string, mixed> $data
     * @throws SofizPayRequestException
     */
    public function perform(array $data): PerformServiceOperationResponse
    {
        if (! isset($data['encrypted_sk'])) {
            $data['encrypted_sk'] = $this->encryptedSK;
        }

        $response = $this->httpClient->post('/services/operation_post', $data);

        return PerformServiceOperationResponse::fromArray($response->json());
    }

    /**
     * Retrieve the details of a specific service operation.
     *
     * @throws SofizPayRequestException
     */
    public function details(string $operationId): ServiceOperationDetailsResponse
    {
        $endpoint = sprintf('/services/operation-detail/%s/', $operationId);

        $response = $this->httpClient->get($endpoint, [
            'encrypted_sk' => $this->encryptedSK,
        ]);

        $data = $response->json('data');

        if (!$data) {
            throw new SofizPayRequestException('Failed to retrieve operation details: '.$response->json('message', 'Missing data'), $response);
        }

        return ServiceOperationDetailsResponse::fromArray($data);
    }

    /**
     * Retrieve the history of service operations.
     *
     * @throws SofizPayRequestException
     */
    public function history(int $limit = 10, int $offset = 0): ServiceOperationHistoryResponse
    {
        $response = $this->httpClient->get('/services/operation-history/', [
            'limit' => $limit,
            'offset' => $offset,
            'encrypted_sk' => $this->encryptedSK,
        ]);

        return ServiceOperationHistoryResponse::fromArray($response->json());
    }

    public function getProducts(string $search = ''): ProductsResponse
    {
        $response = $this->httpClient->getWithBody('/services/get_products/', [
            'encrypted_sk' => $this->encryptedSK,
            'search' => $search,
        ]);

        return ProductsResponse::fromArray($response->json());
    }
}
