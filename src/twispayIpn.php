<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Twispay.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'TwispaySample.php';

# normally you get the encrypted data from the HTTP request (POST/GET) in the `opensslResult` parameter
$encryptedIpnResponse = TwispaySample::getEncryptedIpnResponse();

# your secret key
$secretKey = TwispaySample::getSecretKey();

if (count($argv) == 3) {
    echo "Arguments provided for encrypted IPN response and secret key.\n";
    $encryptedIpnResponse = $argv[1];
    $secretKey = $argv[2];
} else {
    echo "No arguments provided for encrypted IPN response and secret key, using sample values!\n";
}

echo "encryptedIpnResponse: " . $encryptedIpnResponse . "\n";
echo "secretKey: " . $secretKey . "\n";

# get the JSON IPN response
$jsonResponse = Twispay::decryptIpnResponse($encryptedIpnResponse, $secretKey);

echo "Decrypted IPN response: " . print_r($jsonResponse, true);
