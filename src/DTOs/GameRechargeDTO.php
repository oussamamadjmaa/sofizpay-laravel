<?php

declare(strict_types=1);

namespace OussamaMadjmaa\SofizPay\DTOs;

use OussamaMadjmaa\SofizPay\Enums\GameRechargeOperator;

/**
 * Data required to recharge a supported game account.
 */
final class GameRechargeDTO
{
    public function __construct(
        public readonly float $amount,
        public readonly GameRechargeOperator $operator,
        public readonly string $playerId,
        public readonly string $offer,

    ) {}

    /**
     * Create DTO from request data.
     *
     * @param array{
     *     amount: float,
     *     operator: string|GameRechargeOperator,
     *     playerId: string,
     *     offer: string
     * } $data
     */
    public static function fromArray(array $data): self
    {
        $operator = $data['operator'];

        if (!$operator instanceof GameRechargeOperator) {
            $operator = GameRechargeOperator::from($operator);
        }

        return new self(
            amount: $data['amount'],
            operator: $operator,
            playerId: $data['playerId'],
            offer: $data['offer']
        );
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'operator' => $this->operator->value,
            'playerId' => $this->playerId,
            'offer' => $this->offer,
        ];
    }
}
