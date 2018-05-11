<?php

namespace Unit\Item;

use PHPUnit\Framework\TestCase;
use Twispay\Entity\Item\ItemType;

/**
 * Class ItemTypeTest
 *
 * @category Unit
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class ItemTypeTest extends TestCase
{
    /**
     * Method testShouldBeValidItemType
     */
    public function testShouldBeValidItemType()
    {
        $this->assertTrue(ItemType::isValid(ItemType::DIGITAL));
        $this->assertTrue(ItemType::isValid(ItemType::PHYSICAL));
    }

    /**
     * Method testShouldBeInvalidItemType
     */
    public function testShouldBeInvalidItemType()
    {
        $this->assertFalse(ItemType::isValid('??'));
    }
}
