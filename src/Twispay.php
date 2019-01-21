<?php

/**
 * The Twispay class implements methods to get the value
 * of `jsonRequest` and `checksum` that need to be sent by POST
 * when making a Twispay order and to decrypt the Twispay IPN response.
 */
class Twispay
{
    /**
     * Get the `jsonRequest` parameter (order parameters as JSON and base64 encoded).
     *
     * @param array $orderData The order parameters.
     *
     * @return string
     */
    public static function getBase64JsonRequest(array $orderData)
    {
        return base64_encode(json_encode($orderData));
    }

    /**
     * Get the `checksum` parameter (the checksum computed over the `jsonRequest` and base64 encoded).
     *
     * @param array $orderData The order parameters.
     * @param string $secretKey The secret key (from Twispay).
     *
     * @return string
     */
    public static function getBase64Checksum(array $orderData, $secretKey)
    {
        $hmacSha512 = hash_hmac('sha512', json_encode($orderData), $secretKey, true);
        return base64_encode($hmacSha512);
    }

    /**
     * Decrypt the IPN response from Twispay.
     *
     * @param string $encryptedIpnResponse
     * @param string $secretKey The secret key (from Twispay).
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
