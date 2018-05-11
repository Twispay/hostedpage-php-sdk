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
