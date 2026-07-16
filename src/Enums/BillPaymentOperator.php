<?php

declare(strict_types=1);

namespace OussamaMadjmaa\SofizPay\Enums;

/**
 * Bill-payment operators supported by the API.
 */
enum BillPaymentOperator: string
{
    case ADE = 'ade';
    case SONELGAZ = 'sonelgaz';
    case ALGERIE_TELECOM = 'algerie_telecom';
}
