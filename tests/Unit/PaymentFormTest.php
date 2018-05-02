<?php

namespace Unit;

use Mocks\MockPayment;
use PHPUnit\Framework\TestCase;
use Twispay\PaymentForm;
use TypeError;

/**
 * Class PaymentFormTest
 *
 * @category Unit
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class PaymentFormTest extends TestCase
{
    /**
     * Method testCanBeCreatedFromPayment
     */
    public function testCanBeCreatedFromPayment()
    {
        $this->assertInstanceOf(
            PaymentForm::class,
            new PaymentForm(new MockPayment())
        );
    }

    /**
     * Method testCannotBeCreatedWithoutPayment
     *
     * @expectedException TypeError
     */
    public function testCannotBeCreatedWithoutPayment()
    {
        new PaymentForm(null);
    }
}