<?php

namespace Unit;

use PHPUnit\Framework\TestCase;
use Twispay\Response;

/**
 * Class ResponseTest
 *
 * @category Unit
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class ResponseTest extends TestCase
{
    /**
     * Method v
     *
     * @expectedException \Twispay\Exception\ResponseException
     */
    public function testShouldFailDecodeResponseWithInvalidSecretKey()
    {
        $rawResponse = $this->getEncryptedRawResponse();
        $response = new Response();
        $response->setSecretKey('invalid-secret-key')
            ->loadData($rawResponse);
        $this->assertDecodedResponse($response);
    }

    /**
     * Method testShouldFailDecodeResponseWithInvalidResponse
     *
     * @expectedException \Twispay\Exception\ResponseException
     */
    public function testShouldFailDecodeResponseWithInvalidResponse()
    {
        $rawResponse = 'invalid-response';
        $response = new Response();
        $response->setSecretKey($this->getSecretKey())
            ->loadData($rawResponse);
        $this->assertDecodedResponse($response);
    }

    /**
     * Method testShouldDecodeResponseFromString
     */
    public function testShouldDecodeResponseFromString()
    {
        $rawResponse = $this->getEncryptedRawResponse();
        $response = new Response();
        $response->setSecretKey($this->getSecretKey())
            ->loadData($rawResponse);
        $this->assertDecodedResponse($response);
    }

    /**
     * Method testShouldDecodeResponseFromArray
     */
    public function testShouldDecodeResponseFromArray()
    {
        $rawResponse = $this->getEncryptedRawResponse();
        $response = new Response();
        $response->setSecretKey($this->getSecretKey())
            ->loadData(
                [
                    'opensslResult' => $rawResponse
                ]
            );
        $this->assertDecodedResponse($response);
    }

    /**
     * Method testShouldDecodeResponseFromPostOverGet
     */
    public function testShouldDecodeResponseFromPostOverGet()
    {
        $_POST['opensslResult'] = $this->getEncryptedRawResponse();
        $_GET['opensslResult'] = 'invalid-response';
        $response = new Response();
        $response->setSecretKey($this->getSecretKey())
            ->loadData();
        $this->assertDecodedResponse($response);
    }

    /**
     * Method testShouldDecodeResponseFromGet
     */
    public function testShouldDecodeResponseFromGet()
    {
        $_GET['opensslResult'] = $this->getEncryptedRawResponse();
        $response = new Response();
        $response->setSecretKey($this->getSecretKey())
            ->loadData();
        $this->assertDecodedResponse($response);
    }

    /**
     * Method getSecretKey
     *
     * @return string
     */
    protected function getSecretKey()
    {
        return 'ea9521816d4fcf0c0a78052fa70c3df9';
    }

    /**
     * Method getEncryptedRawResponse
     *
     * @return string
     */
    protected function getEncryptedRawResponse()
    {
        return 'tqb0pHyFGeeWagIthcu/hw==,joq3TJgwFjC7UCHge4Ql7c5kyc/E42GyYfwEnEdZVOzBe5lSFptCmhDVozfffrKJhzvJ3Higsbde+Xg2agBdnOK087Vr6o/F2qEWImOwKpb3BabM9ya6tY0nRoVRx7BJQC9RIVLdTXm0nXMejBE7TM0uDO2JeTX54i2FBpg8oPd0ae82C36yz0amKNyG+7DP10EOxNjVvzQnV2npf7QdR1m2E0iGMBEO1Ykj3Fe6av3n3p15ulkym1B1NxNtVpjSdmpXcN1+ncYU4I/RGNHf6w3+bgLY/j3PCZnIfO0d7KuWQe+33WYb7a7amoYHdLYMNjhWec8GyHtyit7i82bxUV7KMTEfVXKqiaK2uC0liZBQWFY1f/K82E6gIK0Hns8ui/u/qCHUWyFehXR9T7aZQRK9q5kHQnQwPt+Aj4pK16rQF8B76hArKC8hdqZEUvTb0soJ3kpvF4+MTPq/fUCtcrgcYJhZdhGc2NJPONnfea6CjXWKhRGNB3tHmEY8z87AhPFnLBbv39uMIRMW5iOBhNxmutifcapYSZhpNo0FUWcsiQ4GkDuY6QFd7D3nkZX/';
    }

    /**
     * Method assertDecodedResponse
     *
     * @param Response $response
     */
    protected function assertDecodedResponse(Response $response)
    {
        $this->assertEquals('identifier', $response->getIdentifier());
        $this->assertEquals('external-order-id', $response->getExternalOrderId());
        $this->assertEquals('complete-ok', $response->getTransactionStatus());
        $this->assertEquals(1, $response->getCustomerId());
        $this->assertEquals(218, $response->getOrderId());
        $this->assertEquals(37, $response->getCardId());
        $this->assertEquals(207, $response->getTransactionId());
        $this->assertEquals(10.0, $response->getAmount());
        $this->assertEquals('USD', $response->getCurrency());
        $this->assertEquals(1525782732, $response->getTimestamp());
        $this->assertEquals(
            [
                'key_1' => 'value_1',
                'key_2' => 'value_2'
            ],
            $response->getCustomData()
        );
    }
}
