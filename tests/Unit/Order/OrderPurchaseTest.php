<?php

namespace Unit\Order;

use Mocks\MockItem;
use Mocks\MockItemLevel3;
use Mocks\MockItemList;
use Mocks\MockLevel3Airline;
use PHPUnit\Framework\TestCase;
use Twispay\Entity\Item\ItemList;
use Twispay\Entity\Order\Currency;
use Twispay\Entity\Order\OrderPurchase;
use Twispay\Entity\Order\OrderType;

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
                'orderType' => OrderType::PURCHASE,
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
     * Method testShouldPassValidation
     *
     * @throws \Twispay\Exception\ValidationException
     */
    public function testShouldPassValidation()
    {
        $orderPurchase = $this->getValidOrderPurchase();
        $orderPurchase->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingOrderId
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ORDER_ID_MISSING
     */
    public function testShouldFailValidationWithMissingOrderId()
    {
        $orderPurchase = $this->getValidOrderPurchase();
        $orderPurchase->setOrderId(null);
        $orderPurchase->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidOrderId
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ORDER_ID_INVALID
     */
    public function testShouldFailValidationWithInvalidOrderId()
    {
        $orderPurchase = $this->getValidOrderPurchase();
        $orderPurchase->setOrderId(str_repeat('*', 33));
        $orderPurchase->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingAmount
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AMOUNT_MISSING
     */
    public function testShouldFailValidationWithMissingAmount()
    {
        $orderPurchase = $this->getValidOrderPurchase();
        $orderPurchase->setAmount(null);
        $orderPurchase->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidAmount
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AMOUNT_INVALID
     */
    public function testShouldFailValidationWithInvalidAmount()
    {
        $orderPurchase = $this->getValidOrderPurchase();
        $orderPurchase->setAmount(0);
        $orderPurchase->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingCurrency
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::CURRENCY_MISSING
     */
    public function testShouldFailValidationWithMissingCurrency()
    {
        $orderPurchase = $this->getValidOrderPurchase();
        $orderPurchase->setCurrency(null);
        $orderPurchase->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidCurrency
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::CURRENCY_INVALID
     */
    public function testShouldFailValidationWithInvalidCurrency()
    {
        $orderPurchase = $this->getValidOrderPurchase();
        $orderPurchase->setCurrency('invalid');
        $orderPurchase->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingDescription
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ORDER_DESCRIPTION_MISSING
     */
    public function testShouldFailValidationWithMissingDescription()
    {
        $orderPurchase = $this->getValidOrderPurchase(false);
        $orderPurchase->setDescription(null);
        $orderPurchase->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidDescription
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ORDER_DESCRIPTION_INVALID
     */
    public function testShouldFailValidationWithInvalidDescription()
    {
        $orderPurchase = $this->getValidOrderPurchase();
        $orderPurchase->setDescription(str_repeat('*', 65536));
        $orderPurchase->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidOrderTag
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::TAG_INVALID
     */
    public function testShouldFailValidationWithInvalidOrderTag()
    {
        $orderPurchase = $this->getValidOrderPurchase();
        $orderPurchase->setOrderTags(
            [
                '!invalid'
            ]
        );
        $orderPurchase->validate();
    }

    /**
     * Method testShouldFailValidationWithRepeatedOrderTag
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::TAG_INVALID
     */
    public function testShouldFailValidationWithRepeatedOrderTag()
    {
        $orderPurchase = $this->getValidOrderPurchase();
        $orderPurchase->setOrderTags(
            [
                'tag',
                'tag',
            ]
        );
        $orderPurchase->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidBackUrl
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::URL_INVALID
     */
    public function testShouldFailValidationWithInvalidBackUrl()
    {
        $orderPurchase = $this->getValidOrderPurchase();
        $orderPurchase->setBackUrl('!invalid');
        $orderPurchase->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidItemList
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ITEM_LIST_INVALID
     */
    public function testShouldFailValidationWithInvalidItemList()
    {
        $orderPurchase = $this->getValidOrderPurchase();
        $orderPurchase->setItemList(new ItemList([
            new MockItem(),
            new MockItemLevel3(),
        ]));
        $orderPurchase->validate();
    }

    /**
     * Method testShouldFailValidationWithAmountNotMatchingItemsAmount
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::LEVEL3_DATA_INVALID
     */
    public function testShouldFailValidationWithAmountNotMatchingItemsAmount()
    {
        $orderPurchase = $this->getValidOrderPurchase();
        $orderPurchase->setAmount(99.99);
        $orderPurchase->validate();
    }

    /**
     * Method getValidOrderPurchase
     *
     * @param bool $withItems
     *
     * @return OrderPurchase
     */
    protected function getValidOrderPurchase($withItems = true)
    {
        $orderPurchase = new OrderPurchase();
        $orderPurchase->setOrderId('order-id')
            ->setAmount(12.56)
            ->setCurrency(Currency::USD)
            ->setDescription('description')
            ->setBackUrl('http://sample.com')
            ->setOrderTags(
                [
                    'tag',
                    'tag1'
                ]
            );
        if ($withItems) {
            $orderPurchase->setItemList(new MockItemList())
                ->setLevel3(new MockLevel3Airline());
        }
        return $orderPurchase;
    }
}
