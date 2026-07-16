<?php

declare(strict_types=1);

namespace OussamaMadjmaa\SofizPay\Responses;

use Illuminate\Support\Str;

/**
 * The status returned for a CIB transaction.
 */
final class CheckCIBTransactionResponse
{
    public function __construct(
        public string $orderNumber,
        public ?int $orderStatus,
        public ?int $errorCode,
        public string $errorMessage,
        public string $actionCodeDescription,
        public string $respCodeDesc,
        public string $respCode,
        public string $destinationAccount,
        public float $amount
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            orderNumber: (string) ($data['order_number'] ?? ''),
            orderStatus: isset($data['orderStatus']) ? (int) $data['orderStatus'] : null,
            errorCode: isset($data['errorCode']) ? (int) $data['errorCode'] : null,
            errorMessage: (string) ($data['errorMessage'] ?? ''),
            actionCodeDescription: (string) ($data['actionCodeDescription'] ?? ''),
            respCodeDesc: (string) ($data['respCode_desc'] ?? ''),
            respCode: (string) ($data['respCode'] ?? ''),
            destinationAccount: (string) ($data['destination_account'] ?? ''),
            amount: (float) ($data['Amount'] ?? 0),
        );
    }

    public function toArray(): array
    {
        return [
            'order_number' => $this->orderNumber,
            'orderStatus' => $this->orderStatus,
            'errorCode' => $this->errorCode,
            'errorMessage' => $this->errorMessage,
            'actionCodeDescription' => $this->actionCodeDescription,
            'respCode_desc' => $this->respCodeDesc,
            'respCode' => $this->respCode,
            'destination_account' => $this->destinationAccount,
            'Amount' => $this->amount,
        ];
    }

    public function isPaid(): bool
    {
        return $this->orderStatus === 2 && $this->errorCode === 0;
    }

    public function isPending(): bool
    {
        return is_null($this->orderStatus) && is_null($this->errorCode);
    }

    public function isFailed(): bool
    {
        return !is_null($this->errorCode) && $this->errorCode !== 0;
    }

    public function isCancelled(): bool
    {
        return Str::of($this->actionCodeDescription)->lower()->contains(['cancelled', 'canceled', 'annul']);
    }
}
