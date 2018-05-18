<?php

namespace Unit\Item;

use PHPUnit\Framework\TestCase;
use Twispay\Entity\Item\Item;

/**
 * Class ItemTest
 *
 * @category Unit
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class ItemTest extends TestCase
{
    /**
     * Method testShouldConvertToArray
     */
    public function testShouldConvertToArray()
    {
        $item = $this->getValidItem();
        $this->assertEquals(
            [
                'item' => 'item',
                'unitPrice' => 1.2,
                'units' => 2
            ],
            $item->toArray()
        );
    }

    /**
     * Method testShouldPassValidation
     */
    public function testShouldPassValidation()
    {
        $item = $this->getValidItem();
        $item->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingItem
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ITEM_MISSING
     */
    public function testShouldFailValidationWithMissingItem()
    {
        $item = $this->getValidItem();
        $item->setItem(null);
        $item->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidItem
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ITEM_INVALID
     */
    public function testShouldFailValidationWithInvalidItem()
    {
        $item = $this->getValidItem();
        $item->setItem(str_repeat('*', 513));
        $item->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingUnitPrice
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ITEM_UNIT_PRICE_MISSING
     */
    public function testShouldFailValidationWithMissingUnitPrice()
    {
        $item = $this->getValidItem();
        $item->setUnitPrice(null);
        $item->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidUnitPrice
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ITEM_UNIT_PRICE_INVALID
     */
    public function testShouldFailValidationWithInvalidUnitPrice()
    {
        $item = $this->getValidItem();
        $item->setUnitPrice('!invalid');
        $item->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingUnits
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ITEM_UNITS_MISSING
     */
    public function testShouldFailValidationWithMissingUnits()
    {
        $item = $this->getValidItem();
        $item->setUnits(null);
        $item->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidUnits
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ITEM_UNITS_INVALID
     */
    public function testShouldFailValidationWithInvalidUnits()
    {
        $item = $this->getValidItem();
        $item->setUnits('!invalid');
        $item->validate();
    }

    /**
     * Method getValidItem
     */
    protected function getValidItem()
    {
        $item = new Item();
        $item->setItem('item')
            ->setUnitPrice(1.2)
            ->setUnits(2);
        return $item;
    }
}
