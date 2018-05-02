<?php

namespace Twispay;

use Twispay\Entity\CardTransactionMode;
use Twispay\Entity\Customer\CustomerInterface;
use Twispay\Entity\ErrorCode;
use Twispay\Entity\Order\OrderInterface;
use Twispay\Exception\ValidationException;

/**
 * Class Payment
 *
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class Payment implements PaymentInterface
{
    /** @var int $siteId Provided by Twispay */
    protected $siteId;

    /** @var CustomerInterface $customer */
    protected $customer;

    /** @var OrderInterface $order */
    protected $order;

    /** @var string|null $cardTransactionMode */
    protected $cardTransactionMode;

    /** @var int|null $cardId The ID of a previously used card for this customer */
    protected $cardId;

    /** @var string|null $invoiceEmail Alternative email address to send invoice to */
    protected $invoiceEmail;

    /** @var array $customData */
    protected $customData;

    /**
     * Payment constructor.
     *
     * @param string $siteId
     * @param CustomerInterface $customer
     * @param OrderInterface $order
     */
    public function __construct(
        $siteId,
        CustomerInterface $customer,
        OrderInterface $order
    )
    {
        $this->setSiteId($siteId)
            ->setCustomer($customer)
            ->setOrder($order)
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
     * Method getCustomer
     *
     * @return CustomerInterface
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Method setCustomer
     *
     * @param CustomerInterface $customer
     *
     * @return $this
     */
    public function setCustomer(CustomerInterface $customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * Method getOrder
     *
     * @return OrderInterface
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Method setOrder
     *
     * @param OrderInterface $order
     *
     * @return $this
     */
    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * Method getCardTransactionMode
     *
     * @return string
     */
    public function getCardTransactionMode()
    {
        return $this->cardTransactionMode;
    }

    /**
     * Method setCardTransactionMode
     *
     * @param string $cardTransactionMode
     *
     * @return $this
     */
    public function setCardTransactionMode($cardTransactionMode)
    {
        $this->cardTransactionMode = $cardTransactionMode;
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
        $key = (string)$key;
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
                'cardTransactionMode' => $this->cardTransactionMode,
                'cardId' => $this->cardId,
                'invoiceEmail' => $this->invoiceEmail,
                'custom' => $this->customData,
            ],
            $this->customer->toArray(),
            $this->order->toArray()
        );
    }

    /**
     * Method recursiveSortAndPrepare
     *
     * @param array $data
     */
    protected function recursiveSortAndPrepare(array &$data)
    {
        ksort($data, SORT_STRING);
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $this->recursiveSortAndPrepare($data[$key]);
                continue;
            }
            $data[$key] = (string)$value;
        }
    }

    /**
     * Method getChecksum
     *
     * @param string $secretKey
     * @param array $data
     *
     * @return string
     */
    public function getChecksum($secretKey, array $data)
    {
        $this->recursiveSortAndPrepare($data);
        $rawData = http_build_query($data);
        return base64_encode(hash_hmac('sha512', $rawData, $secretKey, true));
    }

    /**
     * Method validate
     *
     * @throws ValidationException
     */
    public function validate()
    {
        if (strlen($this->siteId) == 0) {
            throw new ValidationException('*siteId* is a required field', ErrorCode::SITE_ID_MISSING);
        }
        if (
            ((int)$this->siteId == 0)
            || (preg_match('/^[0-9]{1,11}$/', $this->siteId) != 1)
        ) {
            throw new ValidationException('*siteId* is invalid, not a positive integer number', ErrorCode::SITE_ID_INVALID);
        }

        $this->customer->validate();

        $this->order->validate();

        if (
            (strlen($this->cardTransactionMode) != 0)
            && !CardTransactionMode::isValid($this->cardTransactionMode)
        ) {
            throw new ValidationException('*cardTransactionMode* is invalid', ErrorCode::TRANSACTION_MODE_INVALID);
        }

        if (
            (strlen($this->cardId) != 0)
            && (
                ((int)$this->cardId == 0)
                || (preg_match('/^[0-9]{1,11}$/', $this->cardId) != 1)
            )
        ) {
            throw new ValidationException('*cardId* is invalid, not a positive integer number', ErrorCode::CARD_ID_INVALID);
        }

        if (
            (strlen($this->invoiceEmail) != 0)
            && !filter_var($this->invoiceEmail, FILTER_VALIDATE_EMAIL)
        ) {
            throw new ValidationException('*invoiceEmail* is invalid', ErrorCode::EMAIL_INVALID);
        }

        if (!empty($this->customData)) {
            if (count($this->customData) > 512) {
                throw new ValidationException('*customData* is invalid, can have maximum 512 elements', ErrorCode::CUSTOM_DATA_INVALID);
            }
            foreach ($this->customData as $key => $value) {
                if (mb_strlen($key, 'UTF-8') > 255) {
                    throw new ValidationException('*customData* is invalid, a key can have maximum 255 characters', ErrorCode::CUSTOM_DATA_INVALID);
                }
                if (is_scalar($value)) {
                    if (mb_strlen($value, 'UTF-8') > 65535) {
                        throw new ValidationException('*customData* is invalid, a value can have maximum 65535 characters', ErrorCode::CUSTOM_DATA_INVALID);
                    }
                } elseif (is_array($value)) {
                    if (count($value) > 512) {
                        throw new ValidationException('*customData* is invalid, a value can have maximum 512 sub-elements', ErrorCode::CUSTOM_DATA_INVALID);
                    }
                    foreach ($value as $subKey => $subValue) {
                        if (mb_strlen($subKey, 'UTF-8') > 255) {
                            throw new ValidationException('*customData* is invalid, a sub-key can have maximum 255 characters', ErrorCode::CUSTOM_DATA_INVALID);
                        }
                        if (is_scalar($subValue)) {
                            if (mb_strlen($subValue, 'UTF-8') > 65535) {
                                throw new ValidationException('*customData* is invalid, a sub-value can have maximum 65535 characters', ErrorCode::CUSTOM_DATA_INVALID);
                            }
                        } else {
                            throw new ValidationException('*customData* is invalid, a sub-value must be scalar', ErrorCode::CUSTOM_DATA_INVALID);
                        }
                    }
                } else {
                    throw new ValidationException('*customData* is invalid, a value must be scalar or array', ErrorCode::CUSTOM_DATA_INVALID);
                }
            }
        }
    }
}
