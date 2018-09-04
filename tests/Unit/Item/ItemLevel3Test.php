<?php

namespace Unit\Item;

use PHPUnit\Framework\TestCase;
use Twispay\Entity\Item\ItemLevel3;
use Twispay\Entity\Item\ItemType;

/**
 * Class ItemLevel3Test
 *
 * @category Unit
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class ItemLevel3Test extends TestCase
{
    /**
     * Method testShouldConvertToArray
     */
    public function testShouldConvertToArray()
    {
        $item = $this->getValidItemLevel3();
        $this->assertEquals(
            [
                'item' => 'item',
                'unitPrice' => 1.2,
                'units' => 2,
                'type' => ItemType::DIGITAL,
                'code' => 'IT',
                'vatPercent' => 0.16,
                'itemDescription' => 'description'
            ],
            $item->toArray()
        );
    }

    /**
     * Method testShouldPassValidation
     *
     * @throws \Twispay\Exception\ValidationException
     */
    public function testShouldPassValidation()
    {
        $item = $this->getValidItemLevel3();
        $item->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingItemType
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ITEM_TYPE_MISSING
     */
    public function testShouldFailValidationWithMissingItemType()
    {
        $item = $this->getValidItemLevel3();
        $item->setItemType(null);
        $item->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidItem
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ITEM_TYPE_INVALID
     */
    public function testShouldFailValidationWithInvalidItem()
    {
        $item = $this->getValidItemLevel3();
        $item->setItemType('!invalid');
        $item->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingCode
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ITEM_CODE_MISSING
     */
    public function testShouldFailValidationWithMissingCode()
    {
        $item = $this->getValidItemLevel3();
        $item->setCode(null);
        $item->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidCode
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ITEM_CODE_INVALID
     */
    public function testShouldFailValidationWithInvalidCode()
    {
        $item = $this->getValidItemLevel3();
        $item->setCode(str_repeat('*',65));
        $item->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingDescription
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ITEM_DESCRIPTION_MISSING
     */
    public function testShouldFailValidationWithMissingDescription()
    {
        $item = $this->getValidItemLevel3();
        $item->setDescription(null);
        $item->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidDescription
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ITEM_DESCRIPTION_INVALID
     */
    public function testShouldFailValidationWithInvalidDescription()
    {
        $item = $this->getValidItemLevel3();
        $item->setDescription(str_repeat('*',501));
        $item->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingVatPercent
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ITEM_VAT_PERCENT_MISSING
     */
    public function testShouldFailValidationWithMissingVatPercent()
    {
        $item = $this->getValidItemLevel3();
        $item->setVatPercent(null);
        $item->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidVatPercent
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ITEM_VAT_PERCENT_INVALID
     */
    public function testShouldFailValidationWithInvalidVatPercent()
    {
        $item = $this->getValidItemLevel3();
        $item->setVatPercent('!invalid');
        $item->validate();
    }

    /**
     * Method getValidItemLevel3
     *
     * @return ItemLevel3
     */
    protected function getValidItemLevel3()
    {
        $item = new ItemLevel3();
        $item->setItem('item')
            ->setUnitPrice(1.2)
            ->setUnits(2)
            ->setItemType(ItemType::DIGITAL)
            ->setCode('IT')
            ->setDescription('description')
            ->setVatPercent(0.16);
        return $item;
    }
}
