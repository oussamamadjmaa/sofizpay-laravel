<?php

declare(strict_types=1);

return [
    'account_id' => env('SOFIZPAY_ACCOUNT_ID', ''),
    'encrypted_sk' => env('SOFIZPAY_ENCRYPTED_SK', ''),
    'sandbox' => env('SOFIZPAY_SANDBOX', true),
];
