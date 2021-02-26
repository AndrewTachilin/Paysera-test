<?php

return [
    'total_percent' => env('APP_TOTAL_PERCENT', 100),
    'numbers_after_dot' => env('APP_NUMBERS_AFTER_DOT', 222),
    'commission_deposit' => env('APP_COMMISSION_DEPOSIT', 0.03),
    'commission_business_withdraw' => env('APP_COMMISSION_BUSINESS_WITHDRAW', 0.5),
    'scale' => env('APP_SCALE', 4),
    'commission_private' => env('APP_COMMISSION_PRIVATE', 0.3),
    'limit_free_withdraw' => env('APP_LIMIT_FREE_WITHDRAW', 1000),
    'count_free_operation' => env('APP_COUNT_FREE_OPERATION', 3),
    'date_time_format' => env('APP_DATE_FORMAT', 'Y-m-d'),
    'api_exchange_url' => env('APP_API_EXCHANGE_URL', 'https://api.exchangeratesapi.io/latest'),
    'wallet_actions' => [
        'wallet_action_withdraw' => env('APP_WALLET_ACTION_WITHDRAW', 'withdraw'),
        'wallet_action_deposit' => env('APP_WALLET_ACTION_DEPOSIT', 'deposit'),
    ],
    'wallet_types' => [
        'wallet_action_type_business' => env('APP_WALLET_ACTION_BUSINESS', 'business'),
        'wallet_action_type_private' => env('APP_WALLET_ACTION_PRIVATE', 'private'),
    ],
    'currencies' => [
        'default_currency' => env('APP_DEFAULT_CURRENCY', 'EUR'),
        'usd_currency' => env('APP_USD_CURRENCY', 'USD'),
        'jpy_currency' => env('APP_JPY_CURRENCY', 'JPY'),
    ],
    'file_extensions' => [
        'csv' => env('APP_AVAILABLE_FILE_EXTENSION', 'csv')
    ]
];
