<?php

class Twispay
{
    /**
     * Method getBase64JsonRequest
     *
     * @param array $orderData
     *
     * @return string
     */
    public static function getBase64JsonRequest(array $orderData)
    {
        return base64_encode(json_encode($orderData));
    }

    /**
     * Method getBase64Checksum
     *
     * @param array $orderData
     * @param string $secretKey
     *
     * @return string
     */
    public static function getBase64Checksum(array $orderData, $secretKey)
    {
        $hmacSha512 = hash_hmac('sha512', json_encode($orderData), $secretKey, true);
        return base64_encode($hmacSha512);
    }

    /**
     * Method getHtmlOrderForm
     *
     * @param array $orderData
     * @param string $secretKey
     * @param bool $twispayLive
     *
     * @return string
     */
    public static function getHtmlOrderForm(array $orderData, $secretKey, $twispayLive = false)
    {
        $base64JsonRequest = self::getBase64JsonRequest($orderData);
        $base64Checksum = self::getBase64Checksum($orderData, $secretKey);
        $hostName = $twispayLive ? "secure.twispay.com" : "secure-stage.twispay.com";
        return <<<FORM
<form action="https://{$hostName}" method="post" accept-charset="UTF-8">
    <input type="hidden" name="jsonRequest" value="{$base64JsonRequest}">
    <input type="hidden" name="checksum" value="{$base64Checksum}">
    <input type="submit" value="Pay">
</form>
FORM;
    }

    /**
     * Method decryptIpnResponse
     *
     * @param string $encryptedIpnResponse
     * @param string $secretKey
     *
     * @return array
     */
    public static function decryptIpnResponse($encryptedIpnResponse, $secretKey)
    {
        // get the IV and the encrypted data
        $encryptedParts = explode(',', $encryptedIpnResponse, 2);
        $iv = base64_decode($encryptedParts[0]);
        $encryptedData = base64_decode($encryptedParts[1]);

        // decrypt the encrypted data
        $decryptedIpnResponse = openssl_decrypt($encryptedData, 'aes-256-cbc', $secretKey, OPENSSL_RAW_DATA, $iv);

        # JSON decode the decrypted data
        return json_decode($decryptedIpnResponse, true, 4);
    }
}
