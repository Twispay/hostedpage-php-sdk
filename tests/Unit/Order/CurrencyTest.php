<?php

namespace Unit\Order;

use PHPUnit\Framework\TestCase;
use Twispay\Entity\Order\Currency;

/**
 * Class OrderTest
 *
 * @category Unit
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class OrderTest extends TestCase
{
    /**
     * Method testShouldBeValidCurrencyCode
     */
    public function testShouldBeValidCurrencyCode()
    {
        $this->assertTrue(Currency::isValid(Currency::USD));
    }

    /**
     * Method testShouldBeInvalidCurrencyCode
     */
    public function testShouldBeInvalidCurrencyCode()
    {
        $this->assertFalse(Currency::isValid('???'));
    }

    /**
     * Method testShouldGetIndexedCurrencyList
     */
    public function testShouldGetIndexedCurrencyList()
    {
        $currencyList = Currency::getCurrencyList();
        $this->assertNotEmpty($currencyList);
        foreach ($currencyList as $currencyCode => $currencyName) {
            $this->assertEquals(3, strlen($currencyCode));
            $this->assertNotEmpty($currencyName);
        }
    }
}
