<?php

namespace Twispay;

use Twispay\Entity\ErrorCode;
use Twispay\Exception\ResponseException;

/**
 * Class Response
 *
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class Response
{
    /** @var string $code */
    protected $code;

    /** @var string $message */
    protected $message;

    /** @var array $errors */
    protected $errors;

    /** @var string $identifier */
    protected $identifier;

    /** @var string $externalOrderId */
    protected $externalOrderId;

    /** @var string $transactionStatus */
    protected $transactionStatus;

    /** @var int $customerId */
    protected $customerId;

    /** @var int $orderId */
    protected $orderId;

    /** @var int $cardId */
    protected $cardId;

    /** @var int $transactionId */
    protected $transactionId;

    /** @var string $transactionMethod */
    protected $transactionMethod;

    /** @var float $amount */
    protected $amount;

    /** @var string $currency */
    protected $currency;

    /** @var int $timestamp */
    protected $timestamp;

    /** @var array $customData */
    protected $customData;

    /** @var array $customFields */
    protected $customFields;

    /** @var string $secretKey */
    protected $secretKey;

    /**
     * Response constructor.
     *
     * @param string $secretKey
     * @param array $config
     */
    public function __construct($secretKey = null, array $config = [])
    {
        $this->secretKey = $secretKey;
        $this->errors = [];
        $this->customData = [];
        $this->customFields = [];
    }

    /**
     * Method decrypt
     *
     * @param string $encryptedContent
     * @param string $decryptionKey
     *
     * @return string
     *
     * @throws ResponseException
     */
    protected function decrypt($encryptedContent, $decryptionKey)
    {
        if (strpos($encryptedContent, ',') === false) {
            throw new ResponseException('Invalid encrypted data', ErrorCode::RESPONSE_INVALID_DATA);
        }
        $encryptedParts = explode(',', $encryptedContent, 2);
        $iv = base64_decode($encryptedParts[0]);
        if (false === $iv) {
            throw new ResponseException('Invalid encrypted data', ErrorCode::RESPONSE_SSL_INVALID_IV);
        }
        $encryptedContent = base64_decode($encryptedParts[1]);
        if (false === $encryptedContent) {
            throw new ResponseException('Invalid encrypted data', ErrorCode::RESPONSE_INVALID_DATA);
        }
        $decrypted = openssl_decrypt(
            $encryptedContent,
            'aes-256-cbc',
            $decryptionKey,
            OPENSSL_RAW_DATA,
            $iv
        );
        if (false === $decrypted) {
            throw new ResponseException('Data could not be decrypted', ErrorCode::RESPONSE_NOT_DECRYPTED);
        }
        return $decrypted;
    }

    /**
     * Method initFrom
     *
     * @param array $data
     */
    protected function initFrom(array $data)
    {
        $this->code = array_key_exists('code', $data) ? $data['code'] : null;
        $this->message = array_key_exists('message', $data) ? $data['message'] : null;
        $this->errors = array_key_exists('errors', $data) ? (array)$data['errors'] : [];
        $this->identifier = array_key_exists('identifier', $data) ? $data['identifier'] : null;
        $this->externalOrderId = array_key_exists('externalOrderId', $data) ? $data['externalOrderId'] : null;
        $this->transactionStatus = array_key_exists('transactionStatus', $data) ? $data['transactionStatus'] : null;
        $this->customerId = array_key_exists('customerId', $data) ? (int)$data['customerId'] : null;
        $this->orderId = array_key_exists('orderId', $data) ? (int)$data['orderId'] : null;
        $this->cardId = array_key_exists('cardId', $data) ? (int)$data['cardId'] : null;
        $this->transactionId = array_key_exists('transactionId', $data) ? (int)$data['transactionId'] : null;
        $this->transactionMethod = array_key_exists('transactionMethod', $data) ? (int)$data['transactionMethod'] : null;
        $this->amount = array_key_exists('amount', $data) ? (float)$data['amount'] : null;
        $this->currency = array_key_exists('currency', $data) ? $data['currency'] : null;
        $this->timestamp = array_key_exists('timestamp', $data) ? (int)$data['timestamp'] : null;
        $this->customData = array_key_exists('custom', $data) ? (array)$data['custom'] : [];
        $this->customFields = array_key_exists('customField', $data) ? (array)$data['customField'] : [];
    }

    /**
     * Method loadData
     *
     * @param string $encryptedResponse
     *
     * @throws ResponseException
     */
    public function loadData($encryptedResponse)
    {
        if (!is_scalar($encryptedResponse)) {
            throw new ResponseException('Invalid response data', ErrorCode::RESPONSE_INVALID_DATA);
        }
        $encryptedResponse = trim((string)$encryptedResponse);
        if (empty($encryptedResponse)) {
            throw new ResponseException('Missing response data', ErrorCode::RESPONSE_MISSING);
        }
        if (strlen($this->secretKey) == 0) {
            throw new ResponseException("Can't decrypt response, missing secret key", ErrorCode::SECRET_KEY_MISSING);
        }
        $data = $this->decrypt($encryptedResponse, $this->secretKey);
        $data = json_decode($data, true, 4);
        if (json_last_error() != JSON_ERROR_NONE) {
            throw new ResponseException('Invalid response data ' . json_last_error(), ErrorCode::RESPONSE_INVALID_DATA);
        }
        $this->initFrom($data);
    }

    /**
     * Method getEncryptedResponse
     *
     * @return mixed|null
     */
    public function getEncryptedResponse()
    {
        return empty($_POST['opensslResult'])
            ? (empty($_GET['opensslResult']) ? null : $_GET['opensslResult'])
            : $_POST['opensslResult'];
    }

    /**
     * Method getSecretKey
     *
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * Method setSecretKey
     *
     * @param string $secretKey
     *
     * @return $this
     */
    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;
        return $this;
    }

    /**
     * Method getCode
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Method getMessage
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Method getErrors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Method getIdentifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Method getExternalOrderId
     *
     * @return string
     */
    public function getExternalOrderId()
    {
        return $this->externalOrderId;
    }

    /**
     * Method getTransactionStatus
     *
     * @return string
     */
    public function getTransactionStatus()
    {
        return $this->transactionStatus;
    }

    /**
     * Method getCustomerId
     *
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Method getOrderId
     *
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Method getCardId
     *
     * @return int
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * Method getTransactionId
     *
     * @return int
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * Method getTransactionMethod
     *
     * @return string
     */
    public function getTransactionMethod()
    {
        return $this->transactionMethod;
    }

    /**
     * Method getAmount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Method getCurrency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Method getTimestamp
     *
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Method getCustomData
     *
     * @return array
     */
    public function getCustomData()
    {
        return $this->customData;
    }

    /**
     * Method getCustomFields
     *
     * @return array
     */
    public function getCustomFields()
    {
        return $this->customFields;
    }
}
