<?php

namespace Twispay;

/**
 * Class TwispayPayment
 *
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class TwispayPayment
{
    /** @var int $siteId Provided by twispay */
    protected $siteId;

    /** @var TwispayCustomer $twispayCustomer */
    protected $twispayCustomer;

    /** @var TwispayOrderInterface $twispayOrder */
    protected $twispayOrder;

    /** @var string|null $twispayCardTransactionMode */
    protected $twispayCardTransactionMode;

    /** @var int|null $cardId The ID of a previously used card for this customer */
    protected $cardId;

    /** @var string|null $invoiceEmail Alternative email address to send invoice to */
    protected $invoiceEmail;

    /** @var array $customData */
    protected $customData;

    /**
     * TwispayPayment constructor.
     *
     * @param string $siteId
     * @param TwispayCustomer $twispayCustomer
     * @param TwispayOrderInterface $twispayOrder
     */
    public function __construct(
        $siteId,
        TwispayCustomer $twispayCustomer,
        TwispayOrderInterface $twispayOrder
    )
    {
        $this->setSiteId($siteId)
            ->setTwispayCustomer($twispayCustomer)
            ->setTwispayOrder($twispayOrder)
            ->setCustomData([]);
    }

    /**
     * Method getSiteId
     *
     * @return int
     */
    public function getSiteId()
    {
        return $this->siteId;
    }

    /**
     * Method setSiteId
     *
     * @param int $siteId
     *
     * @return $this
     */
    public function setSiteId($siteId)
    {
        $this->siteId = $siteId;
        return $this;
    }

    /**
     * Method getTwispayCustomer
     *
     * @return TwispayCustomer
     */
    public function getTwispayCustomer()
    {
        return $this->twispayCustomer;
    }

    /**
     * Method setTwispayCustomer
     *
     * @param TwispayCustomer $twispayCustomer
     *
     * @return $this
     */
    public function setTwispayCustomer(TwispayCustomer $twispayCustomer)
    {
        $this->twispayCustomer = $twispayCustomer;
        return $this;
    }

    /**
     * Method getTwispayOrder
     *
     * @return TwispayOrderInterface
     */
    public function getTwispayOrder()
    {
        return $this->twispayOrder;
    }

    /**
     * Method setTwispayOrder
     *
     * @param TwispayOrderInterface $twispayOrder
     *
     * @return $this
     */
    public function setTwispayOrder(TwispayOrderInterface $twispayOrder)
    {
        $this->twispayOrder = $twispayOrder;
        return $this;
    }

    /**
     * Method getTwispayCardTransactionMode
     *
     * @return string
     */
    public function getTwispayCardTransactionMode()
    {
        return $this->twispayCardTransactionMode;
    }

    /**
     * Method setTwispayCardTransactionMode
     *
     * @param string $twispayCardTransactionMode
     *
     * @return $this
     */
    public function setTwispayCardTransactionMode($twispayCardTransactionMode)
    {
        $this->twispayCardTransactionMode = $twispayCardTransactionMode;
        return $this;
    }

    /**
     * Method getCardId
     *
     * @return int|null
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * Method setCardId
     *
     * @param int|null $cardId
     *
     * @return $this
     */
    public function setCardId($cardId)
    {
        $this->cardId = $cardId;
        return $this;
    }

    /**
     * Method getInvoiceEmail
     *
     * @return null|string
     */
    public function getInvoiceEmail()
    {
        return $this->invoiceEmail;
    }

    /**
     * Method setInvoiceEmail
     *
     * @param null|string $invoiceEmail
     *
     * @return $this
     */
    public function setInvoiceEmail($invoiceEmail)
    {
        $this->invoiceEmail = $invoiceEmail;
        return $this;
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
     * Method setCustomData
     *
     * @param array $customData
     *
     * @return $this
     */
    public function setCustomData(array $customData)
    {
        $this->customData = $customData;
        return $this;
    }

    /**
     * Method addCustomData
     *
     * @param string $key
     * @param string|string[] $value
     *
     * @return $this
     */
    public function addCustomData($key, $value)
    {
        if (array_key_exists($key, $this->customData)) {
            if (!is_array($this->customData[$key])) {
                $this->customData[$key] = [$this->customData[$key]];
            }
            $this->customData[$key] = $value;
            return $this;
        }
        $this->customData[$key] = $value;
        return $this;
    }

    /**
     * Method toArray
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge(
            [
                'siteId' => $this->siteId,
                'cardTransactionMode' => $this->twispayCardTransactionMode,
                'cardId' => $this->cardId,
                'invoiceEmail' => $this->invoiceEmail,
                'custom' => $this->customData,
            ],
            $this->twispayCustomer->toArray(),
            $this->twispayOrder->toArray()
        );
    }

    /**
     * Method recursiveKeySort
     *
     * @param array $data
     */
    protected function recursiveKeySort(array &$data)
    {
        ksort($data, SORT_STRING);
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $this->recursiveKeySort($data[$key]);
            }
        }
    }

    /**
     * Method getChecksum
     *
     * @param string $secretKey
     *
     * @return string
     */
    public function getChecksum($secretKey)
    {
        $data = $this->toArray();
        $this->recursiveKeySort($data);
        $rawData = http_build_query($data);
        return base64_encode(hash_hmac('sha512', $rawData, $secretKey, true));
    }

    /**
     * Method validate
     *
     * @throws TwispayException
     */
    public function validate()
    {
        if (strlen($this->siteId) == 0) {
            throw new TwispayException('*siteId* is a required field', TwispayErrorCode::SITE_ID_MISSING);
        }
        if (
            ((int)$this->siteId == 0)
            || (preg_match('/^[0-9]{1,11}$/', $this->siteId) != 1)
        ) {
            throw new TwispayException('*siteId* is invalid, not a positive integer number', TwispayErrorCode::SITE_ID_INVALID);
        }

        $this->twispayCustomer->validate();

        $this->twispayOrder->validate();

        if (
            (strlen($this->twispayCardTransactionMode) != 0)
            && !TwispayCardTransactionMode::isValid($this->twispayCardTransactionMode)
        ) {
            throw new TwispayException('*twispayCardTransactionMode* is invalid', TwispayErrorCode::TRANSACTION_MODE_INVALID);
        }

        if (
            (strlen($this->cardId) != 0)
            && (
                ((int)$this->cardId == 0)
                || (preg_match('/^[0-9]{1,11}$/', $this->cardId) != 1)
            )
        ) {
            throw new TwispayException('*cardId* is invalid, not a positive integer number', TwispayErrorCode::CARD_ID_INVALID);
        }

        if (
            (strlen($this->invoiceEmail) != 0)
            && !filter_var($this->invoiceEmail, FILTER_VALIDATE_EMAIL)
        ) {
            throw new TwispayException('*invoiceEmail* is invalid', TwispayErrorCode::EMAIL_INVALID);
        }

        if (!empty($this->customData)) {
            if (count($this->customData) > 512) {
                throw new TwispayException('*customData* is invalid, can have maximum 512 elements', TwispayErrorCode::CUSTOM_DATA_INVALID);
            }
            foreach ($this->customData as $key => $value) {
                if (mb_strlen($key, 'UTF-8') > 255) {
                    throw new TwispayException('*customData* is invalid, a key can have maximum 255 characters', TwispayErrorCode::CUSTOM_DATA_INVALID);
                }
                if (is_scalar($value)) {
                    if (mb_strlen($value, 'UTF-8') > 65535) {
                        throw new TwispayException('*customData* is invalid, a value can have maximum 65535 characters', TwispayErrorCode::CUSTOM_DATA_INVALID);
                    }
                } elseif (is_array($value)) {
                    if (count($value) > 512) {
                        throw new TwispayException('*customData* is invalid, a value can have maximum 512 sub-elements', TwispayErrorCode::CUSTOM_DATA_INVALID);
                    }
                    foreach ($value as $subKey => $subValue) {
                        if (mb_strlen($subKey, 'UTF-8') > 255) {
                            throw new TwispayException('*customData* is invalid, a sub-key can have maximum 255 characters', TwispayErrorCode::CUSTOM_DATA_INVALID);
                        }
                        if (is_scalar($subValue)) {
                            if (mb_strlen($subValue, 'UTF-8') > 65535) {
                                throw new TwispayException('*customData* is invalid, a sub-value can have maximum 65535 characters', TwispayErrorCode::CUSTOM_DATA_INVALID);
                            }
                        } else {
                            throw new TwispayException('*customData* is invalid, a sub-value must be scalar', TwispayErrorCode::CUSTOM_DATA_INVALID);
                        }
                    }
                } else {
                    throw new TwispayException('*customData* is invalid, a value must be scalar or array', TwispayErrorCode::CUSTOM_DATA_INVALID);
                }
            }
        }
    }
}
