<?php

/**
 * Replace `siteId` and `secretKey` with the values provided by Twispay
 *
 * @author Dragos URSU
 */

$twispayConfig = [
    'siteId' => 19246,
    'secretKey' => '12345678901234567890abcdef123456',
    'config' => [
        'paymentUrl' => 'https://secure-stage.twispay.com',
        'popupJsUrl' => 'https://secure-stage.twispay.com/assets/script',
        'sslAlgorithm' => 'aes-256-cbc',
    ],
];

return $twispayConfig;
