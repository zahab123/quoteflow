<?php

return [
    'easypaisa' => [
        'mode' => env('EASYPAISA_MODE', 'sandbox'), // sandbox or production
        'sandbox_url' => 'https://easypay.easypaisa.com.pk/easypay/Index.js',
        'production_url' => 'https://easypay.easypaisa.com.pk/easypay/Index.js',
        'store_id' => env('EASYPAISA_STORE_ID'),
        'hash_key' => env('EASYPAISA_HASH_KEY'),
        'callback_url' => env('EASYPAISA_CALLBACK_URL'),
    ],

    'jazzcash' => [
        'mode' => env('JAZZCASH_MODE', 'sandbox'),
        'sandbox_url' => 'https://sandbox.jazzcash.com.pk/ApplicationAPI/API/2.0/Purchase/DoMWalletTransaction',
        'production_url' => 'https://payments.jazzcash.com.pk/ApplicationAPI/API/2.0/Purchase/DoMWalletTransaction',
        'merchant_id' => env('JAZZCASH_MERCHANT_ID'),
        'password' => env('JAZZCASH_PASSWORD'),
        'hash_key' => env('JAZZCASH_HASH_KEY'),
        'callback_url' => env('JAZZCASH_CALLBACK_URL'),
    ],
];
