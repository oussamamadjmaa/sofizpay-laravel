<?php

declare(strict_types=1);

namespace OussamaMadjmaa\SofizPay\DTOs;

use OussamaMadjmaa\SofizPay\Enums\BillPaymentOperator;

/**
 * Data required to pay a bill through SofizPay.
 */
final class BillPaymentDTO
{
    public string $offer;

    public function __construct(
        public readonly float $amount,
        public readonly BillPaymentOperator $operator,
        public readonly string $bill,

        // Sonelgaz
        public readonly ?string $customerId = null,
        public readonly ?string $ebb = null,

        // Algérie Télécom
        public readonly ?string $phone = null,

    ) {
        $this->offer = $this->operator->value;
    }

    /**
     * Create DTO from request data.
     *
     * @param array{
     *     amount: float,
     *     operator: string|BillPaymentOperator,
     *     bill: string,
     *     customerId?: string,
     *     ebb?: string,
     *     phone?: string
     * } $data
     */
    public static function fromArray(array $data): self
    {
        $operator = $data['operator'];

        if (!$operator instanceof BillPaymentOperator) {
            $operator = BillPaymentOperator::from($operator);
        }

        return new self(
            amount: $data['amount'],
            operator: $operator,
            bill: $data['bill'],
            customerId: $data['customerId'] ?? null,
            ebb: $data['ebb'] ?? null,
            phone: $data['phone'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'amount' => $this->amount,
            'operator' => $this->operator->value,
            'bill' => $this->bill,
            'customerId' => $this->customerId,
            'ebb' => $this->ebb,
            'phone' => $this->phone,
            'offer' => $this->offer,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
