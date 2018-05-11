<?php

/**
 * Replace `siteId` and `secretKey` with the values provided by Twispay
 *
 * @author Dragos URSU
 */

$twispayConfig = [
    'siteId' => 19246,
    'secretKey' => 'ea9521816d4fcf0c0a78052fa70c3df9',
    'config' => [
        'paymentUrl' => 'https://secure-stage.twispay.com',
        'popupJsUrl' => 'https://secure-stage.twispay.com/assets/script',
        'sslAlgorithm' => 'aes-256-cbc',
    ],
];

return $twispayConfig;
