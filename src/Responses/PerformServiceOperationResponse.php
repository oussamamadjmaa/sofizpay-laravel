<?php

declare(strict_types=1);

namespace OussamaMadjmaa\SofizPay\Responses;

/**
 * The response returned after submitting a service operation.
 */
final class PerformServiceOperationResponse
{
    public function __construct(
        public string $status,
        public string $message,
        public string $operationId,
        public string $transactionId,
        public string $transactionStatus,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            status: (string) ($data['status'] ?? ''),
            message: (string) ($data['message'] ?? ''),
            operationId: (string) ($data['operation_id'] ?? ''),
            transactionId: (string) ($data['transaction_id'] ?? ''),
            transactionStatus: (string) ($data['transaction_status'] ?? ''),
        );
    }

    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'operation_id' => $this->operationId,
            'transaction_id' => $this->transactionId,
            'transaction_status' => $this->transactionStatus,
        ];
    }
}
