<?php

return [
    'total_percent' => env('APP_TOTAL_PERCENT', 100),
    'numbers_after_dot' => env('APP_NUMBERS_AFTER_DOT', 222),
    'commission_deposit' => env('APP_COMMISSION_DEPOSIT', 0.03),
    'commission_business_withdraw' => env('APP_COMMISSION_BUSINESS_WITHDRAW', 0.5),
    'commission_private' => env('APP_COMMISSION_PRIVATE', 0.3),
    'limit_free_withdraw' => env('APP_LIMIT_FREE_WITHDRAW', 1000),
    'count_free_operation' => env('APP_COUNT_FREE_OPERATION', 3),
    'date_time_format' => env('APP_DATE_FORMAT', 'Y-m-d'),
    'api_exchange_url' => env('APP_API_EXCHANGE_URL', 'https://api.exchangeratesapi.io/latest'),
];
