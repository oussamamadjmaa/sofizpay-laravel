<?php

declare(strict_types=1);

namespace OussamaMadjmaa\SofizPay\Client;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use OussamaMadjmaa\SofizPay\Exceptions\SofizPayRequestException;

/**
 * Sends requests to the SofizPay API and normalizes failed HTTP responses.
 *
 * @internal
 */
final class HttpClient
{
    protected string $apiBaseUrl;

    public function __construct(protected bool $sandbox)
    {
        $this->apiBaseUrl = $this->sandbox ? 'https://sofizpay.com/sandbox' : 'https://sofizpay.com';

        $this->setupFakeResponses();
    }

    public function get(string $endpoint, array $data = []): Response
    {
        return Http::get($this->apiBaseUrl.$endpoint, $data)
            ->throw($this->throwCallback(...));
    }

    public function post(string $endpoint, array $data = []): Response
    {
        return Http::post($this->apiBaseUrl.$endpoint, $data)
            ->throw($this->throwCallback(...));
    }

    public function getWithBody(string $endpoint, array $data = []): Response
    {
        return Http::withBody(json_encode($data), 'application/json')
            ->get($this->apiBaseUrl.$endpoint)
            ->throw($this->throwCallback(...));
    }

    public function getApiBaseUrl(): string
    {
        return $this->apiBaseUrl;
    }

    private function throwCallback(Response $response, \Throwable $exception): void
    {
        throw new SofizPayRequestException($exception->getMessage(), $response, previous: $exception);
    }

    private function setupFakeResponses(): void
    {
        if ($this->sandbox || app()->environment('testing')) {
            $this->setupServiceOperationFakeResponses();
        }

        if (app()->environment('testing')) {
            $this->setupTestingResponses();
        }
    }

    private function setupServiceOperationFakeResponses(): void
    {
        Http::fake([
            $this->apiBaseUrl . '/services/operation_post' => [
                'status' => 'success',
                'message' => 'Operation submitted successfully (Sandbox)',
                'operation_id' => Str::uuid()->toString(),
                'transaction_id' => Str::uuid()->toString(),
                'transaction_status' => 'confirmed',
            ],
            $this->apiBaseUrl . '/services/operation-detail/INVALID_OPERATION_ID*' => Http::response([
                'status' => 'error',
                'message' => 'Operation not found',
            ], 404),
            $this->apiBaseUrl . '/services/operation-detail/*' => [
                'status' => 'success',
                'data' => [
                    'id' => 'YOUR_OPERATION_ID',
                    'operation_type' => 'topup',
                    'phone' => '+213123456789',
                    'operator' => 'xxxxxx',
                    'amount' => 'XXX',
                    'offer' => 'XXXXX',
                    'status' => 'completed',
                    'status_message' => 'Operation completed successfully (Sandbox)',
                    'created_at' => '2024-01-15T10:30:00Z',
                    'updated_at' => '2024-01-15T10:35:00Z',
                    'blockchain_transactions' => [],
                    'transaction_logs' => [],
                ],
            ],
            $this->apiBaseUrl . '/services/operation-history*' => [
                'status' => 'success',
                'data' => [
                    'operations' => [
                        [
                            'id' => 'YOUR_OPERATION_ID',
                            'operation_type' => 'topup',
                            'phone' => '+213123456789',
                            'operator' => 'xxxxxx',
                            'amount' => 'XXX',
                            'offer' => 'XXXXX',
                            'status' => 'completed',
                            'status_message' => 'Operation completed successfully',
                            'created_at' => '2024-01-15T10:30:00Z',
                            'updated_at' => '2024-01-15T10:35:00Z',
                        ],
                    ],
                    "pagination" => [
                        "total_count" => 1,
                        "limit" => 10,
                        "offset" => 0,
                        "has_more" => false
                    ],
                ],
            ],

            $this->apiBaseUrl . '/services/get_products/' => [
                'status' => 'success',
                'count' => 8,
                'products' => [
                    [
                        'name' => 'PUBG 1320 UC',
                        'price' => '4743.24',
                    ],
                    [
                        'name' => 'PUBG 1800 UC',
                        'price' => '5929.05',
                    ],
                    [
                        'name' => 'PUBG 325 UC',
                        'price' => '1185.81',
                    ],
                ],
            ]
        ]);
    }

    /**
     * Fake sandbox responses so CIB transactions can be built and tested
     * end-to-end without hitting the live SofizPay API, mirroring the
     * sandbox behaviour of ServiceOperation.
     */
    private function setupTestingResponses(): void
    {
        Http::fake([
            $this->apiBaseUrl . '/make-cib-transaction/' => [
                'success' => true,
                'transaction_id' => Str::uuid()->toString(),
                'cib_transaction_id' => Str::uuid()->toString(),
                'payment_url' => 'https://sofizpay.com/sandbox/pay/' . Str::uuid()->toString(),
                'amount' => 0,
                'status' => 'pending',
                'more_info_url' => 'https://sofizpay.com/sandbox/info',
                'cib_response' => [],
            ],
            $this->apiBaseUrl . '/cib-transaction-check/*' => [
                'order_number' => 'SANDBOX_ORDER_NUMBER',
                'orderStatus' => 2,
                'errorCode' => 0,
                'errorMessage' => '',
                'actionCodeDescription' => 'Approved',
                'respCode_desc' => 'Approved',
                'respCode' => '00',
                'destination_account' => 'SANDBOX_ACCOUNT',
                'Amount' => 0,
            ],
        ]);
    }
}
