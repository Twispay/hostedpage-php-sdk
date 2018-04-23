<?php

namespace Twispay\Entity\Item;

use Twispay\Entity\ErrorCode;
use Twispay\Exception\ValidationException;

/**
 * Class ItemLevel3
 *
 * @package Twispay\Entity\Item
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class ItemLevel3 extends Item
{
    /** @var string $itemType Item type @see ItemType */
    protected $itemType;

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
        $this->setItemType($twispayItemType)
            ->setCode($code)
            ->setDescription($description)
            ->setVatPercent($vatPercent);
    }

    /**
     * Method getTwispayItemType
     *
     * @return string
     */
    public function getItemType()
    {
        return $this->itemType;
    }

    /**
     * Method setTwispayItemType
     *
     * @param string $itemType Item type
     *
     * @return $this
     */
    public function setItemType($itemType)
    {
        $this->itemType = $itemType;
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
                'type' => $this->getItemType(),
                'code' => $this->getCode(),
                'vatPercent' => $this->getVatPercent(),
                'itemDescription' => $this->getDescription(),
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

        if (strlen($this->itemType) == 0) {
            throw new ValidationException('*itemType* is a required field', ErrorCode::ITEM_TYPE_MISSING);
        }
        if (ItemType::isValid($this->itemType)) {
            throw new ValidationException('*itemType* is invalid', ErrorCode::ITEM_TYPE_INVALID);
        }

        if (strlen($this->code) == 0) {
            throw new ValidationException('*code* is a required field', ErrorCode::ITEM_CODE_MISSING);
        }
        if (mb_strlen($this->code, 'UTF-8') > 64) {
            throw new ValidationException('*code* is invalid, can have maximum 64 characters', ErrorCode::ITEM_CODE_INVALID);
        }

        if (strlen($this->description) == 0) {
            throw new ValidationException('*description* is a required field', ErrorCode::ITEM_DESCRIPTION_MISSING);
        }
        if (mb_strlen($this->description, 'UTF-8') > 500) {
            throw new ValidationException('*description* is invalid, can have maximum 500 characters', ErrorCode::ITEM_DESCRIPTION_INVALID);
        }

        if (strlen($this->vatPercent) == 0) {
            throw new ValidationException('*vatPercent* is a required field', ErrorCode::ITEM_VAT_PERCENT_MISSING);
        }
        if (preg_match('/^[0-9]{1,8}(\.+[0-9]{0,4})?$/', $this->vatPercent) != 1) {
            throw new ValidationException('*vatPercent* is invalid, does not match /^[0-9]{1,8}(\.+[0-9]{0,4})?$/', ErrorCode::ITEM_VAT_PERCENT_INVALID);
        }
    }
}
