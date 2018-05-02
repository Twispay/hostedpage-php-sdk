<?php

/**
 * Pass one of the values from `live` or `stage` keys (the array) where a `config` parameter is needed for a method
 * By default the array value `live` is used
 */

$twispayConfig = [
    'live' => [
        'paymentUrl' => 'https://secure.twispay.com',
        'popupJsUrl' => 'https://secure.twispay.com/js/sdk/v1/TwisPay.js',
        'popupCssUrl' => 'https://secure.twispay.com/js/sdk/v1/TwisPay.css',
        'sslAlgorithm' => 'aes-256-cbc',
    ],
    'stage' => [
        'paymentUrl' => 'https://secure-stage.twispay.com',
        'popupJsUrl' => 'https://secure-stage.twispay.com/js/sdk/v1/TwisPay.js',
        'popupCssUrl' => 'https://secure-stage.twispay.com/js/sdk/v1/TwisPay.css',
        'sslAlgorithm' => 'aes-256-cbc',
    ],
];

return $twispayConfig;
