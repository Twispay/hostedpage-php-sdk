<?php

namespace Unit;

use Mocks\MockCustomer;
use Mocks\MockOrderPurchase;
use PHPUnit\Framework\TestCase;
use Twispay\Payment;
use TypeError;

/**
 * Class PaymentTest
 *
 * @category Unit
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class PaymentTest extends TestCase
{
    /**
     * Method testCanBeCreatedFromSiteIdCustomerAndOrder
     */
    public function testCanBeCreatedFromSiteIdCustomerAndOrder()
    {
        $this->assertInstanceOf(
            Payment::class,
            new Payment(1, new MockCustomer(), new MockOrderPurchase())
        );
    }

    /**
     * Method testCannotBeCreatedWithoutOrderOrCustomer
     *
     * @expectedException TypeError
     */
    public function testCannotBeCreatedWithoutCustomerOrOrder()
    {
        new Payment(null, null, null);
    }
}