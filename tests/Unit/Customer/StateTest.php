<?php

namespace Unit\Customer;

use PHPUnit\Framework\TestCase;
use Twispay\Entity\Customer\State;

/**
 * Class StateTest
 *
 * @category Unit
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class StateTest extends TestCase
{
    /**
     * Method testShouldBeValidStateCode
     */
    public function testShouldBeValidStateCode()
    {
        $this->assertTrue(State::isValid('NY', 'US'));
    }

    /**
     * Method testShouldBeInvalidStateCode
     */
    public function testShouldBeInvalidStateCode()
    {
        $this->assertFalse(State::isValid('NY', '??'));
        $this->assertFalse(State::isValid('??', 'US'));
    }

    /**
     * Method testShouldGetIndexedStateList
     */
    public function testShouldGetIndexedStateList()
    {
        $stateList = State::getStateListByCountryCode('US');
        $this->assertNotEmpty($stateList);
        foreach ($stateList as $stateCode => $stateName) {
            $this->assertEquals(2, strlen($stateCode));
            $this->assertNotEmpty($stateName);
        }
        $stateList = State::getStateListByCountryCode('CA');
        $this->assertNotEmpty($stateList);
        $stateList = State::getStateListByCountryCode('??');
        $this->assertEmpty($stateList);
    }
}
