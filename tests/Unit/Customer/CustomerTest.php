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
     * Method testShouldPassValidation
     */
    public function testShouldPassValidation()
    {
        $customer = $this->getValidCustomer();
        $customer->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingIdentifier
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::CUSTOMER_ID_MISSING
     */
    public function testShouldFailValidationWithMissingIdentifier()
    {
        $customer = $this->getValidCustomer();
        $customer->setIdentifier(null);
        $customer->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidIdentifier
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::CUSTOMER_ID_INVALID
     */
    public function testShouldFailValidationWithInvalidIdentifier()
    {
        $customer = $this->getValidCustomer();
        $customer->setIdentifier('!invalid');
        $customer->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidFirstName
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::FIRST_NAME_INVALID
     */
    public function testShouldFailValidationWithInvalidFirstName()
    {
        $customer = $this->getValidCustomer();
        $customer->setFirstName(str_repeat('*', 101));
        $customer->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidLastName
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::LAST_NAME_INVALID
     */
    public function testShouldFailValidationWithInvalidLastName()
    {
        $customer = $this->getValidCustomer();
        $customer->setLastName(str_repeat('*', 101));
        $customer->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidCountry
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::COUNTRY_INVALID
     */
    public function testShouldFailValidationWithInvalidCountry()
    {
        $customer = $this->getValidCustomer();
        $customer->setCountry('XX');
        $customer->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidState
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::STATE_INVALID
     */
    public function testShouldFailValidationWithInvalidState()
    {
        $customer = $this->getValidCustomer();
        $customer->setState('XX');
        $customer->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidCity
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::CITY_INVALID
     */
    public function testShouldFailValidationWithInvalidCity()
    {
        $customer = $this->getValidCustomer();
        $customer->setCity(str_repeat('*', 101));
        $customer->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidAddress
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ADDRESS_INVALID
     */
    public function testShouldFailValidationWithInvalidAddress()
    {
        $customer = $this->getValidCustomer();
        $customer->setAddress(str_repeat('*', 151));
        $customer->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidZipCode
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ZIP_INVALID
     */
    public function testShouldFailValidationWithInvalidZipCode()
    {
        $customer = $this->getValidCustomer();
        $customer->setZipCode('!invalid');
        $customer->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidPhone
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::PHONE_INVALID
     */
    public function testShouldFailValidationWithInvalidPhone()
    {
        $customer = $this->getValidCustomer();
        $customer->setPhone('!invalid');
        $customer->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidEmail
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::EMAIL_INVALID
     */
    public function testShouldFailValidationWithInvalidEmail()
    {
        $customer = $this->getValidCustomer();
        $customer->setEmail('!invalid');
        $customer->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidCustomerTag
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::TAG_INVALID
     */
    public function testShouldFailValidationWithInvalidCustomerTag()
    {
        $customer = $this->getValidCustomer();
        $customer->addCustomerTag('!invalid');
        $customer->validate();
    }

    /**
     * Method testShouldFailValidationWithNonUniqueCustomerTag
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::TAG_INVALID
     */
    public function testShouldFailValidationWithNonUniqueCustomerTag()
    {
        $customer = $this->getValidCustomer();
        $customer->addCustomerTag('tag');
        $customer->addCustomerTag('tag');
        $customer->validate();
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
