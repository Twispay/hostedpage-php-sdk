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
     * Method getValidItemLevel3
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
