# Twispay sample code for PHP

Sample code for generating a HTML form for a Twispay order:

```php
// sample data contains order parameters
$orderData = [
    "siteId" => 1,
    "customer" => [
        "identifier" => "external-user-id",
        "firstName" => "John ",
        "lastName" => "Doe",
        "country" => "US",
        "state" => "NY",
        "city" => "New York",
        "address" => "1st Street",
        "zipCode" => "11222",
        "phone" => "0012120000000",
        "email" => "john.doe@test.com"
    ],
    "order" => [
        "orderId" => "external-order-id",
        "type" => "purchase",
        "amount" => 2194.99,
        "currency" => "USD",
        "description" => "1 year subscription on site"
    ],
    "cardTransactionMode" => "authAndCapture",
    "invoiceEmail" => "john.doe@test.com",
    "backUrl" => "http://google.com"
];

// your secret key
$secretKey = "cd07b3c95dc9a0c8e9318b29bdc13b03";

// TRUE for Twispay live site, otherwise Twispay stage will be used
$twispayLive = false;

// get the HTML form
$base64JsonRequest = Twispay::getBase64JsonRequest($orderData);
$base64Checksum = Twispay::getBase64Checksum($orderData, $secretKey);
$hostName = $twispayLive ? "secure.twispay.com" : "secure-stage.twispay.com";
$htmlForm = <<<FORM
<form action="https://{$hostName}" method="post" accept-charset="UTF-8">
    <input type="hidden" name="jsonRequest" value="{$base64JsonRequest}">
    <input type="hidden" name="checksum" value="{$base64Checksum}">
    <input type="submit" value="Pay">
</form>
FORM;
```

Sample code for decrypting the Twispay IPN response:

```php
// normally you get the encrypted data from the HTTP request (POST/GET) in the `opensslResult` parameter
$encryptedIpnResponse = "oUrO8wW0IXK1yj9F8RYbHw==,Hrw4AkEt+DBALL4P9gNDyBxkvnjh3wxlgAdqe1jVffEGrwpEpCKc3eYjR4l+mi9dCxPuvXRceVgqd7ypn9aXGLXejxClumv4l2Ym2djbpsi2PFRWyWXHoJar+NX8aLU/yCYdHUoNtvoZRA2RI13IUCLZZ1znlQdyEL9NXQTEAxrbZe7a4vmYbUDBosAiIfApGLGMWQG/OF+ebukvLeZGajzUbhbp69k8/UD03dT8NBDMSos5XayJNnEibM2unImh6tcOek5prenHQOqkIv7TeGfC3HQDxUgXH2Rw8j+7Kyu/p72AYTCvXrJOoAVJ00KKDXTi4xu7+a5VJwP/tpdLz5jeoIfivzgxPP9I/o72OhSrdAZcxPQ5YjbyS22IXhz7G1MkHX0ItytWRqKyfXjq+58LS2ovlQu3eYhoftfBjsq3xisdjqTld9V+DL97qCcWzHo7hscMLO7/5nrXsGiSY16PZ6tUtqe9lI4ErvC+71iH+i44NijMTXMt9uX01V/4Wqlz8m5sDE4Nl0uM31eV2M1MvLKyV1tntj78WREX/mpuqclD8wWO+weglzqfyaF/";

# your secret key
$secretKey = "cd07b3c95dc9a0c8e9318b29bdc13b03";

echo "encryptedIpnResponse: " . $encryptedIpnResponse . "\n";
echo "secretKey: " . $secretKey . "\n";

# get the IPN response
$ipnResponse = Twispay::decryptIpnResponse($encryptedIpnResponse, $secretKey);
```

Run the sample code from the command line:

- execute `php ./example/twispayOrder.php` to generate and output the HTML form for a Twispay order;
- execute `php ./example/twispayIpn.php` to decrypt and output the received data from a IPN call.
