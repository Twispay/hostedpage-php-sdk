<?php

/**
 * Example code for reading order status for both when a back-URL is used and on IPN
 *
 * @author Dragos URSU
 */

use Twispay\Exception\ResponseException;
use Twispay\Response;

require_once 'bootstrap.php';

// should be read from your APP config
$twispayConfig = require_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

// secret key is provided by Twispay
// replace it with your own
$secretKey = $twispayConfig['secretKey'];

// init response object
$response = new Response($twispayConfig['twispay']);

// load data from $_POST['opensslResult'] and $_GET['opensslResult'] (in this order)
// alternatively you can pass an array containing the `opensslResult` key
// or the encrypted response as a string value
try {
    $response->loadData($secretKey);
} catch (ResponseException $e) {
    // do something on error
    throw $e;
}

// do something
echo 'Order unique identifier (externally provided): ' . $response->getExternalOrderId();
echo 'Order ID (Twispay): ' . $response->getOrderId();
echo 'Transaction ID (Twispay): ' . $response->getTransactionId();
echo 'Transaction status: ' . $response->getTransactionStatus();
echo 'Customer unique identifier (externally provided): ' . $response->getIdentifier();
echo 'Customer ID (Twispay): ' . $response->getCustomerId();
echo 'Amount: ' . $response->getAmount();
echo 'Currency: ' . $response->getCurrency();
