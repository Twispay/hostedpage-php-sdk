<?php

namespace Twispay\Entity\Order;

use Twispay\Entity\ErrorCode;
use Twispay\Exception\ValidationException;

/**
 * Class OrderRecurring
 *
 * @package Twispay\Entity\Order
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class OrderRecurring extends OrderAbstract
{
    /** @var string $orderType */
    protected $orderType = OrderType::RECURRING;

    /** @var string $intervalType */
    protected $intervalType;

    /** @var int $intervalValue */
    protected $intervalValue;

    /** @var float $trialAmount Greater or equal with zero */
    protected $trialAmount;

    /** @var string $firstBillDate Datetime ISO-8601 yyyy-mm-ddThh:mm:ss+00:00 UTC always */
    protected $firstBillDate;

    /**
     * OrderRecurring constructor.
     *
     * @param string $orderId
     * @param float $amount
     * @param string $currency
     * @param string $intervalType
     * @param int $intervalValue
     */
    public function __construct(
        $orderId = null,
        $amount = null,
        $currency = null,
        $intervalType = null,
        $intervalValue = null
    )
    {
        parent::__construct($orderId, $amount, $currency);
        $this->setIntervalType($intervalType)
            ->setIntervalValue($intervalValue);
    }

    /**
     * Method getIntervalType
     *
     * @return string
     */
    public function getIntervalType()
    {
        return $this->intervalType;
    }

    /**
     * Method setIntervalType
     *
     * @param string $intervalType
     *
     * @return $this
     */
    public function setIntervalType($intervalType)
    {
        $this->intervalType = $intervalType;
        return $this;
    }

    /**
     * Method getIntervalValue
     *
     * @return int
     */
    public function getIntervalValue()
    {
        return $this->intervalValue;
    }

    /**
     * Method setIntervalValue
     *
     * @param int $intervalValue
     *
     * @return $this
     */
    public function setIntervalValue($intervalValue)
    {
        $this->intervalValue = $intervalValue;
        return $this;
    }

    /**
     * Method getTrialAmount
     *
     * @return float
     */
    public function getTrialAmount()
    {
        return $this->trialAmount;
    }

    /**
     * Method setTrialAmount
     *
     * @param float $trialAmount Greater or equal with zero
     *
     * @return $this
     */
    public function setTrialAmount($trialAmount)
    {
        $this->trialAmount = $trialAmount;
        return $this;
    }

    /**
     * Method getFirstBillDate
     *
     * @return string
     */
    public function getFirstBillDate()
    {
        return $this->firstBillDate;
    }

    /**
     * Method setFirstBillDate
     *
     * @param string $firstBillDate Datetime ISO-8601 yyyy-mm-ddThh:mm:ss+00:00 UTC always
     *
     * @return $this
     */
    public function setFirstBillDate($firstBillDate)
    {
        $this->firstBillDate = $firstBillDate;
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
            parent::toArray(),
            [
                'intervalType' => $this->intervalType,
                'intervalValue' => $this->intervalValue,
                'trialAmount' => $this->trialAmount,
                'firstBillDate' => $this->firstBillDate,
            ]
        );
    }

    /**
     * Method validate
     *
     * @throws ValidationException
     */
    public function validate()
    {
        parent::validate();

        if (strlen($this->intervalType) == 0) {
            throw new ValidationException('*intervalType* is a required field', ErrorCode::INTERVAL_TYPE_MISSING);
        }
        if (!IntervalType::isValid($this->intervalType)) {
            throw new ValidationException('*intervalType* is invalid', ErrorCode::INTERVAL_TYPE_INVALID);
        }

        if (strlen($this->intervalValue) == 0) {
            throw new ValidationException('*intervalValue* is a required field', ErrorCode::INTERVAL_VALUE_MISSING);
        }
        if (
            ((int)$this->intervalValue == 0)
            || ((int)$this->intervalValue > 365)
            || (preg_match('/^[0-9]{1,3}$/', $this->intervalValue) != 1)
        ) {
            throw new ValidationException('*intervalValue* is invalid, must be between 1 and 365', ErrorCode::INTERVAL_VALUE_INVALID);
        }

        if (
            (strlen($this->trialAmount) != 0)
            && (
                ((float)$this->trialAmount < 0.01)
                || ((float)$this->trialAmount > 99999999999.99)
                || (preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $this->trialAmount) != 1)
            )
        ) {
            throw new ValidationException('*trialAmount* is invalid, must be greater than 0.01 and match /^[0-9]+(\.[0-9]{1,2})?$/', ErrorCode::TRIAL_AMOUNT_INVALID);
        }

        if (strlen($this->firstBillDate) == 0) {
            if (strlen($this->trialAmount) != 0) {
                throw new ValidationException('*firstBillDate* is a required field', ErrorCode::FIRST_BILL_DATE_MISSING);
            }
        } else {
            $firstBillDate = \DateTime::createFromFormat(\DateTime::ATOM, $this->firstBillDate);
            if (
                !$firstBillDate
                || ($firstBillDate->format(\DateTime::ATOM) != $this->firstBillDate)
            ) {
                throw new ValidationException('*firstBillDate* is invalid, must be in ISO-8601 UTC format', ErrorCode::FIRST_BILL_DATE_INVALID);
            }
        }
    }
}
