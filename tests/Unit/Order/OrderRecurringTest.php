<?php

namespace Unit\Order;

use Mocks\MockItemList;
use PHPUnit\Framework\TestCase;
use Twispay\Entity\Order\Currency;
use Twispay\Entity\Order\IntervalType;
use Twispay\Entity\Order\OrderRecurring;

/**
 * Class OrderRecurringTest
 *
 * @category Unit
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class OrderRecurringTest extends TestCase
{
    /**
     * Method testShouldConvertToArray
     */
    public function testShouldConvertToArray()
    {
        $orderRecurring = $this->getValidOrderRecurring();
        $this->assertEquals(
            [
                'orderType' => 'recurring',
                'orderId' => 'order-id',
                'amount' => 12.56,
                'currency' => 'USD',
                'description' => 'description',
                'orderTags' => [
                    'tag',
                    'tag1'
                ],
                'backUrl' => 'http://sample.com',
                'items' => 'sample',
                'intervalType' => 'day',
                'intervalValue' => 15,
                'trialAmount' => 1.2,
                'firstBillDate' => '2020-05-12T00:20:50+01:00'
            ],
            $orderRecurring->toArray()
        );
    }

    /**
     * Method getValidOrderRecurring
     */
    protected function getValidOrderRecurring()
    {
        $orderRecurring = new OrderRecurring();
        $orderRecurring->setOrderId('order-id')
            ->setAmount(12.56)
            ->setCurrency(Currency::USD)
            ->setDescription('description')
            ->setIntervalType(IntervalType::DAY)
            ->setIntervalValue(15)
            ->setTrialAmount(1.2)
            ->setFirstBillDate('2020-05-12T00:20:50+01:00')
            ->setItemList(new MockItemList())
            ->setBackUrl('http://sample.com')
            ->setOrderTags(
                [
                    'tag',
                    'tag1'
                ]
            );
        return $orderRecurring;
    }
}
