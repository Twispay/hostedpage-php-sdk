<?php

namespace Unit\Item;

use Mocks\MockItem;
use Mocks\MockItemLevel3;
use PHPUnit\Framework\TestCase;
use Twispay\Entity\Item\Item;
use Twispay\Entity\Item\ItemLevel3;
use Twispay\Entity\Item\ItemList;
use Twispay\Entity\Item\ItemType;

/**
 * Class ItemListTest
 *
 * @category Unit
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class ItemListTest extends TestCase
{
    /**
     * Method testShouldGetAmount
     */
    public function testShouldGetAmount()
    {
        $itemList = $this->getValidItemList();
        $this->assertEquals(5.4, $itemList->getAmount());
        $itemList = $this->getValidItemLevel3List();
        $this->assertEquals(5.4, $itemList->getAmount());
    }

    /**
     * Method testShouldConvertToArray
     */
    public function testShouldConvertToArray()
    {
        $itemList = $this->getValidItemList();
        $this->assertEquals(
            [
                'item' => [
                    'item',
                    'item1'
                ],
                'unitPrice' => [
                    1.2,
                    3
                ],
                'units' => [
                    2,
                    1
                ]
            ],
            $itemList->toArray()
        );
        $itemLevel3List = $this->getValidItemLevel3List();
        $this->assertEquals(
            [
                'item' => [
                    'item',
                    'item1'
                ],
                'unitPrice' => [
                    1.2,
                    3
                ],
                'units' => [
                    2,
                    1
                ],
                'type' => [
                    ItemType::DIGITAL,
                    ItemType::DIGITAL
                ],
                'code' => [
                    'IT',
                    'IT1'
                ],
                'vatPercent' => [
                    0.16,
                    0.18
                ],
                'itemDescription' => [
                    'description',
                    'description1'
                ]
            ],
            $itemLevel3List->toArray()
        );
    }

    /**
     * Method testShouldPassValidation
     *
     * @throws \Twispay\Exception\ValidationException
     */
    public function testShouldPassValidation()
    {
        $itemList = $this->getValidItemList();
        $itemList->validate();
        $itemList = $this->getValidItemLevel3List();
        $itemList->validate();
    }

    /**
     * Method testShouldFailValidationWhenInvalidItem
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ITEM_LIST_INVALID
     */
    public function testShouldFailValidationWhenInvalidItem()
    {
        $itemList = new ItemList();
        $itemList[] = '!invalid';
        $itemList->validate();
    }

    /**
     * Method testShouldFailValidationWithDifferentItemtype
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ITEM_LIST_INVALID
     */
    public function testShouldFailValidationWithDifferentItemtype()
    {
        $itemList = new ItemList();
        $itemList[] = new MockItem();
        $itemList[] = new MockItemLevel3();
        $itemList->validate();
    }

    /**
     * Method getValidItemList
     *
     * @return ItemList
     */
    protected function getValidItemList()
    {
        return new ItemList(
            [
                new Item('item', 1.2, 2),
                new Item('item1', 3, 1)
            ]
        );
    }

    /**
     * Method getValidItemLevel3List
     *
     * @return ItemList
     */
    protected function getValidItemLevel3List()
    {
        return new ItemList(
            [
                new ItemLevel3('item', 1.2, 2, ItemType::DIGITAL, 'IT', 'description', 0.16),
                new ItemLevel3('item1', 3, 1, ItemType::DIGITAL, 'IT1', 'description1', 0.18)
            ]
        );
    }
}
