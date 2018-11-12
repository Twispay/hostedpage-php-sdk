<?php

/**
 * Example code for reading order status for both when a back-URL is used and on IPN
 *
 * @author Dragos URSU
 */

use Twispay\Exception\ResponseException;
use Twispay\Response;

require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

// secret key is provided by Twispay
// replace it with your own
$secretKey = 'cd07b3c95dc9a0c8e9318b29bdc13b03';

// init response object
$response = new Response($secretKey);

// this will come from the request (it is put here only for example)
// $encryptedResponse = $response->getEncryptedResponse();
$encryptedResponse = 'oUrO8wW0IXK1yj9F8RYbHw==,Hrw4AkEt+DBALL4P9gNDyBxkvnjh3wxlgAdqe1jVffEGrwpEpCKc3eYjR4l+mi9dCxPuvXRceVgqd7ypn9aXGLXejxClumv4l2Ym2djbpsi2PFRWyWXHoJar+NX8aLU/yCYdHUoNtvoZRA2RI13IUCLZZ1znlQdyEL9NXQTEAxrbZe7a4vmYbUDBosAiIfApGLGMWQG/OF+ebukvLeZGajzUbhbp69k8/UD03dT8NBDMSos5XayJNnEibM2unImh6tcOek5prenHQOqkIv7TeGfC3HQDxUgXH2Rw8j+7Kyu/p72AYTCvXrJOoAVJ00KKDXTi4xu7+a5VJwP/tpdLz5jeoIfivzgxPP9I/o72OhSrdAZcxPQ5YjbyS22IXhz7G1MkHX0ItytWRqKyfXjq+58LS2ovlQu3eYhoftfBjsq3xisdjqTld9V+DL97qCcWzHo7hscMLO7/5nrXsGiSY16PZ6tUtqe9lI4ErvC+71iH+i44NijMTXMt9uX01V/4Wqlz8m5sDE4Nl0uM31eV2M1MvLKyV1tntj78WREX/mpuqclD8wWO+weglzqfyaF/';

try {
    $response->loadData($encryptedResponse);
} catch (ResponseException $e) {
    // do something on error
    throw $e;
}

// echo response data
echo 'Order unique identifier (externally provided): ' . $response->getExternalOrderId() . "\n";
echo 'Order ID (Twispay ID): ' . $response->getOrderId() . "\n";
echo 'Transaction ID (Twispay ID): ' . $response->getTransactionId() . "\n";
echo 'Transaction status: ' . $response->getTransactionStatus() . "\n";
echo 'Customer unique identifier (externally provided): ' . $response->getIdentifier() . "\n";
echo 'Customer ID (Twispay ID): ' . $response->getCustomerId() . "\n";
echo 'Amount: ' . $response->getAmount() . "\n";
echo 'Currency: ' . $response->getCurrency() . "\n";
