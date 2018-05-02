<?php

namespace Twispay\Entity\Item;

use Twispay\Entity\ErrorCode;
use Twispay\Exception\ValidationException;

/**
 * Class Item
 *
 * @package Twispay\Entity\Item
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class Item
{
    /** @var string $item Item name */
    protected $item;

    /** @var float $unitPrice Item unit price including VAT, negative for discount etc. */
    protected $unitPrice;

    /** @var int $units Item number/quantity */
    protected $units;

    /**
     * Item constructor.
     *
     * @param string $item
     * @param float $unitPrice
     * @param int $units
     */
    public function __construct(
        $item,
        $unitPrice,
        $units
    )
    {
        $this->setitem($item)
            ->setUnitPrice($unitPrice)
            ->setUnits($units);
    }

    /**
     * Method getItem
     *
     * @return string
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Method setItem
     *
     * @param string $item Item name
     *
     * @return $this
     */
    public function setItem($item)
    {
        $this->item = $item;
        return $this;
    }

    /**
     * Method getUnitPrice
     *
     * @return float
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Method setUnitPrice
     *
     * @param float $unitPrice Item unit price including VAT, negative for discount etc.
     *
     * @return $this
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
        return $this;
    }

    /**
     * Method getUnits
     *
     * @return int
     */
    public function getUnits()
    {
        return $this->units;
    }

    /**
     * Method setUnits
     *
     * @param int $units Item number/quantity
     *
     * @return $this
     */
    public function setUnits($units)
    {
        $this->units = $units;
        return $this;
    }

    /**
     * Method toArray
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'item' => $this->item,
            'unitPrice' => $this->unitPrice,
            'units' => $this->units,
        ];
    }

    /**
     * Method validate
     *
     * @throws ValidationException
     */
    public function validate()
    {
        if (strlen($this->item) == 0) {
            throw new ValidationException('*item* is a required field', ErrorCode::ITEM_MISSING);
        }
        if (mb_strlen($this->item, 'UTF-8') > 512) {
            throw new ValidationException('*item* is invalid, can have maximum 512 characters', ErrorCode::ITEM_INVALID);
        }

        if (strlen($this->unitPrice) == 0) {
            throw new ValidationException('*unitPrice* is a required field', ErrorCode::ITEM_UNIT_PRICE_MISSING);
        }
        if (preg_match('/^-?[0-9]+(.[0-9]+)?$/', $this->unitPrice) != 1) {
            throw new ValidationException('*unitPrice* is invalid, does not match /^-?[0-9]{1,}(.[0-9]+)?$/', ErrorCode::ITEM_UNIT_PRICE_INVALID);
        }

        if (strlen($this->units) == 0) {
            throw new ValidationException('*units* is a required field', ErrorCode::ITEM_UNITS_MISSING);
        }
        if (
            ((int)$this->units == 0)
            || (preg_match('/^[0-9]+$/', $this->units) != 1)
        ) {
            throw new ValidationException('*units* is invalid, not a positive integer number', ErrorCode::ITEM_UNITS_INVALID);
        }
    }
}
