<?php

declare(strict_types=1);

namespace OussamaMadjmaa\SofizPay\DTOs;

/**
 * Data required to recharge an internet service.
 */
final class InternetRechargeDTO
{
    public function __construct(
        public readonly string $phone,
        public readonly float $amount,
        public readonly ?string $operator = 'idoom',
        public ?string $offer = null,
    ) {
        $this->offer = $this->offer ?? $this->generateOffer();
    }

    private function generateOffer(): string
    {
        $prefix = strlen($this->phone) === 9 ? 'IDOOM ADSL' : 'IDOOM 4G';

        return sprintf('%s %s', $prefix, $this->amount);
    }

    /**
     * Create DTO from request data.
     *
     * @param array{
     *     phone: string,
     *     amount: float,
     *     operator?: string,
     *     offer?: string
     * } $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            phone: $data['phone'],
            amount: $data['amount'],
            operator: $data['operator'] ?? 'idoom',
            offer: $data['offer'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'phone' => $this->phone,
            'amount' => $this->amount,
            'operator' => $this->operator,
            'offer' => $this->offer,
        ];
    }
}
