<?php

declare(strict_types=1);

namespace OussamaMadjmaa\SofizPay\Responses;

/**
 * Details for a submitted service operation.
 */
final class ServiceOperationDetailsResponse
{
    public function __construct(
        public string $id,
        public string $operationType,
        public string $phone,
        public string $operator,
        public float $amount,
        public string $offer,
        public string $status,
        public string $statusMessage,
        public string $createdAt,
        public string $updatedAt,
        public array $blockchainTransactions,
        public array $transactionLogs
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) ($data['id'] ?? ''),
            operationType: (string) ($data['operation_type'] ?? ''),
            phone: (string) ($data['phone'] ?? ''),
            operator: (string) ($data['operator'] ?? ''),
            amount: (float) ($data['amount'] ?? 0),
            offer: (string) ($data['offer'] ?? ''),
            status: (string) ($data['status'] ?? ''),
            statusMessage: (string) ($data['status_message'] ?? ''),
            createdAt: (string) ($data['created_at'] ?? ''),
            updatedAt: (string) ($data['updated_at'] ?? ''),
            blockchainTransactions: $data['blockchain_transactions'] ?? [],
            transactionLogs: $data['transaction_logs'] ?? []
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'operation_type' => $this->operationType,
            'phone' => $this->phone,
            'operator' => $this->operator,
            'amount' => $this->amount,
            'offer' => $this->offer,
            'status' => $this->status,
            'status_message' => $this->statusMessage,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'blockchain_transactions' => $this->blockchainTransactions,
            'transaction_logs' => $this->transactionLogs
        ];
    }
}
