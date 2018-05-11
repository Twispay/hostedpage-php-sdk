<?php

namespace Unit\Order;

use PHPUnit\Framework\TestCase;
use Twispay\Entity\Order\IntervalType;

/**
 * Class IntervalTypeTest
 *
 * @category Unit
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class IntervalTypeTest extends TestCase
{
    /**
     * Method testShouldBeValidIntervalType
     */
    public function testShouldBeValidIntervalType()
    {
        $this->assertTrue(IntervalType::isValid(IntervalType::DAY));
    }

    /**
     * Method testShouldBeInvalidIntervalType
     */
    public function testShouldBeInvalidIntervalType()
    {
        $this->assertFalse(IntervalType::isValid('?'));
    }
}
