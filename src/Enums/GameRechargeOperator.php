<?php

declare(strict_types=1);

namespace OussamaMadjmaa\SofizPay\Enums;

/**
 * Game-recharge operators supported by the API.
 */
enum GameRechargeOperator: string
{
    case FREEFIRE = 'freefire';
    case PUBG = 'pubg';
}
