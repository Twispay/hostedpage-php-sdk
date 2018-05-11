<?php

namespace Unit\Order;

use Mocks\MockItemList;
use Mocks\MockLevel3Airline;
use PHPUnit\Framework\TestCase;
use Twispay\Entity\Order\Currency;
use Twispay\Entity\Order\OrderPurchase;

/**
 * Class OrderPurchaseTest
 *
 * @category Unit
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class OrderPurchaseTest extends TestCase
{
    /**
     * Method testShouldConvertToArray
     */
    public function testShouldConvertToArray()
    {
        $orderPurchase = $this->getValidOrderPurchase();
        $this->assertEquals(
            [
                'orderType' => 'purchase',
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
                'level3' => 'airline',
            ],
            $orderPurchase->toArray()
        );
    }

    /**
     * Method getValidOrderPurchase
     */
    protected function getValidOrderPurchase()
    {
        $orderPurchase = new OrderPurchase();
        $orderPurchase->setOrderId('order-id')
            ->setAmount(12.56)
            ->setCurrency(Currency::USD)
            ->setDescription('description')
            ->setItemList(new MockItemList())
            ->setLevel3(new MockLevel3Airline())
            ->setBackUrl('http://sample.com')
            ->setOrderTags(
                [
                    'tag',
                    'tag1'
                ]
            );
        return $orderPurchase;
    }
}
