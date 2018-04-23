<?php

namespace Twispay;

/**
 * Class TwispayOrderRecurring
 *
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class TwispayOrderRecurring extends TwispayOrderAbstract
{
    /** @var string $orderType */
    protected $orderType = 'recurring';

    /** @var string $twispayIntervalType */
    protected $twispayIntervalType;

    /** @var int $intervalValue */
    protected $intervalValue;

    /** @var float $trialAmount Greater or equal with zero */
    protected $trialAmount;

    /** @var string $firstBillDate Datetime ISO-8601 yyyy-mm-ddThh:mm:ss+00:00 UTC always */
    protected $firstBillDate;

    /**
     * Method getTwispayIntervalType
     *
     * @return string
     */
    public function getTwispayIntervalType()
    {
        return $this->twispayIntervalType;
    }

    /**
     * Method setTwispayIntervalType
     *
     * @param string $twispayIntervalType
     *
     * @return $this
     */
    public function setTwispayIntervalType($twispayIntervalType)
    {
        $this->twispayIntervalType = $twispayIntervalType;
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
     * Method validate
     *
     * @throws TwispayException
     */
    public function validate()
    {
        parent::validate();

        if (strlen($this->twispayIntervalType) == 0) {
            throw new TwispayException('*twispayIntervalType* is a required field', TwispayErrorCode::INTERVAL_TYPE_MISSING);
        }
        if (!TwispayIntervalType::isValid($this->twispayIntervalType)) {
            throw new TwispayException('*twispayIntervalType* is invalid', TwispayErrorCode::INTERVAL_TYPE_INVALID);
        }

        if (strlen($this->intervalValue) == 0) {
            throw new TwispayException('*intervalValue* is a required field', TwispayErrorCode::INTERVAL_VALUE_MISSING);
        }
        if (
            ((int)$this->intervalValue == 0)
            || ((int)$this->intervalValue > 365)
            || (preg_match('/^[0-9]{1,3}$/', $this->intervalValue) != 1)
        ) {
            throw new TwispayException('*intervalValue* is invalid, must be between 1 and 365', TwispayErrorCode::INTERVAL_VALUE_INVALID);
        }

        if (
            (strlen($this->trialAmount) != 0)
            && (
                ((float)$this->trialAmount < 0.01)
                || ((float)$this->trialAmount > 99999999999.99)
                || (preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $this->trialAmount) != 1)
            )
        ) {
            throw new TwispayException('*trialAmount* is invalid, must be greater than 0.01 and match /^[0-9]+(\.[0-9]{1,2})?$/', TwispayErrorCode::TRIAL_AMOUNT_INVALID);
        }

        if (strlen($this->trialAmount) != 0) {
            if (strlen($this->firstBillDate) == 0) {
                throw new TwispayException('*firstBillDate* is a required field', TwispayErrorCode::FIRST_BILL_DATE_MISSING);
            }
        }
        $firstBillDate = \DateTime::createFromFormat(\DateTime::ATOM, $this->firstBillDate);
        if (
            (strlen($this->firstBillDate) != 0)
            && (
                !$firstBillDate
                || ($firstBillDate->format(\DateTime::ATOM) != $this->firstBillDate)
            )
        ) {
            throw new TwispayException('*firstBillDate* is invalid, must be in ISO-8601 UTC format', TwispayErrorCode::FIRST_BILL_DATE_INVALID);
        }
    }
}
