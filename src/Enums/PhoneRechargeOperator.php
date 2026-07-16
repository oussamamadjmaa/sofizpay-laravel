<?php

declare(strict_types=1);

namespace OussamaMadjmaa\SofizPay\Enums;

/**
 * Mobile operators inferred from Algerian mobile-number prefixes.
 */
enum PhoneRechargeOperator: string
{
    case OOREDOO = 'ooredoo';
    case MOBILIS = 'mobilis';
    case DJEZZY = 'djezzy';

    public static function fromPhoneNumber(string $phone): self
    {
        $prefix = substr($phone, 0, 2);

        return match ($prefix) {
            '05' => self::OOREDOO,
            '06' => self::MOBILIS,
            '07' => self::DJEZZY,
            default => throw new \InvalidArgumentException('Invalid phone number prefix.'),
        };
    }
}
