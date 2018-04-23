<?php

namespace Twispay;

/**
 * Class TwispayItemLevel3
 *
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class TwispayItemLevel3 extends TwispayItem
{
    /** @var string $twispayItemType Item type */
    protected $twispayItemType;

    /** @var string $code Item code */
    protected $code;

    /** @var string $description Item description */
    protected $description;

    /** @var float $vatPercent Item VAT [%] */
    protected $vatPercent;

    /**
     * TwispayItem constructor.
     *
     * @param string $item
     * @param float $unitPrice
     * @param int $units
     * @param string $twispayItemType
     * @param string $code
     * @param string $description
     * @param float $vatPercent
     */
    public function __construct(
        $item,
        $unitPrice,
        $units,
        $twispayItemType,
        $code,
        $description,
        $vatPercent
    )
    {
        parent::__construct(
            $item,
            $unitPrice,
            $units
        );
        $this->setTwispayItemType($twispayItemType)
            ->setCode($code)
            ->setDescription($description)
            ->setVatPercent($vatPercent);
    }

    /**
     * Method getTwispayItemType
     *
     * @return string
     */
    public function getTwispayItemType()
    {
        return $this->twispayItemType;
    }

    /**
     * Method setTwispayItemType
     *
     * @param string $twispayItemType Item type
     *
     * @return $this
     */
    public function setTwispayItemType($twispayItemType)
    {
        $this->twispayItemType = $twispayItemType;
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
     * Method setCode
     *
     * @param string $code Item code
     *
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Method getDescription
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Method setDescription
     *
     * @param string $description Item description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Method getVatPercent
     *
     * @return float
     */
    public function getVatPercent()
    {
        return $this->vatPercent;
    }

    /**
     * Method setVatPercent
     *
     * @param float $vatPercent Item VAT [%]
     *
     * @return $this
     */
    public function setVatPercent($vatPercent)
    {
        $this->vatPercent = $vatPercent;
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
                'type' => $this->getTwispayItemType(),
                'code' => $this->getCode(),
                'vatPercent' => $this->getVatPercent(),
                'itemDescription' => $this->getDescription(),
            ]
        );
    }

    /**
     * Method validate
     *
     * @throws TwispayException
     */
    public function validate()
    {
        parent::validate();

        if (strlen($this->twispayItemType) == 0) {
            throw new TwispayException('*twispayItemType* is a required field', TwispayErrorCode::ITEM_TYPE_MISSING);
        }
        if (TwispayItemType::isValid($this->twispayItemType)) {
            throw new TwispayException('*twispayItemType* is invalid', TwispayErrorCode::ITEM_TYPE_INVALID);
        }

        if (strlen($this->code) == 0) {
            throw new TwispayException('*code* is a required field', TwispayErrorCode::ITEM_CODE_MISSING);
        }
        if (mb_strlen($this->code, 'UTF-8') > 64) {
            throw new TwispayException('*code* is invalid, can have maximum 64 characters', TwispayErrorCode::ITEM_CODE_INVALID);
        }

        if (strlen($this->description) == 0) {
            throw new TwispayException('*description* is a required field', TwispayErrorCode::ITEM_DESCRIPTION_MISSING);
        }
        if (mb_strlen($this->description, 'UTF-8') > 500) {
            throw new TwispayException('*description* is invalid, can have maximum 500 characters', TwispayErrorCode::ITEM_DESCRIPTION_INVALID);
        }

        if (strlen($this->vatPercent) == 0) {
            throw new TwispayException('*vatPercent* is a required field', TwispayErrorCode::ITEM_VAT_PERCENT_MISSING);
        }
        if (preg_match('/^[0-9]{1,8}(\.+[0-9]{0,4})?$/', $this->vatPercent) != 1) {
            throw new TwispayException('*vatPercent* is invalid, does not match /^[0-9]{1,8}(\.+[0-9]{0,4})?$/', TwispayErrorCode::ITEM_VAT_PERCENT_INVALID);
        }
    }
}
