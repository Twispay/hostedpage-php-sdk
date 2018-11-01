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
$encryptedResponse = 'tqb0pHyFGeeWagIthcu/hw==,joq3TJgwFjC7UCHge4Ql7c5kyc/E42GyYfwEnEdZVOzBe5lSFptCmhDVozfffrKJhzvJ3Higsbde+Xg2agBdnOK087Vr6o/F2qEWImOwKpb3BabM9ya6tY0nRoVRx7BJQC9RIVLdTXm0nXMejBE7TM0uDO2JeTX54i2FBpg8oPd0ae82C36yz0amKNyG+7DP10EOxNjVvzQnV2npf7QdR1m2E0iGMBEO1Ykj3Fe6av3n3p15ulkym1B1NxNtVpjSdmpXcN1+ncYU4I/RGNHf6w3+bgLY/j3PCZnIfO0d7KuWQe+33WYb7a7amoYHdLYMNjhWec8GyHtyit7i82bxUV7KMTEfVXKqiaK2uC0liZBQWFY1f/K82E6gIK0Hns8ui/u/qCHUWyFehXR9T7aZQRK9q5kHQnQwPt+Aj4pK16rQF8B76hArKC8hdqZEUvTb0soJ3kpvF4+MTPq/fUCtcrgcYJhZdhGc2NJPONnfea6CjXWKhRGNB3tHmEY8z87AhPFnLBbv39uMIRMW5iOBhNxmutifcapYSZhpNo0FUWcsiQ4GkDuY6QFd7D3nkZX/';

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
