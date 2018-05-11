<?php

namespace Unit\Customer;

use PHPUnit\Framework\TestCase;
use Twispay\Entity\Customer\Customer;

/**
 * Class CustomerTest
 *
 * @category Unit
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class CustomerTest extends TestCase
{
    /**
     * Method testShouldAddCustomerTag
     */
    public function testShouldAddCustomerTag()
    {
        $customer = new Customer();
        $customer->addCustomerTag('tag');
        $customer->addCustomerTag('tag1');
        $this->assertEquals(
            [
                'tag',
                'tag1'
            ],
            $customer->getCustomerTags()
        );
    }

    /**
     * Method testShouldConvertToArray
     */
    public function testShouldConvertToArray()
    {
        $customer = $this->getValidCustomer();
        $this->assertEquals(
            [
                'identifier' => 'identifier',
                'firstName' => 'John',
                'lastName' => 'Doe',
                'country' => 'US',
                'state' => 'NY',
                'city' => 'City',
                'address' => 'Address',
                'zipCode' => '0998872',
                'phone' => '+0325673589',
                'email' => 'john.doe@site.com',
                'customerTags' =>
                    [
                        'tag',
                        'tag1'
                    ]
            ],
            $customer->toArray()
        );
    }

    /**
     * Method getValidCustomer
     */
    protected function getValidCustomer()
    {
        $customer = new Customer();
        $customer->setIdentifier('identifier')
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setCity('City')
            ->setCountry('US')
            ->setState('NY')
            ->setAddress('Address')
            ->setZipCode('0998872')
            ->setPhone('+0325673589')
            ->setEmail('john.doe@site.com')
            ->setCustomerTags(
                [
                    'tag',
                    'tag1'
                ]
            );
        return $customer;
    }
}
