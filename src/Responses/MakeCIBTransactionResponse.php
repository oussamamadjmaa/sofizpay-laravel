<?php

declare(strict_types=1);

namespace OussamaMadjmaa\SofizPay\Responses;

/**
 * The response returned after creating a CIB transaction.
 */
final class MakeCIBTransactionResponse
{
    public function __construct(
        public bool $success,
        public string $transactionId,
        public string $cibTransactionId,
        public string $paymentUrl,
        public float $amount,
        public string $status,
        public string $moreInfoUrl,
        public array $cibResponse
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            success: (bool) ($data['success'] ?? false),
            transactionId: (string) ($data['transaction_id'] ?? ''),
            cibTransactionId: (string) ($data['cib_transaction_id'] ?? ''),
            paymentUrl: (string) ($data['payment_url'] ?? ''),
            amount: (float) ($data['amount'] ?? 0),
            status: (string) ($data['status'] ?? ''),
            moreInfoUrl: (string) ($data['more_info_url'] ?? ''),
            cibResponse: $data['cib_response'] ?? []
        );
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'transaction_id' => $this->transactionId,
            'cib_transaction_id' => $this->cibTransactionId,
            'payment_url' => $this->paymentUrl,
            'amount' => $this->amount,
            'status' => $this->status,
            'more_info_url' => $this->moreInfoUrl,
            'cib_response' => $this->cibResponse,
        ];
    }
}
