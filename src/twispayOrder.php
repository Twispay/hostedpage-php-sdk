<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Twispay.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'TwispaySample.php';

# get the data as JSON text
$jsonOrderData = TwispaySample::getOrderData();

# your secret key
$secretKey = TwispaySample::getSecretKey();

if (count($argv) == 3) {
    echo "Arguments provided for JSON order data and secret key.\n";
    $jsonOrderData = json_decode($argv[1], true);
    $secretKey = $argv[2];
} else {
    echo "No arguments provided for JSON order data and secret key, using sample values!\n";
}

echo "jsonOrderData: " . json_encode($jsonOrderData) . "\n";
echo "secretKey: " . $secretKey . "\n";

# get the HTML form
$htmlForm = Twispay::getHtmlOrderForm($jsonOrderData, $secretKey);

echo "Generated HTML form: " . $htmlForm;
