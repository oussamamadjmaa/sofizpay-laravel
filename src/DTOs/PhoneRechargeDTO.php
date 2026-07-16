<?php

declare(strict_types=1);

namespace OussamaMadjmaa\SofizPay\DTOs;

use OussamaMadjmaa\SofizPay\Enums\PhoneRechargeOperator;

/**
 * Data required to recharge a mobile phone number.
 */
final class PhoneRechargeDTO
{
    public PhoneRechargeOperator $operator;

    public function __construct(
        public readonly string $phone,
        public readonly float $amount,
        public readonly string $offer
    ) {
        $this->operator = PhoneRechargeOperator::fromPhoneNumber($this->phone);
    }

    /**
     * Create DTO from request data.
     *
     * @param array{
     *     phone: string,
     *     amount: float,
     *     offer: string
     * } $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            phone: $data['phone'],
            amount: $data['amount'],
            offer: $data['offer']
        );
    }

    public function toArray(): array
    {
        return [
            'phone' => $this->phone,
            'amount' => $this->amount,
            'operator' => $this->operator->value,
            'offer' => $this->offer,
        ];
    }
}
