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
     * Method testCanBeCreatedFromSiteIdSecretKeyCustomerAndOrder
     */
    public function testCanBeCreatedFromSiteIdSecretKeyCustomerAndOrder()
    {
        $this->assertInstanceOf(
            Payment::class,
            new Payment(1, 'secret-key', new MockCustomer(), new MockOrderPurchase())
        );
    }

    /**
     * Method testCannotBeCreatedWithoutValidCustomerOrOrder
     *
     * @expectedException TypeError
     */
    public function testCannotBeCreatedWithoutValidCustomerOrOrder()
    {
        new Payment(null, null, 'string', 'string');
    }
}