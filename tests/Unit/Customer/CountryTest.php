<?php

namespace Unit\Customer;

use PHPUnit\Framework\TestCase;
use Twispay\Entity\Customer\Country;

/**
 * Class CountryTest
 *
 * @category Unit
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class CountryTest extends TestCase
{
    /**
     * Method testShouldBeValidCountryCode
     */
    public function testShouldBeValidCountryCode()
    {
        $this->assertTrue(Country::isValid('US'));
    }

    /**
     * Method testShouldBeInvalidCountryCode
     */
    public function testShouldBeInvalidCountryCode()
    {
        $this->assertFalse(Country::isValid('??'));
    }

    /**
     * Method testShouldGetIndexedCountryList
     */
    public function testShouldGetIndexedCountryList()
    {
        $countryList = Country::getCountryList();
        $this->assertNotEmpty($countryList);
        foreach ($countryList as $countryCode => $countryName) {
            $this->assertEquals(2, strlen($countryCode));
            $this->assertNotEmpty($countryName);
        }
    }
}
