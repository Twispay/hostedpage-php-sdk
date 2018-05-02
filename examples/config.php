<?php

/**
 * Replace `siteId` and `secretKey` with the values provided by Twispay
 *
 * @author Dragos URSU
 */

$twispayConfig = [
    'siteId' => 19246,
    'secretKey' => '12345678901234567890abcdef123456',
    'twispay' => [
        'paymentUrl' => 'https://secure-stage.twispay.com',
        'popupJsUrl' => 'https://secure-stage.twispay.com/js/sdk/v1/TwisPay.js',
        'popupCssUrl' => 'https://secure-stage.twispay.com/js/sdk/v1/TwisPay.css',
        'sslAlgorithm' => 'aes-256-cbc',
    ],
];

$twispayConfig = [
    'siteId' => 1,
    'secretKey' => 'ea9521816d4fcf0c0a78052fa70c3df9',
    'twispay' => [
        'paymentUrl' => 'https://secure.twispay.lh',
        'popupJsUrl' => 'https://secure.twispay.lh/js/sdk/v1/TwisPay.js',
        'popupCssUrl' => 'https://secure.twispay.lh/js/sdk/v1/TwisPay.css',
        'sslAlgorithm' => 'aes-256-cbc',
    ],
];

return $twispayConfig;
